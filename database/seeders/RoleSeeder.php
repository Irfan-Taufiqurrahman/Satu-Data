<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // Jadwal::create([
        //     'name' => 'Asesmen',
        //     'href'=> '/apl02',
        //     'status' => true,
        // ]);
        Role::create([
            "name" => "Admin",
        ]);
        Role::create([
            "name" => "Operator",
        ]);
        Role::create([
            "name" => "Viewer",
        ]);
    }
}
