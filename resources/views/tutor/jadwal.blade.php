<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Jadwal - Brainova</title>
    <meta name="description" content="Atur ketersediaan jadwal mengajar Anda dalam 7 hari ke depan di Brainova.">
    @vite('resources/css/app.css')
    <style>
        .btn-primary {
            padding: 11px 24px;
            background: #FBBF24;
            border: 2px solid #000;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 700;
            color: #000;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            transition: background .15s, transform .1s;
        }
        .btn-primary:hover { background: #f59e0b; transform: translateY(-1px); }
        .btn-primary:active { transform: translateY(0); }
        
        .btn-secondary {
            padding: 11px 24px;
            background: #fff;
            border: 2px solid #000;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 700;
            color: #000;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            font-family: 'Inter', sans-serif;
            transition: background .15s, transform .1s;
        }
        .btn-secondary:hover { background: #f3f4f6; transform: translateY(-1px); }
        .btn-secondary:active { transform: translateY(0); }
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

        <main class="siswa-main">
        <!-- Page Header -->
        <div class="page-header">
            <h1>Ketersediaan Jadwal</h1>
            <p class="sub">Atur slot waktu mengajar Anda dalam <strong>7 hari ke depan</strong>
                ({{ now()->format('d M') }} – {{ now()->addDays(7)->format('d M Y') }})</p>
        </div>

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif

        @if(!$tutor || $tutor->status !== 'aktif')
            <div class="notice-box"><strong>Akun tutor belum aktif.</strong> Anda hanya dapat mengelola jadwal setelah akun disetujui oleh admin.</div>
        @else

            <!-- Week Strip -->
            <div class="week-strip">
                @foreach($weekDays as $wday)
                    @php
                        $dName    = $daysId[date('l', strtotime($wday))] ?? date('l', strtotime($wday));
                        $dShort   = mb_substr($dName, 0, 3);
                        $dNum     = date('d', strtotime($wday));
                        $dMon     = $monthsId[date('F', strtotime($wday))] ?? date('M', strtotime($wday));
                        $isActive = ($wday === $activeDate);
                        $isToday  = ($wday === $today);
                        $hasSched = $schedByDate->has($wday) && $schedByDate->get($wday)->count() > 0;
                        $chipClass = 'day-chip' . ($isActive ? ' active' : '') . ($isToday ? ' today-chip' : '') . ($hasSched ? ' has-schedule' : '');
                    @endphp
                    <a href="{{ route('tutor.jadwal', ['date' => $wday]) }}" class="{{ $chipClass }}">
                        <div class="day-name">{{ $dShort }}</div>
                        <div class="day-num">{{ $dNum }}</div>
                        <div class="day-mon">{{ $dMon }}</div>
                    </a>
                @endforeach
            </div>

            <!-- Section Head -->
            @php
                $activeDayName = $daysId[date('l', strtotime($activeDate))] ?? '';
                $activeDateFmt = date('d', strtotime($activeDate)) . ' ' . ($monthsId[date('F', strtotime($activeDate))] ?? date('M', strtotime($activeDate))) . ' ' . date('Y', strtotime($activeDate));
            @endphp
            <div class="section-head">
                <h2>Jadwal {{ $activeDayName }}</h2>
                <span class="date-label">{{ $activeDateFmt }}</span>
            </div>

            <!-- Schedule List -->
            <div class="schedule-list" id="scheduleList">
                @if($activeScheds->isEmpty())
                    <div class="empty-day">
                        <p>Belum ada jadwal untuk hari ini</p>
                        <small>Tambahkan slot mengajar di bawah ini</small>
                    </div>
                @else
                    @foreach($activeScheds as $i => $sc)
                        @php
                            $booked   = $sc->total_booking;
                            $kuota    = intval($sc->kuota);
                            $fillPct  = $kuota > 0 ? min(100, round($booked / $kuota * 100)) : 0;
                            $isPenuh  = $sc->status === 'penuh' || $booked >= $kuota;
                        @endphp
                        <div class="schedule-card {{ $sc->status === 'nonaktif' ? 'inactive' : '' }}" style="animation-delay:{{ $i * 0.05 }}s">
                            <div class="time-block">
                                <div class="time-main">{{ substr($sc->jam_mulai,0,5) }}</div>
                                <div class="time-end">{{ substr($sc->jam_selesai,0,5) }}</div>
                            </div>
                            <div class="sched-info">
                                <div class="sched-date">{{ $sc->tanggal ? \Carbon\Carbon::parse($sc->tanggal)->format('d M Y') : '-' }}</div>
                                <div class="sched-day">{{ $sc->hari }}, {{ substr($sc->jam_mulai,0,5) }} – {{ substr($sc->jam_selesai,0,5) }}</div>
                                <div class="sched-meta"><span class="badge-s badge-{{ $sc->status }}">{{ $sc->status }}</span></div>
                                <div class="kuota-bar">
                                    <div class="bar"><div class="bar-fill {{ $isPenuh ? 'penuh' : '' }}" style="width:{{ $fillPct }}%"></div></div>
                                    <span class="kuota-label">{{ $booked }}/{{ $kuota }} slot</span>
                                </div>
                            </div>
                            <div class="sched-actions">
                                <a href="{{ route('tutor.jadwal.toggle', ['id' => $sc->id, 'date' => $activeDate]) }}" class="btn-icon btn-yellow">
                                    {{ $sc->status === 'nonaktif' ? 'Aktifkan' : 'Nonaktifkan' }}
                                </a>
                                <a href="{{ route('tutor.jadwal', ['edit' => $sc->id, 'date' => $activeDate]) }}" class="btn-icon btn-yellow">Edit</a>
                                <button type="button" class="btn-icon btn-red"
                                    onclick="confirmDelete({{ $sc->id }}, '{{ $activeDayName }}', '{{ substr($sc->jam_mulai,0,5) }} - {{ substr($sc->jam_selesai,0,5) }}')">Hapus</button>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <!-- Form Tambah / Edit -->
            <div class="form-card" id="formSection">
                <div class="form-card-title">{{ $editItem ? 'Edit Jadwal' : 'Tambah Jadwal Baru' }}</div>
                <form method="POST" action="{{ $editItem ? route('tutor.jadwal.update') : route('tutor.jadwal.create') }}">
                    @csrf
                    @if($editItem)
                        <input type="hidden" name="schedule_id" value="{{ $editItem->id }}">
                    @endif

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="tanggal">Tanggal *</label>
                            <input type="date" id="tanggal" name="tanggal"
                                min="{{ $today }}" max="{{ $maxDate }}"
                                value="{{ $editItem ? $editItem->tanggal : $activeDate }}" required
                                onchange="updateHariLabel(this.value)">
                            <span class="form-hint" id="hariLabel">
                                @php
                                    $selDate = $editItem ? ($editItem->tanggal ?? $activeDate) : $activeDate;
                                    echo 'Hari: ' . ($daysId[date('l', strtotime($selDate))] ?? '-');
                                @endphp
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="kuota">Kuota Siswa</label>
                            <input type="number" id="kuota" name="kuota" value="1" readonly
                                style="background:#eee;cursor:not-allowed;color:#555;">
                            <span class="form-hint">Kuota ditetapkan 1 siswa per sesi</span>
                        </div>
                        <div class="form-group">
                            <label for="jam_mulai">Jam Mulai *</label>
                            <input type="time" id="jam_mulai" name="jam_mulai"
                                value="{{ $editItem ? substr($editItem->jam_mulai,0,5) : '08:00' }}" required>
                        </div>
                        <div class="form-group">
                            <label for="jam_selesai">Jam Selesai *</label>
                            <input type="time" id="jam_selesai" name="jam_selesai"
                                value="{{ $editItem ? substr($editItem->jam_selesai,0,5) : '10:00' }}" required>
                        </div>
                        @if($editItem)
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select id="status" name="status">
                                    <option value="tersedia" {{ $editItem->status === 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                                    <option value="nonaktif" {{ $editItem->status === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                </select>
                            </div>
                        @endif
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-primary">{{ $editItem ? 'Simpan Perubahan' : 'Tambah Jadwal' }}</button>
                        @if($editItem)
                            <a href="{{ route('tutor.jadwal', ['date' => $activeDate]) }}" class="btn-secondary">Batal</a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Ringkasan 7 Hari -->
            <div style="margin-top:32px">
                <h2 style="font-size:17px;font-weight:700;margin-bottom:14px">Ringkasan 7 Hari Ke Depan</h2>
                @php
                    $totalSlots  = $schedules->count();
                    $totalBooked = $schedules->sum('total_booking');
                    $sisa        = max(0, $schedules->sum('kuota') - $totalBooked);
                @endphp
                <div style="display:flex;gap:12px;flex-wrap:wrap">
                    <div style="flex:1;min-width:140px;background:#fff;border:2px solid #000;border-radius:12px;padding:16px 20px">
                        <div style="font-size:28px;font-weight:800">{{ $totalSlots }}</div>
                        <div style="font-size:13px;color:#888;margin-top:2px">Total Slot Jadwal</div>
                    </div>
                    <div style="flex:1;min-width:140px;background:#fffbeb;border:2px solid #000;border-radius:12px;padding:16px 20px">
                        <div style="font-size:28px;font-weight:800">{{ $totalBooked }}</div>
                        <div style="font-size:13px;color:#888;margin-top:2px">Total Booking Aktif</div>
                    </div>
                    <div style="flex:1;min-width:140px;background:#fff;border:2px solid #000;border-radius:12px;padding:16px 20px">
                        <div style="font-size:28px;font-weight:800">{{ $sisa }}</div>
                        <div style="font-size:13px;color:#888;margin-top:2px">Sisa Kuota Tersedia</div>
                    </div>
                </div>
            </div>

        @endif
        </main>
    </div>

    <!-- Delete Modal -->
    <div class="modal-overlay" id="deleteModal">
        <div class="modal-box">
            <h3>Hapus Jadwal?</h3>
            <p id="deleteDesc">Jadwal ini akan dihapus permanen. Lanjutkan?</p>
            <div class="modal-actions">
                <form method="POST" action="{{ route('tutor.jadwal.delete') }}" id="deleteForm">
                    @csrf
                    <input type="hidden" name="schedule_id" id="deleteScheduleId">
                    <div style="display:flex;gap:10px">
                        <button type="button" class="btn-secondary" onclick="closeModal()">Batal</button>
                        <button type="submit" class="btn-danger">Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(id, hari, waktu) {
            document.getElementById('deleteScheduleId').value = id;
            document.getElementById('deleteDesc').textContent = 'Jadwal ' + hari + ' ' + waktu + ' akan dihapus permanen. Lanjutkan?';
            document.getElementById('deleteModal').classList.add('open');
        }
        function closeModal() {
            document.getElementById('deleteModal').classList.remove('open');
        }
        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });

        const daysId = { 'Sunday':'Minggu','Monday':'Senin','Tuesday':'Selasa','Wednesday':'Rabu','Thursday':'Kamis','Friday':'Jumat','Saturday':'Sabtu' };
        function updateHariLabel(val) {
            if (!val) { document.getElementById('hariLabel').textContent = ''; return; }
            const d = new Date(val + 'T00:00:00');
            const names = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
            const hari = daysId[names[d.getDay()]] || names[d.getDay()];
            document.getElementById('hariLabel').textContent = 'Hari: ' + hari;
        }

        @if($editItem)
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('formSection').scrollIntoView({ behavior: 'smooth', block: 'start' });
            });
        @endif

        // ── Validasi Form Jadwal ──────────────────────────────────────────────
        (function() {
            const form = document.querySelector('#formSection form');
            if (!form) return;

            form.addEventListener('submit', function(e) {
                let valid  = true;
                const tgl  = document.getElementById('tanggal');
                const jMul = document.getElementById('jam_mulai');
                const jSel = document.getElementById('jam_selesai');

                // Reset
                [tgl, jMul, jSel].forEach(el => { el.style.outline = ''; el.style.borderColor = ''; });
                form.querySelectorAll('.jadwal-err').forEach(el => el.remove());

                // Tanggal wajib diisi
                if (!tgl.value) {
                    markErr(tgl, 'Tanggal wajib dipilih.');
                    valid = false;
                }

                // Jam mulai wajib
                if (!jMul.value) {
                    markErr(jMul, 'Jam mulai wajib diisi.');
                    valid = false;
                }

                // Jam selesai harus setelah jam mulai
                if (jMul.value && jSel.value && jSel.value <= jMul.value) {
                    markErr(jSel, 'Jam selesai harus lebih dari jam mulai.');
                    valid = false;
                }

                if (!valid) e.preventDefault();
            });

            function markErr(input, msg) {
                input.style.borderColor = '#ef4444';
                const span = document.createElement('span');
                span.className = 'jadwal-err';
                span.style.cssText = 'color:#ef4444;font-size:11px;font-weight:600;margin-top:4px;display:block;';
                span.textContent = msg;
                input.insertAdjacentElement('afterend', span);
            }

            // Hapus error saat input berubah
            ['tanggal', 'jam_mulai', 'jam_selesai'].forEach(id => {
                const el = document.getElementById(id);
                if (el) el.addEventListener('change', function() {
                    this.style.borderColor = '';
                    const err = this.nextElementSibling;
                    if (err && err.classList.contains('jadwal-err')) err.remove();
                });
            });
        })();
    </script>
</body>
</html>
