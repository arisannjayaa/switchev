<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NewRoleAccount extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'BPLJSKB',
            'email' => 'bpljskb@mail.com',
            'password' => bcrypt('password1'),
            'role_id' => Role::BPLJSKB,
            'status' => 'verified'
        ]);
    }
}
