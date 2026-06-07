<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ulasan Saya - Brainova</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <style>
        body { margin: 0; font-family: 'Inter', sans-serif; background: #fafafa; }

        /* ── Page Header ── */
        .ul-page-title { font-size: 32px; font-weight: 800; color: #000; letter-spacing: -.5px; margin-bottom: 4px; }
        .ul-page-sub   { font-size: 14px; color: #6b7280; margin-bottom: 32px; }

        /* ── Two-col layout ── */
        .ul-layout {
            display: grid;
            grid-template-columns: 1fr 380px;
            gap: 32px;
            align-items: start;
        }

        /* ── Section heading ── */
        .ul-section-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
        }
        .ul-section-title {
            font-size: 18px;
            font-weight: 800;
            color: #000;
        }
        .ul-count-badge {
            background: #f3f4f6;
            border: 2px solid #000;
            border-radius: 20px;
            padding: 3px 12px;
            font-size: 12px;
            font-weight: 700;
            color: #374151;
        }

        /* ── Perlu Dinilai card ── */
        .ul-pending-card {
            background: #fff;
            border: 2px solid #000;
            border-radius: 14px;
            padding: 16px 20px;
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 12px;
            transition: border-color .2s, box-shadow .2s;
        }
        .ul-pending-card:hover {
            border-color: #FBBF24;
            box-shadow: 0 2px 12px rgba(251,191,36,.12);
        }
        .ul-pending-avatar {
            width: 48px; height: 48px;
            border-radius: 50%;
            border: 2px solid #000;
            object-fit: cover;
            flex-shrink: 0;
        }
        .ul-pending-info { flex: 1; min-width: 0; }
        .ul-pending-name {
            font-size: 15px;
            font-weight: 700;
            color: #000;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .ul-pending-meta {
            font-size: 12px;
            color: #6b7280;
            margin-top: 3px;
        }
        .ul-pending-meta span { display: inline-flex; align-items: center; gap: 3px; }
        .btn-beri-ulasan {
            padding: 9px 18px;
            background: #FBBF24;
            border: 2px solid #000;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 700;
            color: #000;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            white-space: nowrap;
            transition: background .15s, transform .1s;
            flex-shrink: 0;
        }
        .btn-beri-ulasan:hover { background: #f59e0b; transform: translateY(-1px); }

        /* ── Empty state ── */
        .ul-empty {
            background: #fff;
            border: 2px dashed #000;
            border-radius: 14px;
            text-align: center;
            padding: 48px 24px;
            color: #aaa;
        }
        .ul-empty-icon { font-size: 36px; margin-bottom: 10px; }
        .ul-empty p { font-size: 14px; color: #555; font-weight: 600; margin-bottom: 4px; }
        .ul-empty small { font-size: 12px; }

        /* ── Riwayat Ulasan card ── */
        .ul-review-card {
            background: #fdf8ef;
            border: 2px solid #000;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 12px;
            transition: box-shadow .2s;
        }
        .ul-review-card:hover { box-shadow: 0 2px 12px rgba(0,0,0,.06); }
        .ul-review-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 8px;
        }
        .ul-reviewer-name {
            font-size: 13px;
            font-weight: 700;
            color: #000;
        }
        .ul-review-date {
            font-size: 11px;
            color: #9ca3af;
            white-space: nowrap;
        }
        .ul-stars {
            display: flex;
            gap: 2px;
            margin-bottom: 8px;
        }
        .ul-stars .star { color: #FBBF24; font-size: 18px; }
        .ul-stars .star.empty { color: #e5e7eb; }
        .ul-review-text {
            font-size: 13px;
            color: #374151;
            line-height: 1.6;
        }
        .ul-review-subject {
            font-size: 11px;
            color: #9ca3af;
            margin-top: 8px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* ── Modal ── */
        .ul-modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,.4);
            z-index: 999;
            align-items: center;
            justify-content: center;
        }
        .ul-modal-overlay.open { display: flex; }
        .ul-modal {
            background: #fff;
            border-radius: 20px;
            width: 460px;
            max-width: 92vw;
            padding: 32px;
            box-shadow: 0 24px 64px rgba(0,0,0,.15);
            animation: ulModalIn .22s ease;
        }
        @keyframes ulModalIn {
            from { opacity: 0; transform: scale(.95) translateY(16px); }
            to   { opacity: 1; transform: scale(1) translateY(0); }
        }
        .ul-modal-title { font-size: 20px; font-weight: 800; color: #000; margin-bottom: 4px; }
        .ul-modal-sub   { font-size: 13px; color: #6b7280; margin-bottom: 24px; }

        /* Star rating input */
        .star-rating {
            display: flex;
            flex-direction: row-reverse;
            justify-content: flex-end;
            gap: 4px;
            margin-bottom: 20px;
        }
        .star-rating input[type="radio"] { display: none; }
        .star-rating label {
            font-size: 32px;
            color: #e5e7eb;
            cursor: pointer;
            transition: color .15s;
        }
        .star-rating label:hover,
        .star-rating label:hover ~ label,
        .star-rating input:checked ~ label {
            color: #FBBF24;
        }

        .ul-form-label {
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
            display: block;
        }
        .ul-textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #000;
            border-radius: 10px;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            resize: vertical;
            min-height: 100px;
            outline: none;
            transition: border-color .2s;
            box-sizing: border-box;
        }
        .ul-textarea:focus { border-color: #FBBF24; }

        .ul-modal-actions {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }
        .ul-btn-cancel {
            flex: 1;
            padding: 11px;
            background: #fff;
            border: 2px solid #000;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            color: #374151;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            transition: background .15s;
        }
        .ul-btn-cancel:hover { background: #f9fafb; }
        .ul-btn-submit {
            flex: 1;
            padding: 11px;
            background: #FBBF24;
            border: 2px solid #000;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 700;
            color: #000;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            transition: background .15s;
        }
        .ul-btn-submit:hover { background: #f59e0b; }
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

        <h1 class="ul-page-title">Ulasan Saya</h1>
        <p class="ul-page-sub">Kelola masukan dan ulasan untuk tutor Anda.</p>

        <div class="ul-layout">

            {{-- ══ KIRI: Perlu Dinilai ══ --}}
            <div>
                <div class="ul-section-head">
                    <div class="ul-section-title">Perlu Dinilai</div>
                    @if($perluDinilai->count() > 0)
                        <span class="ul-count-badge">{{ $perluDinilai->count() }} Kelas</span>
                    @endif
                </div>

                @if($perluDinilai->isEmpty())
                    @php
                        $demoPending = [
                            ['id' => 901, 'tutor' => 'Tutor Demo',  'mapel' => 'Matematika SMA',  'selesai' => '20 Okt 2023'],
                            ['id' => 902, 'tutor' => 'Siti Rahayu', 'mapel' => 'Fisika Dasar',    'selesai' => '18 Okt 2023'],
                            ['id' => 903, 'tutor' => 'Budi Hartono','mapel' => 'Persiapan UTBK',  'selesai' => '15 Okt 2023'],
                        ];
                    @endphp
                    <div class="ul-section-head" style="margin-bottom:12px;">
                        <span class="ul-count-badge">{{ count($demoPending) }} Kelas</span>
                    </div>
                    @foreach($demoPending as $dp)
                    <div class="ul-pending-card">
                        <img class="ul-pending-avatar"
                             src="https://ui-avatars.com/api/?name={{ urlencode($dp['tutor']) }}&background=random&color=fff"
                             alt="{{ $dp['tutor'] }}">
                        <div class="ul-pending-info">
                            <div class="ul-pending-name">{{ $dp['mapel'] }}</div>
                            <div class="ul-pending-meta">
                                Bersama {{ $dp['tutor'] }} &bull; Selesai {{ $dp['selesai'] }}
                            </div>
                        </div>
                        <button class="btn-beri-ulasan"
                                onclick="bukaModal({{ $dp['id'] }}, '{{ $dp['mapel'] }}', '{{ $dp['tutor'] }}')">
                            Beri Ulasan
                        </button>
                    </div>
                    @endforeach
                @else
                    <div class="ul-section-head" style="margin-bottom:12px;">
                        <span class="ul-count-badge">{{ $perluDinilai->count() }} Kelas</span>
                    </div>
                    @foreach($perluDinilai as $booking)
                    @php
                        $sched   = $booking->schedule;
                        $tutor   = $sched?->tutor;
                        $subject = $sched?->subject;
                        $selesai = $booking->updated_at
                            ? \Carbon\Carbon::parse($booking->updated_at)->translatedFormat('j M')
                            : '-';
                    @endphp
                    <div class="ul-pending-card">
                        <img class="ul-pending-avatar"
                             src="https://ui-avatars.com/api/?name={{ urlencode($tutor?->name ?? 'T') }}&background=random&color=fff"
                             alt="{{ $tutor?->name }}">
                        <div class="ul-pending-info">
                            <div class="ul-pending-name">{{ $subject?->nama_mapel ?? 'Kelas' }}</div>
                            <div class="ul-pending-meta">
                                Bersama {{ $tutor?->name ?? '-' }} &bull; Selesai {{ $selesai }}
                            </div>
                        </div>
                        <button class="btn-beri-ulasan"
                                onclick="bukaModal({{ $booking->id }}, '{{ addslashes($subject?->nama_mapel ?? 'Kelas') }}', '{{ addslashes($tutor?->name ?? '-') }}')">
                            Beri Ulasan
                        </button>
                    </div>
                    @endforeach
                @endif
            </div>

            {{-- ══ KANAN: Riwayat Ulasan ══ --}}
            <div>
                <div class="ul-section-head">
                    <div class="ul-section-title">Riwayat Ulasan</div>
                </div>

                @if($riwayatUlasan->isEmpty())
                    @php
                        $demoRiwayat = [
                            ['tutor' => 'Tutor Demo',   'mapel' => 'Matematika SMA', 'rating' => 5, 'tanggal' => '10 Okt 2023', 'komentar' => 'Tutor sangat sabar dan penjelasannya mudah dipahami. Nilai saya naik drastis setelah belajar di sini!'],
                            ['tutor' => 'Rina Wulandari','mapel' => 'Bahasa Inggris', 'rating' => 4, 'tanggal' => '3 Okt 2023',  'komentar' => 'Cara mengajarnya menyenangkan, materi disampaikan dengan contoh nyata sehari-hari.'],
                            ['tutor' => 'Ahmad Fauzi',  'mapel' => 'Kimia Dasar',    'rating' => 5, 'tanggal' => '25 Sep 2023', 'komentar' => 'Sangat membantu persiapan ujian saya. Rekomen banget untuk teman-teman yang mau UTBK!'],
                        ];
                    @endphp
                    @foreach($demoRiwayat as $dr)
                    <div class="ul-review-card">
                        <div class="ul-review-top">
                            <div class="ul-reviewer-name">{{ $dr['tutor'] }}</div>
                            <div class="ul-review-date">{{ $dr['tanggal'] }}</div>
                        </div>
                        <div class="ul-stars">
                            @for($s = 1; $s <= 5; $s++)
                                <span class="star {{ $s <= $dr['rating'] ? '' : 'empty' }}">★</span>
                            @endfor
                        </div>
                        <div class="ul-review-text">"{{ $dr['komentar'] }}"</div>
                        <div class="ul-review-subject">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
                                <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
                            </svg>
                            {{ $dr['mapel'] }}
                        </div>
                    </div>
                    @endforeach
                @else
                    @foreach($riwayatUlasan as $review)
                    @php
                        $sched   = $review->booking?->schedule;
                        $tutor   = $sched?->tutor;
                        $subject = $sched?->subject;
                    @endphp
                    <div class="ul-review-card">
                        <div class="ul-review-top">
                            <div class="ul-reviewer-name">{{ $tutor?->name ?? '-' }}</div>
                            <div class="ul-review-date">
                                {{ $review->created_at ? \Carbon\Carbon::parse($review->created_at)->translatedFormat('j M') : '' }}
                            </div>
                        </div>
                        <div class="ul-stars">
                            @for($s = 1; $s <= 5; $s++)
                                <span class="star {{ $s <= $review->rating ? '' : 'empty' }}">★</span>
                            @endfor
                        </div>
                        @if($review->komentar)
                            <div class="ul-review-text">"{{ $review->komentar }}"</div>
                        @endif
                        <div class="ul-review-subject">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
                                <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
                            </svg>
                            {{ $subject?->nama_mapel ?? '-' }}
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>

        </div>{{-- end .ul-layout --}}
    </main>
</div>

{{-- ══ Modal Beri Ulasan ══ --}}
<div class="ul-modal-overlay" id="ulasanModal">
    <div class="ul-modal">
        <div class="ul-modal-title">Beri Ulasan</div>
        <div class="ul-modal-sub" id="modalSub">Berikan penilaian untuk kelas ini</div>

        <form method="POST" action="{{ route('siswa.ulasan.store') }}">
            @csrf
            <input type="hidden" name="booking_id" id="modalBookingId">

            {{-- Bintang --}}
            <label class="ul-form-label">Rating</label>
            <div class="star-rating">
                @for($i = 5; $i >= 1; $i--)
                    <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" {{ $i === 5 ? 'checked' : '' }}>
                    <label for="star{{ $i }}">★</label>
                @endfor
            </div>

            {{-- Komentar --}}
            <label class="ul-form-label" for="komentar">Komentar (opsional)</label>
            <textarea class="ul-textarea" name="komentar" id="komentar"
                      placeholder="Bagaimana pengalaman belajar kamu bersama tutor ini?"></textarea>

            <div class="ul-modal-actions">
                <button type="button" class="ul-btn-cancel" onclick="tutupModal()">Batal</button>
                <button type="submit" class="ul-btn-submit">Kirim Ulasan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function bukaModal(bookingId, mapel, tutorName) {
        document.getElementById('modalBookingId').value = bookingId;
        document.getElementById('modalSub').textContent = mapel + ' · Bersama ' + tutorName;
        document.getElementById('ulasanModal').classList.add('open');
        document.body.style.overflow = 'hidden';
    }
    function tutupModal() {
        document.getElementById('ulasanModal').classList.remove('open');
        document.body.style.overflow = '';
    }
    // Close on overlay click
    document.getElementById('ulasanModal').addEventListener('click', function(e) {
        if (e.target === this) tutupModal();
    });
</script>
</body>
</html>
