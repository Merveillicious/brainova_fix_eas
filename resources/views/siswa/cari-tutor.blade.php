<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cari Tutor - Brainova</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/brainova.css') }}">
    <style>
        body { margin: 0; font-family: 'Inter', sans-serif; }
    </style>
</head>
<body>
    <div class="app-topbar">
        <a href="{{ route('siswa.dashboard') }}" class="app-brand">
            Brainova 
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M9.5 2A2.5 2.5 0 0 1 12 4.5v15a2.5 2.5 0 0 1-4.96.44 2.5 2.5 0 0 1-2.96-3.08 3 3 0 0 1-.34-5.58 2.5 2.5 0 0 1 1.32-4.24 2.5 2.5 0 0 1 1.98-3A2.5 2.5 0 0 1 9.5 2Z"/>
              <path d="M14.5 2A2.5 2.5 0 0 0 12 4.5v15a2.5 2.5 0 0 0 4.96.44 2.5 2.5 0 0 0 2.96-3.08 3 3 0 0 0 .34-5.58 2.5 2.5 0 0 0-1.32-4.24 2.5 2.5 0 0 0-1.98-3A2.5 2.5 0 0 0 14.5 2Z"/>
            </svg>
        </a>
    </div>

    <div class="cari-tutor-layout">
        <!-- Sidebar Filter -->
        <aside class="filter-sidebar">
            <div class="filter-card">
                <div class="filter-header">
                    <div class="filter-title">Filter</div>
                    <a href="#" class="filter-reset">Reset</a>
                </div>

                <div class="search-box">
                    <svg class="search-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <input type="text" placeholder="Cari mata pelajaran">
                </div>

                <div class="filter-section">
                    <div class="filter-label">Tingkat Pendidikan</div>
                    <div class="checkbox-group">
                        <label class="checkbox-label"><input type="checkbox"> SD</label>
                        <label class="checkbox-label"><input type="checkbox"> SMP</label>
                        <label class="checkbox-label"><input type="checkbox" checked> SMA</label>
                    </div>
                </div>

                <div class="filter-section">
                    <div class="filter-label">Harga</div>
                    <div style="font-size: 11px; font-weight: 600; color: #555; display: flex; justify-content: space-between; margin-bottom: 8px;">
                        <span>Rp 0</span><span>Rp 500k+</span>
                    </div>
                    <div style="width: 100%; height: 2px; background: #e5e7eb; position: relative;">
                        <div style="position: absolute; left: 15%; right: 30%; height: 2px; background: #f5a623;"></div>
                    </div>
                </div>

                <div class="filter-section">
                    <div class="filter-label">Special Event & Offers</div>
                    <button type="button" class="btn-dynamic-pricing">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                        Dynamic Pricing
                    </button>
                </div>

                <button class="btn-terapkan">Terapkan Filter</button>
            </div>
        </aside>

        <!-- Tutor List -->
        <main class="tutor-list-container">
            <div class="list-header">
                <div class="list-count">{{ isset($tutors) && count($tutors) > 0 ? count($tutors) . '+' : '1.200+' }} tutor ditemukan</div>
                <div class="list-sort">
                    Urutkan: 
                    <select>
                        <option>Relevansi</option>
                        <option>Harga terendah</option>
                        <option>Rating tertinggi</option>
                    </select>
                </div>
            </div>

            @if(isset($tutors) && count($tutors) > 0)
                @foreach($tutors as $tutor)
                <div class="tutor-list-card">
                    <div class="tutor-info-wrap">
                        <div class="tutor-avatar-wrap">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($tutor->name) }}&background=random" alt="Avatar">
                            <div class="tutor-verified"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></div>
                        </div>
                        <div class="tutor-details">
                            <h3>
                                {{ $tutor->name }}
                            </h3>
                            <div class="tutor-rating">
                                <span class="star">★</span> 4.9 (124 ulasan)
                            </div>
                            <div class="tutor-subjects">
                                <span class="tutor-subject-pill">{{ $tutor->subject->nama_mapel ?? 'Umum' }}</span>
                            </div>
                            <p class="tutor-bio-snippet">{{ \Illuminate\Support\Str::limit($tutor->bio ?: 'Tutor berpengalaman yang membantu siswa memahami materi dengan cara interaktif.', 100) }}</p>
                        </div>
                    </div>
                    <div class="tutor-action-wrap">
                        <div class="tutor-price-label">Privat</div>
                        <div class="tutor-price">Rp {{ number_format($tutor->tarif, 0, ',', '.') }}<span>/jam</span></div>
                        <a href="{{ route('siswa.tutor-profil', $tutor->id) }}" class="btn-lihat-profil">Lihat Profil</a>
                    </div>
                </div>
                @endforeach
            @endif

            <!-- Static UI representation matching the mockup if needed to fill space -->
            <div class="tutor-list-card">
                <div class="tutor-info-wrap">
                    <div class="tutor-avatar-wrap">
                        <img src="https://ui-avatars.com/api/?name=Amanda+Putri&background=random" alt="Avatar">
                        <div class="tutor-verified"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></div>
                    </div>
                    <div class="tutor-details">
                        <h3>Amanda Putri</h3>
                        <div class="tutor-rating">
                            <span class="star">★</span> 4.9 (76 ulasan)
                        </div>
                        <div class="tutor-subjects">
                            <span class="tutor-subject-pill">Matematika</span>
                            <span class="tutor-subject-pill">Fisika</span>
                        </div>
                        <p class="tutor-bio-snippet">Berpengalaman mengajar olimpiade dan persiapan masuk PTN favorit.</p>
                    </div>
                </div>
                <div class="tutor-action-wrap">
                    <div class="tutor-price-label">Privat</div>
                    <div class="tutor-price">Rp 79.000<span>/jam</span></div>
                    <a href="#" class="btn-lihat-profil">Lihat Profil</a>
                </div>
            </div>

            <div class="tutor-list-card">
                <div class="tutor-info-wrap">
                    <div class="tutor-avatar-wrap">
                        <img src="https://ui-avatars.com/api/?name=David+Lim&background=random" alt="Avatar">
                        <div class="tutor-verified"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></div>
                    </div>
                    <div class="tutor-details">
                        <h3>David Lim</h3>
                        <div class="tutor-rating">
                            <span class="star">★</span> 4.7 (42 ulasan)
                        </div>
                        <div class="tutor-subjects">
                            <span class="tutor-subject-pill">Bahasa Inggris</span>
                        </div>
                        <p class="tutor-bio-snippet">Spesialis percakapan aktif dan persiapan tes TOEFL/IELTS dengan hasil terjamin.</p>
                    </div>
                </div>
                <div class="tutor-action-wrap">
                    <div class="tutor-price-label">Privat</div>
                    <div class="tutor-price">Rp 100.000<span>/jam</span></div>
                    <a href="#" class="btn-lihat-profil">Lihat Profil</a>
                </div>
            </div>
            
        </main>
    </div>
</body>
</html>
