<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\Position;
use Carbon\Carbon;

class DummyAttendanceSeeder extends Seeder
{
    public function run(): void
    {
        // Create dummy positions
        $positions = [
            'HR Manager' => Position::firstOrCreate(['name' => 'HR Manager'], ['description' => 'Mengelola sumber daya manusia']),
            'IT Support' => Position::firstOrCreate(['name' => 'IT Support'], ['description' => 'Menangani infrastruktur IT']),
            'Finance Staff' => Position::firstOrCreate(['name' => 'Finance Staff'], ['description' => 'Mengurus keuangan perusahaan']),
        ];

        // Create dummy employees
        $employees = [
            ['nip' => '19850101', 'name' => 'Budi Santoso', 'email' => 'budi@example.com', 'number' => '08123456789', 'position_id' => $positions['HR Manager']->id],
            ['nip' => '19850102', 'name' => 'Siti Aisyah', 'email' => 'siti@example.com', 'number' => '08123456780', 'position_id' => $positions['Finance Staff']->id],
            ['nip' => '19850103', 'name' => 'Agus Pratama', 'email' => 'agus@example.com', 'number' => '08123456781', 'position_id' => $positions['IT Support']->id],
        ];

        $employeeIds = [];
        foreach ($employees as $emp) {
            // Create user first because of foreign key constraint
            \App\Models\User::firstOrCreate(
                ['nip' => $emp['nip']],
                [
                    'password' => \Illuminate\Support\Facades\Hash::make('password'),
                    'role' => 'admin',
                ]
            );

            // Then create employee
            $e = Employee::firstOrCreate(['nip' => $emp['nip']], $emp);
            $employeeIds[] = $e->id;
        }

        $today = Carbon::today()->format('Y-m-d');
        $yesterday = Carbon::yesterday()->format('Y-m-d');

        // Create dummy attendances
        $attendances = [
            // Today records
            [
                'employee_id' => $employeeIds[0],
                'date' => $today,
                'check_in_time' => Carbon::parse($today . ' 07:45:00'),
                'check_in_status' => 'on_time',
                'check_out_time' => Carbon::parse($today . ' 17:05:00'),
                'check_out_status' => 'on_time',
            ],
            [
                'employee_id' => $employeeIds[1],
                'date' => $today,
                'check_in_time' => Carbon::parse($today . ' 08:15:00'), // Late
                'check_in_status' => 'late',
                'check_out_time' => null, // Not checked out
                'check_out_status' => null,
            ],
            [
                'employee_id' => $employeeIds[2],
                'date' => $today,
                'check_in_time' => Carbon::parse($today . ' 07:55:00'),
                'check_in_status' => 'on_time',
                'check_out_time' => null, // Not checked out
                'check_out_status' => null,
            ],
            // Yesterday record
            [
                'employee_id' => $employeeIds[0],
                'date' => $yesterday,
                'check_in_time' => Carbon::parse($yesterday . ' 07:50:00'),
                'check_in_status' => 'on_time',
                'check_out_time' => Carbon::parse($yesterday . ' 17:10:00'),
                'check_out_status' => 'on_time',
            ],
        ];

        foreach ($attendances as $att) {
            Attendance::updateOrCreate([
                'employee_id' => $att['employee_id'],
                'date' => $att['date']
            ], $att);
        }
    }
}
