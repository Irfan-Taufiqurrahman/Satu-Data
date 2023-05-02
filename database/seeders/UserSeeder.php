<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::create([
            "name"=> "andrian",
            "email" => "andrian@gmail.com",
            "role_id" => 1,
            'password' => Hash::make('password',),
            "confirmed" => true,
            "covering_letter" => "https://pens.id/PA1_2023",
            "pic" => "bambang pacul",
        ]);
    }
}
