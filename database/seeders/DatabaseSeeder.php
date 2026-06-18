<?php

namespace Database\Seeders;

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
        $admin = \App\Models\User::factory()->create([
            'nip' => 'admin123',
            'role' => 'admin',
        ]);

        \App\Models\Employee::create([
            'nip' => 'admin123',
            'name' => 'Administrator',
            'email' => 'admin@example.com',
        ]);

        $ceo = \App\Models\User::factory()->create([
            'nip' => 'ceo123',
            'role' => 'ceo',
        ]);

        \App\Models\Employee::create([
            'nip' => 'ceo123',
            'name' => 'Chief Executive Officer',
            'email' => 'ceo@example.com',
        ]);
    }
}
