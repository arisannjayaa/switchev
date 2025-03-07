<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Role::create([
            'name' => 'admin'
        ]);

        Role::create([
            'name' => 'guest'
        ]);

        User::factory()->create([
            'name' => 'Administrator',
            'email' => 'admin@mail.com',
            'password' => bcrypt('password1'),
            'role_id' => 1
        ]);
    }
}
