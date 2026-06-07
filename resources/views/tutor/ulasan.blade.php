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
        .ul-page-title { font-size: 28px; font-weight: 800; color: #000; letter-spacing: -.5px; margin-bottom: 4px; }
        .ul-page-sub   { font-size: 14px; color: #6b7280; margin-bottom: 28px; }

        /* ── Rating Summary Card ── */
        .rating-summary {
            background: #fff;
            border: 2px solid #000;
            border-radius: 16px;
            padding: 28px 32px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 48px;
        }

        /* Big score */
        .rating-big-score {
            text-align: center;
            flex-shrink: 0;
        }
        .rating-big-number {
            font-size: 56px;
            font-weight: 800;
            color: #000;
            line-height: 1;
            margin-bottom: 6px;
        }
        .rating-big-stars { display: flex; gap: 3px; justify-content: center; margin-bottom: 6px; }
        .star-filled { color: #FBBF24; font-size: 20px; }
        .star-empty  { color: #e5e7eb; font-size: 20px; }
        .star-half   { position: relative; font-size: 20px; }
        .rating-big-count { font-size: 13px; color: #6b7280; }

        /* Divider */
        .rating-divider {
            width: 1px;
            height: 100px;
            background: #f3f4f6;
            flex-shrink: 0;
        }

        /* Bar breakdown */
        .rating-bars { flex: 1; display: flex; flex-direction: column; gap: 10px; }
        .rating-bar-row {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .rating-bar-label {
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            width: 16px;
            text-align: right;
            flex-shrink: 0;
        }
        .rating-bar-star { color: #FBBF24; font-size: 13px; flex-shrink: 0; }
        .rating-bar-track {
            flex: 1;
            height: 8px;
            background: #f3f4f6;
            border-radius: 4px;
            overflow: hidden;
        }
        .rating-bar-fill {
            height: 100%;
            background: #FBBF24;
            border-radius: 4px;
            transition: width .6s ease;
        }
        .rating-bar-count {
            font-size: 12px;
            color: #9ca3af;
            width: 28px;
            text-align: right;
            flex-shrink: 0;
        }

        /* Stats row */
        .rating-stats {
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }
        .rating-stat-item { text-align: center; }
        .rating-stat-val  { font-size: 22px; font-weight: 800; color: #000; }
        .rating-stat-lbl  { font-size: 12px; color: #6b7280; margin-top: 2px; }

        /* ── Filter tabs ── */
        .ul-filter-row {
            display: flex;
            gap: 8px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        .ul-filter-btn {
            padding: 8px 16px;
            border: 2px solid #000;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            background: #fff;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            transition: all .15s;
        }
        .ul-filter-btn:hover { border-color: #FBBF24; color: #000; }
        .ul-filter-btn.active {
            background: #FBBF24;
            border-color: #FBBF24;
            color: #000;
        }

        /* ── Review Cards ── */
        .ul-reviews-list { display: flex; flex-direction: column; gap: 14px; }

        .ul-review-card {
            background: #fff;
            border: 2px solid #000;
            border-radius: 14px;
            padding: 20px 22px;
            transition: box-shadow .2s, border-color .2s;
        }
        .ul-review-card:hover {
            box-shadow: 0 4px 16px rgba(0,0,0,.06);
            border-color: #e0e0e0;
        }

        .ul-review-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 12px;
            gap: 12px;
        }
        .ul-reviewer-left { display: flex; align-items: center; gap: 12px; }
        .ul-reviewer-avatar {
            width: 44px; height: 44px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            font-weight: 800;
            color: #fff;
            flex-shrink: 0;
        }
        .ul-reviewer-name {
            font-size: 15px;
            font-weight: 700;
            color: #000;
            margin-bottom: 2px;
        }
        .ul-reviewer-meta { font-size: 12px; color: #9ca3af; }

        .ul-review-right { text-align: right; flex-shrink: 0; }
        .ul-review-stars { display: flex; gap: 2px; justify-content: flex-end; margin-bottom: 4px; }
        .ul-star { color: #FBBF24; font-size: 16px; }
        .ul-star.empty { color: #e5e7eb; }
        .ul-review-date { font-size: 12px; color: #9ca3af; }

        .ul-review-body {
            font-size: 14px;
            color: #374151;
            line-height: 1.7;
            padding: 12px 16px;
            background: #fafafa;
            border-radius: 10px;
            border-left: 3px solid #FBBF24;
            font-style: italic;
        }

        .ul-review-subject {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-top: 12px;
            font-size: 12px;
            color: #9ca3af;
        }
        .ul-subject-pill {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: #f3f4f6;
            border-radius: 20px;
            padding: 3px 10px;
            font-size: 12px;
            font-weight: 600;
            color: #374151;
        }

        /* Tutor reply */
        .ul-reply-box {
            margin-top: 14px;
            background: #fff8e6;
            border: 2px solid #000;
            border-radius: 10px;
            padding: 12px 16px;
        }
        .ul-reply-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .05em;
            color: #92400e;
            margin-bottom: 6px;
        }
        .ul-reply-text { font-size: 13px; color: #374151; line-height: 1.6; }

        .btn-balas {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 14px;
            background: #fff;
            border: 2px solid #000;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            color: #374151;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            margin-top: 12px;
            transition: all .15s;
        }
        .btn-balas:hover { border-color: #FBBF24; color: #000; }

        /* Empty state */
        .ul-empty {
            background: #fff;
            border: 2px dashed #000;
            border-radius: 14px;
            text-align: center;
            padding: 60px 24px;
        }
        .ul-empty-icon { font-size: 40px; margin-bottom: 12px; }
        .ul-empty-title { font-size: 16px; font-weight: 700; color: #374151; margin-bottom: 4px; }
        .ul-empty-sub   { font-size: 13px; color: #9ca3af; }

        /* Alert */
        .alert-success { background:#f0fdf4;border: 2px solid #000;border-radius:8px;padding:12px 16px;font-size:14px;color:#166534;margin-bottom:20px; }
        .alert-error   { background:#fef2f2;border: 2px solid #000;border-radius:8px;padding:12px 16px;font-size:14px;color:#b91c1c;margin-bottom:20px; }

        @media (max-width: 768px) {
            .rating-summary { flex-direction: column; gap: 24px; }
            .rating-divider { width: 100%; height: 1px; }
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

        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif

        <h1 class="ul-page-title">Ulasan Saya</h1>
        <p class="ul-page-sub">Ulasan yang diberikan oleh siswa kepada Anda.</p>

        @php
            // Data dari controller (real dari DB, atau kosong jika belum ada)
            $hasReal = isset($reviews) && $reviews->isNotEmpty();
            $displayReviews = $hasReal ? $reviews : collect();

            // Fallback jika belum ada data
            if (!isset($avgRating))    $avgRating    = 0;
            if (!isset($totalReviews)) $totalReviews = 0;
            if (!isset($bintangCount)) $bintangCount = [5=>0,4=>0,3=>0,2=>0,1=>0];
        @endphp

        {{-- ══ Rating Summary ══ --}}
        <div class="rating-summary">

            {{-- Big score --}}
            <div class="rating-big-score">
                <div class="rating-big-number">{{ $avgRating }}</div>
                <div class="rating-big-stars">
                    @for($s = 1; $s <= 5; $s++)
                        <span class="{{ $s <= floor($avgRating) ? 'star-filled' : 'star-empty' }}">★</span>
                    @endfor
                </div>
                <div class="rating-big-count">dari {{ $totalReviews }} ulasan</div>
            </div>

            <div class="rating-divider"></div>

            {{-- Bar breakdown --}}
            <div class="rating-bars">
                @foreach([5,4,3,2,1] as $bintang)
                @php $pct = $totalReviews > 0 ? round(($bintangCount[$bintang] / $totalReviews) * 100) : 0; @endphp
                <div class="rating-bar-row">
                    <div class="rating-bar-label">{{ $bintang }}</div>
                    <span class="rating-bar-star">★</span>
                    <div class="rating-bar-track">
                        <div class="rating-bar-fill" style="width: {{ $pct }}%;"></div>
                    </div>
                    <div class="rating-bar-count">{{ $bintangCount[$bintang] }}</div>
                </div>
                @endforeach
            </div>

            <div class="rating-divider"></div>

            {{-- Stats --}}
            <div class="rating-stats">
                <div class="rating-stat-item">
                    <div class="rating-stat-val">{{ $totalReviews }}</div>
                    <div class="rating-stat-lbl">Total Ulasan</div>
                </div>
                <div class="rating-stat-item">
                    <div class="rating-stat-val">{{ $bintangCount[5] }}</div>
                    <div class="rating-stat-lbl">Bintang 5 ⭐</div>
                </div>
                <div class="rating-stat-item">
                    <div class="rating-stat-val">{{ round(($bintangCount[5] + $bintangCount[4]) / max($totalReviews, 1) * 100) }}%</div>
                    <div class="rating-stat-lbl">Kepuasan</div>
                </div>
            </div>
        </div>

        {{-- ══ Filter ══ --}}
        <div class="ul-filter-row">
            <button class="ul-filter-btn active" onclick="filterUlasan(this, 'all')">Semua</button>
            <button class="ul-filter-btn" onclick="filterUlasan(this, '5')">⭐⭐⭐⭐⭐ 5 Bintang</button>
            <button class="ul-filter-btn" onclick="filterUlasan(this, '4')">⭐⭐⭐⭐ 4 Bintang</button>
            <button class="ul-filter-btn" onclick="filterUlasan(this, '3')">⭐⭐⭐ 3 Bintang ke bawah</button>
        </div>

        {{-- ══ Review List ══ --}}
        <div class="ul-reviews-list" id="reviewList">

            @if($hasReal)
                @foreach($displayReviews as $review)
                @php
                    $siswa   = $review->booking->student ?? null;
                    $nama    = $siswa->name ?? 'Siswa';
                    $words   = explode(' ', $nama);
                    $inits   = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
                    $colors  = ['#6366f1','#10b981','#ef4444','#8b5cf6','#f59e0b','#0ea5e9'];
                    $color   = $colors[$review->id % count($colors)];
                    $mapel   = $review->booking->schedule->subject?->nama_mapel ?? '-';
                    $tgl     = $review->created_at ? \Carbon\Carbon::parse($review->created_at)->format('d M Y') : '-';
                    $rating  = $review->rating ?? 5;
                @endphp
                <div class="ul-review-card" data-rating="{{ $rating }}">
                    <div class="ul-review-header">
                        <div class="ul-reviewer-left">
                            <div class="ul-reviewer-avatar" style="background: {{ $color }};">{{ $inits }}</div>
                            <div>
                                <div class="ul-reviewer-name">{{ $nama }}</div>
                                <div class="ul-reviewer-meta">{{ $mapel }}</div>
                            </div>
                        </div>
                        <div class="ul-review-right">
                            <div class="ul-review-stars">
                                @for($s = 1; $s <= 5; $s++)
                                    <span class="ul-star {{ $s <= $rating ? '' : 'empty' }}">★</span>
                                @endfor
                            </div>
                            <div class="ul-review-date">{{ $tgl }}</div>
                        </div>
                    </div>
                    @if($review->komentar)
                    <div class="ul-review-body">"{{ $review->komentar }}"</div>
                    @endif
                    <div class="ul-review-subject">
                        <span class="ul-subject-pill">📚 {{ $mapel }}</span>
                    </div>
                </div>
                @endforeach
            @else
                <div class="ul-empty">
                    <div class="ul-empty-icon">⭐</div>
                    <div class="ul-empty-title">Belum ada ulasan</div>
                    <div class="ul-empty-sub">Ulasan dari siswa akan muncul di sini setelah sesi selesai.</div>
                </div>
            @endif

        </div>{{-- end #reviewList --}}

    </main>
</div>

<script>
    function filterUlasan(btn, filter) {
        // Toggle active button
        document.querySelectorAll('.ul-filter-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        // Filter cards
        document.querySelectorAll('.ul-review-card').forEach(card => {
            const rating = parseInt(card.dataset.rating);
            let show = false;
            if (filter === 'all')      show = true;
            else if (filter === '5')   show = rating === 5;
            else if (filter === '4')   show = rating === 4;
            else if (filter === '3')   show = rating <= 3;
            card.style.display = show ? '' : 'none';
        });
    }
</script>
</body>
</html>
