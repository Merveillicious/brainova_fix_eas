<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Brainova</title>
    @vite('resources/css/app.css')
</head>
<body class="auth-page">
    <div class="auth-topbar">
        <a href="{{ url('/') }}" class="brand">
            Brainova 
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M9.5 2A2.5 2.5 0 0 1 12 4.5v15a2.5 2.5 0 0 1-4.96.44 2.5 2.5 0 0 1-2.96-3.08 3 3 0 0 1-.34-5.58 2.5 2.5 0 0 1 1.32-4.24 2.5 2.5 0 0 1 1.98-3A2.5 2.5 0 0 1 9.5 2Z"/>
              <path d="M14.5 2A2.5 2.5 0 0 0 12 4.5v15a2.5 2.5 0 0 0 4.96.44 2.5 2.5 0 0 0 2.96-3.08 3 3 0 0 0 .34-5.58 2.5 2.5 0 0 0-1.32-4.24 2.5 2.5 0 0 0-1.98-3A2.5 2.5 0 0 0 14.5 2Z"/>
            </svg>
        </a>
        <a href="{{ route('login') }}" class="btn-topbar">Log in</a>
    </div>

    <div class="auth-main">
        <div class="auth-container" id="main-container">
            
            <div id="auth-header-wrapper">
                <h1 class="auth-title">Sign Up</h1>
                <p class="auth-subtitle">Already have an account? <a href="{{ route('login') }}">Log in</a></p>

                @if(session('error'))
                    <div class="alert-error">{{ session('error') }}</div>
                @endif

                @php $activeTab = session('tab', $tab ?? 'siswa'); @endphp

                <div class="tab-row">
                    <button class="tab-btn {{ $activeTab === 'siswa' ? 'active' : '' }}" onclick="switchTab('siswa')">Daftar Siswa</button>
                    <button class="tab-btn {{ $activeTab === 'tutor' ? 'active' : '' }}" onclick="switchTab('tutor')">Daftar Tutor</button>
                </div>
            </div>

            <!-- Form Siswa -->
            <div class="tab-content {{ $activeTab === 'siswa' ? 'active' : '' }}" id="tab-siswa">
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <input type="hidden" name="reg_type" value="siswa">
                    <div class="form-group">
                        <label for="name_siswa">Nama Lengkap</label>
                        <input type="text" id="name_siswa" name="name" class="input-field" placeholder="Nama lengkap" required>
                    </div>
                    <div class="form-group">
                        <label for="email_siswa">Email</label>
                        <input type="email" id="email_siswa" name="email" class="input-field" placeholder="Email kamu" required>
                    </div>
                    <div class="form-group">
                        <label for="phone_siswa">Nomor Hp</label>
                        <input type="text" id="phone_siswa" name="phone" class="input-field" placeholder="08xx-xxxx-xxxx">
                    </div>
                    <div class="form-group">
                        <label for="password_siswa">Password</label>
                        <div class="password-box">
                            <input type="password" id="password_siswa" name="password" class="input-field" placeholder="Minimal 8 karakter" required>
                            <button type="button" class="eye-icon" onclick="togglePass('password_siswa', this)">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                            </button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation_siswa">Konfirmasi Password</label>
                        <div class="password-box">
                            <input type="password" id="password_confirmation_siswa" name="password_confirmation" class="input-field" placeholder="Ulangi password" required>
                            <button type="button" class="eye-icon" onclick="togglePass('password_confirmation_siswa', this)">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                            </button>
                        </div>
                    </div>
                    <button type="submit" class="btn-submit">Sign Up sebagai Siswa</button>
                </form>
            </div>

            <!-- Form Tutor -->
            <div class="tab-content {{ $activeTab === 'tutor' ? 'active' : '' }}" id="tab-tutor">
                
                <div class="stepper" id="tutor-stepper" style="display: none;">
                    <div class="step-item active" id="ind-1">
                        <div class="step-circle" id="circle-1">✓</div>
                        <div class="step-label">Akun Dasar</div>
                    </div>
                    <div class="stepper-line"></div>
                    <div class="step-item" id="ind-2">
                        <div class="step-circle" id="circle-2">2</div>
                        <div class="step-label">Profil Tutor</div>
                    </div>
                    <div class="stepper-line"></div>
                    <div class="step-item" id="ind-3">
                        <div class="step-circle" id="circle-3">3</div>
                        <div class="step-label">Video Intro</div>
                    </div>
                    <div class="stepper-line"></div>
                    <div class="step-item" id="ind-4">
                        <div class="step-circle" id="circle-4">4</div>
                        <div class="step-label">Tetapkan Tarif</div>
                    </div>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <input type="hidden" name="reg_type" value="tutor">
                    
                    <!-- Step 1: Akun Dasar -->
                    <div id="tutor-step-1">
                        <div class="form-group">
                            <label for="name_tutor">Nama Lengkap</label>
                            <input type="text" id="name_tutor" name="name" class="input-field" placeholder="Nama lengkap" required>
                        </div>
                        <div class="form-group">
                            <label for="email_tutor">Email</label>
                            <input type="email" id="email_tutor" name="email" class="input-field" placeholder="Email kamu" required>
                        </div>
                        <div class="form-group">
                            <label for="phone_tutor">Nomor Hp</label>
                            <input type="text" id="phone_tutor" name="phone" class="input-field" placeholder="08xx-xxxx-xxxx">
                        </div>
                        <div class="form-group">
                            <label for="password_tutor">Password</label>
                            <div class="password-box">
                                <input type="password" id="password_tutor" name="password" class="input-field" placeholder="Minimal 8 karakter" required>
                                <button type="button" class="eye-icon" onclick="togglePass('password_tutor', this)">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                </button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation_tutor">Konfirmasi Password</label>
                            <div class="password-box">
                                <input type="password" id="password_confirmation_tutor" name="password_confirmation" class="input-field" placeholder="Ulangi password" required>
                                <button type="button" class="eye-icon" onclick="togglePass('password_confirmation_tutor', this)">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                </button>
                            </div>
                        </div>
                        <button type="button" class="btn-submit" onclick="nextTutorStep(2)">Sign Up sebagai Tutor</button>
                    </div>

                    <!-- Step 2: Profil Tutor -->
                    <div id="tutor-step-2" style="display: none;">
                        <div class="step-card">
                            <h2 class="step-card-title">Profil Tutor</h2>
                            <p class="step-card-subtitle">Lengkapi profil untuk menarik lebih banyak siswa</p>

                            <div class="form-group">
                                <label>Foto Profil</label>
                                <div class="upload-box">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                                    <span>Upload</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Mata Pelajaran yang Diajarkan</label>
                                <div class="pill-group">
                                    @if(isset($subjects))
                                        @foreach($subjects as $s)
                                            <label>
                                                <input type="radio" name="subject_id" value="{{ $s->id }}" class="pill-radio" {{ $loop->first ? 'checked' : '' }}>
                                                <span class="pill-label">{{ $s->nama_mapel }}</span>
                                            </label>
                                        @endforeach
                                    @endif
                                    <label><input type="radio" name="subject_id_dummy" value="0" class="pill-radio"><span class="pill-label">Sejarah</span></label>
                                    <label><input type="radio" name="subject_id_dummy" value="0" class="pill-radio"><span class="pill-label">Coding</span></label>
                                    <label><input type="radio" name="subject_id_dummy" value="0" class="pill-radio"><span class="pill-label">Kalkulus</span></label>
                                    <label><input type="radio" name="subject_id_dummy" value="0" class="pill-radio"><span class="pill-label">Statistika</span></label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Tingkat Pendidikan</label>
                                <input type="text" id="pendidikan_tutor" class="input-field" placeholder="Misalnya SD, SMP, SMA">
                            </div>

                            <div class="form-group">
                                <label>Bio Singkat</label>
                                <div class="textarea-wrapper">
                                    <textarea id="bio" name="bio" class="input-field" placeholder="Ceritakan tentang diri kamu sebagai tutor..."></textarea>
                                    <div class="char-count">0/300</div>
                                </div>
                            </div>
                        </div>
                        <div class="step-actions">
                            <button type="button" class="btn-back" onclick="prevTutorStep(1)">← Kembali</button>
                            <button type="button" class="btn-next" onclick="nextTutorStep(3)">Lanjut →</button>
                        </div>
                    </div>

                    <!-- Step 3: Video Intro -->
                    <div id="tutor-step-3" style="display: none;">
                        <div class="step-card wide">
                            <h2 class="step-card-title">Video Perkenalan</h2>
                            <p class="step-card-subtitle">Tambahkan video horizontal maksimal 2 menit — perkenalkan diri kamu ke calon siswa</p>
                            
                            <div class="two-cols">
                                <div class="col-left">
                                    <div class="video-placeholder">Video kamu akan muncul di sini</div>
                                    <button type="button" class="btn-camera">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"/><circle cx="12" cy="13" r="3"/></svg>
                                        Test Kamera
                                    </button>
                                    <button type="button" class="btn-record">
                                        <span class="record-dot"></span> Mulai Rekam
                                    </button>
                                    <div class="link-label">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
                                        Atau tempel link video (YouTube)
                                    </div>
                                    <input type="text" id="video_tutor" class="input-field" placeholder="Link Video Youtube">
                                </div>
                                <div class="col-right">
                                    <h3 class="req-title">Persyaratan Video</h3>
                                    <p class="req-desc">Pastikan video kamu memenuhi persyaratan agar disetujui tim kami.</p>
                                    
                                    <div class="req-header text-green">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
                                        Harus
                                    </div>
                                    <ul class="req-list">
                                        <li>Durasi antara 30 detik – 2 menit</li>
                                        <li>Mode horizontal & sejajar mata</li>
                                        <li>Pencahayaan baik & latar belakang netral</li>
                                        <li>Permukaan stabil agar video tidak goyang</li>
                                        <li>Pastikan wajah & mata terlihat jelas</li>
                                        <li>Ceritakan pengalaman & sertifikasi mengajar</li>
                                        <li>Sambut siswa dengan hangat & ajak booking</li>
                                    </ul>

                                    <div class="req-header text-red">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                        Jangan
                                    </div>
                                    <ul class="req-list">
                                        <li>Cantumkan nama belakang atau kontak</li>
                                        <li>Cantumkan logo atau link apapun</li>
                                        <li>Gunakan slideshow atau presentasi</li>
                                        <li>Ada orang lain dalam video kamu</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="step-actions">
                            <button type="button" class="btn-back" onclick="prevTutorStep(2)">← Kembali</button>
                            <button type="button" class="btn-next" onclick="nextTutorStep(4)">Simpan & Lanjutkan →</button>
                        </div>
                    </div>

                    <!-- Step 4: Tetapkan Tarif -->
                    <div id="tutor-step-4" style="display: none;">
                        <div class="step-card">
                            <h2 class="step-card-title">Tetapkan tarif sesi 60 menit kamu</h2>
                            <p class="step-card-subtitle">Tarif yang kompetitif membantu menarik lebih banyak siswa. Setelah beberapa sesi pertama, kamu bisa menyesuaikannya sesuai pengalaman.</p>
                            
                            <p class="req-desc" style="font-size: 13px; color: #111; margin-bottom: 24px;">Untuk memulai, <strong>kami merekomendasikan tarif awal Rp 50.000</strong></p>

                            <div class="input-rp-wrapper">
                                <div class="input-rp-prefix">Rp</div>
                                <input type="number" id="tarif" name="tarif" placeholder="Masukan nominal" required>
                            </div>
                            <div class="char-count" style="position: static; text-align: left; margin-bottom: 16px;">Tarif dalam Rupiah (IDR)</div>

                            <div class="info-box">
                                <div>Tutor yang mengikuti rekomendasi tarif kami memiliki peluang <strong>40% lebih tinggi</strong> mendapatkan siswa pertama dalam seminggu setelah disetujui.</div>
                            </div>
                        </div>
                        <div class="step-actions">
                            <button type="button" class="btn-back" onclick="prevTutorStep(3)">← Kembali</button>
                            <button type="button" class="btn-next" onclick="validateStep4AndSubmit()">Selesai Registrasi →</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="auth-footer">
        &copy; 2026 Brainova
    </div>

    <style>
        .auth-container.expanded { max-width: 900px; }
    </style>

    <script>
        function switchTab(tab) {
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
            document.getElementById('tab-' + tab).classList.add('active');
            event.target.classList.add('active');
        }
        function togglePass(id, btn) {
            const inp = document.getElementById(id);
            inp.type = inp.type === 'password' ? 'text' : 'password';
            btn.style.opacity = inp.type === 'text' ? '0.5' : '1';
        }

        // Multi-step logic
        function nextTutorStep(step) {
            if (step === 2) {
                const name = document.getElementById('name_tutor').value;
                const email = document.getElementById('email_tutor').value;
                const pass = document.getElementById('password_tutor').value;
                const confirm = document.getElementById('password_confirmation_tutor').value;
                
                if (!name || !email || !pass || !confirm) {
                    alert('Mohon isi semua field dasar (Nama, Email, Password) terlebih dahulu.');
                    return;
                }
                if (pass !== confirm) {
                    alert('Password dan Konfirmasi Password tidak cocok!');
                    return;
                }
            } else if (step === 3) {
                const pendidikan = document.getElementById('pendidikan_tutor').value;
                const bio = document.getElementById('bio').value;
                
                if (!pendidikan || !bio) {
                    alert('Mohon lengkapi Tingkat Pendidikan dan Bio Singkat terlebih dahulu.');
                    return;
                }
            } else if (step === 4) {
                const video = document.getElementById('video_tutor').value;
                
                if (!video) {
                    alert('Mohon tempelkan link video perkenalan terlebih dahulu.');
                    return;
                }
            }

            // Hide all steps
            for(let i=1; i<=4; i++) {
                document.getElementById('tutor-step-' + i).style.display = 'none';
            }
            // Show target step
            document.getElementById('tutor-step-' + step).style.display = 'block';
            
            // Adjust container width and headers
            if(step > 1) {
                document.getElementById('auth-header-wrapper').style.display = 'none';
                document.getElementById('main-container').classList.add('expanded');
                document.getElementById('tutor-stepper').style.display = 'flex';
                updateStepper(step);
            } else {
                document.getElementById('auth-header-wrapper').style.display = 'block';
                document.getElementById('main-container').classList.remove('expanded');
                document.getElementById('tutor-stepper').style.display = 'none';
            }
        }

        function prevTutorStep(step) {
            // No validation when going back
            for(let i=1; i<=4; i++) {
                document.getElementById('tutor-step-' + i).style.display = 'none';
            }
            document.getElementById('tutor-step-' + step).style.display = 'block';
            
            if(step > 1) {
                document.getElementById('auth-header-wrapper').style.display = 'none';
                document.getElementById('main-container').classList.add('expanded');
                document.getElementById('tutor-stepper').style.display = 'flex';
                updateStepper(step);
            } else {
                document.getElementById('auth-header-wrapper').style.display = 'block';
                document.getElementById('main-container').classList.remove('expanded');
                document.getElementById('tutor-stepper').style.display = 'none';
            }
        }

        function validateStep4AndSubmit() {
            const tarif = document.getElementById('tarif').value;
            if (!tarif) {
                alert('Mohon tetapkan tarif kamu terlebih dahulu.');
                return;
            }
            // Submit form
            document.querySelector('#tab-tutor form').submit();
        }

        function updateStepper(step) {
            for(let i=1; i<=4; i++) {
                let circle = document.getElementById('circle-' + i);
                if(i < step) {
                    circle.innerHTML = '✓';
                } else {
                    circle.innerHTML = i;
                }
            }
        }

        // ── Validasi Form Register Siswa ──────────────────────────────────────
        document.querySelector('#tab-siswa form').addEventListener('submit', function(e) {
            let valid = true;
            const name  = document.getElementById('name_siswa');
            const email = document.getElementById('email_siswa');
            const pass  = document.getElementById('password_siswa');
            const conf  = document.getElementById('password_confirmation_siswa');

            // Reset border
            [name, email, pass, conf].forEach(el => el.style.borderColor = '');

            // Nama wajib
            if (!name.value.trim() || name.value.trim().length < 2) {
                name.style.borderColor = '#ef4444';
                showErr(name, 'Nama minimal 2 karakter.');
                valid = false;
            }

            // Email format
            if (!email.value || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
                email.style.borderColor = '#ef4444';
                showErr(email, 'Format email tidak valid.');
                valid = false;
            }

            // Password minimal 8
            if (!pass.value || pass.value.length < 8) {
                pass.style.borderColor = '#ef4444';
                showErr(pass, 'Password minimal 8 karakter.');
                valid = false;
            }

            // Konfirmasi password harus sama
            if (conf.value !== pass.value) {
                conf.style.borderColor = '#ef4444';
                showErr(conf, 'Konfirmasi password tidak cocok.');
                valid = false;
            }

            if (!valid) e.preventDefault();
        });

        // Helper: tampilkan pesan error kecil di bawah input
        function showErr(input, msg) {
            // Hapus pesan lama
            const existing = input.parentNode.querySelector('.reg-err');
            if (existing) existing.remove();

            const span = document.createElement('span');
            span.className = 'reg-err';
            span.style.cssText = 'color:#ef4444;font-size:11px;font-weight:600;margin-top:3px;display:block;';
            span.textContent = msg;

            // Masukkan setelah input (atau setelah .password-box jika ada)
            const box = input.closest('.password-box') || input;
            box.insertAdjacentElement('afterend', span);
        }

        // Hapus error saat mengetik
        ['name_siswa','email_siswa','password_siswa','password_confirmation_siswa'].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.addEventListener('input', function() {
                this.style.borderColor = '';
                const err = this.closest('.password-box')
                    ? this.closest('.password-box').nextElementSibling
                    : this.nextElementSibling;
                if (err && err.classList.contains('reg-err')) err.remove();
            });
        });
    </script>
</body>
</html>
