<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pembayaran - Brainova</title>
    @vite('resources/css/app.css')
</head>
<body>
<header class="app-topbar">
    <a href="/admin/dashboard" class="app-brand">
        Brainova
    </a>
</header>
<div class="siswa-layout">
    @include('admin.partials.sidebar')
    
    <main class="siswa-main">
        <h1 class="page-title">Kelola Pembayaran</h1>
        <p class="sub-text">Approve atau tolak pembayaran booking.</p>

        {{-- Export Buttons --}}
        <div style="display:flex;gap:10px;margin-bottom:24px;flex-wrap:wrap;">
            <a href="{{ route('admin.report.pdf-pembayaran') }}" class="btn btn-primary" target="_blank">
                📄 Download PDF Pembayaran
            </a>
            <a href="{{ route('admin.report.excel-pembayaran') }}" class="btn btn-secondary">
                📊 Download Excel Pembayaran
            </a>
            <a href="{{ route('admin.report.pdf-booking') }}" class="btn btn-secondary" target="_blank">
                📄 Download PDF Booking
            </a>
            <a href="{{ route('admin.report.excel-booking') }}" class="btn btn-secondary">
                📊 Download Excel Booking
            </a>
        </div>

        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif

        @if($bookings->isEmpty())
            <div class="empty-state">Belum ada booking.</div>
        @else
            @foreach($bookings as $b)
                @php
                    $payStatus = $b->payment->status ?? 'menunggu';
                    $sc = $b->schedule;
                    $tutor = $sc->tutor ?? null;
                @endphp
                <div class="card">
                    <div class="card-label">
                        Booking #{{ $b->id }}
                        <span class="badge-status badge-{{ $payStatus }}">{{ $payStatus }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Siswa</span>
                        <span class="info-value">{{ $b->student->name ?? '-' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Tutor</span>
                        <span class="info-value">{{ $tutor->name ?? '-' }} ({{ $sc->subject?->nama_mapel ?? '-' }})</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Jadwal</span>
                        <span class="info-value">{{ $sc->hari }}, {{ substr($sc->jam_mulai,0,5) }} - {{ substr($sc->jam_selesai,0,5) }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Jumlah</span>
                        <span class="info-value">Rp {{ number_format($b->payment->jumlah ?? $tutor->tarif ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Metode</span>
                        <span class="info-value">{{ ucfirst($b->payment->metode ?? $b->metode_pembayaran) }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Tanggal</span>
                        <span class="info-value">{{ \Carbon\Carbon::parse($b->tanggal_booking)->format('d M Y H:i') }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Status Booking</span>
                        <span class="info-value"><span class="badge-status badge-{{ $b->status_booking }}">{{ $b->status_booking }}</span></span>
                    </div>
                    @if($payStatus === 'menunggu')
                        <div class="btn-group">
                            <form method="POST" action="{{ route('admin.pembayaran.update') }}" style="display:inline">
                                @csrf
                                <input type="hidden" name="booking_id" value="{{ $b->id }}">
                                <input type="hidden" name="status_pembayaran" value="berhasil">
                                <button type="submit" class="btn-approve">✓ Approve Pembayaran</button>
                            </form>
                            <form method="POST" action="{{ route('admin.pembayaran.update') }}" style="display:inline">
                                @csrf
                                <input type="hidden" name="booking_id" value="{{ $b->id }}">
                                <input type="hidden" name="status_pembayaran" value="gagal">
                                <button type="submit" class="btn-reject">✕ Tolak</button>
                            </form>
                        </div>
                    @endif
                </div>
            @endforeach
        @endif
    </main>
</div>
</body>
</html>
