<?php

namespace Database\Seeders;

use App\Models\TopicData;
use Illuminate\Database\Seeder;

class TopicDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // ThematicData::create([
        //     'main_code' => 1,
        //     'code_thematic' => '01.01',
        //     "title_thematic" => "Data Industri"
        // ]);
        TopicData::create([
            'code_topic' => '1',
            'kinerja_utama' => 'sangat bagus kinerja ',
            'sumber_data' => 'data center',
            'penanggungjawab' => 'andrian',
            'thematic_code' => '01.05',
        ]);
        TopicData::create([
            'code_topic' => '2',
            'kinerja_utama' => 'perlu ada perbaikan',
            'sumber_data' => 'big data center',
            'penanggungjawab' => 'andrian',
            'thematic_code' => '01.05',
        ]);
        TopicData::create([
            'code_topic' => '3',
            'kinerja_utama' => 'bagus dan tingkatkan dan teruskan',
            'sumber_data' => 'big data media',
            'penanggungjawab' => 'andrian',
            'thematic_code' => '01.05',
        ]);
    }
}
