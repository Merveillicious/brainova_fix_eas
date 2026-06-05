<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Booking;
use App\Models\Schedule;
use App\Models\Tutor;
use App\Models\Payment;
use App\Models\Review;

class SiswaController extends Controller
{
    public function dashboard()
    {
        $userId  = session('user.id');
        $student = Student::where('user_id', $userId)->first();

        $bookings = collect();
        if ($student) {
            $bookings = Booking::with(['schedule.tutor', 'schedule.subject', 'payment'])
                ->where('student_id', $student->id)
                ->orderByDesc('id')
                ->get();
        }

        $tutors = Tutor::with('subject')->where('status', 'aktif')->get();

        return view('siswa.dashboard', compact('bookings', 'student', 'tutors'));
    }

    public function jadwalKelas()
    {
        $userId  = session('user.id');
        $student = Student::where('user_id', $userId)->first();

        $aktif    = collect();
        $riwayat  = collect();

        if ($student) {
            $semua = Booking::with(['schedule.tutor', 'schedule.subject', 'payment'])
                ->where('student_id', $student->id)
                ->orderByDesc('id')
                ->get();

            $aktif   = $semua->whereIn('status_booking', ['pending', 'diterima']);
            $riwayat = $semua->whereIn('status_booking', ['selesai', 'batal']);
        }

        return view('siswa.jadwal-kelas', compact('student', 'aktif', 'riwayat'));
    }

    public function pembayaran()
    {
        $userId  = session('user.id');
        $student = Student::where('user_id', $userId)->first();

        $payments = collect();
        if ($student) {
            $payments = Payment::with(['booking.schedule.tutor', 'booking.schedule.subject'])
                ->whereHas('booking', fn($q) => $q->where('student_id', $student->id))
                ->orderByDesc('created_at')
                ->get();
        }

        return view('siswa.pembayaran', compact('student', 'payments'));
    }

    public function pesan()
    {
        $userId  = session('user.id');
        $student = Student::where('user_id', $userId)->first();

        $tutors = collect();
        if ($student) {
            $tutors = Booking::with('schedule.tutor')
                ->where('student_id', $student->id)
                ->get()
                ->pluck('schedule.tutor')
                ->filter()
                ->unique('id')
                ->values();
        }

        return view('siswa.pesan', compact('student', 'tutors'));
    }

    public function pengaturan()
    {
        $userId  = session('user.id');
        $student = Student::where('user_id', $userId)->first();
        $user    = \App\Models\User::find($userId);

        return view('siswa.pengaturan', compact('student', 'user'));
    }

    public function updateProfil(Request $request)
    {
        $userId = session('user.id');
        $user   = \App\Models\User::find($userId);

        if (!$user) return back()->with('error', 'User tidak ditemukan.');

        $user->update([
            'name'  => trim($request->input('name', $user->name)),
            'phone' => trim($request->input('phone', '')),
        ]);

        // Update session name
        $request->session()->put('user.name', $user->name);

        // Update student name too
        $student = Student::where('user_id', $userId)->first();
        if ($student) $student->update(['name' => $user->name]);

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function updateSandi(Request $request)
    {
        $userId      = session('user.id');
        $user        = \App\Models\User::find($userId);
        $sandiLama   = $request->input('sandi_lama', '');
        $sandiBaru   = $request->input('sandi_baru', '');
        $konfirmasi  = $request->input('konfirmasi_sandi', '');

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

    public function ulasan()
    {
        $userId  = session('user.id');
        $student = Student::where('user_id', $userId)->first();

        $perluDinilai = collect();
        $riwayatUlasan = collect();

        if ($student) {
            // Booking selesai yang belum diulas
            $reviewedBookingIds = Review::where('student_id', $student->id)->pluck('booking_id');

            $perluDinilai = Booking::with(['schedule.tutor', 'schedule.subject'])
                ->where('student_id', $student->id)
                ->where('status_booking', 'selesai')
                ->whereNotIn('id', $reviewedBookingIds)
                ->orderByDesc('id')
                ->get();

            $riwayatUlasan = Review::with(['booking.schedule.tutor', 'booking.schedule.subject'])
                ->where('student_id', $student->id)
                ->orderByDesc('created_at')
                ->get();
        }

        return view('siswa.ulasan', compact('student', 'perluDinilai', 'riwayatUlasan'));
    }

    public function storeUlasan(Request $request)
    {
        $userId    = session('user.id');
        $bookingId = intval($request->input('booking_id'));
        $rating    = max(1, min(5, intval($request->input('rating', 5))));
        $komentar  = trim($request->input('komentar', ''));

        $student = Student::where('user_id', $userId)->first();
        if (!$student) {
            return back()->with('error', 'Data siswa tidak ditemukan.');
        }

        $booking = Booking::with('schedule')
            ->where('id', $bookingId)
            ->where('student_id', $student->id)
            ->where('status_booking', 'selesai')
            ->first();

        if (!$booking) {
            return back()->with('error', 'Booking tidak valid.');
        }

        if (Review::where('booking_id', $bookingId)->exists()) {
            return back()->with('error', 'Kelas ini sudah pernah diulas.');
        }

        Review::create([
            'booking_id' => $bookingId,
            'student_id' => $student->id,
            'tutor_id'   => $booking->schedule->tutor_id,
            'rating'     => $rating,
            'komentar'   => $komentar,
        ]);

        return redirect()->route('siswa.ulasan')->with('success', 'Ulasan berhasil dikirim. Terima kasih!');
    }

    public function cariTutor()
    {
        $schedules = Schedule::with(['tutor', 'subject'])
            ->where('status', 'tersedia')
            ->whereHas('tutor', fn($q) => $q->where('status', 'aktif'))
            ->get()
            ->groupBy('tutor_id');

        $tutors = Tutor::with('subject')->where('status', 'aktif')->get();

        return view('siswa.cari-tutor', compact('schedules', 'tutors'));
    }

    public function tutorProfil($id)
    {
        $tutor = Tutor::with('subject')->findOrFail($id);
        
        $schedules = Schedule::where('tutor_id', $id)
            ->where('status', 'tersedia')
            ->orderBy('tanggal')
            ->orderBy('jam_mulai')
            ->get();

        return view('siswa.profil-tutor', compact('tutor', 'schedules'));
    }

    public function booking(Request $request)
    {
        $userId      = session('user.id');
        $scheduleId  = intval($request->input('schedule_id'));
        $metode      = $request->input('metode_pembayaran', 'transfer');

        if (!in_array($metode, ['transfer', 'ewallet'])) {
            $metode = 'transfer';
        }

        $student = Student::where('user_id', $userId)->first();
        if (!$student) {
            return redirect()->route('siswa.cari-tutor')->with('error', 'Data siswa tidak ditemukan.');
        }

        $existing = Booking::where('student_id', $student->id)
            ->where('schedule_id', $scheduleId)
            ->whereIn('status_booking', ['pending', 'diterima'])
            ->first();

        if ($existing) {
            return redirect()->route('siswa.cari-tutor')->with('error', 'Kamu sudah memiliki booking aktif untuk jadwal ini.');
        }

        $schedule = Schedule::with('tutor')->find($scheduleId);
        if (!$schedule || $schedule->status !== 'tersedia') {
            return redirect()->route('siswa.cari-tutor')->with('error', 'Jadwal tidak tersedia.');
        }

        $b = Booking::create([
            'student_id'        => $student->id,
            'schedule_id'       => $scheduleId,
            'tanggal_booking'   => now(),
            'metode_pembayaran' => $metode,
            'status_pembayaran' => 'menunggu',
            'status_booking'    => 'pending',
        ]);

        Payment::create([
            'booking_id' => $b->id,
            'jumlah'     => $schedule->tutor->tarif,
            'metode'     => $metode,
            'status'     => 'menunggu',
        ]);

        return redirect()->route('siswa.dashboard')->with('success', 'Booking berhasil dibuat! Menunggu konfirmasi pembayaran.');
    }

    public function cancelBooking(Request $request)
    {
        $userId    = session('user.id');
        $bookingId = intval($request->input('booking_id'));

        $student = Student::where('user_id', $userId)->first();
        if (!$student) {
            return redirect()->route('siswa.dashboard')->with('error', 'Data siswa tidak ditemukan.');
        }

        $booking = Booking::where('id', $bookingId)->where('student_id', $student->id)->first();
        if (!$booking) {
            return redirect()->route('siswa.dashboard')->with('error', 'Booking tidak ditemukan.');
        }

        if ($booking->status_booking !== 'pending') {
            return redirect()->route('siswa.dashboard')->with('error', 'Hanya booking dengan status pending yang bisa dibatalkan.');
        }

        $booking->update(['status_booking' => 'batal']);
        Payment::where('booking_id', $bookingId)->update(['status' => 'gagal']);

        return redirect()->route('siswa.dashboard')->with('success', 'Booking berhasil dibatalkan.');
    }
}
