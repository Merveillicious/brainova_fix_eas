<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Penarikan - Brainova Admin</title>
    @vite('resources/css/app.css')
    <style>
        .badge-pending  { background:#fef3c7;color:#92400e;border:1.5px solid #FBBF24; }
        .badge-diproses { background:#dbeafe;color:#1e40af;border:1.5px solid #3b82f6; }
        .badge-berhasil { background:#dcfce7;color:#166534;border:1.5px solid #16a34a; }
        .badge-ditolak  { background:#fee2e2;color:#991b1b;border:1.5px solid #ef4444; }
        .badge-status { display:inline-block;padding:4px 10px;border-radius:20px;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.04em; }
        .wd-table { width:100%;border-collapse:collapse;font-size:14px; }
        .wd-table th { background:#000;color:#FBBF24;padding:12px 16px;text-align:left;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.05em; }
        .wd-table td { padding:13px 16px;border-bottom:1px solid #f3f4f6;vertical-align:middle; }
        .wd-table tr:hover td { background:#fafafa; }
        .wd-amount { font-size:15px;font-weight:800;color:#000; }
        .wd-tutor  { font-weight:700;color:#000; }
        .wd-meta   { font-size:12px;color:#6b7280;margin-top:2px; }
        .btn-approve { padding:7px 14px;background:#FBBF24;border:2px solid #000;border-radius:8px;font-size:12px;font-weight:700;cursor:pointer;font-family:inherit;transition:background .15s; }
        .btn-approve:hover { background:#f59e0b; }
        .btn-reject  { padding:7px 14px;background:#fff;border:2px solid #000;border-radius:8px;font-size:12px;font-weight:700;cursor:pointer;font-family:inherit;color:#ef4444;transition:background .15s; }
        .btn-reject:hover { background:#fef2f2; }
        .btn-proses  { padding:7px 14px;background:#dbeafe;border:2px solid #3b82f6;border-radius:8px;font-size:12px;font-weight:700;cursor:pointer;font-family:inherit;color:#1e40af; }
        .stat-pill { display:inline-flex;align-items:center;gap:6px;background:#fff;border:2px solid #000;border-radius:12px;padding:10px 20px;font-size:14px;font-weight:700; }
        .stat-pill span { font-size:22px;font-weight:800; }
    </style>
</head>
<body>
<header class="app-topbar">
    <a href="/admin/dashboard" class="app-brand">Brainova</a>
</header>
<div class="siswa-layout">
    @include('admin.partials.sidebar')

    <main class="siswa-main">
        <h1 class="page-title">Kelola Penarikan Saldo</h1>
        <p class="sub-text">Approve, proses, atau tolak permintaan penarikan dari tutor.</p>

        {{-- Stats --}}
        <div style="display:flex;gap:12px;flex-wrap:wrap;margin-bottom:24px;">
            <div class="stat-pill">
                ⏳ Menunggu: <span style="color:#92400e;">{{ $pendingCount }}</span>
            </div>
            <div class="stat-pill">
                📋 Total: <span>{{ $withdrawals->total() }}</span>
            </div>
        </div>

        {{-- Alert --}}
        @if(session('success'))
        <div style="background:#f0fdf4;border:2px solid #16a34a;border-radius:10px;padding:14px 18px;margin-bottom:20px;font-size:14px;color:#15803d;font-weight:600;">
            ✅ {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div style="background:#fef2f2;border:2px solid #dc2626;border-radius:10px;padding:14px 18px;margin-bottom:20px;font-size:14px;color:#dc2626;font-weight:600;">
            ⚠️ {{ session('error') }}
        </div>
        @endif

        {{-- Table --}}
        <div style="background:#fff;border:2px solid #000;border-radius:16px;overflow:hidden;">
            @if($withdrawals->isEmpty())
            <div style="padding:60px;text-align:center;color:#9ca3af;">
                <div style="font-size:48px;margin-bottom:12px;">💸</div>
                <div style="font-size:16px;font-weight:700;color:#374151;">Belum ada permintaan penarikan</div>
            </div>
            @else
            <table class="wd-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tutor</th>
                        <th>Jumlah</th>
                        <th>Metode</th>
                        <th>Rekening / Akun</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th style="text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($withdrawals as $wd)
                    <tr>
                        <td style="color:#9ca3af;font-size:12px;">{{ $wd->id }}</td>
                        <td>
                            <div class="wd-tutor">{{ $wd->tutor->name ?? '-' }}</div>
                            <div class="wd-meta">{{ $wd->nama_pemilik }}</div>
                        </td>
                        <td>
                            <div class="wd-amount">Rp {{ number_format($wd->jumlah, 0, ',', '.') }}</div>
                        </td>
                        <td>
                            @php
                                $metodeLabel = [
                                    'transfer_bank' => '🏦 Transfer Bank',
                                    'gopay'         => '💚 GoPay',
                                    'ovo'           => '💜 OVO',
                                    'dana'          => '🔵 DANA',
                                ][$wd->metode] ?? $wd->metode;
                            @endphp
                            <span style="font-size:13px;font-weight:600;">{{ $metodeLabel }}</span>
                        </td>
                        <td>
                            <div style="font-family:monospace;font-size:13px;font-weight:700;">{{ $wd->nomor_rekening }}</div>
                        </td>
                        <td>
                            <div style="font-size:13px;">{{ \Carbon\Carbon::parse($wd->created_at)->format('d M Y') }}</div>
                            <div class="wd-meta">{{ \Carbon\Carbon::parse($wd->created_at)->format('H:i') }}</div>
                        </td>
                        <td>
                            <span class="badge-status badge-{{ $wd->status }}">
                                {{ ucfirst($wd->status) }}
                            </span>
                            @if($wd->catatan)
                            <div class="wd-meta" style="margin-top:4px;">📝 {{ $wd->catatan }}</div>
                            @endif
                        </td>
                        <td style="text-align:center;">
                            @if($wd->status === 'pending')
                            <div style="display:flex;gap:6px;justify-content:center;flex-wrap:wrap;">
                                {{-- Proses --}}
                                <form method="POST" action="{{ route('admin.penarikan.update') }}" style="display:inline;">
                                    @csrf
                                    <input type="hidden" name="withdrawal_id" value="{{ $wd->id }}">
                                    <input type="hidden" name="status" value="diproses">
                                    <button type="submit" class="btn-proses">⚙️ Proses</button>
                                </form>
                                {{-- Approve --}}
                                @php $fmtJumlah = 'Rp ' . number_format($wd->jumlah, 0, ',', '.'); @endphp
                                <form method="POST" action="{{ route('admin.penarikan.update') }}" style="display:inline;">
                                    @csrf
                                    <input type="hidden" name="withdrawal_id" value="{{ $wd->id }}">
                                    <input type="hidden" name="status" value="berhasil">
                                    <button type="submit" class="btn-approve"
                                            onclick="return confirm('Setujui penarikan {{ $fmtJumlah }}?')">
                                        ✅ Approve
                                    </button>
                                </form>
                                {{-- Tolak --}}
                                <button class="btn-reject btn-tolak"
                                        data-id="{{ $wd->id }}"
                                        data-jumlah="{{ $fmtJumlah }}">
                                    ❌ Tolak
                                </button>
                            </div>
                            @elseif($wd->status === 'diproses')
                            <form method="POST" action="{{ route('admin.penarikan.update') }}" style="display:inline;">
                                @csrf
                                <input type="hidden" name="withdrawal_id" value="{{ $wd->id }}">
                                <input type="hidden" name="status" value="berhasil">
                                <button type="submit" class="btn-approve"
                                        onclick="return confirm('Konfirmasi selesai transfer?')">
                                    ✅ Selesai
                                </button>
                            </form>
                            @else
                            <span style="font-size:12px;color:#9ca3af;">—</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Pagination --}}
            @if($withdrawals->hasPages())
            <div style="padding:16px 24px;border-top:1px solid #f3f4f6;">
                {{ $withdrawals->links() }}
            </div>
            @endif
            @endif
        </div>
    </main>
</div>

{{-- Modal Tolak --}}
<div id="modalTolak"
     style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:9999;align-items:center;justify-content:center;"
     onclick="if(event.target===this)this.style.display='none'">
    <div style="background:#fff;border:2px solid #000;border-radius:16px;padding:32px;max-width:420px;width:90%;position:relative;">
        <h3 style="margin:0 0 8px;font-size:18px;font-weight:800;">Tolak Penarikan</h3>
        <p id="tolakInfo" style="font-size:13px;color:#6b7280;margin:0 0 20px;"></p>
        <form method="POST" action="{{ route('admin.penarikan.update') }}">
            @csrf
            <input type="hidden" name="withdrawal_id" id="tolakId">
            <input type="hidden" name="status" value="ditolak">
            <div style="margin-bottom:16px;">
                <label style="font-size:13px;font-weight:700;display:block;margin-bottom:6px;">Alasan Penolakan</label>
                <textarea name="catatan" rows="3" placeholder="Contoh: Data rekening tidak valid..."
                          style="width:100%;padding:10px;border:2px solid #000;border-radius:8px;font-size:14px;font-family:inherit;box-sizing:border-box;resize:none;"></textarea>
            </div>
            <div style="display:flex;gap:10px;">
                <button type="button" onclick="document.getElementById('modalTolak').style.display='none'"
                        style="flex:1;padding:11px;border:2px solid #000;border-radius:8px;background:#fff;font-weight:700;cursor:pointer;font-family:inherit;">
                    Batal
                </button>
                <button type="submit"
                        style="flex:1;padding:11px;border:2px solid #ef4444;border-radius:8px;background:#ef4444;color:#fff;font-weight:700;cursor:pointer;font-family:inherit;">
                    Tolak
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Tombol tolak pakai data-attribute
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.btn-tolak').forEach(function(btn) {
        btn.addEventListener('click', function() {
            openTolak(this.dataset.id, this.dataset.jumlah);
        });
    });
});

function openTolak(id, jumlah) {
    document.getElementById('tolakId').value = id;
    document.getElementById('tolakInfo').textContent = 'Penarikan ' + jumlah + ' akan ditolak.';
    document.getElementById('modalTolak').style.display = 'flex';
}
</script>
</body>
</html>
