<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Laporan Booking - Brainova</title>
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #111; background: #fff; }
    .header { background: #FBBF24; padding: 18px 24px; margin-bottom: 20px; border-bottom: 3px solid #000; }
    .header h1 { font-size: 20px; font-weight: bold; color: #000; }
    .header p  { font-size: 11px; color: #555; margin-top: 4px; }
    .summary { display: flex; gap: 16px; padding: 0 24px; margin-bottom: 20px; }
    .summary-card { background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px; padding: 12px 16px; flex: 1; }
    .summary-card .val { font-size: 16px; font-weight: bold; color: #000; }
    .summary-card .lbl { font-size: 10px; color: #888; margin-top: 2px; }
    table { width: 100%; border-collapse: collapse; margin: 0 24px; width: calc(100% - 48px); }
    th { background: #FBBF24; color: #000; font-weight: bold; padding: 8px 10px; text-align: left; font-size: 10px; text-transform: uppercase; letter-spacing: .04em; border: 1px solid #000; }
    td { padding: 7px 10px; border: 1px solid #e5e7eb; font-size: 10px; }
    tr:nth-child(even) td { background: #fafafa; }
    .badge { display: inline-block; padding: 2px 8px; border-radius: 20px; font-size: 9px; font-weight: bold; }
    .badge-pending  { background: #fef3c7; color: #92400e; }
    .badge-diterima { background: #d1fae5; color: #065f46; }
    .badge-selesai  { background: #dbeafe; color: #1e40af; }
    .badge-batal    { background: #f3f4f6; color: #6b7280; }
    .footer { margin-top: 24px; padding: 12px 24px; font-size: 10px; color: #888; border-top: 1px solid #e5e7eb; text-align: center; }
</style>
</head>
<body>
<div class="header">
    <h1>📋 Laporan Booking — Brainova</h1>
    <p>Dicetak pada: {{ now()->format('d F Y H:i') }} WIB</p>
</div>

<div class="summary">
    <div class="summary-card">
        <div class="val">{{ $bookings->count() }}</div>
        <div class="lbl">Total Booking</div>
    </div>
    <div class="summary-card">
        <div class="val">{{ $bookings->where('status_booking', 'pending')->count() }}</div>
        <div class="lbl">Pending</div>
    </div>
    <div class="summary-card">
        <div class="val">{{ $bookings->where('status_booking', 'diterima')->count() }}</div>
        <div class="lbl">Diterima</div>
    </div>
    <div class="summary-card">
        <div class="val">{{ $bookings->where('status_booking', 'selesai')->count() }}</div>
        <div class="lbl">Selesai</div>
    </div>
</div>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Siswa</th>
            <th>Tutor</th>
            <th>Mata Pelajaran</th>
            <th>Hari/Jam</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($bookings as $i => $b)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $b->tanggal_booking ? \Carbon\Carbon::parse($b->tanggal_booking)->format('d/m/Y') : '-' }}</td>
            <td>{{ $b->student->name ?? '-' }}</td>
            <td>{{ $b->schedule->tutor->name ?? '-' }}</td>
            <td>{{ $b->schedule->subject?->nama_mapel ?? '-' }}</td>
            <td>{{ $b->schedule->hari ?? '-' }}, {{ $b->schedule->jam_mulai ?? '-' }}</td>
            <td>
                <span class="badge badge-{{ $b->status_booking }}">
                    {{ ucfirst($b->status_booking) }}
                </span>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="footer">
    Brainova — Platform Les Privat Online &nbsp;|&nbsp; Laporan ini digenerate otomatis oleh sistem
</div>
</body>
</html>
