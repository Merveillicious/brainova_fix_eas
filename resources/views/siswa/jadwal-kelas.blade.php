<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Kelas - Brainova</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <style>
        body { margin: 0; font-family: 'Inter', sans-serif; background: #fafafa; }

        /* ── Jadwal Cards ── */
        .jk-section-title {
            font-size: 22px;
            font-weight: 800;
            color: #000;
            margin-bottom: 20px;
            letter-spacing: -.4px;
        }

        .jk-cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .jk-card {
            background: #fff;
            border: 2px solid #000;
            border-radius: 16px;
            padding: 20px;
            position: relative;
            transition: box-shadow .2s, border-color .2s;
        }
        .jk-card:hover {
            border-color: #FBBF24;
            box-shadow: 0 4px 18px rgba(251,191,36,.15);
        }

        /* top row */
        .jk-card-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 14px;
            padding-bottom: 14px;
            border-bottom: 2px solid #000;
        }
        .jk-card-icon-title {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .jk-icon-box {
            width: 36px;
            height: 36px;
            border: 2px solid #000;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            background: #fff;
            flex-shrink: 0;
        }
        .jk-card-name {
            font-size: 16px;
            font-weight: 700;
            color: #000;
        }

        /* status badge */
        .jk-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .04em;
        }
        .jk-badge-live {
            background: #fee2e2;
            color: #b91c1c;
        }
        .jk-badge-live .dot {
            width: 6px; height: 6px;
            background: #ef4444;
            border-radius: 50%;
            animation: blink 1.2s infinite;
        }
        @keyframes blink { 0%,100%{opacity:1} 50%{opacity:0} }
        .jk-badge-pending {
            background: #fef3c7;
            color: #92400e;
        }
        .jk-badge-diterima {
            background: #d1fae5;
            color: #065f46;
        }
        .jk-badge-belum {
            background: #f3f4f6;
            color: #6b7280;
        }

        /* tutor row */
        .jk-tutor-row {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 14px;
        }
        .jk-tutor-row img {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            border: 2px solid #000;
            object-fit: cover;
        }
        .jk-tutor-name {
            font-size: 14px;
            font-weight: 700;
            color: #000;
        }
        .jk-tutor-mapel {
            font-size: 12px;
            color: #777;
        }

        /* meta */
        .jk-meta {
            display: flex;
            align-items: center;
            gap: 18px;
            font-size: 13px;
            color: #555;
            margin-bottom: 16px;
        }
        .jk-meta span {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /* join btn */
        .jk-btn-join {
            width: 100%;
            padding: 11px;
            background: #FBBF24;
            border: 2px solid #000;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 700;
            color: #000;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            transition: background .15s, transform .1s;
            text-align: center;
            display: block;
            text-decoration: none;
        }
        .jk-btn-join:hover { background: #f59e0b; transform: translateY(-1px); }
        .jk-btn-join:active { transform: translateY(0); }
        .jk-btn-join.outline {
            background: #fff;
            color: #000;
        }
        .jk-btn-join.outline:hover { background: #f9fafb; transform: none; }

        /* ── Riwayat Table ── */
        .jk-table-wrap {
            background: #fff;
            border: 2px solid #000;
            border-radius: 16px;
            overflow: hidden;
        }
        .jk-table {
            width: 100%;
            border-collapse: collapse;
        }
        .jk-table thead tr {
            background: #f9fafb;
        }
        .jk-table th {
            padding: 12px 20px;
            font-size: 11px;
            font-weight: 700;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: .06em;
            text-align: left;
            border-bottom: 2px solid #000;
        }
        .jk-table td {
            padding: 16px 20px;
            font-size: 14px;
            color: #000;
            border-bottom: 2px solid #000;
            vertical-align: middle;
        }
        .jk-table tbody tr:last-child td { border-bottom: none; }
        .jk-table tbody tr:hover td { background: #fffbeb; }

        .jk-tutor-cell {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .jk-tutor-cell img {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: 2px solid #000;
            object-fit: cover;
            flex-shrink: 0;
        }
        .jk-tutor-cell-name { font-weight: 600; color: #000; }

        /* tipe badge */
        .jk-tipe {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
        }
        .jk-tipe-privat { background: #f3f4f6; color: #555; border: 2px solid #000; }
        .jk-tipe-dynamic { background: #fff7ed; color: #c2410c; border: 2px solid #000; }

        /* status badge table */
        .jk-status {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
        }
        .jk-status-selesai  { background: #d1fae5; color: #065f46; }
        .jk-status-batal    { background: #f3f4f6; color: #6b7280; }
        .jk-status-pending  { background: #fef3c7; color: #92400e; }
        .jk-status-diterima { background: #d1fae5; color: #065f46; }

        .jk-price { font-weight: 700; color: #000; }

        /* empty */
        .jk-empty {
            text-align: center;
            padding: 56px 20px;
            color: #aaa;
        }
        .jk-empty-icon { font-size: 40px; margin-bottom: 12px; }
        .jk-empty p { font-size: 15px; margin-bottom: 8px; color: #555; font-weight: 600; }
        .jk-empty small { font-size: 13px; color: #aaa; }
    </style>
</head>
<body>
<header class="app-topbar">
    <a href="{{ route('siswa.dashboard') }}" class="app-brand">
        Brainova
    </a>
</header>
<div class="siswa-layout">

    @include('siswa.partials.sidebar')

    {{-- Main --}}
    <main class="siswa-main">

        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif

        {{-- ══════════════════════════════════
             JADWAL AKTIF
        ══════════════════════════════════ --}}
        <h1 class="jk-section-title">Jadwal Kelas Saya</h1>

        @if($aktif->isEmpty())
            <div class="jk-empty" style="background:#fff;border: 2px dashed #000;border-radius:16px;margin-bottom:40px;">
                <div class="jk-empty-icon">📅</div>
                <p>Belum ada jadwal aktif</p>
                <small>Pesan kelas tutor untuk mulai belajar!</small>
                <br><br>
                <a href="{{ route('siswa.cari-tutor') }}" class="jk-btn-join" style="max-width:200px;margin:0 auto;">
                    Cari Tutor
                </a>
            </div>
        @else
            <div class="jk-cards-grid">
                @foreach($aktif as $booking)
                @php
                    $sched   = $booking->schedule;
                    $tutor   = $sched?->tutor;
                    $subject = $sched?->subject;
                    $isLive  = $booking->status_booking === 'diterima';
                    $icons   = ['Matematika'=>'Σ','Fisika'=>'⚛','Kimia'=>'⚗','Biologi'=>'🧬',
                                'Bahasa Inggris'=>'🔤','Bahasa Indonesia'=>'📝','Coding'=>'</>','Pemrograman'=>'</>'];
                    $icon    = $icons[$subject?->nama_mapel ?? ''] ?? '📚';
                @endphp
                <div class="jk-card">
                    {{-- Top row --}}
                    <div class="jk-card-top">
                        <div class="jk-card-icon-title">
                            <div class="jk-card-name">{{ $subject?->nama_mapel ?? 'Kelas' }}</div>
                        </div>
                        @if($isLive)
                            <span class="jk-badge jk-badge-live">
                                <span class="dot"></span> LIVE
                            </span>
                        @elseif($booking->status_booking === 'diterima')
                            <span class="jk-badge jk-badge-diterima">Diterima</span>
                        @else
                            <span class="jk-badge jk-badge-belum">Belum Dimulai</span>
                        @endif
                    </div>

                    {{-- Tutor row --}}
                    <div class="jk-tutor-row">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($tutor?->name ?? 'T') }}&background=random&color=fff"
                             alt="{{ $tutor?->name }}">
                        <div>
                            <div class="jk-tutor-name">{{ $tutor?->name ?? '-' }}</div>
                            <div class="jk-tutor-mapel">{{ $subject?->nama_mapel ?? '-' }}</div>
                        </div>
                    </div>

                    {{-- Meta --}}
                    <div class="jk-meta">
                        <span>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/>
                                <line x1="3" y1="10" x2="21" y2="10"/>
                            </svg>
                            {{ $sched?->tanggal ? \Carbon\Carbon::parse($sched->tanggal)->translatedFormat('j M') : ($sched?->hari ?? '-') }}
                        </span>
                        <span>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"/>
                                <polyline points="12 6 12 12 16 14"/>
                            </svg>
                            {{ substr($sched?->jam_mulai ?? '00:00', 0, 5) }} - {{ substr($sched?->jam_selesai ?? '00:00', 0, 5) }}
                        </span>
                    </div>

                    {{-- Button --}}
                    @if($isLive)
                        <a href="#" class="jk-btn-join">Join Kelas</a>
                    @else
                        <a href="#" class="jk-btn-join outline">Join Kelas</a>
                    @endif
                </div>
                @endforeach
            </div>
        @endif

        {{-- ══════════════════════════════════
             RIWAYAT KELAS
        ══════════════════════════════════ --}}
        <h2 class="jk-section-title">Riwayat Kelas</h2>

        <div class="jk-table-wrap">
            @if($riwayat->isEmpty())
                <div class="jk-empty">
                    <div class="jk-empty-icon">📋</div>
                    <p>Belum ada riwayat kelas</p>
                    <small>Riwayat kelas yang sudah selesai atau dibatalkan akan muncul di sini.</small>
                </div>
            @else
                <table class="jk-table">
                    <thead>
                        <tr>
                            <th>Tutor</th>
                            <th>Mata Pelajaran</th>
                            <th>Tanggal</th>
                            <th>Tipe</th>
                            <th>Harga</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($riwayat as $booking)
                        @php
                            $sched   = $booking->schedule;
                            $tutor   = $sched?->tutor;
                            $subject = $sched?->subject;
                            $payment = $booking->payment;
                            $tanggal = $booking->tanggal_booking
                                ? \Carbon\Carbon::parse($booking->tanggal_booking)->translatedFormat('j M Y')
                                : '-';
                        @endphp
                        <tr>
                            {{-- Tutor --}}
                            <td>
                                <div class="jk-tutor-cell">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($tutor?->name ?? 'T') }}&background=random&color=fff"
                                         alt="{{ $tutor?->name }}">
                                    <span class="jk-tutor-cell-name">{{ $tutor?->name ?? '-' }}</span>
                                </div>
                            </td>
                            {{-- Mapel --}}
                            <td>{{ $subject?->nama_mapel ?? '-' }}</td>
                            {{-- Tanggal --}}
                            <td style="color:#555;">{{ $tanggal }}</td>
                            {{-- Tipe --}}
                            <td>
                                @if($booking->metode_pembayaran === 'transfer')
                                    <span class="jk-tipe jk-tipe-privat">Privat</span>
                                @else
                                    <span class="jk-tipe jk-tipe-dynamic">Dynamic</span>
                                @endif
                            </td>
                            {{-- Harga --}}
                            <td class="jk-price">
                                Rp {{ number_format($payment?->jumlah ?? 0, 0, ',', '.') }}
                            </td>
                            {{-- Status --}}
                            <td>
                                @php $st = $booking->status_booking; @endphp
                                <span class="jk-status jk-status-{{ $st }}">
                                    {{ ucfirst($st === 'batal' ? 'Dibatalkan' : ucfirst($st)) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

    </main>
</div>
</body>
</html>
