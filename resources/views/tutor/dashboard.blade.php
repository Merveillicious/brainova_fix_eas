<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Tutor - Brainova</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <style>
        body { margin: 0; font-family: 'Inter', sans-serif; }
    </style>
</head>
<body>
<header class="app-topbar">
    <a href="{{ route('tutor.dashboard') }}" class="app-brand">
        Brainova
    </a>
</header>
<div class="siswa-layout">
        @include('tutor.partials.sidebar')

        <main class="siswa-main">

            @if(session('success'))
                <div class="alert-success" style="margin-bottom:24px;">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert-error" style="margin-bottom:24px;">{{ session('error') }}</div>
            @endif

            <h1 class="dash-header-title" style="margin-bottom:6px;">Dashboard Tutor</h1>
            <p style="font-size:15px; color:#888; margin-bottom:32px;">Halo, {{ session('user.name') }}! Selamat datang kembali.</p>

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

                {{-- Quick Actions --}}
                <div class="nav-links" style="margin-bottom:28px;">
                    <a href="{{ route('tutor.jadwal') }}" class="nav-link" style="background:#FBBF24;">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <rect x="3" y="4" width="18" height="18" rx="2"/>
                            <line x1="16" y1="2" x2="16" y2="6"/>
                            <line x1="8"  y1="2" x2="8"  y2="6"/>
                            <line x1="3"  y1="10" x2="21" y2="10"/>
                        </svg>
                        Kelola Jadwal
                    </a>
                </div>

                {{-- Info Tutor --}}
                <div class="card">
                    <div class="card-label">Profil Tutor</div>
                    <div class="info-row">
                        <span class="info-label">Status</span>
                        <span class="info-value">
                            <span class="badge-status badge-{{ $tutor->status }}">{{ $tutor->status }}</span>
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Mata Pelajaran</span>
                        <span class="info-value">{{ $tutor->subject?->nama_mapel ?? '-' }}</span>
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

                {{-- Booking Masuk --}}
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
                                <span class="info-value">
                                    <span class="badge-status badge-{{ $payStatus }}">{{ $payStatus }}</span>
                                </span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Status</span>
                                <span class="info-value">
                                    <span class="badge-status badge-{{ $b->status_booking }}">{{ $b->status_booking }}</span>
                                </span>
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

        </main>
    </div>
</body>
</html>
