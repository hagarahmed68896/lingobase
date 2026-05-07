<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::updateOrCreate(
            ['email' => 'admin@lingobase.com'],
            [
                'name' => 'System Admin',
                'password' => \Hash::make('Admin@123'),
                'is_admin' => true,
            ]
        );
    }
}
