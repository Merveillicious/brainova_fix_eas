<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Booking;
use App\Models\Schedule;
use App\Models\Tutor;
use App\Models\Payment;

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
