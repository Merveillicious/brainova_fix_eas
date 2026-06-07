<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gateway Pembayaran - Brainova</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <style>
        body { margin: 0; font-family: 'Inter', sans-serif; background: #fafafa; }
        .gw-layout { max-width: 1000px; margin: 40px auto; padding: 0 20px; display: grid; grid-template-columns: 1fr 340px; gap: 24px; align-items: start; }
        @media (max-width: 800px) { .gw-layout { grid-template-columns: 1fr; } }
        
        .gw-card { background: #fff; border: 2px solid #000; border-radius: 12px; overflow: hidden; }
        
        /* Left Column */
        .gw-header { background: #f5a623; padding: 16px 20px; display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #000; }
        .gw-back { font-size: 14px; font-weight: 600; color: #000; text-decoration: none; display: flex; align-items: center; gap: 6px; }
        .gw-title { font-size: 14px; font-weight: 800; color: #000; }
        
        .gw-total-row { padding: 20px; display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #000; }
        .gw-total-label { font-size: 14px; color: #666; }
        .gw-total-val { font-size: 20px; font-weight: 800; color: #000; }
        
        /* Payment Methods */
        .gw-method { border-bottom: 1px solid #e5e7eb; }
        .gw-method.active { background: #f5a623; border-bottom: 2px solid #000; }
        .gw-method-header { padding: 16px 20px; display: flex; justify-content: space-between; align-items: center; cursor: pointer; }
        
        .gw-radio-wrap { display: flex; align-items: flex-start; gap: 12px; }
        .gw-radio { width: 18px; height: 18px; border-radius: 50%; border: 2px solid #ccc; background: #fff; margin-top: 2px; position: relative; }
        .gw-method.active .gw-radio { border-color: #000; }
        .gw-method.active .gw-radio::after { content: ''; position: absolute; top: 3px; left: 3px; width: 8px; height: 8px; background: #000; border-radius: 50%; }
        
        .gw-method-title { font-size: 15px; font-weight: 700; color: #000; display: flex; align-items: center; gap: 8px; }
        .gw-badge-rec { background: #000; color: #fff; font-size: 10px; padding: 2px 6px; border-radius: 12px; font-weight: 600; }
        .gw-method-desc { font-size: 12px; color: #666; margin-top: 4px; }
        .gw-method.active .gw-method-desc { color: #222; }
        
        /* QRIS Expanded Area */
        .gw-qris-area { padding: 0 20px 20px 20px; }
        .gw-qris-card { background: #fff; border: 2px solid #000; border-radius: 8px; padding: 16px; display: flex; gap: 16px; align-items: center; }
        .gw-qr-img { width: 80px; height: 80px; border: 1px solid #eee; border-radius: 4px; object-fit: cover; }
        .gw-qris-right h4 { margin: 0 0 6px 0; font-size: 14px; font-weight: 700; }
        .gw-qris-right p { margin: 0 0 10px 0; font-size: 12px; color: #666; line-height: 1.4; }
        .gw-mini-badges { display: flex; gap: 4px; flex-wrap: wrap; }
        .gw-mb { background: #e5e7eb; font-size: 10px; font-weight: 700; color: #555; padding: 3px 6px; border-radius: 4px; }
        
        /* Footer area of left card */
        .gw-footer-area { padding: 20px; text-align: center; }
        .gw-secure-text { font-size: 12px; color: #888; display: flex; justify-content: center; align-items: center; gap: 6px; margin-bottom: 16px; }
        .gw-btn { width: 100%; padding: 14px; background: #f5a623; border: 2px solid #000; border-radius: 8px; font-size: 15px; font-weight: 800; cursor: pointer; transition: all 0.2s; display: flex; justify-content: center; align-items: center; gap: 8px; }
        .gw-btn:hover { background: #e59613; }
        
        /* Right Column (Summary) */
        .gw-sum-header { background: #f5a623; padding: 16px 20px; border-bottom: 2px solid #000; display: flex; align-items: center; gap: 12px; }
        .gw-sum-avatar { width: 40px; height: 40px; border-radius: 8px; border: 2px solid #000; object-fit: cover; }
        .gw-sum-tutor { font-size: 14px; font-weight: 800; color: #000; margin-bottom: 2px; }
        .gw-sum-sub { font-size: 11px; color: #333; font-weight: 500; }
        
        .gw-sum-body { padding: 20px; }
        .gw-sum-row { display: flex; justify-content: space-between; font-size: 12px; color: #555; margin-bottom: 12px; }
        .gw-sum-val { font-size: 12px; font-weight: 600; color: #000; }
        .gw-divider { height: 1px; background: #ccc; margin: 16px 0; }
        
        .gw-sum-total-box { background: #f5a623; padding: 16px 20px; border-top: 2px solid #000; border-bottom: 2px solid #000; display: flex; justify-content: space-between; align-items: center; }
        .gw-sum-total-box span:first-child { font-weight: 800; font-size: 14px; }
        .gw-sum-total-box span:last-child { font-weight: 800; font-size: 18px; }
        
        .gw-sum-footer { padding: 16px; background: #fff; display: flex; justify-content: center; }
        .gw-sum-badge { background: #f3f4f6; color: #666; font-size: 11px; font-weight: 600; padding: 6px 12px; border-radius: 6px; display: flex; align-items: center; gap: 6px; border: 1px solid #e5e7eb; }
    </style>
</head>
<body>
<header class="app-topbar">
    <a href="{{ route('siswa.dashboard') }}" class="app-brand">
        Brainova
    </a>
</header>

@php
    $tutor = $booking->schedule->tutor;
    $subject = $booking->schedule->subject;
    $hargaSesi = $tutor->tarif;
    $biayaLayanan = 4000;
    $total = $hargaSesi + $biayaLayanan;
@endphp

<div class="gw-layout">
    <!-- Kiri: Metode Pembayaran -->
    <div class="gw-card">
        <div class="gw-header">
            <a href="javascript:history.back()" class="gw-back">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                Ringkasan
            </a>
            <div class="gw-title">Pilih Metode Pembayaran</div>
        </div>
        
        <div class="gw-total-row">
            <span class="gw-total-label">Total Pembayaran</span>
            <span class="gw-total-val">Rp {{ number_format($total, 0, ',', '.') }}</span>
        </div>
        
        <!-- Accordion Item 1 (Active) -->
        <div class="gw-method active">
            <div class="gw-method-header">
                <div class="gw-radio-wrap">
                    <div class="gw-radio"></div>
                    <div>
                        <div class="gw-method-title">
                            QRIS <span class="gw-badge-rec">Rekomendasi</span>
                        </div>
                        <div class="gw-method-desc">Scan dengan semua aplikasi bank & dompet</div>
                    </div>
                </div>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m18 15-6-6-6 6"/></svg>
            </div>
            <div class="gw-qris-area">
                <div class="gw-qris-card">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=BrainovaPayment" class="gw-qr-img" alt="QRIS">
                    <div class="gw-qris-right">
                        <h4>QRIS — All Payment</h4>
                        <p>Scan menggunakan GoPay, OVO, DANA, ShopeePay, BCA Mobile, M-Banking, dan 30+ aplikasi lainnya.</p>
                        <div class="gw-mini-badges">
                            <span class="gw-mb">GP</span>
                            <span class="gw-mb">OV</span>
                            <span class="gw-mb">DN</span>
                            <span class="gw-mb">SP</span>
                            <span class="gw-mb">BC</span>
                            <span class="gw-mb">MR</span>
                            <span class="gw-mb" style="background:transparent; font-weight:500;">+30 lainnya</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Accordion Item 2 -->
        <div class="gw-method">
            <div class="gw-method-header">
                <div class="gw-radio-wrap">
                    <div class="gw-radio"></div>
                    <div>
                        <div class="gw-method-title">Transfer Bank</div>
                        <div class="gw-method-desc">BCA, Mandiri, BNI, BRI — Virtual Account</div>
                    </div>
                </div>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
            </div>
        </div>

        <!-- Accordion Item 3 -->
        <div class="gw-method" style="border-bottom:none;">
            <div class="gw-method-header">
                <div class="gw-radio-wrap">
                    <div class="gw-radio"></div>
                    <div>
                        <div class="gw-method-title">Dompet Digital</div>
                        <div class="gw-method-desc">GoPay, OVO, DANA, ShopeePay</div>
                    </div>
                </div>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
            </div>
        </div>
        
        <div class="gw-footer-area">
            <div class="gw-secure-text">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                Pembayaran aman &amp; terenkripsi 256-bit SSL
            </div>

            @if($booking->status_pembayaran === 'dibayar')
                {{-- Sudah dibayar --}}
                <div style="background:#f0fdf4;border:2px solid #16a34a;border-radius:10px;padding:14px;text-align:center;font-weight:700;color:#15803d;font-size:15px;">
                    ✅ Pembayaran sudah dikonfirmasi
                </div>
                <div style="margin-top:12px;text-align:center;">
                    <a href="{{ route('siswa.jadwal') }}" class="gw-btn" style="text-decoration:none;display:inline-flex;">
                        Lihat Jadwal Kelas
                    </a>
                </div>
            @else
                {{-- Tombol konfirmasi bayar --}}
                <form method="POST" action="{{ route('siswa.gateway.confirm', $booking->id) }}" id="confirmForm">
                    @csrf
                    <button type="submit" class="gw-btn">
                        Bayar dengan QRIS
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                    </button>
                </form>
            @endif
        </div>
    </div>
    
    <!-- Kanan: Ringkasan Pemesanan -->
    <div class="gw-card">
        <div class="gw-sum-header">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($tutor->name) }}&background=random" class="gw-sum-avatar" alt="Avatar">
            <div>
                <div class="gw-sum-tutor">{{ $tutor?->name ?? '-' }}</div>
                <div class="gw-sum-sub">{{ $subject?->nama_mapel ?? 'Matematika' }} · {{ \Carbon\Carbon::parse($booking->schedule?->tanggal)->translatedFormat('j M Y') }}</div>
            </div>
        </div>
        
        <div class="gw-sum-body">
            <div class="gw-sum-row">
                <span>Waktu</span>
                <span class="gw-sum-val">{{ \Carbon\Carbon::parse($booking->schedule->jam_mulai)->format('H:i') }} WIB</span>
            </div>
            <div class="gw-sum-row">
                <span>Durasi</span>
                <span class="gw-sum-val">60 menit</span>
            </div>
            <div class="gw-sum-row">
                <span>Platform</span>
                <span class="gw-sum-val">Zoom (otomatis)</span>
            </div>
            
            <div class="gw-divider"></div>
            
            <div class="gw-sum-row">
                <span>Harga sesi</span>
                <span class="gw-sum-val">Rp {{ number_format($hargaSesi, 0, ',', '.') }}</span>
            </div>
            <div class="gw-sum-row" style="margin-bottom:0;">
                <span>Biaya layanan</span>
                <span class="gw-sum-val">Rp {{ number_format($biayaLayanan, 0, ',', '.') }}</span>
            </div>
        </div>
        
        <div class="gw-sum-total-box">
            <span>Total</span>
            <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
        </div>
        
        <div class="gw-sum-footer">
            <div class="gw-sum-badge">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                Pembayaran Aman & Terenkripsi
            </div>
        </div>
    </div>
</div>
</body>
</html>
