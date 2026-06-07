<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Brainova</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <style>
        body { margin: 0; font-family: 'Inter', sans-serif; }
        .chart-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 24px; }
        .chart-card { background: #fff; border: 2px solid #000; border-radius: 14px; padding: 24px; }
        .chart-card-title { font-size: 15px; font-weight: 800; color: #000; margin-bottom: 18px; display: flex; align-items: center; gap: 8px; }
        .chart-wrap { position: relative; height: 230px; }
        @media(max-width:768px){ .chart-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
<header class="app-topbar">
    <a href="/admin/dashboard" class="app-brand">Brainova</a>
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

        {{-- Stat Cards --}}
        <div class="stat-grid" style="grid-template-columns:repeat(4,1fr);margin-bottom:24px;">
            <div class="stat-card">
                <div class="stat-number">{{ $totalSiswa }}</div>
                <div class="stat-label">Total Siswa</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $totalTutor }}</div>
                <div class="stat-label">Tutor Aktif</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $totalBooking }}</div>
                <div class="stat-label">Total Booking</div>
            </div>
            <div class="stat-card" style="background:#FBBF24;">
                <div class="stat-number">Rp {{ number_format($totalPendapatan,0,',','.') }}</div>
                <div class="stat-label">Total Pendapatan</div>
            </div>
        </div>

        {{-- Pending alerts --}}
        @if($tutorPending > 0 || $paymentPending > 0)
        <div style="display:flex;gap:12px;margin-bottom:24px;flex-wrap:wrap;">
            @if($tutorPending > 0)
            <a href="{{ route('admin.kelola-tutor') }}" class="notice" style="flex:1;min-width:200px;text-decoration:none;display:block;">
                ⏳ <strong>{{ $tutorPending }}</strong> tutor menunggu persetujuan
            </a>
            @endif
            @if($paymentPending > 0)
            <a href="{{ route('admin.kelola-pembayaran') }}" class="notice" style="flex:1;min-width:200px;text-decoration:none;display:block;">
                💳 <strong>{{ $paymentPending }}</strong> pembayaran menunggu konfirmasi
            </a>
            @endif
        </div>
        @endif

        {{-- Charts --}}
        <div class="chart-grid">
            {{-- Bar Chart: Booking per Bulan --}}
            <div class="chart-card">
                <div class="chart-card-title">
                    📊 Booking per Bulan (6 Bulan Terakhir)
                </div>
                <div class="chart-wrap">
                    <canvas id="bookingChart"></canvas>
                </div>
            </div>

            {{-- Pie Chart: Status Pembayaran --}}
            <div class="chart-card">
                <div class="chart-card-title">
                    💰 Status Pembayaran
                </div>
                <div class="chart-wrap">
                    <canvas id="paymentChart"></canvas>
                </div>
            </div>
        </div>

        {{-- Pendapatan per Bulan --}}
        <div class="chart-card" style="margin-bottom:24px;">
            <div class="chart-card-title">📈 Pendapatan per Bulan (6 Bulan Terakhir)</div>
            <div class="chart-wrap" style="height:200px;">
                <canvas id="pendapatanChart"></canvas>
            </div>
        </div>

        {{-- Info Card --}}
        <div class="card">
            <div class="card-label">Informasi Akun Admin</div>
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

<script>
const chartLabels    = @json($chartLabels);
const chartBooking   = @json($chartBooking);
const chartPendapatan= @json($chartPendapatan);
const payBerhasil    = {{ $payBerhasil }};
const payMenunggu    = {{ $payMenunggu }};
const payGagal       = {{ $payGagal }};

// ── Bar Chart: Booking ──
new Chart(document.getElementById('bookingChart').getContext('2d'), {
    type: 'bar',
    data: {
        labels: chartLabels,
        datasets: [{
            label: 'Jumlah Booking',
            data: chartBooking,
            backgroundColor: chartLabels.map((l, i) => i === chartLabels.length - 1 ? '#FBBF24' : '#e5e7eb'),
            borderRadius: 6,
            borderSkipped: false,
            hoverBackgroundColor: '#f59e0b',
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: '#000',
                titleColor: '#fff',
                bodyColor: '#FBBF24',
                padding: 10,
                cornerRadius: 8,
            }
        },
        scales: {
            x: { grid: { display: false }, border: { display: false } },
            y: {
                grid: { color: '#f3f4f6' },
                border: { display: false },
                ticks: { precision: 0, color: '#9ca3af', font: { size: 11 } },
                beginAtZero: true,
            }
        }
    }
});

// ── Pie Chart: Status Pembayaran ──
new Chart(document.getElementById('paymentChart').getContext('2d'), {
    type: 'doughnut',
    data: {
        labels: ['Berhasil', 'Menunggu', 'Gagal'],
        datasets: [{
            data: [payBerhasil, payMenunggu, payGagal],
            backgroundColor: ['#d1fae5', '#fef3c7', '#fee2e2'],
            borderColor: ['#000', '#000', '#000'],
            borderWidth: 2,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
                labels: { font: { size: 12, family: 'Inter' }, padding: 16 }
            },
            tooltip: {
                backgroundColor: '#000',
                titleColor: '#fff',
                bodyColor: '#FBBF24',
                padding: 10,
                cornerRadius: 8,
            }
        },
        cutout: '65%',
    }
});

// ── Line Chart: Pendapatan ──
new Chart(document.getElementById('pendapatanChart').getContext('2d'), {
    type: 'line',
    data: {
        labels: chartLabels,
        datasets: [{
            label: 'Pendapatan (Rp)',
            data: chartPendapatan,
            borderColor: '#FBBF24',
            backgroundColor: 'rgba(251,191,36,0.1)',
            borderWidth: 2.5,
            pointBackgroundColor: '#FBBF24',
            pointBorderColor: '#000',
            pointBorderWidth: 2,
            pointRadius: 5,
            tension: 0.4,
            fill: true,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: '#000',
                titleColor: '#fff',
                bodyColor: '#FBBF24',
                padding: 10,
                cornerRadius: 8,
                callbacks: {
                    label: ctx => 'Rp ' + ctx.parsed.y.toLocaleString('id-ID')
                }
            }
        },
        scales: {
            x: { grid: { display: false }, border: { display: false } },
            y: {
                grid: { color: '#f3f4f6' },
                border: { display: false },
                ticks: {
                    color: '#9ca3af',
                    font: { size: 11 },
                    callback: val => val >= 1000000 ? (val/1000000)+'M' : val >= 1000 ? (val/1000)+'K' : val
                },
                beginAtZero: true,
            }
        }
    }
});
</script>
</body>
</html>
