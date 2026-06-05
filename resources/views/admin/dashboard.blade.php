<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Brainova</title>
    <link rel="stylesheet" href="{{ asset('css/brainova.css') }}">
</head>
<body>
    <nav class="navbar">
        <span class="navbar-brand">Brainova</span>
        <div class="navbar-right">
            <span class="badge-role">Admin</span>
            <form method="POST" action="{{ route('logout') }}" style="display:inline">
                @csrf
                <button type="submit" class="btn-logout">Log out</button>
            </form>
        </div>
    </nav>

    <div class="dashboard-wrapper">
        <h1 class="page-title">Dashboard Admin</h1>
        <p class="sub-text">Halo, {{ session('user.name') }}! Kelola platform Brainova dari sini.</p>

        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif

        <div class="stat-grid">
            <div class="stat-card"><div class="stat-number">{{ $totalSiswa }}</div><div class="stat-label">Total Siswa</div></div>
            <div class="stat-card"><div class="stat-number">{{ $totalTutor }}</div><div class="stat-label">Tutor Aktif</div></div>
            <div class="stat-card"><div class="stat-number">{{ $totalBooking }}</div><div class="stat-label">Total Booking</div></div>
            <div class="stat-card"><div class="stat-number">{{ $bookingPending }}</div><div class="stat-label">Booking Pending</div></div>
        </div>

        <div class="nav-links">
            <a href="{{ route('admin.kelola-tutor') }}" class="nav-link">
                Kelola Tutor
                @if($tutorPending > 0)
                    <span class="badge-count">{{ $tutorPending }}</span>
                @endif
            </a>
            <a href="{{ route('admin.kelola-pembayaran') }}" class="nav-link">
                Kelola Pembayaran
                @if($paymentPending > 0)
                    <span class="badge-count">{{ $paymentPending }}</span>
                @endif
            </a>
        </div>

        <div class="card">
            <div class="card-label">Informasi Akun</div>
            <div class="info-row">
                <span class="info-label">Nama</span>
                <span class="info-value">{{ session('user.name') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Email</span>
                <span class="info-value">{{ session('user.email') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Role</span>
                <span class="info-value">Admin</span>
            </div>
        </div>
    </div>
</body>
</html>
