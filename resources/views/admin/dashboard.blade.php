<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Brainova</title>
    <link rel="stylesheet" href="{{ asset('css/brainova.css') }}">
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
        <h1 class="page-title">Dashboard Admin</h1>
        <p class="sub-text">Halo, {{ session('user.name') }}! Kelola platform Brainova dari sini.</p>

        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif

        <div class="stat-grid" style="margin-bottom: 32px;">
            <div class="stat-card"><div class="stat-number">{{ $totalSiswa }}</div><div class="stat-label">Total Siswa</div></div>
            <div class="stat-card"><div class="stat-number">{{ $totalTutor }}</div><div class="stat-label">Tutor Aktif</div></div>
            <div class="stat-card"><div class="stat-number">{{ $totalBooking }}</div><div class="stat-label">Total Booking</div></div>
            <div class="stat-card"><div class="stat-number">{{ $bookingPending }}</div><div class="stat-label">Booking Pending</div></div>
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
    </main>
</div>
</body>
</html>
