<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Tutor - Brainova</title>
    <link rel="stylesheet" href="{{ asset('css/brainova.css') }}">
</head>
<body>
    <nav class="navbar">
        <a href="{{ route('tutor.dashboard') }}" class="navbar-brand">Brainova</a>
        <div class="navbar-right">
            <span class="badge-role">Tutor</span>
            <form method="POST" action="{{ route('logout') }}" style="display:inline">
                @csrf
                <button type="submit" class="btn-logout">Log out</button>
            </form>
        </div>
    </nav>

    <div class="dashboard-wrapper">
        <h1 class="page-title">Dashboard Tutor</h1>
        <p class="sub-text">Halo, {{ session('user.name') }}!</p>

        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif

        @if(!$tutor)
            <div class="notice notice-warning">
                ⚠ <strong>Profil tutor belum lengkap.</strong> Hubungi admin untuk bantuan.
            </div>
        @else
            @if($tutor->status === 'pending')
                <div class="notice">
                    ⏳ <strong>Menunggu Approval.</strong> Akun tutor kamu sedang ditinjau oleh admin.
                </div>
            @elseif($tutor->status === 'ditolak')
                <div class="notice notice-warning">
                    ❌ <strong>Pendaftaran Ditolak.</strong> Silakan hubungi admin.
                </div>
            @endif

            <div class="nav-links">
                <a href="{{ route('tutor.profil') }}" class="nav-link">Edit Profil</a>
                <a href="{{ route('tutor.jadwal') }}" class="nav-link" style="background:#FBBF24;">Kelola Jadwal</a>
            </div>

            <div class="card">
                <div class="card-label">Profil Tutor</div>
                <div class="info-row">
                    <span class="info-label">Status</span>
                    <span class="info-value"><span class="badge-status badge-{{ $tutor->status }}">{{ $tutor->status }}</span></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Mata Pelajaran</span>
                    <span class="info-value">{{ $tutor->subject->nama_mapel ?? '-' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Bio</span>
                    <span class="info-value">{{ $tutor->bio ?: '-' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Tarif</span>
                    <span class="info-value">Rp {{ number_format($tutor->tarif, 0, ',', '.') }}</span>
                </div>
            </div>

            <h2 style="font-size:20px;font-weight:700;margin-bottom:16px;">Booking Masuk</h2>

            @if($bookings->isEmpty())
                <div class="empty-state">Belum ada booking masuk.</div>
            @else
                @foreach($bookings as $b)
                    @php
                        $sc = $b->schedule;
                        $payStatus = $b->payment->status ?? $b->status_pembayaran;
                    @endphp
                    <div class="card">
                        <div class="card-label">Booking #{{ $b->id }}</div>
                        <div class="info-row">
                            <span class="info-label">Siswa</span>
                            <span class="info-value">{{ $b->student->name ?? '-' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Jadwal</span>
                            <span class="info-value">{{ $sc->hari }}, {{ substr($sc->jam_mulai,0,5) }} - {{ substr($sc->jam_selesai,0,5) }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Tanggal Booking</span>
                            <span class="info-value">{{ \Carbon\Carbon::parse($b->tanggal_booking)->format('d M Y H:i') }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Pembayaran</span>
                            <span class="info-value"><span class="badge-status badge-{{ $payStatus }}">{{ $payStatus }}</span></span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Status</span>
                            <span class="info-value"><span class="badge-status badge-{{ $b->status_booking }}">{{ $b->status_booking }}</span></span>
                        </div>
                        @if($b->status_booking === 'diterima')
                            <div class="btn-group">
                                <form method="POST" action="{{ route('tutor.booking.status') }}">
                                    @csrf
                                    <input type="hidden" name="booking_id" value="{{ $b->id }}">
                                    <input type="hidden" name="status_booking" value="selesai">
                                    <button type="submit" class="btn-complete">✔ Tandai Selesai</button>
                                </form>
                            </div>
                        @endif
                    </div>
                @endforeach
            @endif
        @endif
    </div>
</body>
</html>
