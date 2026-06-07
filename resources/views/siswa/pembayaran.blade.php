<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran - Brainova</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <style>
        body { margin: 0; font-family: 'Inter', sans-serif; background: #fafafa; }

        /* ── Summary Cards ── */
        .pb-summary-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-bottom: 32px;
        }
        .pb-summary-card {
            background: #fff;
            border: 2px solid #000;
            border-radius: 14px;
            padding: 20px 24px;
            display: flex;
            align-items: center;
            gap: 16px;
            transition: box-shadow .2s;
        }
        .pb-summary-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,.06); }
        .pb-summary-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .pb-summary-icon.yellow { background: #fef3c7; color: #d97706; }
        .pb-summary-icon.green  { background: #d1fae5; color: #059669; }
        .pb-summary-icon.red    { background: #fee2e2; color: #dc2626; }
        .pb-summary-label { font-size: 12px; color: #6b7280; margin-bottom: 4px; font-weight: 500; }
        .pb-summary-value { font-size: 20px; font-weight: 800; color: #000; }

        /* ── Table Card ── */
        .pb-table-card {
            background: #fff;
            border: 2px solid #000;
            border-radius: 14px;
            overflow: hidden;
        }
        .pb-table-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 24px 16px;
            border-bottom: 2px solid #000;
            background: #fffdf5;
        }
        .pb-table-title {
            font-size: 18px;
            font-weight: 800;
            color: #000;
            letter-spacing: -.3px;
        }
        .pb-filter-row {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .pb-filter-select {
            padding: 7px 12px;
            border: 2px solid #000;
            border-radius: 8px;
            font-size: 13px;
            font-family: 'Inter', sans-serif;
            color: #374151;
            background: #fff;
            outline: none;
            cursor: pointer;
        }
        .pb-filter-select:focus { border-color: #FBBF24; }

        /* ── Table ── */
        .pb-table {
            width: 100%;
            border-collapse: collapse;
        }
        .pb-table thead tr { background: #f9fafb; }
        .pb-table th {
            padding: 11px 24px;
            font-size: 11px;
            font-weight: 700;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: .06em;
            text-align: left;
            border-bottom: 2px solid #000;
        }
        .pb-table td {
            padding: 18px 24px;
            font-size: 14px;
            color: #111;
            border-bottom: 2px solid #000;
            vertical-align: middle;
        }
        .pb-table tbody tr:last-child td { border-bottom: none; }
        .pb-table tbody tr:hover td { background: #fffbeb; }

        /* deskripsi cell */
        .pb-desc-wrap { display: flex; align-items: center; gap: 12px; }
        .pb-desc-avatar {
            width: 36px; height: 36px;
            border-radius: 50%;
            border: 2px solid #000;
            object-fit: cover;
            flex-shrink: 0;
        }
        .pb-desc-main { font-size: 14px; font-weight: 600; color: #111; }
        .pb-desc-sub  { font-size: 12px; color: #6b7280; margin-top: 2px; }

        /* invoice */
        .pb-invoice {
            font-size: 12px;
            font-weight: 600;
            color: #6b7280;
            font-family: monospace;
            background: #f3f4f6;
            padding: 3px 8px;
            border-radius: 5px;
        }

        /* nominal */
        .pb-nominal { font-weight: 700; color: #000; }

        /* metode badge */
        .pb-metode {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
        }
        .pb-metode-transfer { background: #eff6ff; color: #1d4ed8; border: 2px solid #000; }
        .pb-metode-ewallet  { background: #f0fdf4; color: #15803d; border: 2px solid #000; }

        /* status badge */
        .pb-status {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
        }
        .pb-status-menunggu { background: #fef3c7; color: #92400e; }
        .pb-status-berhasil { background: #d1fae5; color: #065f46; }
        .pb-status-gagal    { background: #fee2e2; color: #991b1b; }

        /* tanggal */
        .pb-date { font-size: 13px; color: #555; white-space: nowrap; }

        /* empty */
        .pb-empty {
            text-align: center;
            padding: 64px 20px;
            color: #aaa;
        }
        .pb-empty-icon { font-size: 44px; margin-bottom: 14px; }
        .pb-empty p { font-size: 15px; color: #555; font-weight: 600; margin-bottom: 6px; }
        .pb-empty small { font-size: 13px; }
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

    <main class="siswa-main">

        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif

        <h1 class="dash-header-title" style="margin-bottom: 28px;">Pembayaran</h1>

        {{-- ── Summary Cards ── --}}
        @php
            $allPayments = $payments instanceof \Illuminate\Pagination\LengthAwarePaginator
                ? $payments->getCollection() : $payments;
            $total    = $allPayments->sum('jumlah');
            $berhasil = $allPayments->where('status', 'berhasil')->sum('jumlah');
            $menunggu = $allPayments->where('status', 'menunggu')->sum('jumlah');
        @endphp
        <div class="pb-summary-grid">
            <div class="pb-summary-card">
                <div class="pb-summary-icon yellow">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="1" x2="12" y2="23"/>
                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                    </svg>
                </div>
                <div>
                    <div class="pb-summary-label">Total Transaksi</div>
                    <div class="pb-summary-value">Rp {{ number_format($total, 0, ',', '.') }}</div>
                </div>
            </div>
            <div class="pb-summary-card">
                <div class="pb-summary-icon green">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                </div>
                <div>
                    <div class="pb-summary-label">Berhasil Dibayar</div>
                    <div class="pb-summary-value">Rp {{ number_format($berhasil, 0, ',', '.') }}</div>
                </div>
            </div>
            <div class="pb-summary-card">
                <div class="pb-summary-icon red">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/>
                        <polyline points="12 6 12 12 16 14"/>
                    </svg>
                </div>
                <div>
                    <div class="pb-summary-label">Menunggu Pembayaran</div>
                    <div class="pb-summary-value">Rp {{ number_format($menunggu, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>

        {{-- ── Riwayat Transaksi Table ── --}}
        <div class="pb-table-card">
            <div class="pb-table-header">
                <div class="pb-table-title">Riwayat Transaksi</div>
                <div class="pb-filter-row">
                    <select class="pb-filter-select">
                        <option>Semua Status</option>
                        <option>Berhasil</option>
                        <option>Menunggu</option>
                        <option>Gagal</option>
                    </select>
                    <select class="pb-filter-select">
                        <option>Semua Metode</option>
                        <option>Transfer</option>
                        <option>E-Wallet</option>
                    </select>
                </div>
            </div>

            @if($payments->isEmpty())
                <div class="pb-empty">
                    <div class="pb-empty-icon">🧾</div>
                    <p>Belum ada transaksi</p>
                    <small>Transaksi pembayaran kelas akan muncul di sini.</small>
                </div>
            @else
                <table class="pb-table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Deskripsi</th>
                            <th>Nomor Invoice</th>
                            <th>Metode</th>
                            <th>Nominal</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payments as $i => $pay)
                        @php
                            $booking = $pay->booking;
                            $sched   = $booking?->schedule;
                            $tutor   = $sched?->tutor;
                            $subject = $sched?->subject;
                            $invoice = 'INV-' . date('Y', strtotime($pay->created_at)) . '-' . str_pad($pay->id, 3, '0', STR_PAD_LEFT);
                            $deskripsi = 'Sesi ' . ($subject?->nama_mapel ?? 'Kelas') . ($tutor ? ' - ' . $tutor->name : '');
                        @endphp
                        <tr>
                            {{-- Tanggal --}}
                            <td class="pb-date">
                                {{ $pay->created_at ? \Carbon\Carbon::parse($pay->created_at)->translatedFormat('j M Y') : '-' }}
                            </td>

                            {{-- Deskripsi --}}
                            <td>
                                <div class="pb-desc-wrap">
                                    <img class="pb-desc-avatar"
                                         src="https://ui-avatars.com/api/?name={{ urlencode($tutor?->name ?? 'T') }}&background=random&color=fff"
                                         alt="{{ $tutor?->name }}">
                                    <div>
                                        <div class="pb-desc-main">{{ $deskripsi }}</div>
                                        <div class="pb-desc-sub">{{ $sched?->hari ?? '' }}{{ $sched?->tanggal ? ', ' . \Carbon\Carbon::parse($sched->tanggal)->translatedFormat('j M Y') : '' }}</div>
                                    </div>
                                </div>
                            </td>

                            {{-- Invoice --}}
                            <td><span class="pb-invoice">{{ $invoice }}</span></td>

                            {{-- Metode --}}
                            <td>
                                @if($pay->metode === 'transfer')
                                    <span class="pb-metode pb-metode-transfer">Transfer</span>
                                @else
                                    <span class="pb-metode pb-metode-ewallet">E-Wallet</span>
                                @endif
                            </td>

                            {{-- Nominal --}}
                            <td class="pb-nominal">Rp {{ number_format($pay->jumlah, 0, ',', '.') }}</td>

                            {{-- Status --}}
                            <td>
                                <span class="pb-status pb-status-{{ $pay->status }}">
                                    {{ ucfirst($pay->status) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        {{-- Pagination --}}
        @if($payments instanceof \Illuminate\Pagination\LengthAwarePaginator && $payments->hasPages())
            <div style="margin-top:20px;display:flex;justify-content:center;">
                {{ $payments->links() }}
            </div>
        @endif

    </main>
</div>
</body>
</html>
