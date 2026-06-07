<?php

namespace App\Exports;

use App\Models\Booking;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BookingExport implements FromCollection, WithHeadings, WithStyles, WithTitle, ShouldAutoSize
{
    public function collection()
    {
        return Booking::with(['student', 'schedule.tutor', 'schedule.subject', 'payment'])
            ->orderByDesc('id')
            ->get()
            ->map(function ($b, $i) {
                return [
                    'No'              => $i + 1,
                    'Tanggal Booking' => $b->tanggal_booking ? \Carbon\Carbon::parse($b->tanggal_booking)->format('d/m/Y H:i') : '-',
                    'Nama Siswa'      => $b->student->name ?? '-',
                    'Tutor'           => $b->schedule->tutor->name ?? '-',
                    'Mata Pelajaran'  => $b->schedule->subject->nama_mapel ?? '-',
                    'Hari'            => $b->schedule->hari ?? '-',
                    'Jam'             => ($b->schedule->jam_mulai ?? '-') . ' - ' . ($b->schedule->jam_selesai ?? '-'),
                    'Metode Bayar'    => ucfirst($b->metode_pembayaran),
                    'Status Booking'  => ucfirst($b->status_booking),
                    'Status Bayar'    => ucfirst($b->payment->status ?? '-'),
                    'Jumlah (Rp)'     => $b->payment->jumlah ?? 0,
                ];
            });
    }

    public function headings(): array
    {
        return ['No', 'Tanggal Booking', 'Nama Siswa', 'Tutor', 'Mata Pelajaran', 'Hari', 'Jam', 'Metode Bayar', 'Status Booking', 'Status Bayar', 'Jumlah (Rp)'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'FBBF24']]],
        ];
    }

    public function title(): string
    {
        return 'Laporan Booking';
    }
}
