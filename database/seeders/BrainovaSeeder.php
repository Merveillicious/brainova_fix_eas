<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class BrainovaSeeder extends Seeder
{
    public function run(): void
    {
        // ─── Bersihkan data lama (urutan: child dulu) ─────────────────────────
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('reviews')->truncate();
        DB::table('payments')->truncate();
        DB::table('bookings')->truncate();
        DB::table('schedules')->truncate();
        DB::table('tutors')->truncate();
        DB::table('students')->truncate();
        DB::table('subjects')->truncate();
        DB::table('users')->where('role', '!=', 'admin')->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // ─── Admin ─────────────────────────────────────────────────────────────
        $adminId = DB::table('users')->insertGetId([
            'name'       => 'Admin Brainova',
            'email'      => 'admin@brainova.id',
            'password'   => Hash::make('admin123'),
            'role'       => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // ─── Subjects ──────────────────────────────────────────────────────────
        $subjects = [
            'Matematika', 'Fisika', 'Kimia', 'Biologi',
            'Bahasa Inggris', 'Bahasa Indonesia',
        ];
        $subjectIds = [];
        foreach ($subjects as $s) {
            $subjectIds[$s] = DB::table('subjects')->insertGetId(['nama_mapel' => $s]);
        }

        // ─── Tutors ────────────────────────────────────────────────────────────
        $tutorData = [
            ['Andi Saputra',   'Matematika',      180000, 'Lulusan S2 Matematika ITB. Berpengalaman 7 tahun mengajar siswa SMA dan persiapan SBMPTN.'],
            ['Reni Hartati',   'Fisika',           150000, 'Dosen muda Fisika Unpad. Spesialis mekanika dan gelombang untuk SMA dan olimpiade.'],
            ['Budi Santoso',   'Kimia',            140000, 'Pengajar berpengalaman 5 tahun. Mahir membimbing siswa untuk ujian nasional dan UTBK.'],
            ['Siti Rahayu',    'Biologi',          130000, 'Alumni Biologi UI. Fokus pada konsep sel, genetika, dan ekologi untuk SMA.'],
            ['David Lim',      'Bahasa Inggris',   160000, 'Native-level English speaker. Spesialis TOEFL, IELTS, dan conversation aktif.'],
            ['Tutor Demo',     'Matematika',       150000, 'Tutor berpengalaman 5 tahun di bidang Matematika. Sabar dan metodis dalam pengajaran.'],
            ['Maya Sari',      'Bahasa Indonesia', 120000, 'Guru SMA berpengalaman 10 tahun. Ahli dalam tata bahasa, sastra, dan persiapan UN.'],
            ['Fajar Nugroho',  'Fisika',           170000, 'Finalis olimpiade fisika nasional. Mengajar dengan metode visual dan eksperimen sederhana.'],
        ];

        $tutorIds = [];
        foreach ($tutorData as [$name, $subj, $tarif, $bio]) {
            $userId = DB::table('users')->insertGetId([
                'name'       => $name,
                'email'      => strtolower(str_replace(' ', '.', $name)) . '@brainova.id',
                'password'   => Hash::make('tutor123'),
                'role'       => 'tutor',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $tutorId = DB::table('tutors')->insertGetId([
                'user_id'    => $userId,
                'subject_id' => $subjectIds[$subj],
                'name'       => $name,
                'bio'        => $bio,
                'tarif'      => $tarif,
                'status'     => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $tutorIds[$name] = ['id' => $tutorId, 'subject_id' => $subjectIds[$subj], 'tarif' => $tarif];
        }

        // ─── Schedules ─────────────────────────────────────────────────────────
        $days   = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $slots  = [['07:00', '09:00'], ['09:00', '11:00'], ['13:00', '15:00'], ['15:00', '17:00'], ['19:00', '21:00']];

        $scheduleIds = [];
        foreach ($tutorIds as $name => $t) {
            // Setiap tutor punya 3–5 jadwal
            $chosenDays  = array_slice($days, 0, rand(3, 5));
            $chosenSlots = array_slice($slots, 0, rand(2, 3));
            foreach ($chosenDays as $d) {
                foreach ($chosenSlots as [$start, $end]) {
                    $nextDate = $this->nextDateForDay($d);
                    $sid = DB::table('schedules')->insertGetId([
                        'tutor_id'    => $t['id'],
                        'subject_id'  => $t['subject_id'],
                        'hari'        => $d,
                        'tanggal'     => $nextDate,
                        'jam_mulai'   => $start,
                        'jam_selesai' => $end,
                        'kuota'       => 1,
                        'status'      => 'tersedia',
                        'created_at'  => now(),
                        'updated_at'  => now(),
                    ]);
                    $scheduleIds[] = ['id' => $sid, 'tutor' => $name, 'tutor_id' => $t['id'], 'tarif' => $t['tarif'], 'subject_id' => $t['subject_id']];
                }
            }
        }

        // ─── Students ──────────────────────────────────────────────────────────
        $studentData = [
            ['Anita Sari',     'anita.sari@gmail.com'],
            ['Dimas Nugroho',  'dimas.nugroho@gmail.com'],
            ['Wulan Dewi',     'wulan.dewi@gmail.com'],
            ['Rizky Pratama',  'rizky.pratama@gmail.com'],
            ['Siswa Demo',     'siswa@brainova.id'],
            ['Farhan Ahmad',   'farhan.ahmad@gmail.com'],
            ['Nadia Putri',    'nadia.putri@gmail.com'],
        ];

        $studentIds = [];
        foreach ($studentData as [$name, $email]) {
            $userId = DB::table('users')->insertGetId([
                'name'       => $name,
                'email'      => $email,
                'password'   => Hash::make('siswa123'),
                'role'       => 'siswa',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $studentIds[$name] = DB::table('students')->insertGetId([
                'user_id'    => $userId,
                'name'       => $name,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // ─── Bookings + Payments + Reviews ────────────────────────────────────
        $komentar = [
            'Tutor sangat sabar dan jelas dalam menjelaskan materi. Nilai saya naik drastis!',
            'Penjelasan mudah dipahami, contoh soal yang diberikan relevan banget.',
            'Materinya disampaikan sistematis. Tutor juga responsif di luar jam belajar.',
            'Luar biasa! Salah satu tutor terbaik yang pernah saya temui.',
            'Cara mengajarnya menyenangkan, tidak membosankan sama sekali.',
            'Sangat membantu persiapan ujian. Rekomen untuk teman-teman yang mau UTBK!',
            'Penjelasannya detail dan mudah dimengerti. Terima kasih banyak!',
        ];

        $students     = array_values($studentIds);
        $schedulePool = array_values($scheduleIds);

        // Buat 20 booking (selesai/diterima/pending) sebaran 6 bulan
        for ($i = 0; $i < 20; $i++) {
            $sched     = $schedulePool[$i % count($schedulePool)];
            $studentId = $students[$i % count($students)];
            $bulanLalu = Carbon::now()->subMonths(rand(0, 5));
            $tgl       = $bulanLalu->format('Y-m-') . rand(1, 28);
            $status    = $i < 12 ? 'selesai' : ($i < 17 ? 'diterima' : 'pending');
            $metode    = $i % 2 === 0 ? 'transfer' : 'ewallet';

            $bookingId = DB::table('bookings')->insertGetId([
                'student_id'        => $studentId,
                'schedule_id'       => $sched['id'],
                'tanggal_booking'   => $tgl . ' 10:00:00',
                'metode_pembayaran' => $metode,
                'status_pembayaran' => $status === 'selesai' ? 'dibayar' : ($status === 'diterima' ? 'dibayar' : 'menunggu'),
                'status_booking'    => $status,
                'created_at'        => $tgl . ' 10:00:00',
                'updated_at'        => $tgl . ' 10:00:00',
            ]);

            $payStatus = $status === 'selesai' ? 'berhasil' : ($status === 'diterima' ? 'berhasil' : 'menunggu');
            DB::table('payments')->insertGetId([
                'booking_id' => $bookingId,
                'jumlah'     => $sched['tarif'] + 4000,
                'metode'     => $metode,
                'status'     => $payStatus,
                'paid_at'    => $payStatus === 'berhasil' ? $tgl . ' 10:30:00' : null,
                'created_at' => $tgl . ' 10:00:00',
                'updated_at' => $tgl . ' 10:30:00',
            ]);

            // Review untuk yang sudah selesai
            if ($status === 'selesai') {
                $rating = rand(4, 5);
                DB::table('reviews')->insertGetId([
                    'booking_id' => $bookingId,
                    'student_id' => $studentId,
                    'tutor_id'   => $sched['tutor_id'],
                    'rating'     => $rating,
                    'komentar'   => $komentar[$i % count($komentar)],
                    'created_at' => $tgl . ' 11:00:00',
                    'updated_at' => $tgl . ' 11:00:00',
                ]);
            }
        }

        $this->command->info('✅ Seeder selesai! Data demo berhasil dibuat.');
        $this->command->info('');
        $this->command->info('Akun Login:');
        $this->command->info('  Admin  : admin@brainova.id   / admin123');
        $this->command->info('  Siswa  : siswa@brainova.id   / siswa123');
        $this->command->info('  Tutor  : tutor.demo@brainova.id / tutor123');
    }

    private function nextDateForDay(string $hariId): string
    {
        $map = ['Senin'=>'Monday','Selasa'=>'Tuesday','Rabu'=>'Wednesday','Kamis'=>'Thursday','Jumat'=>'Friday','Sabtu'=>'Saturday','Minggu'=>'Sunday'];
        $en  = $map[$hariId] ?? 'Monday';
        return Carbon::parse("next $en")->format('Y-m-d');
    }
}
