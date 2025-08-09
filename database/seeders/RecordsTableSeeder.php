<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use App\Models\User;
use App\Models\Record;
use App\Models\TimingTag;
use App\Models\Medication;

class RecordsTableSeeder extends Seeder
{
    public function run(): void
    {
        $users       = User::take(3)->get();               // 上位3ユーザーに作成（適宜調整）
        $timingTags  = TimingTag::orderBy('id')->get();    // 朝/昼/夕/就寝前
        $medications = Medication::orderBy('id')->get();

        if ($users->isEmpty() || $timingTags->isEmpty() || $medications->isEmpty()) {
            $this->command->warn('Users / TimingTags / Medications のいずれかが空です。先にSeederを流してください。');
            return;
        }

        $dosages = ['1錠','2錠','1包','5mL','10mL'];
        $notTakenReasons = ['飲み忘れ','体調不良','外出中','在庫切れ', null];

        foreach ($users as $user) {
            // 直近7日分
            for ($d = 0; $d < 7; $d++) {
                $date = Carbon::today()->subDays($d);

                // その日の記録を 1〜3 件ランダム作成
                $timesPerDay = rand(1, 3);
                $pickedTags = $timingTags->random($timesPerDay);

                foreach (Arr::wrap($pickedTags) as $tag) {
                    // taken_at = 日付 + タグの基準時刻
                    $takenAt = Carbon::parse($date->toDateString().' '.$tag->base_time);

                    $record = Record::updateOrCreate(
                        [
                            'user_id'       => $user->id,
                            'timing_tag_id' => $tag->id,
                            'taken_at'      => $takenAt,
                        ],
                        [] // 追加の更新項目があればここに
                    );

                    // この記録に 1〜3 個の薬をランダム添付（pivot付き）
                    $attachCount = rand(1, 3);
                    $pickMeds = $medications->random($attachCount);

                    $pivot = [];
                    foreach (Arr::wrap($pickMeds) as $med) {
                        $isCompleted = (bool)rand(0,1);
                        $reason = $isCompleted ? null : Arr::random($notTakenReasons);

                        $pivot[$med->id] = [
                            'taken_dosage'    => Arr::random($dosages),
                            'is_completed'    => $isCompleted,
                            'reason_not_taken'=> $reason,
                            'created_at'      => now(),
                            'updated_at'      => now(),
                        ];
                    }

                    // 二重登録防止のため syncWithoutDetaching
                    $record->medications()->syncWithoutDetaching($pivot);
                }
            }
        }

        $this->command->info('Records + pivot をランダム投入しました。');
    }
}
