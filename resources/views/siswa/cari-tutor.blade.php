<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cari Tutor - Brainova</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <style>
        body { margin: 0; font-family: 'Inter', sans-serif; }

        /* ── Range Slider ── */
        .range-wrap { position: relative; margin-top: 10px; }
        .range-track { position: relative; height: 4px; background: #e5e7eb; border-radius: 2px; margin: 18px 0 8px; }
        .range-fill  { position: absolute; height: 4px; background: #f5a623; border-radius: 2px; pointer-events: none; }
        .range-input { position: absolute; width: 100%; top: -7px; left: 0; appearance: none; -webkit-appearance: none;
                       background: transparent; pointer-events: none; }
        .range-input::-webkit-slider-thumb { appearance: none; -webkit-appearance: none; width: 18px; height: 18px;
            border-radius: 50%; background: #fff; border: 2px solid #000; cursor: pointer; pointer-events: all; position: relative; }
        .range-input::-moz-range-thumb { width: 18px; height: 18px; border-radius: 50%; background: #fff;
            border: 2px solid #000; cursor: pointer; pointer-events: all; }
        .range-labels { display: flex; justify-content: space-between; font-size: 11px; font-weight: 600; color: #555; margin-top: 4px; }
        .range-val { font-size: 12px; font-weight: 700; color: #000; text-align: center; margin-top: 8px; }

        /* ── Empty state ── */
        .empty-tutor { text-align: center; padding: 60px 20px; border: 2px dashed #e5e7eb; border-radius: 14px; }
        .empty-tutor .icon { font-size: 40px; margin-bottom: 12px; }
        .empty-tutor h3 { font-size: 16px; font-weight: 700; color: #374151; margin-bottom: 6px; }
        .empty-tutor p  { font-size: 13px; color: #9ca3af; }

        /* ── Tag active filter ── */
        .active-filters { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 16px; }
        .filter-tag { display: inline-flex; align-items: center; gap: 6px; background: #fff8e6; border: 2px solid #FBBF24;
                      border-radius: 20px; padding: 4px 12px; font-size: 12px; font-weight: 600; color: #92400e; }
        .filter-tag a { color: #92400e; text-decoration: none; font-weight: 700; }

        /* ── Rating stars ── */
        .tutor-avg-rating { display: flex; align-items: center; gap: 4px; font-size: 13px; color: #555; margin-bottom: 10px; }
        .tutor-avg-rating .star { color: #f5a623; }
    </style>
</head>
<body>
<header class="app-topbar">
    <a href="{{ route('siswa.dashboard') }}" class="app-brand">Brainova</a>
</header>

<div class="cari-tutor-layout">

    {{-- ── Filter Sidebar ── --}}
    <aside class="filter-sidebar">
        <form method="GET" action="{{ route('siswa.cari-tutor') }}" id="filterForm">
            <div class="filter-card">
                <div class="filter-header">
                    <div class="filter-title">Filter</div>
                    <a href="{{ route('siswa.cari-tutor') }}" class="filter-reset">Reset</a>
                </div>

                {{-- Search keyword --}}
                <div class="search-box">
                    <svg class="search-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <input type="text" name="keyword" id="keywordInput"
                           placeholder="Cari nama tutor / mata pelajaran"
                           value="{{ $keyword ?? '' }}"
                           autocomplete="off">
                </div>

                {{-- Mata Pelajaran --}}
                <div class="filter-section">
                    <div class="filter-label">Mata Pelajaran</div>
                    <div class="checkbox-group" style="max-height: 160px; overflow-y: auto; padding-right: 4px;">
                        @foreach($subjects as $subj)
                        <label class="checkbox-label">
                            <input type="checkbox" name="subject[]" value="{{ $subj->id }}"
                                {{ in_array($subj->id, $subjectIds ?? []) ? 'checked' : '' }}>
                            {{ $subj->nama_mapel }}
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Range Harga --}}
                <div class="filter-section">
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
                    <div class="range-labels">
                        <span>Rp 0</span><span>Rp 500k+</span>
                    </div>
                    <div class="range-val" id="rangeVal">
                        Rp <span id="minVal">{{ number_format($minHarga ?? 0, 0, ',', '.') }}</span>
                        —
                        Rp <span id="maxVal">{{ ($maxHarga ?? 0) > 0 ? number_format($maxHarga, 0, ',', '.') : '500.000+' }}</span>
                    </div>
                </div>

                {{-- Urutkan (hidden, dihandle di list header juga) --}}
                <input type="hidden" name="sort" id="sortHidden" value="{{ $sort ?? 'relevansi' }}">

                <button type="submit" class="btn-terapkan">Terapkan Filter</button>
            </div>
        </form>
    </aside>

    {{-- ── Tutor List ── --}}
    <main class="tutor-list-container">

        {{-- Header --}}
        <div class="list-header">
            <div class="list-count">
                <strong>{{ count($tutors) }}</strong> tutor ditemukan
            </div>
            <div class="list-sort">
                Urutkan:
                <select id="sortSelect" onchange="doSort(this.value)">
                    <option value="relevansi"  {{ ($sort ?? '') === 'relevansi'  ? 'selected' : '' }}>Relevansi</option>
                    <option value="harga_asc"  {{ ($sort ?? '') === 'harga_asc'  ? 'selected' : '' }}>Harga Terendah</option>
                    <option value="harga_desc" {{ ($sort ?? '') === 'harga_desc' ? 'selected' : '' }}>Harga Tertinggi</option>
                    <option value="rating"     {{ ($sort ?? '') === 'rating'     ? 'selected' : '' }}>Rating Tertinggi</option>
                </select>
            </div>
        </div>

        {{-- Active filter tags --}}
        @php
            $hasFilter = ($keyword ?? '') !== '' || ($minHarga ?? 0) > 0 || (($maxHarga ?? 0) > 0 && ($maxHarga ?? 0) < 500000);
        @endphp
        @if($hasFilter)
        <div class="active-filters">
            @if(($keyword ?? '') !== '')
                <span class="filter-tag">
                    🔍 "{{ $keyword }}"
                    <a href="{{ route('siswa.cari-tutor', request()->except('keyword')) }}">✕</a>
                </span>
            @endif
            @if(($minHarga ?? 0) > 0 || (($maxHarga ?? 0) > 0 && ($maxHarga ?? 0) < 500000))
                <span class="filter-tag">
                    💰 Rp {{ number_format($minHarga ?? 0, 0, ',', '.') }} — Rp {{ ($maxHarga ?? 0) > 0 ? number_format($maxHarga, 0, ',', '.') : '500.000+' }}
                    <a href="{{ route('siswa.cari-tutor', request()->except(['min_harga','max_harga'])) }}">✕</a>
                </span>
            @endif
        </div>
        @endif

        {{-- Tutor cards --}}
        @if(count($tutors) > 0)
            @foreach($tutors as $tutor)
            @php
                $avgRating = $tutor->reviews->avg('rating') ?? 0;
                $countReview = $tutor->reviews->count();
            @endphp
            <div class="tutor-list-card" style="cursor:pointer;"
                 onclick="window.location.href='{{ route('siswa.tutor-profil', $tutor->id) }}'">
                <div class="tutor-info-wrap">
                    <div class="tutor-avatar-wrap">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($tutor->name) }}&background=random" alt="Avatar">
                        <div class="tutor-verified">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                        </div>
                    </div>
                    <div class="tutor-details">
                        <h3>{{ $tutor->name }}</h3>
                        <div class="tutor-avg-rating">
                            <span class="star">★</span>
                            {{ $avgRating > 0 ? number_format($avgRating, 1) : '—' }}
                            ({{ $countReview }} ulasan)
                        </div>
                        <div class="tutor-subjects">
                            <span class="tutor-subject-pill">{{ $tutor->subject?->nama_mapel ?? 'Umum' }}</span>
                        </div>
                        <p class="tutor-bio-snippet">
                            {{ \Illuminate\Support\Str::limit($tutor->bio ?: 'Tutor berpengalaman di bidang ' . ($tutor->subject?->nama_mapel ?? 'umum') . '.', 120) }}
                        </p>
                    </div>
                </div>
                <div class="tutor-action-wrap">
                    <div class="tutor-price-label">Privat</div>
                    <div class="tutor-price">Rp {{ number_format($tutor->tarif, 0, ',', '.') }}<span>/jam</span></div>
                    <a href="{{ route('siswa.tutor-profil', $tutor->id) }}" class="btn-lihat-profil"
                       onclick="event.stopPropagation()">Lihat Profil</a>
                </div>
            </div>
            @endforeach
        @else
            <div class="empty-tutor">
                <div class="icon">🔍</div>
                <h3>Tutor tidak ditemukan</h3>
                <p>Coba ubah kata kunci atau reset filter untuk melihat semua tutor.</p>
                <a href="{{ route('siswa.cari-tutor') }}" class="btn btn-primary" style="margin-top:16px;display:inline-flex;">
                    Reset Filter
                </a>
            </div>
        @endif

    </main>
</div>

<script>
// ── Range Slider Logic ──────────────────────────────────────
const minRange  = document.getElementById('minRange');
const maxRange  = document.getElementById('maxRange');
const rangeFill = document.getElementById('rangeFill');
const minVal    = document.getElementById('minVal');
const maxVal    = document.getElementById('maxVal');

function formatRp(val) {
    return val >= 500000 ? '500.000+' : val.toLocaleString('id-ID');
}

function updateSlider() {
    const min = parseInt(minRange.value);
    const max = parseInt(maxRange.value);
    const total = 500000;

    // Prevent crossover
    if (min > max - 10000) {
        minRange.value = max - 10000;
    }

    const leftPct  = (parseInt(minRange.value) / total) * 100;
    const rightPct = (parseInt(maxRange.value) / total) * 100;

    rangeFill.style.left  = leftPct + '%';
    rangeFill.style.width = (rightPct - leftPct) + '%';

    minVal.textContent = formatRp(parseInt(minRange.value));
    maxVal.textContent = formatRp(parseInt(maxRange.value));
}

minRange.addEventListener('input', updateSlider);
maxRange.addEventListener('input', updateSlider);
updateSlider(); // init

// ── Sort: ubah hidden input lalu submit ────────────────────
function doSort(val) {
    document.getElementById('sortHidden').value = val;
    document.getElementById('filterForm').submit();
}

// ── Keyword: debounce 400ms lalu submit ───────────────────
let debounceTimer;
document.getElementById('keywordInput').addEventListener('input', function() {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => {
        document.getElementById('filterForm').submit();
    }, 400);
});

// ── Checkbox: submit langsung ─────────────────────────────
document.querySelectorAll('input[name="subject[]"]').forEach(cb => {
    cb.addEventListener('change', () => {
        document.getElementById('filterForm').submit();
    });
});
</script>
</body>
</html>
