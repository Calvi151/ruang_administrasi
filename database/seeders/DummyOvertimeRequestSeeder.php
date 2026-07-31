<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OvertimeRequest;
use App\Models\Employee;
use Carbon\Carbon;

class DummyOvertimeRequestSeeder extends Seeder
{
    public function run(): void
    {
        $employees = Employee::all();

        if ($employees->isEmpty()) {
            $this->command->info('No employees found. Run DummyAttendanceSeeder first.');
            return;
        }

        $overtimeRequests = [
            // Pending
            [
                'employee_id' => $employees[0]->id,
                'date' => Carbon::now()->format('Y-m-d'),
                'start_time' => '17:00:00',
                'end_time' => '20:30:00',
                'reason' => 'Menyelesaikan modul laporan akhir bulan yang harus disubmit besok pagi.',
                'status' => 'pending',
            ],
            // Approved
            [
                'employee_id' => $employees[1]->id,
                'date' => Carbon::now()->subDays(2)->format('Y-m-d'),
                'start_time' => '18:00:00',
                'end_time' => '21:00:00',
                'reason' => 'Rapat koordinasi dadakan dengan klien dari luar kota via Zoom.',
                'status' => 'approved',
                'approved_by' => 1,
            ],
            // Rejected
            [
                'employee_id' => $employees[2]->id,
                'date' => Carbon::now()->subDays(5)->format('Y-m-d'),
                'start_time' => '17:00:00',
                'end_time' => '22:00:00',
                'reason' => 'Merapikan meja kerja dan menyusun arsip lama.',
                'status' => 'rejected',
                'approved_by' => 1,
                'rejected_reason' => 'Pekerjaan tersebut bukan pekerjaan mendesak yang membutuhkan waktu lembur. Silakan kerjakan di jam kerja reguler.',
            ],
            // Pending 2
            [
                'employee_id' => $employees[0]->id,
                'date' => Carbon::now()->subDays(1)->format('Y-m-d'),
                'start_time' => '19:00:00',
                'end_time' => '23:30:00',
                'reason' => 'Maintenance server utama dan backup database bulanan (Downtime malam).',
                'status' => 'pending',
            ],
        ];

        foreach ($overtimeRequests as $or) {
            OvertimeRequest::create($or);
        }
    }
}
