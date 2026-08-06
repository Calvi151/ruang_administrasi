<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Support\Facades\Hash;

class DummyEmployeeUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pegawai 1
        $user1 = User::firstOrCreate(
            ['nip' => '1001'],
            [
                'role' => 'pegawai',
                'password' => Hash::make('password'),
            ]
        );

        Employee::firstOrCreate(
            ['nip' => '1001'],
            [
                'name' => 'Ahmad Pegawai',
                'email' => 'ahmad@example.com',
                'position_id' => null, 
                'number' => '081234567890',
            ]
        );

        // Pegawai 2
        $user2 = User::firstOrCreate(
            ['nip' => '1002'],
            [
                'role' => 'pegawai',
                'password' => Hash::make('password'),
            ]
        );

        Employee::firstOrCreate(
            ['nip' => '1002'],
            [
                'name' => 'Budi Pegawai',
                'email' => 'budi@example.com',
                'position_id' => null, 
                'number' => '089876543210',
            ]
        );
    }
}
