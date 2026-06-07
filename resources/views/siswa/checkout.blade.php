<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Brainova</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <style>
        body { margin: 0; font-family: 'Inter', sans-serif; background: #fafafa; }
        .checkout-layout { max-width: 900px; margin: 40px auto; padding: 0 20px; display: grid; grid-template-columns: 1fr 320px; gap: 24px; }
        @media (max-width: 768px) {
            .checkout-layout { grid-template-columns: 1fr; }
        }
        .checkout-card { background: #fff; border: 2px solid #000; border-radius: 12px; padding: 24px; margin-bottom: 24px; }
        .checkout-title { font-size: 16px; font-weight: 800; color: #000; margin-bottom: 20px; }
        
        /* Left Panel */
        .co-tutor-info { display: flex; align-items: center; gap: 16px; margin-bottom: 24px; }
        .co-avatar { width: 48px; height: 48px; border-radius: 50%; border: 2px solid #000; object-fit: cover; }
        .co-tutor-name { font-size: 16px; font-weight: 700; display: flex; align-items: center; gap: 6px; }
        .co-detail-table { width: 100%; border-collapse: collapse; }
        .co-detail-table td { padding: 8px 0; font-size: 13px; }
        .co-detail-label { color: #666; width: 120px; }
        .co-detail-value { color: #000; font-weight: 500; }
        
        /* Right Panel */
        .co-summary-tutor { display: flex; align-items: center; gap: 12px; margin-bottom: 16px; }
        .co-summary-avatar { width: 40px; height: 40px; border-radius: 50%; border: 2px solid #000; object-fit: cover; }
        .co-summary-name { font-size: 14px; font-weight: 700; color: #000; }
        .co-summary-sub { font-size: 12px; color: #666; }
        .co-divider { height: 2px; background: #000; margin: 16px 0; }
        .co-price-row { display: flex; justify-content: space-between; font-size: 13px; color: #444; margin-bottom: 8px; }
        .co-total-row { display: flex; justify-content: space-between; font-size: 16px; font-weight: 800; color: #000; margin-top: 8px; }
        .co-btn { width: 100%; padding: 14px; background: #f5a623; border: 2px solid #000; border-radius: 8px; font-size: 14px; font-weight: 700; cursor: pointer; margin-top: 24px; transition: all 0.2s; }
        .co-btn:hover { background: #e59613; }
        
        /* Cancellation Policy */
        .co-policy-item { font-size: 13px; color: #666; margin-bottom: 12px; }
    </style>
</head>
<body>
<header class="app-topbar">
    <a href="{{ route('siswa.dashboard') }}" class="app-brand">
        Brainova
    </a>
</header>

@if(session('error'))
    <div style="max-width:900px;margin:16px auto 0;padding:0 20px;">
        <div style="background:#fef2f2;border:2px solid #000;border-radius:8px;padding:12px 16px;font-size:14px;color:#b91c1c;font-weight:600;">
            ⚠️ {{ session('error') }}
        </div>
    </div>
@endif
@if(session('info'))
    <div style="max-width:900px;margin:16px auto 0;padding:0 20px;">
        <div style="background:#eff6ff;border:2px solid #000;border-radius:8px;padding:12px 16px;font-size:14px;color:#1d4ed8;font-weight:600;">
            ℹ️ {{ session('info') }}
        </div>
    </div>
@endif

<div class="checkout-layout">
    <!-- Kiri -->
    <div>
        <div class="checkout-card">
            <div class="checkout-title">Detail Kelas</div>
            <div class="co-tutor-info">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($schedule->tutor->name) }}&background=random" class="co-avatar" alt="Avatar">
                <div>
                    <div class="co-tutor-name">
                        {{ $schedule->tutor->name }}
                        <div style="display:inline-flex; align-items:center; justify-content:center; width:16px; height:16px; background:#fff; color:#ccc; border-radius:50%; border:1px solid #ccc; font-size:8px;">
                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                        </div>
                    </div>
                </div>
            </div>
            
            <table class="co-detail-table">
                <tr>
                    <td class="co-detail-label">Mata Pelajaran</td>
                    <td class="co-detail-value">{{ $schedule->subject?->nama_mapel ?? 'Matematika' }}</td>
                </tr>
                <tr>
                    <td class="co-detail-label">Tipe</td>
                    <td class="co-detail-value">Privat</td>
                </tr>
                <tr>
                    <td class="co-detail-label">Tanggal</td>
                    <td class="co-detail-value">{{ \Carbon\Carbon::parse($schedule->tanggal)->translatedFormat('j F Y') }}</td>
                </tr>
                <tr>
                    <td class="co-detail-label">Jam</td>
                    <td class="co-detail-value">{{ \Carbon\Carbon::parse($schedule->jam_mulai)->format('H:i') }} WIB</td>
                </tr>
                <tr>
                    <td class="co-detail-label">Durasi</td>
                    <td class="co-detail-value">60 menit</td>
                </tr>
                <tr>
                    <td class="co-detail-label">Platform</td>
                    <td class="co-detail-value">Zoom (link dikirim otomatis)</td>
                </tr>
            </table>
        </div>

        <div class="checkout-card">
            <div class="checkout-title">Kebijakan Pembatalan</div>
            <div class="co-policy-item">Batalkan lebih dari 24 jam sebelum kelas — pengembalian dana penuh</div>
            <div class="co-policy-item">Batalkan kurang dari 24 jam — tidak dapat pengembalian dana</div>
            <div class="co-policy-item" style="margin-bottom:0;">Tutor membatalkan — pengembalian dana penuh dalam 1x24 jam</div>
        </div>
    </div>

    <!-- Kanan -->
    <div>
        <div class="checkout-card" style="padding: 24px 20px;">
            <div class="co-summary-tutor">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($schedule->tutor->name) }}&background=random" class="co-summary-avatar" alt="Avatar">
                <div>
                    <div class="co-summary-name">{{ explode(' ', trim($schedule->tutor->name))[0] }}</div>
                    <div class="co-summary-sub">{{ $schedule->subject?->nama_mapel ?? 'Matematika' }} · {{ \Carbon\Carbon::parse($schedule->tanggal)->translatedFormat('j M Y') }}</div>
                </div>
            </div>
            <div class="co-divider"></div>
            
            <div class="co-price-row">
                <span>Waktu</span>
                <span style="color:#000; font-weight:500;">{{ \Carbon\Carbon::parse($schedule->jam_mulai)->format('H:i') }} WIB</span>
            </div>
            <div class="co-price-row">
                <span>Durasi</span>
                <span style="color:#000; font-weight:500;">60 menit</span>
            </div>
            <div class="co-price-row">
                <span>Platform</span>
                <span style="color:#000; font-weight:500;">Zoom (otomatis)</span>
            </div>
            
            <div class="co-divider"></div>
            
            @php
                $hargaSesi = $schedule->tutor->tarif;
                $biayaLayanan = 4000;
                $total = $hargaSesi + $biayaLayanan;
            @endphp
            <div class="co-price-row">
                <span>Harga sesi</span>
                <span style="color:#000; font-weight:500;">Rp {{ number_format($hargaSesi, 0, ',', '.') }}</span>
            </div>
            <div class="co-price-row">
                <span>Biaya layanan</span>
                <span style="color:#000; font-weight:500;">Rp {{ number_format($biayaLayanan, 0, ',', '.') }}</span>
            </div>
            
            <div class="co-divider"></div>
            
            <div class="co-total-row">
                <span>Total</span>
                <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>

            <form method="POST" action="{{ route('siswa.booking') }}">
                @csrf
                <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">
                <input type="hidden" name="metode_pembayaran" value="transfer">
                <button type="submit" class="co-btn">Lanjut ke Pembayaran →</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
