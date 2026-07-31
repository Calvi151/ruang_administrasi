<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LeaveRequest;
use App\Models\Employee;
use Carbon\Carbon;

class DummyLeaveRequestSeeder extends Seeder
{
    public function run(): void
    {
        $employees = Employee::all();

        if ($employees->isEmpty()) {
            $this->command->info('No employees found. Run DummyAttendanceSeeder first.');
            return;
        }

        $leaveRequests = [
            // Pending - Cuti
            [
                'employee_id' => $employees[0]->id,
                'type' => 'cuti',
                'start_date' => Carbon::now()->addDays(3)->format('Y-m-d'),
                'end_date' => Carbon::now()->addDays(5)->format('Y-m-d'),
                'reason' => 'Menghadiri acara pernikahan adik di kampung halaman, mohon izin cuti 3 hari.',
                'status' => 'pending',
            ],
            // Pending - Sakit
            [
                'employee_id' => $employees[1]->id,
                'type' => 'sakit',
                'start_date' => Carbon::now()->subDays(1)->format('Y-m-d'),
                'end_date' => Carbon::now()->addDays(1)->format('Y-m-d'),
                'reason' => 'Demam tinggi dan flu berat, sudah periksa ke dokter. Surat keterangan dokter terlampir.',
                'status' => 'pending',
            ],
            // Approved - Izin
            [
                'employee_id' => $employees[2]->id,
                'type' => 'izin',
                'start_date' => Carbon::now()->subDays(7)->format('Y-m-d'),
                'end_date' => Carbon::now()->subDays(7)->format('Y-m-d'),
                'reason' => 'Perlu mengantar anak ke rumah sakit untuk kontrol rutin.',
                'status' => 'approved',
                'approved_by' => 1,
            ],
            // Rejected - Cuti
            [
                'employee_id' => $employees[0]->id,
                'type' => 'cuti',
                'start_date' => Carbon::now()->subDays(14)->format('Y-m-d'),
                'end_date' => Carbon::now()->subDays(10)->format('Y-m-d'),
                'reason' => 'Ingin liburan keluarga ke Bali selama 5 hari.',
                'status' => 'rejected',
                'approved_by' => 1,
                'rejected_reason' => 'Tidak dapat disetujui karena bertepatan dengan deadline proyek besar. Silakan ajukan di minggu berikutnya.',
            ],
            // Pending - Izin
            [
                'employee_id' => $employees[2]->id,
                'type' => 'izin',
                'start_date' => Carbon::now()->addDays(1)->format('Y-m-d'),
                'end_date' => Carbon::now()->addDays(1)->format('Y-m-d'),
                'reason' => 'Ada keperluan ke kantor imigrasi untuk perpanjangan paspor.',
                'status' => 'pending',
            ],
        ];

        foreach ($leaveRequests as $lr) {
            LeaveRequest::create($lr);
        }
    }
}
