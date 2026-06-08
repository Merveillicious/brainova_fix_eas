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

        /* ── Profile Preview Card ── */
        .pg-layout {
            display: grid;
            grid-template-columns: 280px 1fr;
            gap: 24px;
            align-items: start;
        }
        @media (max-width: 860px) {
            .pg-layout { grid-template-columns: 1fr; }
        }

        .pg-preview-wrap {
            position: sticky;
            top: 24px;
        }
        .pg-preview-card {
            background: #fff;
            border: 2px solid #000;
            border-radius: 16px;
            overflow: hidden;
        }
        .pg-preview-banner {
            height: 72px;
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
            border-bottom: 2px solid #000;
        }
        .pg-preview-body {
            padding: 0 20px 20px;
            text-align: center;
        }
        .pg-preview-avatar-wrap {
            margin-top: -36px;
            margin-bottom: 12px;
        }
        .pg-preview-avatar {
            width: 72px; height: 72px;
            border-radius: 50%;
            border: 3px solid #fff;
            box-shadow: 0 0 0 2px #000;
            object-fit: cover;
            background: #000;
        }
        .pg-preview-name {
            font-size: 16px;
            font-weight: 800;
            color: #000;
            margin-bottom: 4px;
            word-break: break-word;
        }
        .pg-preview-email {
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 12px;
            word-break: break-all;
        }
        .pg-preview-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: #fef3c7;
            border: 2px solid #000;
            border-radius: 20px;
            padding: 4px 12px;
            font-size: 12px;
            font-weight: 700;
            color: #92400e;
            margin-bottom: 16px;
        }
        .pg-preview-stats {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            margin-top: 8px;
        }
        .pg-preview-stat {
            background: #f9fafb;
            border: 2px solid #000;
            border-radius: 10px;
            padding: 10px 8px;
            text-align: center;
        }
        .pg-preview-stat-val { font-size: 16px; font-weight: 800; color: #000; }
        .pg-preview-stat-label { font-size: 10px; color: #6b7280; font-weight: 600; margin-top: 2px; }
        .pg-preview-label {
            font-size: 11px;
            font-weight: 700;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: .05em;
            text-align: left;
            margin-bottom: 6px;
            margin-top: 8px;
        }
        .pg-preview-phone-val {
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            text-align: left;
            padding: 8px 10px;
            background: #f9fafb;
            border: 2px solid #000;
            border-radius: 8px;
        }
        .pg-preview-tag {
            display: inline-block;
            font-size: 11px;
            font-weight: 600;
            color: #6b7280;
            margin-top: 16px;
            padding-top: 12px;
            border-top: 1px dashed #e5e7eb;
            width: 100%;
            text-align: center;
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

            <div class="pg-layout">

            {{-- ══ LEFT: Profile Preview ══ --}}
            <div class="pg-preview-wrap">
                <div class="pg-preview-card">
                    <div class="pg-preview-banner"></div>
                    <div class="pg-preview-body">
                        <div class="pg-preview-avatar-wrap">
                            <img class="pg-preview-avatar" id="previewAvatarCard"
                                 src="{{ $user->photo ? asset('storage/photos/' . $user->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=000&color=fff&size=128' }}"
                                 alt="Preview">
                        </div>
                        <div class="pg-preview-name" id="previewName">{{ $user->name }}</div>
                        <div class="pg-preview-email">{{ $user->email }}</div>
                        <div class="pg-preview-badge">🎓 Siswa</div>

                        <div class="pg-preview-stats">
                            <div class="pg-preview-stat">
                                <div class="pg-preview-stat-val">{{ $student ? \App\Models\Booking::where('student_id', $student->id)->count() : 0 }}</div>
                                <div class="pg-preview-stat-label">Booking</div>
                            </div>
                            <div class="pg-preview-stat">
                                <div class="pg-preview-stat-val">{{ $student ? \App\Models\Booking::where('student_id', $student->id)->where('status_booking', 'selesai')->count() : 0 }}</div>
                                <div class="pg-preview-stat-label">Selesai</div>
                            </div>
                        </div>

                        @if($user->phone)
                        <div class="pg-preview-label">WhatsApp</div>
                        <div class="pg-preview-phone-val" id="previewPhone">{{ $user->phone }}</div>
                        @else
                        <div class="pg-preview-label">WhatsApp</div>
                        <div class="pg-preview-phone-val" id="previewPhone" style="color:#d1d5db;">Belum diisi</div>
                        @endif

                        <div class="pg-preview-tag">👁 Tampilan profil publik Anda</div>

                        <a href="{{ route('siswa.dashboard') }}"
                           style="display:flex;align-items:center;justify-content:center;gap:6px;margin-top:14px;padding:10px;background:#fff;border:2px solid #000;border-radius:10px;font-size:13px;font-weight:700;color:#000;text-decoration:none;transition:background .15s;"
                           onmouseover="this.style.background='#fef3c7'" onmouseout="this.style.background='#fff'">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                            Ke Dashboard
                        </a>
                    </div>
                </div>
            </div>

            {{-- ══ RIGHT: Form ══ --}}
            <div>

            {{-- ══ Informasi Pribadi ══ --}}
            <div class="pg-section">
                <div class="pg-section-title">Informasi Pribadi</div>

                {{-- Avatar --}}
                <div class="pg-avatar-row">
                    @if($user->photo)
                        <img class="pg-avatar-img"
                             src="{{ asset('storage/photos/' . $user->photo) }}"
                             alt="Avatar" id="avatarPreview">
                    @else
                        <img class="pg-avatar-img"
                             src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=000&color=fff&size=128"
                             alt="Avatar" id="avatarPreview">
                    @endif
                    <div class="pg-avatar-info">
                        <button type="button" class="btn-ubah-foto" onclick="document.getElementById('fotoInput').click()">
                            Ubah Foto
                        </button>
                        <div class="pg-foto-hint">Format JPG atau PNG. Maksimal 2MB.</div>
                    </div>
                </div>

                <form method="POST" action="{{ route('siswa.pengaturan.profil') }}" enctype="multipart/form-data">
                    @csrf
                    {{-- Hidden file input inside form --}}
                    <input type="file" id="fotoInput" name="photo" accept="image/jpg,image/jpeg,image/png" style="display:none"
                           onchange="previewFoto(this)">
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




            </div> {{-- end right column --}}
            </div> {{-- end pg-layout --}}

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
                // Update both avatars
                document.getElementById('avatarPreview').src = e.target.result;
                document.getElementById('previewAvatarCard').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }

    // Live update name preview
    document.getElementById('name').addEventListener('input', function() {
        const val = this.value.trim() || '{{ $user->name }}';
        document.getElementById('previewName').textContent = val;
    });

    // Live update phone preview
    const phoneInput = document.getElementById('phone');
    if (phoneInput) {
        phoneInput.addEventListener('input', function() {
            const phoneEl = document.getElementById('previewPhone');
            const val = this.value.trim();
            if (val) {
                phoneEl.textContent = val;
                phoneEl.style.color = '';
            } else {
                phoneEl.textContent = 'Belum diisi';
                phoneEl.style.color = '#d1d5db';
            }
        });
    }


</script>
</body>
</html>
