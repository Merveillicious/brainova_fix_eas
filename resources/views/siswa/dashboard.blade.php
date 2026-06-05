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
        <!-- Sidebar -->
        <aside class="siswa-sidebar">
            <div class="sidebar-profile">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($student->name) }}&background=000&color=fff" class="sidebar-avatar" alt="Avatar">
                <div class="sidebar-name">{{ explode(' ', trim($student->name))[0] }}</div>
                <div class="sidebar-role">Siswa</div>
            </div>
            <nav class="sidebar-nav">
                <a href="{{ route('siswa.dashboard') }}" class="sidebar-link active">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    Beranda
                </a>
                <a href="#" class="sidebar-link">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    Jadwal Kelas
                </a>
                <a href="#" class="sidebar-link">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
                    Pembayaran
                </a>
                <a href="#" class="sidebar-link">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    Ulasan Saya
                </a>
                <a href="#" class="sidebar-link">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                    Pesan
                </a>
                <a href="#" class="sidebar-link">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                    Pengaturan
                </a>
            </nav>
            
            <form method="POST" action="{{ route('logout') }}" style="margin-top: auto; padding: 24px;">
                @csrf
                <button type="submit" class="btn-outline" style="width: 100%; border-color: transparent; color: #ef4444; font-weight: 600;">Log out</button>
            </form>
        </aside>

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
