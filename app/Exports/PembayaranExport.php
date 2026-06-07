<?php

namespace App\Exports;

use App\Models\Payment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PembayaranExport implements FromCollection, WithHeadings, WithStyles, WithTitle, ShouldAutoSize
{
    public function collection()
    {
        return Payment::with(['booking.student', 'booking.schedule.tutor', 'booking.schedule.subject'])
            ->orderByDesc('id')
            ->get()
            ->map(function ($p, $i) {
                return [
                    'No'             => $i + 1,
                    'Tanggal'        => $p->created_at ? $p->created_at->format('d/m/Y H:i') : '-',
                    'Nama Siswa'     => $p->booking->student->name ?? '-',
                    'Tutor'          => $p->booking->schedule->tutor->name ?? '-',
                    'Mata Pelajaran' => $p->booking->schedule->subject->nama_mapel ?? '-',
                    'Metode'         => ucfirst($p->metode),
                    'Jumlah (Rp)'    => $p->jumlah,
                    'Status'         => ucfirst($p->status),
                    'Dibayar Pada'   => $p->paid_at ? \Carbon\Carbon::parse($p->paid_at)->format('d/m/Y H:i') : '-',
                ];
            });
    }

    public function headings(): array
    {
        return ['No', 'Tanggal', 'Nama Siswa', 'Tutor', 'Mata Pelajaran', 'Metode', 'Jumlah (Rp)', 'Status', 'Dibayar Pada'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'FBBF24']]],
        ];
    }

    public function title(): string
    {
        return 'Laporan Pembayaran';
    }
}
