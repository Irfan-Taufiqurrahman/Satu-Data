<?php

namespace Database\Seeders;

use App\Models\MainData;
use Illuminate\Database\Seeder;

class MainDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        MainData::create([
            "code_main"=> 1,
            "title_main"=> "Informasi Pertahanan dan Luar Negeri",
        ]);
        MainData::create([
            "code_main"=> 2,
            "title_main"=> "Informasi Ekonomi dan Industri",
        ]);
    }
}
