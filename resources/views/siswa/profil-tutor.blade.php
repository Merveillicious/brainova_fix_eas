<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Tutor - Brainova</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <style>
        body { margin: 0; font-family: 'Inter', sans-serif; background: #fafafa; }
    </style>
</head>
<body>
<header class="app-topbar">
    <a href="{{ route('siswa.dashboard') }}" class="app-brand">
        Brainova
    </a>
</header>
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
                <div class="profil-subject-pill">{{ $tutor->subject?->nama_mapel ?? 'Umum' }}</div>
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
                        <span id="calendar-month-year">Bulan ini</span>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="cursor:pointer;"><path d="m9 18 6-6-6-6"/></svg>
                    </div>
                    
                    <div class="calendar-days" id="calendar-days-container">
                        <!-- Dates will be generated by JS -->
                    </div>
                    <div class="timezone-text">Zona waktu kamu, Asia/Jakarta (GMT +7:00)</div>

                    <div style="font-size:12px; font-weight:700; color:#000; margin-bottom:8px; margin-top:20px;">Pukul</div>
                    <div class="time-slots" id="time-slots-container">
                        <!-- Times will be generated by JS -->
                    </div>
                </div>

                <div class="booking-subject">{{ $tutor->subject?->nama_mapel ?? 'Matematika' }}</div>

                <div class="popularity-badge">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" stroke="none"><path d="M12 2c0 0-3 5-3 9a3 3 0 0 0 6 0c0-4-3-9-3-9z"/><path d="M14 16c0 1.1-.9 2-2 2s-2-.9-2-2"/></svg>
                    Sangat populer. Dipilih 17 kali baru-baru ini
                </div>

                <form method="POST" action="{{ route('siswa.checkout') }}" onsubmit="return validateBooking()">
                    @csrf
                    <input type="hidden" name="schedule_id" id="selected_schedule_id" value="">
                    <input type="hidden" name="metode_pembayaran" value="transfer">
                    <button type="submit" class="btn-pesan-kelas">Pesan Kelas</button>
                </form>
                <button type="button" class="btn-chat">Chat Tutor</button>
            </div>
        </aside>
    </div>

    <script>
        const schedules = @json($schedules);
        const daysContainer = document.getElementById('calendar-days-container');
        const timesContainer = document.getElementById('time-slots-container');
        const scheduleInput = document.getElementById('selected_schedule_id');
        const monthYearLabel = document.getElementById('calendar-month-year');
        
        // Group schedules by date
        const groupedSchedules = {};
        schedules.forEach(s => {
            if(!groupedSchedules[s.tanggal]) groupedSchedules[s.tanggal] = [];
            groupedSchedules[s.tanggal].push(s);
        });

        const dates = Object.keys(groupedSchedules).sort();
        
        if(dates.length === 0) {
            daysContainer.innerHTML = '<div style="font-size:12px; color:#666; padding:10px;">Belum ada jadwal tersedia</div>';
            timesContainer.innerHTML = '';
        } else {
            const firstDateObj = new Date(dates[0]);
            const months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
            monthYearLabel.innerText = months[firstDateObj.getMonth()] + ' ' + firstDateObj.getFullYear();

            let selectedDate = dates[0];
            
            function renderDates() {
                daysContainer.innerHTML = '';
                const daysNames = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
                dates.forEach(d => {
                    const dateObj = new Date(d);
                    const dayName = daysNames[dateObj.getDay()];
                    const dayDate = dateObj.getDate();
                    
                    const dayEl = document.createElement('div');
                    dayEl.className = 'cal-day' + (selectedDate === d ? ' active' : '');
                    dayEl.onclick = () => {
                        selectedDate = d;
                        renderDates();
                        renderTimes();
                    };
                    
                    dayEl.innerHTML = `<div class="cal-day-name">${dayName}</div><div class="cal-day-date">${dayDate}</div>`;
                    daysContainer.appendChild(dayEl);
                });
            }
            
            function renderTimes() {
                timesContainer.innerHTML = '';
                const times = groupedSchedules[selectedDate];
                let firstSelected = false;
                
                // Sort times by start hour
                times.sort((a,b) => a.jam_mulai.localeCompare(b.jam_mulai));
                
                times.forEach(t => {
                    const timeEl = document.createElement('div');
                    const timeStr = t.jam_mulai.substring(0, 5);
                    
                    if(!firstSelected) {
                        timeEl.className = 'time-slot selected';
                        scheduleInput.value = t.id;
                        firstSelected = true;
                    } else {
                        timeEl.className = 'time-slot';
                    }
                    
                    timeEl.onclick = () => {
                        document.querySelectorAll('.time-slot').forEach(el => el.classList.remove('selected'));
                        timeEl.classList.add('selected');
                        scheduleInput.value = t.id;
                    };
                    
                    timeEl.innerText = timeStr;
                    timesContainer.appendChild(timeEl);
                });
            }
            
            renderDates();
            renderTimes();
        }

        function validateBooking() {
            if(!scheduleInput.value) {
                alert('Jadwal tidak tersedia atau belum dipilih!');
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
