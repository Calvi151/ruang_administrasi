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
        // Create Positions
        $adminPosition = \App\Models\Position::create([
            'name' => 'System Administrator',
            'description' => 'Mengelola sistem dan hak akses aplikasi.'
        ]);

        $ceoPosition = \App\Models\Position::create([
            'name' => 'Chief Executive Officer',
            'description' => 'Direktur Utama perusahaan.'
        ]);

        $admin = \App\Models\User::factory()->create([
            'nip' => '10001',
            'role' => 'admin',
        ]);

        \App\Models\Employee::create([
            'nip' => '10001',
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'position_id' => $adminPosition->id,
        ]);

        $ceo = \App\Models\User::factory()->create([
            'nip' => '20001',
            'role' => 'ceo',
        ]);

        \App\Models\Employee::create([
            'nip' => '20001',
            'name' => 'Chief Executive Officer',
            'email' => 'ceo@example.com',
            'position_id' => $ceoPosition->id,
        ]);
    }
}
