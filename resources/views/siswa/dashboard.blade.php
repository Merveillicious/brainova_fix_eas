<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda - Brainova</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/brainova.css') }}">
    <style>
        body { margin: 0; font-family: 'Inter', sans-serif; }
    </style>
</head>
<body>
    <div class="siswa-layout">
        @include('siswa.partials.sidebar')

        <!-- Main Content (Cari Tutor Only) -->
        <main class="siswa-main">
            @if(session('success'))
                <div class="alert-success" style="margin-bottom: 24px;">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert-error" style="margin-bottom: 24px;">{{ session('error') }}</div>
            @endif

            <h1 class="dash-header-title" style="margin-bottom: 32px;">Cari Tutor</h1>

            <div class="cari-tutor-layout" style="padding: 0; background: transparent; min-height: auto; gap: 24px;">
                <!-- Sidebar Filter -->
                <aside class="filter-sidebar" style="width: 250px;">
                    <div class="filter-card" style="position: relative; top: 0; padding: 20px;">
                        <div class="filter-header" style="margin-bottom: 12px;">
                            <div class="filter-title" style="font-size: 16px;">Filter</div>
                            <a href="#" class="filter-reset">Reset</a>
                        </div>

                        <div class="search-box" style="margin-bottom: 16px;">
                            <svg class="search-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                            <input type="text" placeholder="Cari mata pelajaran" style="padding: 10px 10px 10px 32px; font-size: 13px;">
                        </div>

                        <div class="filter-section" style="margin-bottom: 16px;">
                            <div class="filter-label">Tingkat Pendidikan</div>
                            <div class="checkbox-group" style="gap: 8px;">
                                <label class="checkbox-label" style="font-size: 13px;"><input type="checkbox"> SD</label>
                                <label class="checkbox-label" style="font-size: 13px;"><input type="checkbox"> SMP</label>
                                <label class="checkbox-label" style="font-size: 13px;"><input type="checkbox" checked> SMA</label>
                            </div>
                        </div>

                        <div class="filter-section" style="margin-bottom: 16px;">
                            <div class="filter-label">Harga</div>
                            <div style="font-size: 11px; font-weight: 600; color: #555; display: flex; justify-content: space-between; margin-bottom: 8px;">
                                <span>Rp 0</span><span>Rp 500k+</span>
                            </div>
                            <div style="width: 100%; height: 2px; background: #e5e7eb; position: relative;">
                                <div style="position: absolute; left: 15%; right: 30%; height: 2px; background: #f5a623;"></div>
                            </div>
                        </div>

                        <button class="btn-terapkan" style="padding: 10px; font-size: 13px;">Terapkan Filter</button>
                    </div>
                </aside>

                <!-- Tutor List -->
                <div class="tutor-list-container">
                    <div class="list-header" style="margin-bottom: 16px; padding: 12px 20px;">
                        <div class="list-count" style="font-size: 18px;">{{ isset($tutors) && count($tutors) > 0 ? count($tutors) . '+' : '1.200+' }} tutor</div>
                        <div class="list-sort">
                            <select style="padding: 6px 10px; font-size: 13px;">
                                <option>Relevansi</option>
                                <option>Harga terendah</option>
                                <option>Rating tertinggi</option>
                            </select>
                        </div>
                    </div>

                    @if(isset($tutors) && count($tutors) > 0)
                        @foreach($tutors as $tutor)
                        <div class="tutor-list-card" style="padding: 16px; margin-bottom: 12px;">
                            <div class="tutor-info-wrap" style="gap: 16px;">
                                <div class="tutor-avatar-wrap" style="width: 56px; height: 56px;">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($tutor->name) }}&background=random" alt="Avatar">
                                    <div class="tutor-verified" style="width: 16px; height: 16px;"><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></div>
                                </div>
                                <div class="tutor-details">
                                    <h3 style="font-size: 16px; margin-bottom: 4px;">{{ $tutor->name }}</h3>
                                    <div class="tutor-rating" style="margin-bottom: 8px;">
                                        <span class="star">★</span> 4.9 (124)
                                    </div>
                                    <div class="tutor-subjects" style="margin-bottom: 8px;">
                                        <span class="tutor-subject-pill">{{ $tutor->subject->nama_mapel ?? 'Umum' }}</span>
                                    </div>
                                    <p class="tutor-bio-snippet" style="font-size: 12px; margin: 0;">{{ \Illuminate\Support\Str::limit($tutor->bio ?: 'Tutor berpengalaman.', 80) }}</p>
                                </div>
                            </div>
                            <div class="tutor-action-wrap">
                                <div class="tutor-price-label">Privat</div>
                                <div class="tutor-price" style="font-size: 18px;">Rp {{ number_format($tutor->tarif, 0, ',', '.') }}<span style="font-size:12px">/jam</span></div>
                                <a href="{{ route('siswa.tutor-profil', $tutor->id) }}" class="btn-lihat-profil" style="padding: 6px 12px; font-size: 12px;">Lihat Profil</a>
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </main>
    </div>
</body>
</html>
