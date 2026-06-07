<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tutor;
use App\Models\Schedule;
use App\Models\Booking;
use App\Models\Subject;
use App\Models\Payment;
use App\Models\Withdrawal;
use Illuminate\Support\Facades\DB;

class TutorController extends Controller
{
    public function dashboard()
    {
        $userId = session('user.id');
        $tutor  = Tutor::with('subject')->where('user_id', $userId)->first();

        $bookings = collect();
        if ($tutor) {
            $bookings = Booking::with(['schedule', 'student.user', 'payment'])
                ->whereHas('schedule', fn($q) => $q->where('tutor_id', $tutor->id))
                ->orderByDesc('id')
                ->get();
        }

        return view('tutor.dashboard', compact('tutor', 'bookings'));
    }

    public function profil()
    {
        $userId   = session('user.id');
        $tutor    = Tutor::with('subject')->where('user_id', $userId)->first();
        $subjects = Subject::orderBy('nama_mapel')->get();

        if (!$tutor) {
            return redirect()->route('tutor.dashboard')->with('error', 'Profil tutor tidak ditemukan.');
        }

        return view('tutor.profil', compact('tutor', 'subjects'));
    }

    public function updateProfil(Request $request)
    {
        $tutorId   = intval($request->input('tutor_id'));
        $subjectId = intval($request->input('subject_id'));
        $bio       = trim($request->input('bio', ''));
        $tarif     = intval($request->input('tarif', 0));

        Tutor::where('id', $tutorId)->update([
            'subject_id' => $subjectId,
            'bio'        => $bio,
            'tarif'      => $tarif,
        ]);

        return redirect()->route('tutor.profil')->with('success', 'Profil tutor berhasil diperbarui.');
    }

    public function jadwal(Request $request)
    {
        $userId = session('user.id');
        $tutor  = Tutor::with('subject')->where('user_id', $userId)->first();

        $today    = now()->format('Y-m-d');
        $maxDate  = now()->addDays(7)->format('Y-m-d');
        $schedules = collect();
        $editItem  = null;

        if ($tutor) {
            $query = Schedule::with('bookings')
                ->where('tutor_id', $tutor->id)
                ->where(function ($q) use ($today, $maxDate) {
                    $q->whereNull('tanggal')
                      ->orWhereBetween('tanggal', [$today, $maxDate]);
                })
                ->orderBy('tanggal')
                ->orderBy('jam_mulai');

            $schedules = $query->get()->map(function ($sc) {
                $sc->total_booking = $sc->bookings
                    ->whereIn('status_booking', ['pending', 'diterima'])
                    ->count();
                return $sc;
            });

            if ($request->has('edit')) {
                $editId   = intval($request->query('edit'));
                $editItem = Schedule::where('id', $editId)
                    ->where('tutor_id', $tutor->id)
                    ->first();
            }
        }

        $daysId   = ['Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'];
        $monthsId = ['January' => 'Jan', 'February' => 'Feb', 'March' => 'Mar', 'April' => 'Apr', 'May' => 'Mei', 'June' => 'Jun', 'July' => 'Jul', 'August' => 'Agu', 'September' => 'Sep', 'October' => 'Okt', 'November' => 'Nov', 'December' => 'Des'];

        $weekDays  = [];
        for ($i = 0; $i <= 7; $i++) {
            $weekDays[] = now()->addDays($i)->format('Y-m-d');
        }

        $activeDate = $request->query('date', $today);
        if ($activeDate < $today || $activeDate > $maxDate) {
            $activeDate = $today;
        }

        $schedByDate = $schedules->groupBy('tanggal');
        $activeScheds = $schedByDate->get($activeDate, collect());

        return view('tutor.jadwal', compact(
            'tutor', 'schedules', 'editItem',
            'today', 'maxDate', 'weekDays', 'activeDate',
            'activeScheds', 'schedByDate', 'daysId', 'monthsId'
        ));
    }

    public function createJadwal(Request $request)
    {
        $userId  = session('user.id');
        $tutor   = Tutor::where('user_id', $userId)->first();
        $today   = now()->format('Y-m-d');
        $maxDate = now()->addDays(7)->format('Y-m-d');
        $daysId  = ['Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'];

        if (!$tutor) {
            return redirect()->route('tutor.jadwal')->with('error', 'Profil tutor tidak ditemukan.');
        }

        $tanggal    = $request->input('tanggal', '');
        $jamMulai   = $request->input('jam_mulai', '');
        $jamSelesai = $request->input('jam_selesai', '');
        $kuota      = max(1, intval($request->input('kuota', 1)));

        if ($tanggal < $today || $tanggal > $maxDate) {
            return redirect()->route('tutor.jadwal')->with('error', 'Tanggal harus dalam rentang hari ini hingga 7 hari ke depan.');
        }
        if (empty($jamMulai) || empty($jamSelesai)) {
            return redirect()->route('tutor.jadwal')->with('error', 'Jam mulai dan jam selesai harus diisi.');
        }
        if ($jamSelesai <= $jamMulai) {
            return redirect()->route('tutor.jadwal')->with('error', 'Jam selesai harus lebih besar dari jam mulai.');
        }

        // Cek bentrok
        $bentrok = Schedule::where('tutor_id', $tutor->id)
            ->where('tanggal', $tanggal)
            ->where('status', '!=', 'nonaktif')
            ->where('jam_mulai', '<', $jamSelesai)
            ->where('jam_selesai', '>', $jamMulai)
            ->exists();

        if ($bentrok) {
            return redirect()->route('tutor.jadwal')->with('error', 'Terdapat jadwal yang bentrok pada tanggal dan waktu tersebut.');
        }

        $hari = $daysId[date('l', strtotime($tanggal))] ?? 'Senin';

        Schedule::create([
            'tutor_id'    => $tutor->id,
            'subject_id'  => $tutor->subject_id,
            'hari'        => $hari,
            'tanggal'     => $tanggal,
            'jam_mulai'   => $jamMulai,
            'jam_selesai' => $jamSelesai,
            'kuota'       => $kuota,
            'status'      => 'tersedia',
        ]);

        return redirect()->route('tutor.jadwal')->with('success', 'Jadwal berhasil ditambahkan!');
    }

    public function updateJadwal(Request $request)
    {
        $userId     = session('user.id');
        $tutor      = Tutor::where('user_id', $userId)->first();
        $scheduleId = intval($request->input('schedule_id'));
        $today      = now()->format('Y-m-d');
        $maxDate    = now()->addDays(7)->format('Y-m-d');
        $daysId     = ['Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'];

        if (!$tutor) {
            return redirect()->route('tutor.jadwal')->with('error', 'Profil tutor tidak ditemukan.');
        }

        $schedule = Schedule::where('id', $scheduleId)->where('tutor_id', $tutor->id)->first();
        if (!$schedule) {
            return redirect()->route('tutor.jadwal')->with('error', 'Jadwal tidak ditemukan.');
        }

        $tanggal    = $request->input('tanggal');
        $jamMulai   = $request->input('jam_mulai');
        $jamSelesai = $request->input('jam_selesai');
        $status     = $request->input('status', 'tersedia');
        $kuota      = max(1, intval($request->input('kuota', 1)));

        if (!in_array($status, ['tersedia', 'nonaktif'])) $status = 'tersedia';
        if ($tanggal < $today || $tanggal > $maxDate) {
            return redirect()->route('tutor.jadwal')->with('error', 'Tanggal harus dalam rentang hari ini hingga 7 hari ke depan.');
        }
        if ($jamSelesai <= $jamMulai) {
            return redirect()->route('tutor.jadwal')->with('error', 'Jam selesai harus lebih besar dari jam mulai.');
        }

        $hari = $daysId[date('l', strtotime($tanggal))] ?? 'Senin';
        $schedule->update(['hari' => $hari, 'tanggal' => $tanggal, 'jam_mulai' => $jamMulai, 'jam_selesai' => $jamSelesai, 'kuota' => $kuota, 'status' => $status]);

        return redirect()->route('tutor.jadwal')->with('success', 'Jadwal berhasil diperbarui!');
    }

    public function deleteJadwal(Request $request)
    {
        $userId     = session('user.id');
        $tutor      = Tutor::where('user_id', $userId)->first();
        $scheduleId = intval($request->input('schedule_id'));

        if (!$tutor) {
            return redirect()->route('tutor.jadwal')->with('error', 'Profil tutor tidak ditemukan.');
        }

        $schedule = Schedule::where('id', $scheduleId)->where('tutor_id', $tutor->id)->first();
        if (!$schedule) {
            return redirect()->route('tutor.jadwal')->with('error', 'Jadwal tidak ditemukan.');
        }

        $bookingAktif = $schedule->bookings()->whereIn('status_booking', ['pending', 'diterima'])->exists();
        if ($bookingAktif) {
            return redirect()->route('tutor.jadwal')->with('error', 'Tidak dapat menghapus jadwal yang memiliki booking aktif.');
        }

        $schedule->delete();
        return redirect()->route('tutor.jadwal')->with('success', 'Jadwal berhasil dihapus.');
    }

    public function toggleStatusJadwal(Request $request)
    {
        $userId     = session('user.id');
        $tutor      = Tutor::where('user_id', $userId)->first();
        $scheduleId = intval($request->query('id'));

        if (!$tutor) {
            return redirect()->route('tutor.jadwal')->with('error', 'Profil tutor tidak ditemukan.');
        }

        $schedule = Schedule::where('id', $scheduleId)->where('tutor_id', $tutor->id)->first();
        if (!$schedule) {
            return redirect()->route('tutor.jadwal')->with('error', 'Jadwal tidak ditemukan.');
        }

        $newStatus = ($schedule->status === 'nonaktif') ? 'tersedia' : 'nonaktif';
        $schedule->update(['status' => $newStatus]);

        return redirect()->route('tutor.jadwal', ['date' => $request->query('date')])->with('success', 'Status jadwal berhasil diubah.');
    }

    public function updateStatusBooking(Request $request)
    {
        $bookingId     = intval($request->input('booking_id'));
        $statusBooking = $request->input('status_booking');

        if (!in_array($statusBooking, ['pending', 'diterima', 'selesai', 'batal'])) {
            return back()->with('error', 'Status tidak valid.');
        }

        $booking = \App\Models\Booking::find($bookingId);
        if ($booking) {
            $booking->update(['status_booking' => $statusBooking]);
        }

        return redirect()->route('tutor.dashboard')->with('success', 'Status booking berhasil diperbarui.');
    }

    public function pendapatan()
    {
        $userId = session('user.id');
        $tutor  = Tutor::with('subject')->where('user_id', $userId)->first();

        $bookingData = collect();
        $chartLabels = [];
        $chartValues = [];
        $totalPendapatan = 0;
        $bulanIni = 0;

        if ($tutor) {
            $bookingData = Booking::whereHas('schedule', fn($q) => $q->where('tutor_id', $tutor->id))
                ->with(['student', 'schedule.subject', 'payment'])
                ->orderByDesc('tanggal_booking')
                ->get();

            $totalPendapatan = $bookingData->where('status_booking', 'selesai')
                ->sum(fn($b) => $b->payment->jumlah ?? 0);

            $bulanIni = $bookingData->where('status_booking', 'selesai')
                ->filter(fn($b) => \Carbon\Carbon::parse($b->tanggal_booking)->isCurrentMonth())
                ->sum(fn($b) => $b->payment->jumlah ?? 0);

            // Data chart 6 bulan terakhir
            for ($i = 5; $i >= 0; $i--) {
                $bulan = now()->subMonths($i);
                $chartLabels[] = $bulan->translatedFormat('M');
                $chartValues[] = (int) $bookingData->where('status_booking', 'selesai')
                    ->filter(fn($b) => \Carbon\Carbon::parse($b->tanggal_booking)->format('Y-m') === $bulan->format('Y-m'))
                    ->sum(fn($b) => $b->payment->jumlah ?? 0);
            }
        }

        return view('tutor.pendapatan', compact('tutor', 'bookingData', 'totalPendapatan', 'bulanIni', 'chartLabels', 'chartValues'));
    }

    public function ulasan()
    {
        $userId = session('user.id');
        $tutor  = Tutor::with('subject')->where('user_id', $userId)->first();

        $reviews = collect();
        $avgRating = 0;
        $totalReviews = 0;
        $bintangCount = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];

        if ($tutor) {
            $reviews = \App\Models\Review::where('tutor_id', $tutor->id)
                ->with(['booking.student', 'booking.schedule.subject'])
                ->orderByDesc('created_at')
                ->get();

            $totalReviews = $reviews->count();
            if ($totalReviews > 0) {
                $avgRating = round($reviews->avg('rating'), 1);
                foreach ($reviews as $r) {
                    $bintangCount[$r->rating] = ($bintangCount[$r->rating] ?? 0) + 1;
                }
            }
        }

        return view('tutor.ulasan', compact('tutor', 'reviews', 'avgRating', 'totalReviews', 'bintangCount'));
    }

    public function pesan(Request $request)
    {
        $userId = session('user.id');
        $tutor  = Tutor::with('subject')->where('user_id', $userId)->first();

        $students       = collect();
        $messages       = collect();
        $activeStudent  = null;
        $activeStudentUserId = null;

        if ($tutor) {
            $students = \App\Models\Student::whereHas('bookings', function ($q) use ($tutor) {
                $q->whereHas('schedule', fn($sq) => $sq->where('tutor_id', $tutor->id));
            })->with('user')->get();

            $activeStudentId = $request->query('student');
            if ($activeStudentId) {
                $activeStudent = \App\Models\Student::with('user')->find($activeStudentId);
                if ($activeStudent) {
                    $activeStudentUserId = $activeStudent->user_id;
                    $messages = \App\Models\Message::where(function ($q) use ($userId, $activeStudentUserId) {
                        $q->where('sender_id', $userId)->where('receiver_id', $activeStudentUserId);
                    })->orWhere(function ($q) use ($userId, $activeStudentUserId) {
                        $q->where('sender_id', $activeStudentUserId)->where('receiver_id', $userId);
                    })->orderBy('created_at')->get();

                    \App\Models\Message::where('sender_id', $activeStudentUserId)
                        ->where('receiver_id', $userId)
                        ->where('is_read', false)
                        ->update(['is_read' => true]);
                }
            }
        }

        return view('tutor.pesan', compact('tutor', 'students', 'messages', 'activeStudent', 'activeStudentUserId'));
    }

    public function kirimPesan(Request $request)
    {
        $userId     = session('user.id');
        $body       = trim($request->input('body', ''));
        $receiverId = intval($request->input('receiver_id'));

        if (empty($body) || !$receiverId) {
            return back()->with('error', 'Pesan tidak boleh kosong.');
        }

        \App\Models\Message::create([
            'sender_id'   => $userId,
            'receiver_id' => $receiverId,
            'body'        => $body,
        ]);

        $student = \App\Models\Student::where('user_id', $receiverId)->first();
        return redirect()->route('tutor.pesan', ['student' => $student?->id ?? ''])
            ->with('success', 'Pesan terkirim.');
    }

    public function pengaturan()
    {
        $userId = session('user.id');
        $tutor  = Tutor::with('subject')->where('user_id', $userId)->first();
        return view('tutor.pengaturan', compact('tutor'));
    }

    public function updateProfilAkun(Request $request)
    {
        $userId = session('user.id');
        $user   = \App\Models\User::find($userId);
        if (!$user) return back()->with('error', 'User tidak ditemukan.');

        $name  = trim($request->input('name', $user->name));
        $phone = trim($request->input('phone', ''));

        $user->update([
            'name'  => $name,
            'phone' => $phone,
        ]);

        // Update session dan tutor name
        $request->session()->put('user.name', $name);
        $tutor = Tutor::where('user_id', $userId)->first();
        if ($tutor) $tutor->update(['name' => $name]);

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function updateSandiAkun(Request $request)
    {
        $userId     = session('user.id');
        $user       = \App\Models\User::find($userId);
        $sandiLama  = $request->input('sandi_lama', '');
        $sandiBaru  = $request->input('sandi_baru', '');
        $konfirmasi = $request->input('konfirmasi_sandi', '');

        if (!\Illuminate\Support\Facades\Hash::check($sandiLama, $user->password)) {
            return back()->with('error_sandi', 'Kata sandi saat ini salah.');
        }
        if (strlen($sandiBaru) < 8) {
            return back()->with('error_sandi', 'Kata sandi baru minimal 8 karakter.');
        }
        if ($sandiBaru !== $konfirmasi) {
            return back()->with('error_sandi', 'Konfirmasi kata sandi tidak cocok.');
        }

        $user->update(['password' => \Illuminate\Support\Facades\Hash::make($sandiBaru)]);

        return back()->with('success_sandi', 'Kata sandi berhasil diperbarui!');
    }

    public function tarikSaldo(Request $request)
    {
        $userId = session('user.id');
        $tutor  = Tutor::where('user_id', $userId)->first();

        if (!$tutor) {
            return back()->with('error', 'Data tutor tidak ditemukan.');
        }

        // Hitung saldo tersedia
        $totalPendapatan = Booking::whereHas('schedule', fn($q) => $q->where('tutor_id', $tutor->id))
            ->whereHas('payment', fn($q) => $q->where('status', 'berhasil'))
            ->with('payment')
            ->get()
            ->sum(fn($b) => $b->payment->jumlah ?? 0);

        $sudahDitarik = Withdrawal::where('tutor_id', $tutor->id)
            ->whereIn('status', ['pending', 'diproses', 'berhasil'])
            ->sum('jumlah');

        $saldoTersedia = ($totalPendapatan * 0.85) - $sudahDitarik;

        $jumlah = (int) $request->input('jumlah');

        if ($jumlah < 50000) {
            return back()->with('error_tarik', 'Minimum penarikan adalah Rp 50.000.');
        }

        if ($jumlah > $saldoTersedia) {
            return back()->with('error_tarik', 'Saldo tidak mencukupi. Saldo tersedia: Rp ' . number_format($saldoTersedia, 0, ',', '.'));
        }

        Withdrawal::create([
            'tutor_id'       => $tutor->id,
            'jumlah'         => $jumlah,
            'metode'         => $request->input('metode', 'transfer_bank'),
            'nomor_rekening' => $request->input('nomor_rekening'),
            'nama_pemilik'   => $request->input('nama_pemilik'),
            'status'         => 'pending',
            'catatan'        => $request->input('catatan'),
        ]);

        return back()->with('success_tarik', 'Permintaan penarikan Rp ' . number_format($jumlah, 0, ',', '.') . ' berhasil diajukan! Proses 1x24 jam.');
    }
}
