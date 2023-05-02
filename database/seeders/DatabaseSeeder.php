<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            MainDataSeeder::class,
            ThematicDataSeeder::class,
            TopicDataSeeder::class,
        ]);
        // \App\Models\User::factory(2)->create();
    }
}
