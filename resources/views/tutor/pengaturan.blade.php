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
            border: 2px solid #000;
        }
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
            display: block;
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
        .pg-label { font-size: 12px; font-weight: 600; color: #374151; }
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
        .pg-input[readonly] { background: #f9fafb; color: #9ca3af; cursor: not-allowed; }
        .pg-input::placeholder { color: #d1d5db; }

        /* ── Tag / Mapel Chips ── */
        .pg-mapel-input-row {
            display: flex;
            gap: 10px;
            align-items: center;
            margin-bottom: 12px;
        }
        .pg-mapel-input-row .pg-input { flex: 1; margin-bottom: 0; }
        .btn-tambah-mapel {
            padding: 12px 18px;
            background: #FBBF24;
            border: 2px solid #000;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 700;
            color: #000;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            white-space: nowrap;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: background .15s;
        }
        .btn-tambah-mapel:hover { background: #f59e0b; }

        .pg-chips {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 4px;
        }
        .pg-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #FBBF24;
            border-radius: 20px;
            padding: 5px 12px;
            font-size: 13px;
            font-weight: 600;
            color: #000;
        }
        .pg-chip-remove {
            cursor: pointer;
            font-size: 14px;
            font-weight: 700;
            line-height: 1;
            color: #000;
            background: none;
            border: none;
            padding: 0;
            display: flex;
            align-items: center;
        }
        .pg-chip-remove:hover { color: #ef4444; }

        /* ── Sertifikat ── */
        .btn-unggah-sertifikat {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            background: #fff;
            border: 2px solid #000;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            color: #000;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            margin-bottom: 14px;
            transition: background .15s;
        }
        .btn-unggah-sertifikat:hover { background: #f3f4f6; }

        .pg-file-list { display: flex; flex-direction: column; gap: 8px; }
        .pg-file-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 11px 14px;
            border: 2px solid #000;
            border-radius: 10px;
            background: #fafafa;
            font-size: 13px;
            font-weight: 500;
            color: #374151;
        }
        .pg-file-left { display: flex; align-items: center; gap: 10px; }
        .pg-file-icon { color: #6b7280; }
        .btn-hapus-file {
            background: none;
            border: none;
            cursor: pointer;
            color: #9ca3af;
            display: flex;
            align-items: center;
            padding: 4px;
            border-radius: 6px;
            transition: color .15s, background .15s;
        }
        .btn-hapus-file:hover { color: #ef4444; background: #fef2f2; }

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
        .alert-success { background:#f0fdf4;border: 2px solid #000;border-radius:8px;padding:12px 16px;font-size:14px;color:#166534;margin-bottom:20px; }
        .alert-error   { background:#fef2f2;border: 2px solid #000;border-radius:8px;padding:12px 16px;font-size:14px;color:#b91c1c;margin-bottom:20px; }

        @media (max-width: 640px) {
            .pg-form-grid { grid-template-columns: 1fr; }
            .pg-section { padding: 20px; }
            .pg-mapel-input-row { flex-direction: column; align-items: stretch; }
        }
    </style>
</head>
<body>
<header class="app-topbar">
    <a href="{{ route('tutor.dashboard') }}" class="app-brand">
        Brainova
    </a>
</header>
<div class="siswa-layout">

    @include('tutor.partials.sidebar')

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
                         src="https://ui-avatars.com/api/?name={{ urlencode(session('user.name', 'Tutor')) }}&background=000&color=fff&size=128"
                         alt="Avatar" id="avatarPreview">
                    <div class="pg-avatar-info">
                        <button type="button" class="btn-ubah-foto" onclick="document.getElementById('fotoInput').click()">
                            Ubah Foto
                        </button>
                        <input type="file" id="fotoInput" accept="image/jpg,image/jpeg,image/png"
                               style="display:none" onchange="previewFoto(this)">
                        <div class="pg-foto-hint">Format JPG atau PNG. Maksimal 2MB.</div>
                    </div>
                </div>

                <form method="POST" action="{{ route('tutor.pengaturan.profil') }}">
                    @csrf
                    <div class="pg-form-grid">
                        <div class="pg-form-group">
                            <label class="pg-label" for="name">Nama Lengkap</label>
                            <input class="pg-input" type="text" id="name" name="name"
                                   value="{{ old('name', session('user.name')) }}" required>
                        </div>
                        <div class="pg-form-group">
                            <label class="pg-label">Email (Tidak dapat diubah)</label>
                            <input class="pg-input" type="email"
                                   value="{{ session('user.email') }}" readonly>
                        </div>
                    </div>
                    <div class="pg-form-grid full">
                        <div class="pg-form-group">
                            <label class="pg-label" for="phone">Nomor WhatsApp</label>
                            <input class="pg-input" type="text" id="phone" name="phone"
                                   placeholder="+62 812 3456 7890"
                                   value="{{ old('phone', $tutor->phone ?? '') }}">
                        </div>
                    </div>
                    <div class="pg-bottom-bar">
                        <button type="submit" class="btn-pg-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>

            {{-- ══ Profil Profesional ══ --}}
            <div class="pg-section">
                <div class="pg-section-title">Profil Profesional</div>

                {{-- Mata Pelajaran --}}
                <div class="pg-form-group" style="margin-bottom: 16px;">
                    <label class="pg-label">Mata Pelajaran yang Diajar</label>
                    <div class="pg-mapel-input-row">
                        <input class="pg-input" type="text" id="mapelInput"
                               placeholder="Contoh: Kimia Dasar"
                               onkeydown="if(event.key==='Enter'){event.preventDefault();tambahMapel();}">
                        <button type="button" class="btn-tambah-mapel" onclick="tambahMapel()">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"
                                 viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                            Tambah
                        </button>
                    </div>
                    <div class="pg-chips" id="mapelChips">
                        {{-- Pre-fill with current subject --}}
                        @if($tutor && $tutor->subject)
                            <span class="pg-chip">
                                {{ $tutor->subject?->nama_mapel }}
                                <button type="button" class="pg-chip-remove" onclick="hapusChip(this)">×</button>
                            </span>
                        @else
                            <span class="pg-chip">
                                Matematika SMA
                                <button type="button" class="pg-chip-remove" onclick="hapusChip(this)">×</button>
                            </span>
                            <span class="pg-chip">
                                Fisika Dasar
                                <button type="button" class="pg-chip-remove" onclick="hapusChip(this)">×</button>
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Sertifikat --}}
                <div class="pg-form-group">
                    <label class="pg-label">Sertifikat</label>
                    <button type="button" class="btn-unggah-sertifikat" onclick="document.getElementById('sertifikatInput').click()">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                        </svg>
                        Unggah Sertifikat Baru
                    </button>
                    <input type="file" id="sertifikatInput" accept=".pdf,.jpg,.png"
                           style="display:none" onchange="tambahSertifikat(this)">

                    <div class="pg-file-list" id="sertifikatList">
                        <div class="pg-file-item">
                            <div class="pg-file-left">
                                <svg class="pg-file-icon" width="16" height="16" fill="none" stroke="currentColor"
                                     stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                </svg>
                                Sertifikat_Pedagogik_2023.pdf
                            </div>
                            <button type="button" class="btn-hapus-file" onclick="hapusFile(this)">
                                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2"
                                     viewBox="0 0 24 24">
                                    <polyline points="3 6 5 6 21 6"/>
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 11v6M14 11v6"/>
                                </svg>
                            </button>
                        </div>
                        <div class="pg-file-item">
                            <div class="pg-file-left">
                                <svg class="pg-file-icon" width="16" height="16" fill="none" stroke="currentColor"
                                     stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                </svg>
                                IELTS_Score_Report.pdf
                            </div>
                            <button type="button" class="btn-hapus-file" onclick="hapusFile(this)">
                                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2"
                                     viewBox="0 0 24 24">
                                    <polyline points="3 6 5 6 21 6"/>
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 11v6M14 11v6"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="pg-bottom-bar" style="margin-top: 20px;">
                    <button type="button" class="btn-pg-primary">Simpan Profil Profesional</button>
                </div>
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

                <form method="POST" action="{{ route('tutor.pengaturan.sandi') }}">
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
    /* ── Avatar Preview ── */
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

    /* ── Mata Pelajaran Chips ── */
    function tambahMapel() {
        const input = document.getElementById('mapelInput');
        const val   = input.value.trim();
        if (!val) return;

        const chip = document.createElement('span');
        chip.className = 'pg-chip';
        chip.innerHTML = `${escHtml(val)} <button type="button" class="pg-chip-remove" onclick="hapusChip(this)">×</button>`;

        document.getElementById('mapelChips').appendChild(chip);
        input.value = '';
        input.focus();
    }

    function hapusChip(btn) {
        btn.closest('.pg-chip').remove();
    }

    /* ── Sertifikat Files ── */
    function tambahSertifikat(input) {
        if (!input.files || !input.files[0]) return;
        const file = input.files[0];

        const icon = `<svg class="pg-file-icon" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>`;
        const trashIcon = `<svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path stroke-linecap="round" stroke-linejoin="round" d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path stroke-linecap="round" stroke-linejoin="round" d="M10 11v6M14 11v6"/></svg>`;

        const item = document.createElement('div');
        item.className = 'pg-file-item';
        item.innerHTML = `
            <div class="pg-file-left">${icon} ${escHtml(file.name)}</div>
            <button type="button" class="btn-hapus-file" onclick="hapusFile(this)">${trashIcon}</button>
        `;

        document.getElementById('sertifikatList').appendChild(item);
        input.value = '';
    }

    function hapusFile(btn) {
        btn.closest('.pg-file-item').remove();
    }

    function escHtml(str) {
        return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
    }
</script>
</body>
</html>
