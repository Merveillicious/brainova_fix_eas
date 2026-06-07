<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brainova - Belajar Online dengan Tutor Terbaik</title>
    <meta name="description" content="Temukan tutor idealmu di Brainova. Platform belajar online yang menghubungkan siswa dengan tutor profesional untuk berbagai mata pelajaran.">
    @vite('resources/css/app.css')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="container nav-container">
            <a href="{{ route('home') }}" class="brand">
                <div class="brand-dot"></div>
                Brainova
            </a>
            <div class="nav-actions">
                <a href="{{ route('login') }}" class="btn btn-outline">Log in</a>
                <a href="{{ route('register') }}" class="btn btn-primary">Daftar Sekarang</a>
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <section class="hero">
        <div class="container hero-container">
            <div class="hero-content">
                <h1 class="hero-title">Belajar apapun, kapanpun dengan <span>Tutor Ahli.</span></h1>
                <p class="hero-desc">Tingkatkan potensimu dengan bimbingan personal dari tutor berpengalaman. Pilih jadwalmu sendiri dan mulai belajar hari ini.</p>
                <div class="nav-actions" style="margin-bottom:0">
                    <a href="{{ route('login') }}" class="btn btn-primary" style="padding:16px 32px;font-size:16px;">Mulai Belajar Sekarang</a>
                </div>
                <div class="hero-stats">
                    <div class="stat-item"><h4>500+</h4><p>Tutor Profesional</p></div>
                    <div class="stat-item"><h4>10k+</h4><p>Siswa Aktif</p></div>
                    <div class="stat-item"><h4>4.9/5</h4><p>Rating Rata-rata</p></div>
                </div>
            </div>
            <div class="hero-visual">
                <img src="{{ asset('hero_illustration.png') }}" alt="Ilustrasi Siswa Belajar Online"
                     onerror="this.src='https://placehold.co/500x400/FBBF24/000000?text=Brainova+Learning'">
            </div>
        </div>
    </section>
</body>
</html>
