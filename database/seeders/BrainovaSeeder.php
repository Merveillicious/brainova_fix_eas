<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrainovaSeeder extends Seeder
{
    public function run(): void
    {
        // Users
        $adminId = DB::table('users')->insertGetId([
            'name'       => 'Admin Brainova',
            'email'      => 'admin@brainova.com',
            'password'   => 'admin123',
            'role'       => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $siswaId = DB::table('users')->insertGetId([
            'name'       => 'Siswa Demo',
            'email'      => 'siswa@demo.com',
            'password'   => 'siswa123',
            'role'       => 'siswa',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $tutorId = DB::table('users')->insertGetId([
            'name'       => 'Tutor Demo',
            'email'      => 'tutor@demo.com',
            'password'   => 'tutor123',
            'role'       => 'tutor',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Students
        $studentId = DB::table('students')->insertGetId([
            'user_id'    => $siswaId,
            'name'       => 'Siswa Demo',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Subjects
        $mapelIds = [];
        foreach (['Matematika', 'Fisika', 'Kimia', 'Biologi', 'Bahasa Inggris', 'Bahasa Indonesia'] as $mapel) {
            $mapelIds[$mapel] = DB::table('subjects')->insertGetId(['nama_mapel' => $mapel]);
        }

        // Tutors
        $tutorRecordId = DB::table('tutors')->insertGetId([
            'user_id'    => $tutorId,
            'subject_id' => $mapelIds['Matematika'],
            'name'       => 'Tutor Demo',
            'bio'        => 'Tutor berpengalaman 5 tahun di bidang Matematika.',
            'tarif'      => 150000,
            'status'     => 'aktif',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Schedules
        $days = ['Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'];
        $today    = now()->format('Y-m-d');
        $tomorrow = now()->addDay()->format('Y-m-d');
        $hariIni  = $days[now()->format('l')];
        $hariEsok = $days[now()->addDay()->format('l')];

        $schedId = DB::table('schedules')->insertGetId([
            'tutor_id'    => $tutorRecordId,
            'subject_id'  => $mapelIds['Matematika'],
            'hari'        => $hariIni,
            'tanggal'     => $today,
            'jam_mulai'   => '16:00:00',
            'jam_selesai' => '18:00:00',
            'kuota'       => 5,
            'status'      => 'tersedia',
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        DB::table('schedules')->insert([
            'tutor_id'    => $tutorRecordId,
            'subject_id'  => $mapelIds['Matematika'],
            'hari'        => $hariEsok,
            'tanggal'     => $tomorrow,
            'jam_mulai'   => '09:00:00',
            'jam_selesai' => '11:00:00',
            'kuota'       => 5,
            'status'      => 'tersedia',
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        // Booking
        $bookingId = DB::table('bookings')->insertGetId([
            'student_id'        => $studentId,
            'schedule_id'       => $schedId,
            'tanggal_booking'   => now(),
            'metode_pembayaran' => 'transfer',
            'status_pembayaran' => 'menunggu',
            'status_booking'    => 'pending',
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);

        // Payment
        DB::table('payments')->insert([
            'booking_id' => $bookingId,
            'jumlah'     => 150000,
            'metode'     => 'transfer',
            'status'     => 'menunggu',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
