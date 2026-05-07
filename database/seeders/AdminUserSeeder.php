<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    \App\Models\User::firstOrCreate(
        ['email' => 'admin@computecart.com'],
        [
            'name' => 'Super Admin',
            'password' => Hash::make('password123'),
            'role_id' => \App\Models\Role::where('name', 'admin')->first()->id,
        ]
    );
    }
}
