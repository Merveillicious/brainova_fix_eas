<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemasukan - Brainova</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <style>
        body { margin: 0; font-family: 'Inter', sans-serif; background: #fafafa; }

        /* ── Page Header ── */
        .pm-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 28px;
            flex-wrap: wrap;
            gap: 12px;
        }
        .pm-title    { font-size: 28px; font-weight: 800; color: #000; letter-spacing: -.5px; margin-bottom: 4px; }
        .pm-subtitle { font-size: 14px; color: #6b7280; }

        .btn-tarik-saldo {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 11px 20px;
            background: #FBBF24;
            border: 2px solid #000;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 700;
            color: #000;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            white-space: nowrap;
            transition: background .15s, transform .1s;
            text-decoration: none;
        }
        .btn-tarik-saldo:hover  { background: #f59e0b; transform: translateY(-1px); }
        .btn-tarik-saldo:active { transform: translateY(0); }

        /* ── Stat Cards ── */
        .pm-stat-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-bottom: 24px;
        }
        .pm-stat-card {
            background: #fff;
            border: 2px solid #000;
            border-radius: 16px;
            padding: 22px 24px;
            position: relative;
            overflow: hidden;
        }
        .pm-stat-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
        }
        .pm-stat-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: #6b7280;
        }
        .pm-stat-icon {
            width: 38px; height: 38px;
            border-radius: 10px;
            background: #fff8e6;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }
        .pm-stat-value {
            font-size: 24px;
            font-weight: 800;
            color: #000;
            margin-bottom: 6px;
            letter-spacing: -.5px;
        }
        .pm-stat-meta {
            font-size: 12px;
            color: #6b7280;
        }
        .pm-stat-meta.positive { color: #16a34a; font-weight: 600; }

        /* ── Chart Card ── */
        .pm-card {
            background: #fff;
            border: 2px solid #000;
            border-radius: 16px;
            padding: 24px 28px;
            margin-bottom: 24px;
        }
        .pm-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .pm-card-title {
            font-size: 16px;
            font-weight: 800;
            color: #000;
        }
        .btn-period {
            padding: 6px 14px;
            background: #f3f4f6;
            border: 2px solid #000;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            color: #374151;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            transition: background .15s;
        }
        .btn-period:hover { background: #e5e7eb; }

        .chart-container {
            position: relative;
            height: 240px;
        }

        /* ── Transaction Table ── */
        .pm-table-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
        }
        .pm-table-title { font-size: 16px; font-weight: 800; color: #000; }
        .pm-lihat-semua {
            font-size: 13px;
            font-weight: 600;
            color: #f59e0b;
            text-decoration: none;
            transition: opacity .15s;
        }
        .pm-lihat-semua:hover { opacity: .7; }

        .pm-table {
            width: 100%;
            border-collapse: collapse;
        }
        .pm-table th {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: #9ca3af;
            text-align: left;
            padding: 0 12px 12px;
            border-bottom: 2px solid #000;
        }
        .pm-table td {
            padding: 14px 12px;
            font-size: 14px;
            color: #374151;
            border-bottom: 2px solid #000;
            vertical-align: middle;
        }
        .pm-table tr:last-child td { border-bottom: none; }
        .pm-table tr:hover td { background: #fafafa; }

        /* Avatar in table */
        .trx-avatar {
            width: 34px; height: 34px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 800;
            color: #fff;
            margin-right: 10px;
            flex-shrink: 0;
        }
        .trx-name-cell {
            display: flex;
            align-items: center;
        }
        .trx-name { font-weight: 600; color: #111; }

        /* Amount */
        .trx-amount-pos { font-weight: 700; color: #111; }
        .trx-amount-neg { font-weight: 700; color: #ef4444; }

        /* Status badges */
        .trx-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .trx-badge-selesai   { background: #dcfce7; color: #166534; }
        .trx-badge-diproses  { background: #fef9c3; color: #854d0e; }
        .trx-badge-gagal     { background: #fee2e2; color: #991b1b; }

        /* Responsive */
        @media (max-width: 768px) {
            .pm-stat-grid { grid-template-columns: 1fr; }
            .pm-table th:nth-child(3),
            .pm-table td:nth-child(3) { display: none; }
        }
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

    <main class="siswa-main" style="max-height: calc(100vh - 70px); overflow-y: auto;">

        {{-- Header --}}
        <div class="pm-header">
            <div>
                <div class="pm-title">Pemasukan</div>
                <div class="pm-subtitle">Ringkasan pendapatan dan riwayat transaksi Anda.</div>
            </div>
            <button class="btn-tarik-saldo" onclick="document.getElementById('modalTarikSaldo').style.display='flex'">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="2" y="5" width="20" height="14" rx="2"/>
                    <line x1="2" y1="10" x2="22" y2="10"/>
                </svg>
                Tarik Saldo
            </button>
        </div>

        {{-- Alert Messages --}}
        @if(session('success_tarik'))
        <div style="background:#f0fdf4;border:2px solid #16a34a;border-radius:10px;padding:14px 18px;margin-bottom:20px;display:flex;align-items:center;gap:10px;font-size:14px;color:#15803d;font-weight:600;">
            ✅ {{ session('success_tarik') }}
        </div>
        @endif
        @if(session('error_tarik'))
        <div style="background:#fef2f2;border:2px solid #dc2626;border-radius:10px;padding:14px 18px;margin-bottom:20px;display:flex;align-items:center;gap:10px;font-size:14px;color:#dc2626;font-weight:600;">
            ⚠️ {{ session('error_tarik') }}
        </div>
        @endif

        {{-- Stat Cards --}}
        @php
            if (!isset($totalPendapatan)) $totalPendapatan = 0;
            if (!isset($bulanIni))        $bulanIni        = 0;
            if (!isset($bookingData))     $bookingData     = collect();
            // Gunakan $saldoTersedia dari controller (sudah dikurangi penarikan)
            if (!isset($saldoTersedia))   $saldoTersedia   = $totalPendapatan * 0.85;
        @endphp

        <div class="pm-stat-grid">
            {{-- Total Pendapatan --}}
            <div class="pm-stat-card">
                <div class="pm-stat-top">
                    <div class="pm-stat-label">Total Pendapatan</div>
                </div>
                <div class="pm-stat-value">Rp {{ $totalPendapatan > 0 ? number_format($totalPendapatan, 0, ',', '.') : '0' }}</div>
                <div class="pm-stat-meta positive">⬆ +12% dari bulan lalu</div>
            </div>

            {{-- Bulan Ini --}}
            <div class="pm-stat-card">
                <div class="pm-stat-top">
                    <div class="pm-stat-label">Bulan Ini</div>
                </div>
                <div class="pm-stat-value">Rp {{ $bulanIni > 0 ? number_format($bulanIni, 0, ',', '.') : '0' }}</div>
                <div class="pm-stat-meta">{{ now()->translatedFormat('F Y') ?: $bulanLabel }}</div>
            </div>

            {{-- Saldo Tersedia --}}
            <div class="pm-stat-card">
                <div class="pm-stat-top">
                    <div class="pm-stat-label">Saldo Tersedia</div>
                </div>
                <div class="pm-stat-value">Rp {{ number_format($saldoTersedia, 0, ',', '.') }}</div>
                <div class="pm-stat-meta">Siap ditarik</div>
            </div>
        </div>

        {{-- Bar Chart --}}
        <div class="pm-card">
            <div class="pm-card-header">
                <div class="pm-card-title">Statistik Pemasukan</div>
                <button class="btn-period" id="periodBtn" onclick="togglePeriod()">6 Bulan Terakhir</button>
            </div>
            <div class="chart-container">
                <canvas id="incomeChart"></canvas>
            </div>
        </div>

        {{-- Riwayat Transaksi --}}
        <div class="pm-card">
            <div class="pm-table-header">
                <div class="pm-table-title">Riwayat Transaksi</div>
                <a href="#" class="pm-lihat-semua">Lihat Semua</a>
            </div>

            @php
                $demoTrx = [
                    ['tanggal' => '24 Okt 2023', 'nama' => 'Anita Sari',       'inisial' => 'AS', 'warna' => '#6366f1', 'kelas' => 'Matematika SMA',  'jumlah' => 150000,    'type' => '+', 'status' => 'selesai'],
                    ['tanggal' => '22 Okt 2023', 'nama' => 'Dimas Nugroho',    'inisial' => 'DN', 'warna' => '#0ea5e9', 'kelas' => 'Fisika Dasar',     'jumlah' => 200000,    'type' => '+', 'status' => 'selesai'],
                    ['tanggal' => '20 Okt 2023', 'nama' => 'Wulan Dewi',       'inisial' => 'WD', 'warna' => '#f59e0b', 'kelas' => 'Persiapan UTBK',  'jumlah' => 250000,    'type' => '+', 'status' => 'diproses'],
                    ['tanggal' => '18 Okt 2023', 'nama' => 'Penarikan Saldo',  'inisial' => '🏦', 'warna' => '#6b7280', 'kelas' => 'Transfer Bank',    'jumlah' => 1000000,   'type' => '-', 'status' => 'selesai'],
                    ['tanggal' => '15 Okt 2023', 'nama' => 'Rizky Pratama',    'inisial' => 'RP', 'warna' => '#10b981', 'kelas' => 'Kimia Dasar',      'jumlah' => 175000,    'type' => '+', 'status' => 'selesai'],
                    ['tanggal' => '12 Okt 2023', 'nama' => 'Sari Indah',       'inisial' => 'SI', 'warna' => '#ef4444', 'kelas' => 'Bahasa Inggris',   'jumlah' => 200000,    'type' => '+', 'status' => 'selesai'],
                ];

                // Coba ambil data real dari DB jika ada
                $realTrx = collect();
                if (isset($tutor) && $tutor) {
                    $realTrx = \App\Models\Booking::whereHas('schedule', fn($q) => $q->where('tutor_id', $tutor->id))
                        ->with(['student', 'schedule.subject', 'payment'])
                        ->orderByDesc('id')
                        ->limit(10)
                        ->get();
                }
                $hasTrx = $realTrx->isNotEmpty();
            @endphp

            <table class="pm-table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Nama Siswa</th>
                        <th>Jenis Kelas</th>
                        <th style="text-align:right;">Jumlah</th>
                        <th style="text-align:center;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @if($hasTrx)
                        @foreach($realTrx as $b)
                            @php
                                $nama   = $b->student->name ?? 'Siswa';
                                $words  = explode(' ', $nama);
                                $inits  = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
                                $mapel  = $b->schedule->subject?->nama_mapel ?? '-';
                                $jumlah = $b->payment->jumlah ?? ($tutor->tarif ?? 0);
                                $colors = ['#6366f1','#0ea5e9','#10b981','#f59e0b','#ef4444','#8b5cf6'];
                                $color  = $colors[$b->id % count($colors)];
                                $status = $b->status_booking;
                            @endphp
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($b->tanggal_booking)->format('d M Y') }}</td>
                                <td>
                                    <div class="trx-name-cell">
                                        <span class="trx-avatar" style="background:{{ $color }};">{{ $inits }}</span>
                                        <span class="trx-name">{{ $nama }}</span>
                                    </div>
                                </td>
                                <td>{{ $mapel }}</td>
                                <td style="text-align:right;">
                                    <span class="trx-amount-pos">+ Rp {{ number_format($jumlah, 0, ',', '.') }}</span>
                                </td>
                                <td style="text-align:center;">
                                    <span class="trx-badge trx-badge-{{ $status === 'selesai' ? 'selesai' : ($status === 'diterima' ? 'diproses' : 'gagal') }}">
                                        {{ ucfirst($status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        {{-- Demo data --}}
                        @foreach($demoTrx as $trx)
                        <tr>
                            <td>{{ $trx['tanggal'] }}</td>
                            <td>
                                <div class="trx-name-cell">
                                    @if(strlen($trx['inisial']) <= 2)
                                        <span class="trx-avatar" style="background:{{ $trx['warna'] }};">{{ $trx['inisial'] }}</span>
                                    @else
                                        <span class="trx-avatar" style="background:{{ $trx['warna'] }}; font-size:18px;">{{ $trx['inisial'] }}</span>
                                    @endif
                                    <span class="trx-name">{{ $trx['nama'] }}</span>
                                </div>
                            </td>
                            <td>{{ $trx['kelas'] }}</td>
                            <td style="text-align:right;">
                                @if($trx['type'] === '+')
                                    <span class="trx-amount-pos">+ Rp {{ number_format($trx['jumlah'], 0, ',', '.') }}</span>
                                @else
                                    <span class="trx-amount-neg">- Rp {{ number_format($trx['jumlah'], 0, ',', '.') }}</span>
                                @endif
                            </td>
                            <td style="text-align:center;">
                                <span class="trx-badge trx-badge-{{ $trx['status'] }}">
                                    {{ ucfirst($trx['status']) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>

        {{-- ══ Riwayat Penarikan ══ --}}
        <div class="pm-card" style="margin-top:24px;">
            <div class="pm-table-header">
                <div class="pm-table-title">Riwayat Penarikan Saldo</div>
            </div>

            @if(isset($withdrawals) && $withdrawals->isNotEmpty())
            <div style="overflow-x:auto;">
                <table style="width:100%;border-collapse:collapse;font-size:14px;">
                    <thead>
                        <tr style="background:#f9fafb;">
                            <th style="padding:10px 16px;text-align:left;font-size:11px;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:.05em;">Tanggal</th>
                            <th style="padding:10px 16px;text-align:left;font-size:11px;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:.05em;">Jumlah</th>
                            <th style="padding:10px 16px;text-align:left;font-size:11px;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:.05em;">Metode</th>
                            <th style="padding:10px 16px;text-align:left;font-size:11px;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:.05em;">Rekening</th>
                            <th style="padding:10px 16px;text-align:center;font-size:11px;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:.05em;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($withdrawals as $wd)
                        @php
                            $wdMetode = ['transfer_bank'=>'🏦 Bank','gopay'=>'💚 GoPay','ovo'=>'💜 OVO','dana'=>'🔵 DANA'][$wd->metode] ?? $wd->metode;
                            $wdBadge  = ['pending'=>'background:#fef3c7;color:#92400e;border:1.5px solid #FBBF24;',
                                         'diproses'=>'background:#dbeafe;color:#1e40af;border:1.5px solid #3b82f6;',
                                         'berhasil'=>'background:#dcfce7;color:#166534;border:1.5px solid #16a34a;',
                                         'ditolak'=>'background:#fee2e2;color:#991b1b;border:1.5px solid #ef4444;'][$wd->status] ?? '';
                        @endphp
                        <tr style="border-bottom:1px solid #f3f4f6;">
                            <td style="padding:12px 16px;color:#374151;">
                                {{ \Carbon\Carbon::parse($wd->created_at)->format('d M Y') }}
                                <div style="font-size:11px;color:#9ca3af;">{{ \Carbon\Carbon::parse($wd->created_at)->format('H:i') }}</div>
                            </td>
                            <td style="padding:12px 16px;font-size:15px;font-weight:800;color:#ef4444;">
                                - Rp {{ number_format($wd->jumlah, 0, ',', '.') }}
                            </td>
                            <td style="padding:12px 16px;font-size:13px;font-weight:600;">{{ $wdMetode }}</td>
                            <td style="padding:12px 16px;font-family:monospace;font-size:13px;font-weight:700;">
                                {{ $wd->nomor_rekening }}
                                <div style="font-size:11px;color:#6b7280;font-family:inherit;font-weight:400;">{{ $wd->nama_pemilik }}</div>
                            </td>
                            <td style="padding:12px 16px;text-align:center;">
                                <span style="display:inline-block;padding:4px 10px;border-radius:20px;font-size:11px;font-weight:700;text-transform:uppercase;{{ $wdBadge }}">
                                    {{ ucfirst($wd->status) }}
                                </span>
                                @if($wd->catatan)
                                <div style="font-size:11px;color:#6b7280;margin-top:4px;">{{ $wd->catatan }}</div>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div style="padding:40px;text-align:center;color:#9ca3af;">
                <div style="font-size:36px;margin-bottom:8px;">💸</div>
                <div style="font-size:14px;font-weight:600;color:#6b7280;">Belum ada riwayat penarikan saldo.</div>
                <div style="font-size:12px;margin-top:4px;">Klik tombol <strong>Tarik Saldo</strong> di atas untuk mengajukan penarikan.</div>
            </div>
            @endif
        </div>

    </main>
</div>

@php
    $safeLabels = isset($chartLabels) ? $chartLabels : ['Jan','Feb','Mar','Apr','Mei','Jun'];
    $safeValues = isset($chartValues) ? $chartValues : [0,0,0,0,0,0];
@endphp
<script>
    /* ── Bar Chart ── */
    const ctx = document.getElementById('incomeChart').getContext('2d');

    const chartLabels = @json($safeLabels);
    const chartValues = @json($safeValues);

    const data6 = { labels: chartLabels, values: chartValues };
    const data12 = { labels: chartLabels, values: chartValues };
    let currentPeriod = 6;

    @verbatim
    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: data6.labels,
            datasets: [{
                data: data6.values,
                backgroundColor: data6.labels.map((l, i) => i === data6.labels.length - 1 ? '#FBBF24' : '#e5e7eb'),
                borderRadius: 6,
                borderSkipped: false,
                hoverBackgroundColor: '#f59e0b',
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(ctx) { return 'Rp ' + ctx.parsed.y.toLocaleString('id-ID'); },
                    },
                    backgroundColor: '#000',
                    titleColor: '#fff',
                    bodyColor: '#FBBF24',
                    padding: 10,
                    cornerRadius: 8,
                },
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: {
                        font: { size: 12, family: 'Inter', weight: '600' },
                        color: '#9ca3af',
                    },
                    border: { display: false },
                },
                y: {
                    grid: { color: '#f3f4f6' },
                    border: { display: false, dash: [4, 4] },
                    ticks: {
                        font: { size: 11, family: 'Inter' },
                        color: '#9ca3af',
                        callback: function(val) {
                            if (val >= 1000000) return (val / 1000000) + 'M';
                            if (val >= 1000) return (val / 1000) + 'K';
                            return val;
                        },
                    },
                    beginAtZero: true,
                },
            },
        },
    });

    function togglePeriod() {
        const btn = document.getElementById('periodBtn');
        if (currentPeriod === 6) {
            currentPeriod = 12;
            btn.textContent = '12 Bulan Terakhir';
            chart.data.labels   = data12.labels;
            chart.data.datasets[0].data = data12.values;
            chart.data.datasets[0].backgroundColor = data12.values.map((v, i) =>
                i === data12.values.length - 1 ? '#FBBF24' : '#e5e7eb'
            );
        } else {
            currentPeriod = 6;
            btn.textContent = '6 Bulan Terakhir';
            chart.data.labels   = data6.labels;
            chart.data.datasets[0].data = data6.values;
            chart.data.datasets[0].backgroundColor = data6.values.map((v, i) =>
                i === data6.values.length - 1 ? '#FBBF24' : '#e5e7eb'
            );
        }
        chart.update();
    }
    @endverbatim
</script>

{{-- ══ Modal Tarik Saldo ══ --}}
<div id="modalTarikSaldo"
     style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:9999;align-items:center;justify-content:center;padding:20px;"
     onclick="if(event.target===this)this.style.display='none'">
    <div style="background:#fff;border:2px solid #000;border-radius:16px;width:100%;max-width:480px;padding:32px;position:relative;">

        {{-- Close --}}
        <button onclick="document.getElementById('modalTarikSaldo').style.display='none'"
                style="position:absolute;top:16px;right:16px;background:none;border:none;font-size:22px;cursor:pointer;color:#666;">✕</button>

        <h2 style="font-size:20px;font-weight:800;color:#000;margin:0 0 6px;">Tarik Saldo</h2>
        <p style="font-size:13px;color:#6b7280;margin:0 0 24px;">
            Saldo tersedia: <strong style="color:#16a34a;">
                @php
                    $_saldo = $saldoTersedia ?? 0;
                @endphp
                Rp {{ number_format($_saldo, 0, ',', '.') }}
            </strong>
        </p>

        <form method="POST" action="{{ route('tutor.saldo.tarik') }}">
            @csrf

            {{-- Jumlah --}}
            <div style="margin-bottom:16px;">
                <label style="display:block;font-size:13px;font-weight:700;color:#000;margin-bottom:6px;">
                    Jumlah Penarikan <span style="color:#ef4444;">*</span>
                </label>
                <div style="position:relative;">
                    <span style="position:absolute;left:14px;top:50%;transform:translateY(-50%);font-weight:700;color:#374151;">Rp</span>
                    <input type="number" name="jumlah" min="50000" max="{{ (int)($_saldo ?? 0) }}"
                           placeholder="50.000"
                           style="width:100%;padding:12px 12px 12px 40px;border:2px solid #000;border-radius:10px;font-size:15px;font-weight:700;font-family:inherit;box-sizing:border-box;"
                           required>
                </div>
                <div style="font-size:11px;color:#9ca3af;margin-top:4px;">Minimum Rp 50.000</div>
            </div>

            {{-- Metode --}}
            <div style="margin-bottom:16px;">
                <label style="display:block;font-size:13px;font-weight:700;color:#000;margin-bottom:6px;">
                    Metode Penarikan <span style="color:#ef4444;">*</span>
                </label>
                <select name="metode" required
                        style="width:100%;padding:12px;border:2px solid #000;border-radius:10px;font-size:14px;font-family:inherit;background:#fff;">
                    <option value="transfer_bank">🏦 Transfer Bank</option>
                    <option value="gopay">💚 GoPay</option>
                    <option value="ovo">💜 OVO</option>
                    <option value="dana">🔵 DANA</option>
                </select>
            </div>

            {{-- Nomor Rekening / Akun --}}
            <div style="margin-bottom:16px;">
                <label style="display:block;font-size:13px;font-weight:700;color:#000;margin-bottom:6px;">
                    Nomor Rekening / Akun E-Wallet <span style="color:#ef4444;">*</span>
                </label>
                <input type="text" name="nomor_rekening" placeholder="Contoh: 1234567890"
                       style="width:100%;padding:12px;border:2px solid #000;border-radius:10px;font-size:14px;font-family:inherit;box-sizing:border-box;"
                       required>
            </div>

            {{-- Nama Pemilik --}}
            <div style="margin-bottom:24px;">
                <label style="display:block;font-size:13px;font-weight:700;color:#000;margin-bottom:6px;">
                    Nama Pemilik Rekening <span style="color:#ef4444;">*</span>
                </label>
                <input type="text" name="nama_pemilik" placeholder="Sesuai nama di rekening"
                       value="{{ session('user.name') }}"
                       style="width:100%;padding:12px;border:2px solid #000;border-radius:10px;font-size:14px;font-family:inherit;box-sizing:border-box;"
                       required>
            </div>

            {{-- Info --}}
            <div style="background:#fffbeb;border:1.5px solid #FBBF24;border-radius:10px;padding:12px 14px;margin-bottom:20px;font-size:12px;color:#92400e;line-height:1.6;">
                ⏱️ Proses penarikan membutuhkan <strong>1×24 jam kerja</strong>.<br>
                📊 Saldo yang tersedia sudah dipotong biaya platform 15%.
            </div>

            <div style="display:flex;gap:12px;">
                <button type="button"
                        onclick="document.getElementById('modalTarikSaldo').style.display='none'"
                        style="flex:1;padding:13px;border:2px solid #000;border-radius:10px;background:#fff;font-size:14px;font-weight:700;cursor:pointer;font-family:inherit;">
                    Batal
                </button>
                <button type="submit"
                        style="flex:2;padding:13px;border:2px solid #000;border-radius:10px;background:#FBBF24;font-size:14px;font-weight:700;cursor:pointer;font-family:inherit;">
                    💸 Ajukan Penarikan
                </button>
            </div>
        </form>
    </div>
</div>

</body>
</html>