<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Medication;

class MedicationsTableSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['medication_name'=>'アムロジピン', 'effects'=>'高血圧改善','side_effects'=>'むくみ・動悸','description'=>'朝食後に服用'],
            ['medication_name'=>'メトホルミン',   'effects'=>'血糖値低下', 'side_effects'=>'胃部不快感・下痢',      'description'=>'朝夕食後に服用'],
            ['medication_name'=>'アトルバスタチン','effects'=>'コレステロール低下',   'side_effects'=>'筋肉痛・肝機能障害',    'description'=>'就寝前に服用'],
            ['medication_name'=>'ロキソプロフェン','effects'=>'鎮痛・抗炎症',         'side_effects'=>'胃痛・吐き気',          'description'=>'疼痛時に服用'],
            ['medication_name'=>'オメプラゾール',  'effects'=>'胃酸分泌抑制',          'side_effects'=>'下痢・頭痛',            'description'=>'朝食前に服用'],
            ['medication_name'=>'バルサルタン',    'effects'=>'高血圧改善',            'side_effects'=>'低血圧・めまい',        'description'=>'朝食後に服用'],
            ['medication_name'=>'モンテルカスト',  'effects'=>'喘息・鼻炎改善',        'side_effects'=>'腹痛・頭痛',            'description'=>'就寝前に服用'],
            ['medication_name'=>'シロスタゾール',  'effects'=>'血流改善',              'side_effects'=>'頭痛・動悸',            'description'=>'朝夕食後に服用'],
            ['medication_name'=>'プレドニゾロン',  'effects'=>'炎症・免疫抑制',        'side_effects'=>'むくみ・体重増加',      'description'=>'朝食後に服用（漸減）'],
            ['medication_name'=>'ファモチジン',    'effects'=>'胃酸分泌抑制',          'side_effects'=>'便秘・眠気',            'description'=>'朝夕食後に服用'],
        ];

        foreach( $rows as $row){
            Medication::updateOrCreate(
                ['medication_name' => $row['medication_name']],
                [
                    'effects' => $row['effects'],
                    'side_effects'  => $row['side_effects'],
                    'description'   => $row['description'],
                ],
            );
        }
    }
}
