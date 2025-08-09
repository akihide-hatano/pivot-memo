<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TimingTag;

class TimingTagsTableSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['timing_name' => '朝',   'base_time' => '07:00:00'],
            ['timing_name' => '昼',   'base_time' => '12:00:00'],
            ['timing_name' => '夕',   'base_time' => '18:00:00'],
            ['timing_name' => '就寝前','base_time' => '22:00:00'],
        ];

        foreach ($rows as $row) {
            TimingTag::updateOrCreate(
                ['timing_name' => $row['timing_name']],
                ['base_time' => $row['base_time']]
            );
        }
    }
}
