<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Pembayaran - Brainova</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <style>
        body { margin: 0; font-family: 'Inter', sans-serif; background: #fafafa; }

        .ps-wrap {
            max-width: 640px;
            margin: 40px auto;
            padding: 0 20px;
        }

        /* ── Status Hero Card ── */
        .ps-hero {
            background: #fff;
            border: 2px solid #000;
            border-radius: 16px;
            overflow: hidden;
            margin-bottom: 20px;
        }

        /* Menunggu */
        .ps-hero-banner.menunggu {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
            padding: 36px 20px;
            text-align: center;
            border-bottom: 2px solid #000;
        }
        /* Berhasil */
        .ps-hero-banner.berhasil {
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
            padding: 36px 20px;
            text-align: center;
            border-bottom: 2px solid #000;
        }
        /* Gagal */
        .ps-hero-banner.gagal {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            padding: 36px 20px;
            text-align: center;
            border-bottom: 2px solid #000;
        }

        .ps-status-icon {
            font-size: 52px;
            margin-bottom: 12px;
        }

        .ps-status-title {
            font-size: 22px;
            font-weight: 800;
            color: #fff;
            margin-bottom: 6px;
            text-shadow: 0 1px 2px rgba(0,0,0,.15);
        }
        .ps-hero-banner.menunggu .ps-status-title { color: #000; }

        .ps-status-sub {
            font-size: 13px;
            color: rgba(255,255,255,.85);
            font-weight: 500;
        }
        .ps-hero-banner.menunggu .ps-status-sub { color: #78350f; }

        /* Spinner for menunggu */
        .ps-spinner {
            width: 48px;
            height: 48px;
            border: 5px solid rgba(0,0,0,.15);
            border-top-color: #000;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 16px;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* ── Invoice Detail ── */
        .ps-body { padding: 24px; }

        .ps-invoice-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #f3f4f6;
            border: 2px solid #000;
            border-radius: 8px;
            padding: 8px 14px;
            font-size: 13px;
            font-weight: 700;
            font-family: monospace;
            color: #374151;
            margin-bottom: 20px;
        }

        .ps-detail-title {
            font-size: 13px;
            font-weight: 700;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: .06em;
            margin-bottom: 14px;
        }

        .ps-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #f3f4f6;
            font-size: 14px;
        }
        .ps-row:last-of-type { border-bottom: none; }
        .ps-row-label { color: #6b7280; }
        .ps-row-val   { font-weight: 600; color: #111; }

        .ps-total-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #fbbf24;
            border: 2px solid #000;
            border-radius: 10px;
            padding: 14px 18px;
            margin-top: 16px;
            font-weight: 800;
            font-size: 16px;
        }

        /* ── Timeline ── */
        .ps-timeline {
            background: #fff;
            border: 2px solid #000;
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 20px;
        }
        .ps-tl-title {
            font-size: 15px;
            font-weight: 800;
            color: #000;
            margin-bottom: 20px;
        }
        .ps-tl-item {
            display: flex;
            gap: 14px;
            margin-bottom: 20px;
        }
        .ps-tl-item:last-child { margin-bottom: 0; }
        .ps-tl-dot-wrap {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0;
        }
        .ps-tl-dot {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            border: 2px solid #000;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            flex-shrink: 0;
            font-weight: 700;
        }
        .ps-tl-dot.done  { background: #fbbf24; }
        .ps-tl-dot.active { background: #fbbf24; animation: pulse 1.5s ease infinite; }
        .ps-tl-dot.wait  { background: #f3f4f6; color: #9ca3af; }
        .ps-tl-dot.ok    { background: #22c55e; color: #fff; }
        .ps-tl-dot.fail  { background: #ef4444; color: #fff; }
        @keyframes pulse {
            0%, 100% { box-shadow: 0 0 0 0 rgba(251,191,36,.5); }
            50%       { box-shadow: 0 0 0 6px rgba(251,191,36,0); }
        }
        .ps-tl-line {
            width: 2px;
            flex: 1;
            background: #e5e7eb;
            min-height: 20px;
        }
        .ps-tl-line.done { background: #000; }
        .ps-tl-content { padding-top: 3px; }
        .ps-tl-label { font-size: 14px; font-weight: 700; color: #000; }
        .ps-tl-sub   { font-size: 12px; color: #9ca3af; margin-top: 2px; }
        .ps-tl-sub.active-text { color: #d97706; }

        /* ── Actions ── */
        .ps-actions {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .ps-btn-primary {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            width: 100%;
            padding: 14px;
            background: #fbbf24;
            border: 2px solid #000;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 800;
            color: #000;
            text-decoration: none;
            cursor: pointer;
            transition: background .2s;
            box-sizing: border-box;
        }
        .ps-btn-primary:hover { background: #f59e0b; }
        .ps-btn-secondary {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            width: 100%;
            padding: 13px;
            background: #fff;
            border: 2px solid #000;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 700;
            color: #000;
            text-decoration: none;
            cursor: pointer;
            transition: background .2s;
            box-sizing: border-box;
        }
        .ps-btn-secondary:hover { background: #f9fafb; }

        /* ── Auto-refresh notice ── */
        .ps-refresh-notice {
            text-align: center;
            font-size: 12px;
            color: #9ca3af;
            margin-top: 12px;
        }
        .ps-refresh-notice span { font-weight: 700; color: #555; }
    </style>
</head>
<body>
<header class="app-topbar">
    <a href="{{ route('siswa.dashboard') }}" class="app-brand">
        Brainova
    </a>
</header>

@php
    $payStatus    = $booking->payment->status ?? 'menunggu';
    $bookStatus   = $booking->status_booking;
    $konfirmasi   = $booking->status_pembayaran;
    $tutor        = $booking->schedule->tutor;
    $subject      = $booking->schedule->subject;

    // Tentukan state tampilan
    $state = 'menunggu'; // default
    if ($konfirmasi === 'dibayar' || $payStatus === 'berhasil') $state = 'berhasil';
    elseif ($bookStatus === 'batal' || $payStatus === 'gagal')   $state = 'gagal';
    elseif ($konfirmasi === 'menunggu_konfirmasi')                $state = 'menunggu';
@endphp

<div class="ps-wrap">

    {{-- ── Status Hero ── --}}
    <div class="ps-hero">
        <div class="ps-hero-banner {{ $state }}">
            @if($state === 'menunggu')
                <div class="ps-spinner"></div>
                <div class="ps-status-title">Menunggu Konfirmasi Admin</div>
                <div class="ps-status-sub">Pembayaran QRIS Anda sedang diverifikasi tim Brainova</div>
            @elseif($state === 'berhasil')
                <div class="ps-status-icon">✅</div>
                <div class="ps-status-title">Pembayaran Berhasil!</div>
                <div class="ps-status-sub">Admin telah mengkonfirmasi pembayaran Anda</div>
            @else
                <div class="ps-status-icon">❌</div>
                <div class="ps-status-title">Pembayaran Ditolak</div>
                <div class="ps-status-sub">Silakan hubungi admin atau lakukan booking ulang</div>
            @endif
        </div>

        {{-- Detail Booking --}}
        <div class="ps-body">
            <div class="ps-invoice-badge">
                🧾 {{ $invoice }}
            </div>

            <div class="ps-detail-title">Detail Transaksi</div>

            <div class="ps-row">
                <span class="ps-row-label">Tutor</span>
                <span class="ps-row-val">{{ $tutor->name ?? '-' }}</span>
            </div>
            <div class="ps-row">
                <span class="ps-row-label">Mata Pelajaran</span>
                <span class="ps-row-val">{{ $subject->nama_mapel ?? '-' }}</span>
            </div>
            <div class="ps-row">
                <span class="ps-row-label">Tanggal Sesi</span>
                <span class="ps-row-val">{{ \Carbon\Carbon::parse($booking->schedule->tanggal)->translatedFormat('l, j F Y') }}</span>
            </div>
            <div class="ps-row">
                <span class="ps-row-label">Waktu</span>
                <span class="ps-row-val">{{ \Carbon\Carbon::parse($booking->schedule->jam_mulai)->format('H:i') }} WIB</span>
            </div>
            <div class="ps-row">
                <span class="ps-row-label">Metode Bayar</span>
                <span class="ps-row-val">QRIS</span>
            </div>
            <div class="ps-row">
                <span class="ps-row-label">Harga Sesi</span>
                <span class="ps-row-val">Rp {{ number_format($hargaSesi, 0, ',', '.') }}</span>
            </div>
            <div class="ps-row">
                <span class="ps-row-label">Biaya Layanan</span>
                <span class="ps-row-val">Rp {{ number_format($biayaLayanan, 0, ',', '.') }}</span>
            </div>

            <div class="ps-total-row">
                <span>Total Dibayar</span>
                <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    {{-- ── Timeline ── --}}
    <div class="ps-timeline">
        <div class="ps-tl-title">📋 Status Proses Pembayaran</div>

        {{-- Step 1: Booking Dibuat --}}
        <div class="ps-tl-item">
            <div class="ps-tl-dot-wrap">
                <div class="ps-tl-dot done">✓</div>
                <div class="ps-tl-line done"></div>
            </div>
            <div class="ps-tl-content">
                <div class="ps-tl-label">Booking Dibuat</div>
                <div class="ps-tl-sub">{{ \Carbon\Carbon::parse($booking->tanggal_booking)->translatedFormat('j F Y, H:i') }}</div>
            </div>
        </div>

        {{-- Step 2: Pembayaran QRIS --}}
        <div class="ps-tl-item">
            <div class="ps-tl-dot-wrap">
                <div class="ps-tl-dot done">✓</div>
                <div class="ps-tl-line {{ in_array($state, ['berhasil','gagal']) ? 'done' : '' }}"></div>
            </div>
            <div class="ps-tl-content">
                <div class="ps-tl-label">Pembayaran QRIS Dikirim</div>
                <div class="ps-tl-sub">{{ $booking->payment?->paid_at ? \Carbon\Carbon::parse($booking->payment->paid_at)->translatedFormat('j F Y, H:i') : 'Sudah dikonfirmasi siswa' }}</div>
            </div>
        </div>

        {{-- Step 3: Verifikasi Admin --}}
        <div class="ps-tl-item">
            <div class="ps-tl-dot-wrap">
                @if($state === 'menunggu')
                    <div class="ps-tl-dot active">⏳</div>
                    <div class="ps-tl-line"></div>
                @elseif($state === 'berhasil')
                    <div class="ps-tl-dot ok">✓</div>
                    <div class="ps-tl-line done"></div>
                @else
                    <div class="ps-tl-dot fail">✕</div>
                    <div class="ps-tl-line"></div>
                @endif
            </div>
            <div class="ps-tl-content">
                <div class="ps-tl-label">Verifikasi Admin</div>
                @if($state === 'menunggu')
                    <div class="ps-tl-sub active-text">Sedang diverifikasi… biasanya 1x24 jam</div>
                @elseif($state === 'berhasil')
                    <div class="ps-tl-sub">Admin telah menyetujui</div>
                @else
                    <div class="ps-tl-sub" style="color:#ef4444;">Admin menolak pembayaran</div>
                @endif
            </div>
        </div>

        {{-- Step 4: Kelas Dikonfirmasi --}}
        <div class="ps-tl-item">
            <div class="ps-tl-dot-wrap">
                <div class="ps-tl-dot {{ $state === 'berhasil' ? 'ok' : 'wait' }}">
                    {{ $state === 'berhasil' ? '✓' : '4' }}
                </div>
            </div>
            <div class="ps-tl-content">
                <div class="ps-tl-label">Kelas Dikonfirmasi</div>
                <div class="ps-tl-sub">{{ $state === 'berhasil' ? 'Kelas Anda sudah aktif!' : 'Menunggu konfirmasi pembayaran' }}</div>
            </div>
        </div>
    </div>

    {{-- ── CTA Buttons ── --}}
    <div class="ps-actions">
        @if($state === 'berhasil')
            <a href="{{ route('siswa.jadwal') }}" class="ps-btn-primary">
                📅 Lihat Jadwal Kelas Saya
            </a>
            <a href="{{ route('siswa.dashboard') }}" class="ps-btn-secondary">
                Kembali ke Dashboard
            </a>
        @elseif($state === 'gagal')
            <a href="{{ route('siswa.cari-tutor') }}" class="ps-btn-primary">
                🔍 Cari Tutor Lain
            </a>
            <a href="{{ route('siswa.dashboard') }}" class="ps-btn-secondary">
                Kembali ke Dashboard
            </a>
        @else
            <a href="{{ route('siswa.dashboard') }}" class="ps-btn-secondary">
                ← Kembali ke Dashboard
            </a>
            <div class="ps-refresh-notice">
                Halaman ini akan otomatis refresh setiap <span id="countdown">30</span> detik
            </div>
        @endif
    </div>

</div>

@if($state === 'menunggu')
<script>
    // Auto-refresh setiap 30 detik untuk cek status terbaru
    let seconds = 30;
    const countdownEl = document.getElementById('countdown');
    setInterval(() => {
        seconds--;
        if (countdownEl) countdownEl.textContent = seconds;
        if (seconds <= 0) {
            window.location.reload();
        }
    }, 1000);
</script>
@endif

</body>
</html>
