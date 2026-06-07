<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Student;
use App\Models\Tutor;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BookingExport;
use App\Exports\PembayaranExport;

class ReportController extends Controller
{
    // ── PDF: Laporan Pembayaran ──────────────────────────────
    public function pdfPembayaran()
    {
        $bookings = Booking::with([
            'student',
            'schedule.tutor',
            'schedule.subject',
            'payment',
        ])->orderByDesc('id')->get();

        $totalBerhasil = Payment::where('status', 'berhasil')->sum('jumlah');
        $totalMenunggu = Payment::where('status', 'menunggu')->count();

        $pdf = Pdf::loadView('reports.pdf-pembayaran', compact('bookings', 'totalBerhasil', 'totalMenunggu'))
                  ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-pembayaran-' . now()->format('Y-m-d') . '.pdf');
    }

    // ── PDF: Laporan Booking ─────────────────────────────────
    public function pdfBooking()
    {
        $bookings = Booking::with([
            'student',
            'schedule.tutor',
            'schedule.subject',
            'payment',
        ])->orderByDesc('id')->get();

        $pdf = Pdf::loadView('reports.pdf-booking', compact('bookings'))
                  ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-booking-' . now()->format('Y-m-d') . '.pdf');
    }

    // ── Excel: Laporan Booking ───────────────────────────────
    public function excelBooking()
    {
        return Excel::download(new BookingExport, 'laporan-booking-' . now()->format('Y-m-d') . '.xlsx');
    }

    // ── Excel: Laporan Pembayaran ────────────────────────────
    public function excelPembayaran()
    {
        return Excel::download(new PembayaranExport, 'laporan-pembayaran-' . now()->format('Y-m-d') . '.xlsx');
    }
}
