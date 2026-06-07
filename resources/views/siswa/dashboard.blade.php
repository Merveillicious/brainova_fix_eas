<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda - Brainova</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <style>
        body { margin: 0; font-family: 'Inter', sans-serif; }

        /* Range Slider */
        .range-wrap { position: relative; margin-top: 6px; }
        .range-track { position: relative; height: 4px; background: #e5e7eb; border-radius: 2px; margin: 16px 0 6px; }
        .range-fill  { position: absolute; height: 4px; background: #f5a623; border-radius: 2px; pointer-events: none; }
        .range-input {
            position: absolute; width: 100%; top: -8px; left: 0;
            appearance: none; -webkit-appearance: none;
            background: transparent; pointer-events: none;
        }
        .range-input::-webkit-slider-thumb {
            appearance: none; -webkit-appearance: none;
            width: 18px; height: 18px; border-radius: 50%;
            background: #fff; border: 2px solid #000;
            cursor: pointer; pointer-events: all;
        }
        .range-input::-moz-range-thumb {
            width: 18px; height: 18px; border-radius: 50%;
            background: #fff; border: 2px solid #000;
            cursor: pointer; pointer-events: all;
        }
        .range-labels { display: flex; justify-content: space-between; font-size: 11px; font-weight: 600; color: #777; }
        .range-val { font-size: 12px; font-weight: 700; color: #000; text-align: center; margin-top: 6px; }

        /* Empty & tags */
        .empty-tutor { text-align:center; padding:40px 20px; border:2px dashed #e5e7eb; border-radius:12px; }
        .empty-tutor .icon { font-size:32px; margin-bottom:8px; }
        .empty-tutor h3 { font-size:15px; font-weight:700; color:#374151; margin-bottom:4px; }
        .empty-tutor p  { font-size:12px; color:#9ca3af; }
        .active-filters { display:flex; gap:6px; flex-wrap:wrap; margin-bottom:14px; }
        .filter-tag {
            display:inline-flex; align-items:center; gap:5px;
            background:#fff8e6; border:1.5px solid #FBBF24;
            border-radius:20px; padding:3px 10px;
            font-size:11px; font-weight:600; color:#92400e;
        }
        .filter-tag a { color:#92400e; text-decoration:none; font-weight:800; }
    </style>
</head>
<body>
<header class="app-topbar">
    <a href="{{ route('siswa.dashboard') }}" class="app-brand">Brainova</a>
</header>
<div class="siswa-layout">
    @include('siswa.partials.sidebar')

    <main class="siswa-main">
        @if(session('success'))
            <div class="alert-success" style="margin-bottom:20px;">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert-error" style="margin-bottom:20px;">{{ session('error') }}</div>
        @endif

        <h1 class="dash-header-title" style="margin-bottom:24px;">Cari Tutor</h1>

        <div class="cari-tutor-layout" style="padding:0;background:transparent;min-height:auto;gap:20px;">

            {{-- ── Filter Sidebar ── --}}
            <aside class="filter-sidebar" style="width:250px;">
                <form method="GET" action="{{ route('siswa.dashboard') }}" id="filterForm">
                    <div class="filter-card" style="position:relative;top:0;padding:20px;">
                        <div class="filter-header" style="margin-bottom:12px;">
                            <div class="filter-title" style="font-size:16px;">Filter</div>
                            <a href="{{ route('siswa.dashboard') }}" class="filter-reset">Reset</a>
                        </div>

                        {{-- Keyword --}}
                        <div class="search-box" style="margin-bottom:14px;">
                            <svg class="search-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                            </svg>
                            <input type="text" name="keyword" id="keywordInput"
                                   placeholder="Cari nama / mata pelajaran"
                                   value="{{ $keyword ?? '' }}"
                                   style="padding:10px 10px 10px 32px;font-size:13px;"
                                   autocomplete="off">
                        </div>

                        {{-- Mata Pelajaran --}}
                        <div class="filter-section" style="margin-bottom:14px;">
                            <div class="filter-label">Mata Pelajaran</div>
                            <div class="checkbox-group" style="gap:7px;max-height:140px;overflow-y:auto;padding-right:4px;">
                                @foreach($subjects as $subj)
                                <label class="checkbox-label" style="font-size:13px;">
                                    <input type="checkbox" name="subject[]" value="{{ $subj->id }}"
                                        {{ in_array($subj->id, $subjectIds ?? []) ? 'checked' : '' }}>
                                    {{ $subj->nama_mapel }}
                                </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- Range Harga --}}
                        <div class="filter-section" style="margin-bottom:16px;">
                            <div class="filter-label">Harga per Jam</div>
                            <div class="range-wrap">
                                <div class="range-track">
                                    <div class="range-fill" id="rangeFill"></div>
                                </div>
                                <input type="range" class="range-input" id="minRange"
                                       name="min_harga" min="0" max="500000" step="10000"
                                       value="{{ $minHarga ?? 0 }}">
                                <input type="range" class="range-input" id="maxRange"
                                       name="max_harga" min="0" max="500000" step="10000"
                                       value="{{ ($maxHarga ?? 0) > 0 ? $maxHarga : 500000 }}">
                            </div>
                            <div class="range-labels"><span>Rp 0</span><span>Rp 500k+</span></div>
                            <div class="range-val" id="rangeVal">
                                Rp <span id="minVal">{{ number_format($minHarga ?? 0, 0, ',', '.') }}</span>
                                —
                                Rp <span id="maxVal">{{ ($maxHarga ?? 0) > 0 && ($maxHarga ?? 0) < 500000 ? number_format($maxHarga, 0, ',', '.') : '500.000+' }}</span>
                            </div>
                        </div>

                        <input type="hidden" name="sort" id="sortHidden" value="{{ $sort ?? 'relevansi' }}">
                        <button type="submit" class="btn-terapkan" style="padding:10px;font-size:13px;">Terapkan Filter</button>
                    </div>
                </form>
            </aside>

            {{-- ── Tutor List ── --}}
            <div class="tutor-list-container">
                <div class="list-header" style="margin-bottom:14px;padding:12px 20px;">
                    <div class="list-count" style="font-size:17px;">
                        <strong>{{ count($tutors) }}</strong> tutor ditemukan
                    </div>
                    <div class="list-sort">
                        <select style="padding:6px 10px;font-size:13px;" onchange="doSort(this.value)">
                            <option value="relevansi"  {{ ($sort ?? '') === 'relevansi'  ? 'selected' : '' }}>Relevansi</option>
                            <option value="harga_asc"  {{ ($sort ?? '') === 'harga_asc'  ? 'selected' : '' }}>Harga Terendah</option>
                            <option value="harga_desc" {{ ($sort ?? '') === 'harga_desc' ? 'selected' : '' }}>Harga Tertinggi</option>
                            <option value="rating"     {{ ($sort ?? '') === 'rating'     ? 'selected' : '' }}>Rating Tertinggi</option>
                        </select>
                    </div>
                </div>

                {{-- Active filter tags --}}
                @php
                    $hasFilter = ($keyword ?? '') !== '' || ($minHarga ?? 0) > 0
                        || (($maxHarga ?? 0) > 0 && ($maxHarga ?? 0) < 500000)
                        || !empty($subjectIds ?? []);
                @endphp
                @if($hasFilter)
                <div class="active-filters" style="padding:0 4px;">
                    @if(($keyword ?? '') !== '')
                        <span class="filter-tag">
                            🔍 "{{ $keyword }}"
                            <a href="{{ route('siswa.dashboard', array_merge(request()->except('keyword'))) }}">✕</a>
                        </span>
                    @endif
                    @if(!empty($subjectIds ?? []))
                        <span class="filter-tag">
                            📚 {{ $subjects->whereIn('id', $subjectIds)->pluck('nama_mapel')->join(', ') }}
                            <a href="{{ route('siswa.dashboard', array_merge(request()->except('subject'))) }}">✕</a>
                        </span>
                    @endif
                    @if(($minHarga ?? 0) > 0 || (($maxHarga ?? 0) > 0 && ($maxHarga ?? 0) < 500000))
                        <span class="filter-tag">
                            💰 Rp {{ number_format($minHarga ?? 0, 0, ',', '.') }} — {{ ($maxHarga ?? 0) > 0 && ($maxHarga ?? 0) < 500000 ? 'Rp '.number_format($maxHarga, 0, ',', '.') : '500rb+' }}
                            <a href="{{ route('siswa.dashboard', array_merge(request()->except(['min_harga','max_harga']))) }}">✕</a>
                        </span>
                    @endif
                </div>
                @endif

                {{-- Tutor Cards --}}
                @if(count($tutors) > 0)
                    @foreach($tutors as $tutor)
                    @php
                        $avgRating   = $tutor->reviews->avg('rating') ?? 0;
                        $countReview = $tutor->reviews->count();
                    @endphp
                    <div class="tutor-list-card" style="padding:16px;margin-bottom:12px;cursor:pointer;"
                         onclick="window.location.href='{{ route('siswa.tutor-profil', $tutor->id) }}'">
                        <div class="tutor-info-wrap" style="gap:16px;">
                            <div class="tutor-avatar-wrap" style="width:56px;height:56px;">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($tutor->name) }}&background=random" alt="Avatar">
                                <div class="tutor-verified" style="width:16px;height:16px;">
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                </div>
                            </div>
                            <div class="tutor-details">
                                <h3 style="font-size:16px;margin-bottom:4px;">{{ $tutor->name }}</h3>
                                <div class="tutor-rating" style="margin-bottom:8px;">
                                    <span class="star">★</span>
                                    {{ $avgRating > 0 ? number_format($avgRating, 1) : '—' }}
                                    ({{ $countReview }} ulasan)
                                </div>
                                <div class="tutor-subjects" style="margin-bottom:8px;">
                                    <span class="tutor-subject-pill">{{ $tutor->subject?->nama_mapel ?? 'Umum' }}</span>
                                </div>
                                <p class="tutor-bio-snippet" style="font-size:12px;margin:0;">
                                    {{ \Illuminate\Support\Str::limit($tutor->bio ?: 'Tutor berpengalaman di bidang ' . ($tutor->subject?->nama_mapel ?? 'umum') . '.', 90) }}
                                </p>
                            </div>
                        </div>
                        <div class="tutor-action-wrap">
                            <div class="tutor-price-label">Privat</div>
                            <div class="tutor-price" style="font-size:18px;">
                                Rp {{ number_format($tutor->tarif, 0, ',', '.') }}<span style="font-size:12px;">/jam</span>
                            </div>
                            <a href="{{ route('siswa.tutor-profil', $tutor->id) }}"
                               class="btn-lihat-profil"
                               style="padding:6px 12px;font-size:12px;"
                               onclick="event.stopPropagation()">Lihat Profil</a>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="empty-tutor">
                        <div class="icon">🔍</div>
                        <h3>Tutor tidak ditemukan</h3>
                        <p>Coba ubah kata kunci atau reset filter.</p>
                        <a href="{{ route('siswa.dashboard') }}"
                           class="btn btn-primary"
                           style="margin-top:14px;display:inline-flex;font-size:13px;padding:8px 16px;">
                            Reset Filter
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </main>
</div>

<script>
// ── Range Slider ──────────────────────────────────────────
const minRange  = document.getElementById('minRange');
const maxRange  = document.getElementById('maxRange');
const rangeFill = document.getElementById('rangeFill');
const minValEl  = document.getElementById('minVal');
const maxValEl  = document.getElementById('maxVal');

function formatRp(v) {
    return v >= 500000 ? '500.000+' : v.toLocaleString('id-ID');
}

function updateSlider() {
    const min   = parseInt(minRange.value);
    const max   = parseInt(maxRange.value);
    if (min > max - 10000) minRange.value = max - 10000;
    const pMin  = (parseInt(minRange.value) / 500000) * 100;
    const pMax  = (parseInt(maxRange.value) / 500000) * 100;
    rangeFill.style.left  = pMin + '%';
    rangeFill.style.width = (pMax - pMin) + '%';
    minValEl.textContent  = formatRp(parseInt(minRange.value));
    maxValEl.textContent  = formatRp(parseInt(maxRange.value));
}
minRange.addEventListener('input', updateSlider);
maxRange.addEventListener('input', updateSlider);
updateSlider();

// ── Sort → submit ─────────────────────────────────────────
function doSort(val) {
    document.getElementById('sortHidden').value = val;
    document.getElementById('filterForm').submit();
}

// ── Keyword: debounce 500ms ───────────────────────────────
let dTimer;
document.getElementById('keywordInput').addEventListener('input', function () {
    clearTimeout(dTimer);
    dTimer = setTimeout(() => document.getElementById('filterForm').submit(), 500);
});

// ── Checkbox: submit langsung ─────────────────────────────
document.querySelectorAll('input[name="subject[]"]').forEach(cb => {
    cb.addEventListener('change', () => document.getElementById('filterForm').submit());
});
</script>
</body>
</html>
