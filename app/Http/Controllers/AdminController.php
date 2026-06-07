<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Tutor;
use App\Models\Booking;
use App\Models\Payment;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalSiswa      = Student::count();
        $totalTutor      = Tutor::where('status', 'aktif')->count();
        $totalBooking    = Booking::count();
        $bookingPending  = Booking::where('status_booking', 'pending')->count();
        $tutorPending    = Tutor::where('status', 'pending')->count();
        $paymentPending  = Payment::where('status', 'menunggu')->count();
        $totalPendapatan = Payment::where('status', 'berhasil')->sum('jumlah');

        // Chart: booking per 6 bulan terakhir
        $chartLabels = [];
        $chartBooking = [];
        $chartPendapatan = [];
        for ($i = 5; $i >= 0; $i--) {
            $bulan = now()->subMonths($i);
            $chartLabels[]     = $bulan->format('M Y');
            $chartBooking[]    = Booking::whereYear('tanggal_booking', $bulan->year)
                                        ->whereMonth('tanggal_booking', $bulan->month)->count();
            $chartPendapatan[] = (int) Payment::where('status', 'berhasil')
                                        ->whereYear('created_at', $bulan->year)
                                        ->whereMonth('created_at', $bulan->month)->sum('jumlah');
        }

        // Chart: status pembayaran (pie)
        $payBerhasil = Payment::where('status', 'berhasil')->count();
        $payMenunggu = Payment::where('status', 'menunggu')->count();
        $payGagal    = Payment::where('status', 'gagal')->count();

        return view('admin.dashboard', compact(
            'totalSiswa', 'totalTutor', 'totalBooking',
            'bookingPending', 'tutorPending', 'paymentPending', 'totalPendapatan',
            'chartLabels', 'chartBooking', 'chartPendapatan',
            'payBerhasil', 'payMenunggu', 'payGagal'
        ));
    }

    public function kelolaTutor()
    {
        $tutors = Tutor::with(['user', 'subject'])
            ->orderByRaw("FIELD(status, 'pending', 'aktif', 'ditolak')")
            ->orderByDesc('id')
            ->get();
        return view('admin.kelola-tutor', compact('tutors'));
    }

    public function updateTutorStatus(\Illuminate\Http\Request $request)
    {
        $tutorId = intval($request->input('tutor_id'));
        $status  = $request->input('status');

        if (!in_array($status, ['aktif', 'ditolak', 'pending'])) {
            return back()->with('error', 'Status tidak valid.');
        }

        Tutor::where('id', $tutorId)->update(['status' => $status]);
        return redirect()->route('admin.kelola-tutor')->with('success', 'Status tutor berhasil diperbarui.');
    }

    public function deleteTutor(\Illuminate\Http\Request $request)
    {
        $tutorId = intval($request->input('tutor_id'));
        Tutor::where('id', $tutorId)->delete();
        return redirect()->route('admin.kelola-tutor')->with('success', 'Tutor berhasil dihapus.');
    }

    public function kelolaPembayaran()
    {
        $bookings = Booking::with([
            'student.user',
            'schedule.tutor',
            'schedule.subject',
            'payment',
        ])
        ->orderByRaw("FIELD(COALESCE((SELECT status FROM payments WHERE booking_id = bookings.id LIMIT 1),'menunggu'),'menunggu','berhasil','gagal')")
        ->orderByDesc('id')
        ->get();

        return view('admin.kelola-pembayaran', compact('bookings'));
    }

    public function updatePembayaran(\Illuminate\Http\Request $request)
    {
        $bookingId       = intval($request->input('booking_id'));
        $statusPembayaran = $request->input('status_pembayaran');

        if (!in_array($statusPembayaran, ['menunggu', 'berhasil', 'gagal'])) {
            return back()->with('error', 'Status pembayaran tidak valid.');
        }

        $payment = Payment::where('booking_id', $bookingId)->first();
        if ($payment) {
            $payment->status = $statusPembayaran;
            if ($statusPembayaran === 'berhasil') {
                $payment->paid_at = now();
            }
            $payment->save();
        }

        $booking = Booking::find($bookingId);
        if ($booking) {
            if ($statusPembayaran === 'berhasil') {
                $booking->update(['status_pembayaran' => 'dibayar', 'status_booking' => 'diterima']);
            } elseif ($statusPembayaran === 'gagal') {
                $booking->update(['status_pembayaran' => 'ditolak', 'status_booking' => 'batal']);
            }
        }

        return redirect()->route('admin.kelola-pembayaran')->with('success', 'Status pembayaran berhasil diperbarui.');
    }
}
