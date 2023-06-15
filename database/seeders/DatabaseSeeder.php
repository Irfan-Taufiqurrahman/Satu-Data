<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(2)->create();
        Role::create([
            "name" => "Admin",
        ]);
        Role::create([
            "name" => "Operator",
        ]);
        Role::create([
            "name" => "Viewer",
        ]);
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
