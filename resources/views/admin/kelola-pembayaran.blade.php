<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pembayaran - Brainova</title>
    <link rel="stylesheet" href="{{ asset('css/brainova.css') }}">
</head>
<body>
    <nav class="navbar">
        <a href="{{ route('admin.dashboard') }}" class="navbar-brand">Brainova</a>
        <div class="navbar-right">
            <span class="badge-role">Admin</span>
            <form method="POST" action="{{ route('logout') }}" style="display:inline">
                @csrf
                <button type="submit" class="btn-logout">Log out</button>
            </form>
        </div>
    </nav>

    <div class="dashboard-wrapper" style="max-width:800px">
        <a href="{{ route('admin.dashboard') }}" class="back-link">← Kembali ke Dashboard</a>
        <h1 class="page-title">Kelola Pembayaran</h1>
        <p class="sub-text">Approve atau tolak pembayaran booking.</p>

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
                        <span class="info-value">{{ $tutor->name ?? '-' }} ({{ $sc->subject->nama_mapel ?? '-' }})</span>
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
    </div>
</body>
</html>
