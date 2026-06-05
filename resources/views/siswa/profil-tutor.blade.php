<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Tutor - Brainova</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/brainova.css') }}">
    <style>
        body { margin: 0; font-family: 'Inter', sans-serif; background: #fafafa; }
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

    <div class="profil-layout">
        <div class="profil-main">
            <!-- Header Card -->
            <div class="profil-header-card">
                <div class="profil-top-info">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($tutor->name) }}&background=random" alt="Avatar">
                    <h1>{{ $tutor->name }} <div style="display:inline-flex; align-items:center; justify-content:center; width:24px; height:24px; background:#f5a623; color:#fff; border-radius:50%; border:2px solid #fff; font-size:12px; margin-left:8px;"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></div></h1>
                </div>
                <div class="profil-stats">
                    <span><span style="color:#f5a623">★</span> 4.9</span>
                    <div class="divider"></div>
                    <span>124 ulasan</span>
                    <div class="divider"></div>
                    <span>340 sesi</span>
                </div>
                <div class="profil-subject-pill">{{ $tutor->subject->nama_mapel ?? 'Umum' }}</div>
            </div>

            <!-- Tentang Saya -->
            <div class="profil-section-card">
                <div class="profil-section-title">Tentang Saya</div>
                <div class="profil-about-text">
                    {{ $tutor->bio ?: 'Halo! Saya tutor yang bersemangat mengajar dan membantu siswa memahami konsep-konsep dengan cara yang lebih mudah dan menyenangkan. Pendekatan mengajar saya fokus pada pemahaman konsep dasar (first principles) daripada sekadar menghafal rumus.' }}
                </div>
            </div>

            <!-- Video Perkenalan -->
            <div class="profil-section-card">
                <div class="profil-section-title">Video Perkenalan</div>
                <div class="video-container">
                    <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?q=80&w=2070&auto=format&fit=crop" alt="Video Thumbnail" style="opacity:0.8">
                    <div class="play-button">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" stroke="none"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                    </div>
                </div>
            </div>

            <!-- Ulasan Siswa -->
            <div class="profil-section-card">
                <div class="profil-section-title">Ulasan Siswa <span style="color:#f5a623">★</span> <span style="color:#f5a623; font-weight:800;">4.9</span></div>
                
                <div class="review-card">
                    <div class="review-header">
                        <div class="review-user">
                            <div class="review-avatar" style="background:#f3e8dd">A</div>
                            <div>
                                <div class="review-name">Andi R.</div>
                                <div class="review-date">2 hari yang lalu</div>
                            </div>
                        </div>
                        <div class="review-stars">★★★★★</div>
                    </div>
                    <div class="review-text">Kak {{ explode(' ', trim($tutor->name))[0] }} ngajarnya sabar banget! Pelajaran yang awalnya susah jadi kelihatan polanya. Recommended buat persiapan UTBK.</div>
                </div>

                <div class="review-card">
                    <div class="review-header">
                        <div class="review-user">
                            <div class="review-avatar" style="background:#e5e7eb">S</div>
                            <div>
                                <div class="review-name">Siti M.</div>
                                <div class="review-date">1 minggu yang lalu</div>
                            </div>
                        </div>
                        <div class="review-stars">★★★★☆</div>
                    </div>
                    <div class="review-text">Penjelasannya runut, nggak cuma kasih rumus tapi diajarin cara berpikirnya. Top!</div>
                </div>
            </div>
        </div>

        <!-- Sidebar / Booking Area -->
        <aside class="profil-sidebar">
            <div class="booking-card">
                <div class="booking-header">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($tutor->name) }}&background=random" alt="Avatar">
                    Pesan kelas dengan {{ explode(' ', trim($tutor->name))[0] }}.
                </div>

                <div class="pricing-box">
                    <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                        <div class="pricing-badge">Privat</div>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#d97706" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="4"/></svg>
                    </div>
                    <div class="pricing-price">Rp {{ number_format($tutor->tarif, 0, ',', '.') }} <span style="font-size:14px; color:#555; font-weight:600;">/ sesi</span></div>
                    <div class="pricing-desc">1-on-1 langsung dengan tutor</div>
                </div>

                <div class="calendar-widget">
                    <div class="calendar-nav">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="cursor:pointer;"><path d="m15 18-6-6 6-6"/></svg>
                        <span>7 - 13 Mei 2026</span>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="cursor:pointer;"><path d="m9 18 6-6-6-6"/></svg>
                    </div>
                    
                    <div class="calendar-days">
                        <div class="cal-day">
                            <div class="cal-day-name">Sen</div>
                            <div class="cal-day-date">7</div>
                        </div>
                        <div class="cal-day">
                            <div class="cal-day-name">Selasa</div>
                            <div class="cal-day-date">8</div>
                        </div>
                        <div class="cal-day">
                            <div class="cal-day-name">Rabu</div>
                            <div class="cal-day-date">9</div>
                        </div>
                        <div class="cal-day active">
                            <div class="cal-day-name">Kamis</div>
                            <div class="cal-day-date">11</div>
                        </div>
                        <div class="cal-day">
                            <div class="cal-day-name">Jumat</div>
                            <div class="cal-day-date">12</div>
                        </div>
                    </div>
                    <div class="timezone-text">Zona waktu kamu, Asia/Jakarta (GMT +7:00)</div>

                    <div style="font-size:12px; font-weight:700; color:#000; margin-bottom:8px; margin-top:20px;">Pukul</div>
                    <div class="time-slots">
                        <div class="time-slot">07:00</div>
                        <div class="time-slot">08:00</div>
                        <div class="time-slot">09:00</div>
                        <div class="time-slot">10:00</div>
                        <div class="time-slot">11:00</div>
                        <div class="time-slot">12:00</div>
                        <div class="time-slot">13:00</div>
                        <div class="time-slot selected">14:00</div>
                        <div class="time-slot">15:00</div>
                        <div class="time-slot">16:00</div>
                        <div class="time-slot">17:00</div>
                    </div>
                </div>

                <div class="booking-subject">{{ $tutor->subject->nama_mapel ?? 'Matematika' }}</div>

                <div class="popularity-badge">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" stroke="none"><path d="M12 2c0 0-3 5-3 9a3 3 0 0 0 6 0c0-4-3-9-3-9z"/><path d="M14 16c0 1.1-.9 2-2 2s-2-.9-2-2"/></svg>
                    Sangat populer. Dipilih 17 kali baru-baru ini
                </div>

                <!-- Replace with actual booking form for full implementation, dummy for UI match -->
                <form method="POST" action="{{ route('siswa.booking') }}">
                    @csrf
                    <!-- Dummy payload -->
                    <input type="hidden" name="schedule_id" value="{{ $schedules->first()->id ?? 1 }}">
                    <input type="hidden" name="metode_pembayaran" value="transfer">
                    <button type="submit" class="btn-pesan-kelas">Pesan Kelas</button>
                </form>
                <button type="button" class="btn-chat">Chat Tutor</button>
            </div>
        </aside>
    </div>
</body>
</html>
