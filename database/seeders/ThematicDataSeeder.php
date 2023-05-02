<?php

namespace Database\Seeders;

use App\Models\ThematicData;
use Illuminate\Database\Seeder;

class ThematicDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        ThematicData::create([
            'main_code' => 1,
            'code_thematic' => '01.01',
            "title_thematic" => "Data Industri"
        ]);
        ThematicData::create([
            'main_code' => 1,
            'code_thematic' => '01.02',
            "title_thematic" => "Data Perdagangan"
        ]);
        ThematicData::create([
            'main_code' => 1,
            'code_thematic' => '01.03',
            "title_thematic" => "Data Pertanian"
        ]);
        ThematicData::create([
            'main_code' => 1,
            'code_thematic' => '01.04',
            "title_thematic" => "Data Perkebunan"
        ]);
        ThematicData::create([
            'main_code' => 1,
            'code_thematic' => '01.05',
            "title_thematic" => "Data Investasi"
        ]);
    }
}
