<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan - Brainova</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <style>
        body { margin: 0; font-family: 'Inter', sans-serif; background: #fafafa; }

        /* ── Page ── */
        .pg-title { font-size: 30px; font-weight: 800; color: #000; letter-spacing: -.5px; margin-bottom: 4px; }
        .pg-sub   { font-size: 14px; color: #6b7280; margin-bottom: 32px; }

        /* ── Section ── */
        .pg-section {
            background: #fff;
            border: 2px solid #000;
            border-radius: 16px;
            padding: 28px 32px;
            margin-bottom: 24px;
        }
        .pg-section-divider {
            border: none;
            border-top: 2px solid #000;
            margin: 0 0 24px 0;
        }
        .pg-section-title {
            font-size: 18px;
            font-weight: 800;
            color: #000;
            margin-bottom: 20px;
            padding-bottom: 14px;
            border-bottom: 2px solid #000;
        }

        /* ── Avatar row ── */
        .pg-avatar-row {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 24px;
        }
        .pg-avatar-img {
            width: 72px; height: 72px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #e5e7eb;
        }
        .pg-avatar-info {}
        .btn-ubah-foto {
            padding: 8px 18px;
            background: #fff;
            border: 2px solid #000;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            color: #000;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            margin-bottom: 6px;
            transition: background .15s;
        }
        .btn-ubah-foto:hover { background: #f3f4f6; }
        .pg-foto-hint { font-size: 12px; color: #9ca3af; }

        /* ── Form Grid ── */
        .pg-form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 16px;
        }
        .pg-form-grid.full { grid-template-columns: 1fr; }
        .pg-form-group { display: flex; flex-direction: column; gap: 6px; }
        .pg-label {
            font-size: 12px;
            font-weight: 600;
            color: #374151;
        }
        .pg-input {
            width: 100%;
            padding: 12px 14px;
            border: 2px solid #000;
            border-radius: 10px;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            color: #111;
            background: #fff;
            outline: none;
            transition: border-color .2s;
            box-sizing: border-box;
        }
        .pg-input:focus { border-color: #FBBF24; }
        .pg-input[readonly] {
            background: #f9fafb;
            color: #9ca3af;
            cursor: not-allowed;
        }
        .pg-input::placeholder { color: #d1d5db; }

        /* ── Buttons ── */
        .btn-pg-primary {
            padding: 11px 24px;
            background: #FBBF24;
            border: 2px solid #000;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 700;
            color: #000;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            transition: background .15s, transform .1s;
        }
        .btn-pg-primary:hover { background: #f59e0b; transform: translateY(-1px); }
        .btn-pg-primary:active { transform: translateY(0); }

        .pg-bottom-bar {
            display: flex;
            justify-content: flex-end;
            padding-top: 16px;
            border-top: 2px solid #000;
            margin-top: 8px;
        }


        /* ── Alerts ── */
        .alert-success { background:#f0fdf4;border:2px solid #000;border-radius:8px;padding:12px 16px;font-size:14px;color:#166534;margin-bottom:20px; }
        .alert-error   { background:#fef2f2;border:2px solid #000;border-radius:8px;padding:12px 16px;font-size:14px;color:#b91c1c;margin-bottom:20px; }

        @media (max-width: 640px) {
            .pg-form-grid { grid-template-columns: 1fr; }
            .pg-section { padding: 20px; }
        }
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

    <main class="siswa-main" style="max-height: calc(100vh - 70px); overflow-y: auto;">
        <div>

            {{-- Alerts --}}
            @if(session('success'))
                <div class="alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert-error">{{ session('error') }}</div>
            @endif

            <h1 class="pg-title">Pengaturan Profil</h1>
            <p class="pg-sub">Kelola informasi pribadi, keamanan, dan preferensi akun Anda.</p>

            {{-- ══ Informasi Pribadi ══ --}}
            <div class="pg-section">
                <div class="pg-section-title">Informasi Pribadi</div>

                {{-- Avatar --}}
                <div class="pg-avatar-row">
                    <img class="pg-avatar-img"
                         src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=000&color=fff&size=128"
                         alt="Avatar" id="avatarPreview">
                    <div class="pg-avatar-info">
                        <button type="button" class="btn-ubah-foto" onclick="document.getElementById('fotoInput').click()">
                            Ubah Foto
                        </button>
                        <input type="file" id="fotoInput" accept="image/jpg,image/jpeg,image/png" style="display:none"
                               onchange="previewFoto(this)">
                        <div class="pg-foto-hint">Format JPG atau PNG. Maksimal 2MB.</div>
                    </div>
                </div>

                <form method="POST" action="{{ route('siswa.pengaturan.profil') }}">
                    @csrf
                    <div class="pg-form-grid">
                        <div class="pg-form-group">
                            <label class="pg-label" for="name">Nama Lengkap</label>
                            <input class="pg-input" type="text" id="name" name="name"
                                   value="{{ old('name', $user->name) }}" required>
                        </div>
                        <div class="pg-form-group">
                            <label class="pg-label">Email (Tidak dapat diubah)</label>
                            <input class="pg-input" type="email" value="{{ $user->email }}" readonly>
                        </div>
                    </div>
                    <div class="pg-form-grid full">
                        <div class="pg-form-group">
                            <label class="pg-label" for="phone">Nomor WhatsApp</label>
                            <input class="pg-input" type="text" id="phone" name="phone"
                                   placeholder="+62 812 3456 7890"
                                   value="{{ old('phone', $user->phone) }}">
                        </div>
                    </div>
                    <div class="pg-bottom-bar">
                        <button type="submit" class="btn-pg-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>

            {{-- ══ Keamanan Akun ══ --}}
            <div class="pg-section">
                <div class="pg-section-title">Keamanan Akun</div>

                @if(session('success_sandi'))
                    <div class="alert-success">{{ session('success_sandi') }}</div>
                @endif
                @if(session('error_sandi'))
                    <div class="alert-error">{{ session('error_sandi') }}</div>
                @endif

                <form method="POST" action="{{ route('siswa.pengaturan.sandi') }}">
                    @csrf
                    <div class="pg-form-grid full" style="margin-bottom: 16px;">
                        <div class="pg-form-group">
                            <label class="pg-label" for="sandi_lama">Kata Sandi Saat Ini</label>
                            <input class="pg-input" type="password" id="sandi_lama" name="sandi_lama"
                                   placeholder="••••••••" required>
                        </div>
                    </div>
                    <div class="pg-form-grid">
                        <div class="pg-form-group">
                            <label class="pg-label" for="sandi_baru">Kata Sandi Baru</label>
                            <input class="pg-input" type="password" id="sandi_baru" name="sandi_baru"
                                   placeholder="Minimal 8 karakter">
                        </div>
                        <div class="pg-form-group">
                            <label class="pg-label" for="konfirmasi_sandi">Konfirmasi Kata Sandi Baru</label>
                            <input class="pg-input" type="password" id="konfirmasi_sandi" name="konfirmasi_sandi"
                                   placeholder="Ulangi kata sandi baru">
                        </div>
                    </div>
                    <div style="margin-top: 20px;">
                        <button type="submit" class="btn-pg-primary">Perbarui Kata Sandi</button>
                    </div>
                </form>
            </div>




        </div>
    </main>
</div>

<script>
    function previewFoto(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran file maksimal 2MB!');
                return;
            }
            const reader = new FileReader();
            reader.onload = e => {
                document.getElementById('avatarPreview').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }


</script>
</body>
</html>
