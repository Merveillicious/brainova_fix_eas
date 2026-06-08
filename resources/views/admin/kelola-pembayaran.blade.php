<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pembayaran - Brainova Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <style>
        body { margin: 0; font-family: 'Inter', sans-serif; background: #fafafa; }

        /* ── Summary Cards ── */
        .adm-summary {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-bottom: 28px;
        }
        .adm-sum-card {
            background: #fff;
            border: 2px solid #000;
            border-radius: 14px;
            padding: 20px 22px;
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .adm-sum-icon {
            width: 46px; height: 46px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }
        .adm-sum-icon.yellow { background: #fef3c7; }
        .adm-sum-icon.green  { background: #d1fae5; }
        .adm-sum-icon.red    { background: #fee2e2; }
        .adm-sum-label { font-size: 12px; color: #6b7280; margin-bottom: 4px; }
        .adm-sum-val   { font-size: 22px; font-weight: 800; color: #000; }

        /* ── Export Buttons ── */
        .adm-export-row {
            display: flex;
            gap: 10px;
            margin-bottom: 24px;
            flex-wrap: wrap;
        }
        .adm-export-btn {
            padding: 9px 16px;
            border: 2px solid #000;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            color: #000;
            background: #fff;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: background .15s;
        }
        .adm-export-btn:hover { background: #f9fafb; }
        .adm-export-btn.primary { background: #fbbf24; }
        .adm-export-btn.primary:hover { background: #f59e0b; }

        /* ── Filter Row ── */
        .adm-filter-row {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        .adm-filter-select {
            padding: 8px 12px;
            border: 2px solid #000;
            border-radius: 8px;
            font-size: 13px;
            font-family: 'Inter', sans-serif;
            background: #fff;
            outline: none;
            cursor: pointer;
        }
        .adm-filter-select:focus { border-color: #fbbf24; }

        /* ── Payment Cards ── */
        .adm-pay-card {
            background: #fff;
            border: 2px solid #000;
            border-radius: 14px;
            overflow: hidden;
            margin-bottom: 16px;
            transition: box-shadow .2s;
        }
        .adm-pay-card:hover { box-shadow: 0 4px 20px rgba(0,0,0,.08); }
        .adm-pay-card.pending-highlight {
            border-color: #f59e0b;
            box-shadow: 0 0 0 3px rgba(251,191,36,.2);
        }

        .adm-pay-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 20px;
            border-bottom: 2px solid #000;
            background: #fffdf5;
        }
        .adm-pay-header.pending-bg { background: #fef3c7; }
        .adm-pay-header.success-bg { background: #f0fdf4; }
        .adm-pay-header.failed-bg  { background: #fef2f2; }

        .adm-pay-id {
            font-size: 13px;
            font-weight: 800;
            color: #000;
            font-family: monospace;
        }
        .adm-pay-time { font-size: 12px; color: #9ca3af; margin-top: 2px; }

        /* Status Badges */
        .adm-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            border: 2px solid #000;
        }
        .adm-badge-menunggu { background: #fef3c7; color: #92400e; }
        .adm-badge-berhasil { background: #d1fae5; color: #065f46; }
        .adm-badge-gagal    { background: #fee2e2; color: #991b1b; }

        /* Body Grid */
        .adm-pay-body {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 0;
            padding: 0;
        }
        @media (max-width: 700px) {
            .adm-pay-body { grid-template-columns: 1fr; }
            .adm-summary  { grid-template-columns: 1fr; }
        }

        .adm-pay-info-block {
            padding: 16px 20px;
            border-right: 1px solid #f3f4f6;
        }
        .adm-pay-info-block:last-child { border-right: none; }
        .adm-info-label { font-size: 11px; font-weight: 600; color: #9ca3af; text-transform: uppercase; letter-spacing: .05em; margin-bottom: 6px; }
        .adm-info-val   { font-size: 14px; font-weight: 700; color: #111; }
        .adm-info-sub   { font-size: 12px; color: #6b7280; margin-top: 2px; }

        /* Amount highlight */
        .adm-amount-val {
            font-size: 18px;
            font-weight: 800;
            color: #000;
        }

        /* Actions */
        .adm-pay-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 14px 20px;
            background: #fafafa;
            border-top: 2px solid #000;
        }
        .adm-btn-approve {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 20px;
            background: #22c55e;
            border: 2px solid #000;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 800;
            color: #fff;
            cursor: pointer;
            transition: background .15s;
        }
        .adm-btn-approve:hover { background: #16a34a; }
        .adm-btn-reject {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 20px;
            background: #fff;
            border: 2px solid #000;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 800;
            color: #dc2626;
            cursor: pointer;
            transition: background .15s;
        }
        .adm-btn-reject:hover { background: #fee2e2; }

        .adm-done-label {
            font-size: 13px;
            font-weight: 600;
            color: #6b7280;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* Pending count badge */
        .adm-pending-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #fef3c7;
            border: 2px solid #f59e0b;
            border-radius: 20px;
            padding: 4px 12px;
            font-size: 13px;
            font-weight: 700;
            color: #92400e;
            margin-bottom: 16px;
        }

        /* Empty */
        .adm-empty {
            text-align: center;
            padding: 60px 20px;
            color: #9ca3af;
        }
        .adm-empty-icon { font-size: 48px; margin-bottom: 12px; }
        .adm-empty-text { font-size: 16px; font-weight: 600; color: #555; }
    </style>
</head>
<body>
<header class="app-topbar">
    <a href="/admin/dashboard" class="app-brand">
        Brainova
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"></circle>
            <line x1="12" y1="16" x2="12" y2="12"></line>
            <line x1="12" y1="8" x2="12.01" y2="8"></line>
        </svg>
    </a>
    <div style="margin-left: auto; display: flex; align-items: center; gap: 12px;">
        <span class="badge-role">Admin</span>
        <form method="POST" action="{{ route('logout') }}" style="display:inline">
            @csrf
            <button type="submit" class="btn-logout">Log out</button>
        </form>
    </div>
</header>
<div class="siswa-layout">
    @include('admin.partials.sidebar')

    <main class="siswa-main">
        <h1 class="dash-header-title" style="margin-bottom: 8px;">Kelola Pembayaran</h1>
        <p style="color:#6b7280;font-size:14px;margin-bottom:24px;">Approve atau tolak pembayaran QRIS dari siswa.</p>

        @php
            $pendingCount  = $bookings->filter(fn($b) => ($b->payment->status ?? '') === 'menunggu')->count();
            $berhasilCount = $bookings->filter(fn($b) => ($b->payment->status ?? '') === 'berhasil')->count();
            $gagalCount    = $bookings->filter(fn($b) => ($b->payment->status ?? '') === 'gagal')->count();
            $totalAmount   = $bookings->sum(fn($b) => $b->payment->jumlah ?? 0);
        @endphp

        {{-- ── Summary ── --}}
        <div class="adm-summary">
            <div class="adm-sum-card">
                <div class="adm-sum-icon yellow">⏳</div>
                <div>
                    <div class="adm-sum-label">Menunggu Approval</div>
                    <div class="adm-sum-val">{{ $pendingCount }}</div>
                </div>
            </div>
            <div class="adm-sum-card">
                <div class="adm-sum-icon green">✅</div>
                <div>
                    <div class="adm-sum-label">Berhasil</div>
                    <div class="adm-sum-val">{{ $berhasilCount }}</div>
                </div>
            </div>
            <div class="adm-sum-card">
                <div class="adm-sum-icon red">❌</div>
                <div>
                    <div class="adm-sum-label">Ditolak</div>
                    <div class="adm-sum-val">{{ $gagalCount }}</div>
                </div>
            </div>
        </div>

        {{-- ── Export ── --}}
        <div class="adm-export-row">
            <a href="{{ route('admin.report.pdf-pembayaran') }}" class="adm-export-btn primary" target="_blank">📄 PDF Pembayaran</a>
            <a href="{{ route('admin.report.excel-pembayaran') }}" class="adm-export-btn">📊 Excel Pembayaran</a>
            <a href="{{ route('admin.report.pdf-booking') }}" class="adm-export-btn" target="_blank">📄 PDF Booking</a>
            <a href="{{ route('admin.report.excel-booking') }}" class="adm-export-btn">📊 Excel Booking</a>
        </div>

        {{-- ── Alerts ── --}}
        @if(session('success'))
            <div class="alert-success" style="margin-bottom:16px;">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert-error" style="margin-bottom:16px;">{{ session('error') }}</div>
        @endif

        {{-- ── Filter ── --}}
        <div class="adm-filter-row">
            <select class="adm-filter-select" id="filterStatus" onchange="filterCards()">
                <option value="">Semua Status</option>
                <option value="menunggu">⏳ Menunggu</option>
                <option value="berhasil">✅ Berhasil</option>
                <option value="gagal">❌ Gagal</option>
            </select>
        </div>

        @if($pendingCount > 0)
            <div class="adm-pending-badge">
                ⚠️ {{ $pendingCount }} pembayaran menunggu approval Anda
            </div>
        @endif

        @if($bookings->isEmpty())
            <div class="adm-empty">
                <div class="adm-empty-icon">🧾</div>
                <div class="adm-empty-text">Belum ada data pembayaran</div>
            </div>
        @else
            @foreach($bookings as $b)
            @php
                $payStatus = $b->payment->status ?? 'menunggu';
                $sc        = $b->schedule;
                $tutor     = $sc->tutor ?? null;
                $isPending = $payStatus === 'menunggu';
                $invoice   = 'INV-' . date('Y', strtotime($b->tanggal_booking)) . '-' . str_pad($b->id, 4, '0', STR_PAD_LEFT);
            @endphp
            <div class="adm-pay-card {{ $isPending ? 'pending-highlight' : '' }}" data-status="{{ $payStatus }}">

                {{-- Header --}}
                <div class="adm-pay-header {{ $isPending ? 'pending-bg' : ($payStatus === 'berhasil' ? 'success-bg' : ($payStatus === 'gagal' ? 'failed-bg' : '')) }}">
                    <div>
                        <div class="adm-pay-id">{{ $invoice }}</div>
                        <div class="adm-pay-time">{{ \Carbon\Carbon::parse($b->tanggal_booking)->translatedFormat('j F Y, H:i') }}</div>
                    </div>
                    <span class="adm-badge adm-badge-{{ $payStatus }}">
                        @if($payStatus === 'menunggu') ⏳ Menunggu Approval
                        @elseif($payStatus === 'berhasil') ✅ Berhasil
                        @else ❌ Ditolak
                        @endif
                    </span>
                </div>

                {{-- Info Grid --}}
                <div class="adm-pay-body">
                    <div class="adm-pay-info-block">
                        <div class="adm-info-label">Siswa</div>
                        <div class="adm-info-val">{{ $b->student->name ?? '-' }}</div>
                        <div class="adm-info-sub">{{ $b->student->user->email ?? '' }}</div>
                    </div>
                    <div class="adm-pay-info-block">
                        <div class="adm-info-label">Tutor & Mapel</div>
                        <div class="adm-info-val">{{ $tutor->name ?? '-' }}</div>
                        <div class="adm-info-sub">{{ $sc->subject->nama_mapel ?? '-' }} · {{ $sc->hari }}, {{ \Carbon\Carbon::parse($sc->tanggal)->translatedFormat('j M Y') }}</div>
                    </div>
                    <div class="adm-pay-info-block">
                        <div class="adm-info-label">Jumlah & Metode</div>
                        <div class="adm-amount-val">Rp {{ number_format($b->payment->jumlah ?? 0, 0, ',', '.') }}</div>
                        <div class="adm-info-sub">{{ strtoupper($b->payment->metode ?? $b->metode_pembayaran) }}</div>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="adm-pay-actions">
                    @if($isPending)
                        <form method="POST" action="{{ route('admin.pembayaran.update') }}" style="display:inline">
                            @csrf
                            <input type="hidden" name="booking_id" value="{{ $b->id }}">
                            <input type="hidden" name="status_pembayaran" value="berhasil">
                            <button type="submit" class="adm-btn-approve"
                                onclick="return confirm('Yakin approve pembayaran {{ $invoice }}?')">
                                ✓ Approve Pembayaran
                            </button>
                        </form>
                        <form method="POST" action="{{ route('admin.pembayaran.update') }}" style="display:inline">
                            @csrf
                            <input type="hidden" name="booking_id" value="{{ $b->id }}">
                            <input type="hidden" name="status_pembayaran" value="gagal">
                            <button type="submit" class="adm-btn-reject"
                                onclick="return confirm('Yakin tolak pembayaran {{ $invoice }}?')">
                                ✕ Tolak
                            </button>
                        </form>
                    @elseif($payStatus === 'berhasil')
                        <div class="adm-done-label">✅ Pembayaran telah diapprove · {{ $b->payment->paid_at ? \Carbon\Carbon::parse($b->payment->paid_at)->translatedFormat('j M Y, H:i') : '' }}</div>
                    @else
                        <div class="adm-done-label" style="color:#dc2626;">❌ Pembayaran telah ditolak</div>
                    @endif
                </div>
            </div>
            @endforeach
        @endif

    </main>
</div>

<script>
function filterCards() {
    const status = document.getElementById('filterStatus').value;
    document.querySelectorAll('.adm-pay-card').forEach(card => {
        const cardStatus = card.dataset.status || '';
        card.style.display = (!status || cardStatus === status) ? '' : 'none';
    });
}
</script>
</body>
</html>
