<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan - Brainova</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <style>
        body { margin: 0; font-family: 'Inter', sans-serif; background: #fafafa; }

        /* Override siswa-main padding for full-height chat */
        .siswa-main { padding: 0 !important; overflow: hidden; }

        /* ── Chat Wrapper ── */
        .chat-wrapper {
            display: flex;
            height: calc(100vh - 70px);
            overflow: hidden;
        }

        /* ── Contact List (Left Panel) ── */
        .chat-contacts {
            width: 280px;
            flex-shrink: 0;
            border-right: 2px solid #000;
            display: flex;
            flex-direction: column;
            background: #fff;
        }
        .chat-search-box {
            padding: 14px 16px;
            border-bottom: 2px solid #000;
        }
        .chat-search-input {
            width: 100%;
            padding: 10px 14px 10px 36px;
            border: 2px solid #000;
            border-radius: 10px;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            outline: none;
            background: #f9fafb;
            box-sizing: border-box;
            transition: border-color .2s, background .2s;
        }
        .chat-search-input:focus { border-color: #FBBF24; background: #fff; }
        .chat-search-wrap { position: relative; }
        .chat-search-icon {
            position: absolute;
            left: 11px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            pointer-events: none;
        }

        .chat-contact-list { flex: 1; overflow-y: auto; }
        .chat-contact-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 16px;
            cursor: pointer;
            border-left: 3px solid transparent;
            transition: background .15s, border-color .15s;
        }
        .chat-contact-item:hover { background: #f9fafb; }
        .chat-contact-item.active {
            background: #fff8e6;
            border-left-color: #FBBF24;
        }
        .chat-contact-avatar-wrap { position: relative; flex-shrink: 0; }
        .chat-contact-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #000;
        }
        .chat-contact-avatar.initials {
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            font-weight: 800;
            color: #fff;
            border: none;
        }
        .chat-online-dot {
            width: 10px; height: 10px;
            border-radius: 50%;
            border: 2px solid #fff;
            position: absolute;
            bottom: 1px; right: 1px;
        }
        .chat-online-dot.online  { background: #22c55e; }
        .chat-online-dot.offline { background: #9ca3af; }
        .chat-contact-info { flex: 1; min-width: 0; }
        .chat-contact-name {
            font-size: 14px;
            font-weight: 700;
            color: #000;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .chat-contact-item.active .chat-contact-name { color: #92400e; }
        .chat-contact-time {
            font-size: 11px;
            color: #9ca3af;
            white-space: nowrap;
            margin-left: auto;
            flex-shrink: 0;
            align-self: flex-start;
            padding-top: 2px;
        }

        /* ── Chat Window (Right Panel) ── */
        .chat-window {
            flex: 1;
            display: flex;
            flex-direction: column;
            background: #fff;
            min-width: 0;
        }

        /* Chat Header */
        .chat-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 20px;
            border-bottom: 2px solid #000;
            background: #fff;
            flex-shrink: 0;
        }
        .chat-header-left { display: flex; align-items: center; gap: 12px; }
        .chat-header-avatar {
            width: 40px; height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #000;
        }
        .chat-header-name {
            font-size: 15px;
            font-weight: 700;
            color: #000;
        }
        .chat-header-status {
            font-size: 12px;
            color: #22c55e;
            display: flex;
            align-items: center;
            gap: 4px;
            margin-top: 1px;
        }
        .chat-header-status.offline { color: #9ca3af; }
        .chat-header-status .dot {
            width: 7px; height: 7px;
            border-radius: 50%;
            background: currentColor;
        }
        .chat-header-actions { display: flex; gap: 8px; align-items: center; }
        .chat-header-btn {
            width: 34px; height: 34px;
            border: 2px solid #000;
            border-radius: 8px;
            background: #fff;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6b7280;
            transition: background .15s;
        }
        .chat-header-btn:hover { background: #f3f4f6; }

        /* Messages Area */
        .chat-messages {
            flex: 1;
            overflow-y: auto;
            padding: 24px 24px 16px;
            display: flex;
            flex-direction: column;
            gap: 16px;
            background: #fafafa;
        }
        .chat-messages::-webkit-scrollbar { width: 4px; }
        .chat-messages::-webkit-scrollbar-track { background: transparent; }
        .chat-messages::-webkit-scrollbar-thumb { background: #e5e7eb; border-radius: 4px; }

        /* Day separator */
        .chat-day-sep { text-align: center; margin: 8px 0; }
        .chat-day-sep span {
            display: inline-block;
            background: #e5e7eb;
            color: #6b7280;
            font-size: 11px;
            font-weight: 600;
            padding: 4px 14px;
            border-radius: 20px;
        }

        /* Message bubbles */
        .chat-msg-row {
            display: flex;
            align-items: flex-end;
            gap: 8px;
        }
        .chat-msg-row.me { flex-direction: row-reverse; }

        .chat-msg-avatar {
            width: 30px; height: 30px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #000;
            flex-shrink: 0;
            align-self: flex-end;
        }

        .chat-bubble-wrap { max-width: 65%; display: flex; flex-direction: column; gap: 4px; }
        .chat-msg-row.me .chat-bubble-wrap { align-items: flex-end; }

        .chat-bubble {
            padding: 12px 16px;
            border-radius: 18px;
            font-size: 14px;
            line-height: 1.55;
            color: #111;
            position: relative;
            word-break: break-word;
        }
        .chat-bubble.them {
            background: #fff;
            border: 2px solid #000;
            border-bottom-left-radius: 4px;
            box-shadow: 0 1px 4px rgba(0,0,0,.04);
        }
        .chat-bubble.me {
            background: #FBBF24;
            border: 2px solid #000;
            border-bottom-right-radius: 4px;
            color: #000;
        }

        .chat-msg-meta {
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: 11px;
            color: #9ca3af;
            padding: 0 4px;
        }
        .chat-msg-row.me .chat-msg-meta { justify-content: flex-end; }
        .chat-checkmark { color: #6b7280; }

        /* Input Area */
        .chat-input-area {
            padding: 12px 16px;
            border-top: 2px solid #000;
            background: #fff;
            display: flex;
            align-items: center;
            gap: 10px;
            flex-shrink: 0;
        }
        .chat-input-reply {
            width: 34px; height: 34px;
            background: none;
            border: none;
            cursor: pointer;
            color: #9ca3af;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            transition: background .15s;
            flex-shrink: 0;
        }
        .chat-input-reply:hover { background: #f3f4f6; color: #555; }

        .chat-input-field {
            flex: 1;
            padding: 10px 16px;
            border: 2px solid #000;
            border-radius: 24px;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            outline: none;
            transition: border-color .2s;
            background: #f9fafb;
        }
        .chat-input-field:focus { border-color: #FBBF24; background: #fff; }

        .chat-emoji-btn {
            width: 34px; height: 34px;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            transition: background .15s;
            flex-shrink: 0;
        }
        .chat-emoji-btn:hover { background: #f3f4f6; }

        .chat-send-btn {
            width: 40px; height: 40px;
            background: #FBBF24;
            border: 2px solid #000;
            border-radius: 10px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #000;
            transition: background .15s, transform .1s;
            flex-shrink: 0;
        }
        .chat-send-btn:hover { background: #f59e0b; transform: scale(1.05); }

        /* Animate messages in */
        .chat-msg-row { animation: msgIn .2s ease both; }
        @keyframes msgIn {
            from { opacity: 0; transform: translateY(6px); }
            to   { opacity: 1; transform: translateY(0); }
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

    <main class="siswa-main">
        <div class="chat-wrapper">

            {{-- ══ Left: Contact List ══ --}}
            <div class="chat-contacts">
                {{-- Search --}}
                <div class="chat-search-box">
                    <div class="chat-search-wrap">
                        <svg class="chat-search-icon" width="15" height="15" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                        </svg>
                        <input class="chat-search-input" type="text" placeholder="Cari pesan..."
                               id="searchInput" oninput="filterContacts(this.value)">
                    </div>
                </div>

                {{-- Contacts --}}
                <div class="chat-contact-list" id="contactList">
                    @php
                        $demoContacts = [
                            ['name' => 'Sarah M.',      'time' => 'Kemarin', 'online' => false, 'color' => '#6366f1'],
                            ['name' => 'Rizky P.',      'time' => 'Selasa',  'online' => true,  'color' => '#10b981'],
                            ['name' => 'Dewi Lestari',  'time' => 'Senin',   'online' => false, 'color' => '#ef4444'],
                            ['name' => 'Andi Saputra',  'time' => 'Minggu',  'online' => false, 'color' => '#8b5cf6'],
                        ];

                        // Merge real students from bookings + demo
                        $contactList = collect($demoContacts);
                        if (isset($students)) {
                            foreach ($students as $student) {
                                $contactList->prepend([
                                    'name'   => $student->name,
                                    'time'   => 'Hari ini',
                                    'online' => true,
                                    'color'  => '#FBBF24',
                                    'real'   => true,
                                ]);
                            }
                        }
                        $contactList = $contactList->unique('name')->values();
                    @endphp

                    @foreach($contactList as $i => $contact)
                    @php
                        $initials = strtoupper(implode('', array_map(fn($w) => $w[0], explode(' ', $contact['name']))));
                        $initials = substr($initials, 0, 2);
                    @endphp
                    <div class="chat-contact-item {{ $i === 0 ? 'active' : '' }}"
                         onclick="openChat(this, '{{ addslashes($contact['name']) }}', '{{ $contact['online'] ? 'online' : 'offline' }}', '{{ $contact['color'] }}', '{{ $initials }}')"
                         data-name="{{ strtolower($contact['name']) }}">
                        <div class="chat-contact-avatar-wrap">
                            <div class="chat-contact-avatar initials"
                                 style="background:{{ $contact['color'] }};width:44px;height:44px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:15px;font-weight:800;color:#fff;">
                                {{ $initials }}
                            </div>
                            <span class="chat-online-dot {{ $contact['online'] ? 'online' : 'offline' }}"></span>
                        </div>
                        <div class="chat-contact-info">
                            <div class="chat-contact-name">{{ $contact['name'] }}</div>
                        </div>
                        <div class="chat-contact-time">{{ $contact['time'] }}</div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- ══ Right: Chat Window ══ --}}
            <div class="chat-window" id="chatWindow">

                {{-- Header --}}
                <div class="chat-header">
                    <div class="chat-header-left">
                        <div id="chatHeaderAvatar"
                             style="width:40px;height:40px;border-radius:50%;background:{{ $contactList->first()['color'] ?? '#6366f1' }};display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:800;color:#fff;flex-shrink:0;">
                            @php
                                $firstName = $contactList->first()['name'] ?? 'S';
                                $headerInitials = strtoupper(implode('', array_map(fn($w) => $w[0], explode(' ', $firstName))));
                                echo substr($headerInitials, 0, 2);
                            @endphp
                        </div>
                        <div>
                            <div class="chat-header-name" id="chatHeaderName">
                                {{ $contactList->first()['name'] ?? 'Pilih kontak' }}
                            </div>
                            <div class="chat-header-status {{ ($contactList->first()['online'] ?? false) ? '' : 'offline' }}" id="chatHeaderStatus">
                                <span class="dot"></span>
                                {{ ($contactList->first()['online'] ?? false) ? 'Online' : 'Offline' }}
                            </div>
                        </div>
                    </div>
                    <div class="chat-header-actions">
                        <button class="chat-header-btn" title="Video call">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="2" y="7" width="15" height="10" rx="2"/>
                                <polyline points="17 7 22 4 22 20 17 17"/>
                            </svg>
                        </button>
                        <button class="chat-header-btn" title="Opsi">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="5" r="1"/><circle cx="12" cy="12" r="1"/><circle cx="12" cy="19" r="1"/>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Messages --}}
                <div class="chat-messages" id="chatMessages">
                    <div class="chat-day-sep"><span>Hari ini</span></div>

                    {{-- Siswa bertanya --}}
                    @php
                        $firstContact  = $contactList->first();
                        $firstColor    = $firstContact['color'] ?? '#6366f1';
                        $firstInitials = strtoupper(substr(implode('', array_map(fn($w) => $w[0], explode(' ', $firstContact['name'] ?? 'S'))), 0, 2));
                    @endphp

                    <div class="chat-msg-row them">
                        <div style="width:30px;height:30px;border-radius:50%;background:{{ $firstColor }};display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:800;color:#fff;flex-shrink:0;">
                            {{ $firstInitials }}
                        </div>
                        <div class="chat-bubble-wrap">
                            <div class="chat-bubble them">
                                Halo Tutor! Saya ingin bertanya mengenai materi yang kemarin disampaikan.
                            </div>
                            <div class="chat-msg-meta">09:10</div>
                        </div>
                    </div>

                    {{-- Tutor menjawab --}}
                    <div class="chat-msg-row me">
                        <div class="chat-bubble-wrap">
                            <div class="chat-bubble me">
                                Halo! Tentu, silakan. Materi bagian mana yang ingin ditanyakan?
                            </div>
                            <div class="chat-msg-meta">09:12 <span class="chat-checkmark">✓</span></div>
                        </div>
                    </div>

                    {{-- Siswa --}}
                    <div class="chat-msg-row them">
                        <div style="width:30px;height:30px;border-radius:50%;background:{{ $firstColor }};display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:800;color:#fff;flex-shrink:0;">
                            {{ $firstInitials }}
                        </div>
                        <div class="chat-bubble-wrap">
                            <div class="chat-bubble them">
                                Saya masih agak bingung pada materi aljabar linear bagian vektor eigen. Apakah ada referensi tambahan untuk dipelajari?
                            </div>
                            <div class="chat-msg-meta">09:15</div>
                        </div>
                    </div>

                    {{-- Tutor menjawab panjang --}}
                    <div class="chat-msg-row me">
                        <div class="chat-bubble-wrap">
                            <div class="chat-bubble me">
                                Tentu! Untuk referensi, kamu bisa belajar dari playlist Linear Algebra oleh Gilbert Strang di YouTube dan membaca bab Eigenvalue &amp; Eigenvector pada buku Linear Algebra and Its Applications karya David C. Lay. Nanti saya juga kirim beberapa latihan soal tambahan ya 😊
                            </div>
                            <div class="chat-msg-meta">09:20 <span class="chat-checkmark">✓</span></div>
                        </div>
                    </div>

                    {{-- Siswa terima kasih --}}
                    <div class="chat-msg-row them">
                        <div style="width:30px;height:30px;border-radius:50%;background:{{ $firstColor }};display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:800;color:#fff;flex-shrink:0;">
                            {{ $firstInitials }}
                        </div>
                        <div class="chat-bubble-wrap">
                            <div class="chat-bubble them">
                                Wah, terima kasih banyak Tutor! Nanti saya pelajari dulu referensinya 💪
                            </div>
                            <div class="chat-msg-meta">09:22</div>
                        </div>
                    </div>

                    {{-- Tutor balasan akhir --}}
                    <div class="chat-msg-row me">
                        <div class="chat-bubble-wrap">
                            <div class="chat-bubble me">
                                Semangat belajarnya ya! Kalau ada yang belum dimengerti, jangan ragu untuk bertanya lagi 😊
                            </div>
                            <div class="chat-msg-meta">09:23 <span class="chat-checkmark">✓</span></div>
                        </div>
                    </div>
                </div>

                {{-- Input --}}
                <div class="chat-input-area">
                    <button class="chat-input-reply" title="Balas">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="9 17 4 12 9 7"/><path d="M20 18v-2a4 4 0 0 0-4-4H4"/>
                        </svg>
                    </button>
                    <input class="chat-input-field" type="text" id="msgInput"
                           placeholder="Tulis pesan..."
                           onkeydown="if(event.key==='Enter') sendMessage()">
                    <button class="chat-send-btn" onclick="sendMessage()" title="Kirim">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="22" y1="2" x2="11" y2="13"/>
                            <polygon points="22 2 15 22 11 13 2 9 22 2"/>
                        </svg>
                    </button>
                </div>

            </div>{{-- end .chat-window --}}
        </div>
    </main>
</div>

<script>
    function filterContacts(q) {
        document.querySelectorAll('.chat-contact-item').forEach(el => {
            const name = el.dataset.name || '';
            el.style.display = name.includes(q.toLowerCase()) ? '' : 'none';
        });
    }

    function openChat(el, name, status, color, initials) {
        document.querySelectorAll('.chat-contact-item').forEach(c => c.classList.remove('active'));
        el.classList.add('active');

        // Update header
        document.getElementById('chatHeaderName').textContent = name;
        const statusEl = document.getElementById('chatHeaderStatus');
        if (status === 'online') {
            statusEl.innerHTML = '<span class="dot"></span> Online';
            statusEl.className = 'chat-header-status';
        } else {
            statusEl.textContent = 'Offline';
            statusEl.className = 'chat-header-status offline';
        }

        // Update avatar
        const avatarEl = document.getElementById('chatHeaderAvatar');
        avatarEl.textContent = initials;
        avatarEl.style.background = color;

        // Reset messages to demo
        resetMessages(name, color, initials);
    }

    function resetMessages(name, color, initials) {
        const container = document.getElementById('chatMessages');
        container.innerHTML = `
            <div class="chat-day-sep"><span>Hari ini</span></div>
            <div class="chat-msg-row them">
                <div style="width:30px;height:30px;border-radius:50%;background:${color};display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:800;color:#fff;flex-shrink:0;">${initials}</div>
                <div class="chat-bubble-wrap">
                    <div class="chat-bubble them">Halo Tutor! Saya ingin bertanya mengenai materi pelajaran.</div>
                    <div class="chat-msg-meta">09:10</div>
                </div>
            </div>
            <div class="chat-msg-row me">
                <div class="chat-bubble-wrap">
                    <div class="chat-bubble me">Halo! Tentu, silakan. Materi bagian mana yang ingin ditanyakan?</div>
                    <div class="chat-msg-meta">09:12 <span class="chat-checkmark">✓</span></div>
                </div>
            </div>
        `;
        container.scrollTop = container.scrollHeight;
    }

    function sendMessage() {
        const input = document.getElementById('msgInput');
        const text  = input.value.trim();
        if (!text) return;

        const now = new Date();
        const timeStr = now.getHours().toString().padStart(2,'0') + ':' + now.getMinutes().toString().padStart(2,'0');

        const msgEl = document.createElement('div');
        msgEl.className = 'chat-msg-row me';
        msgEl.innerHTML = `
            <div class="chat-bubble-wrap">
                <div class="chat-bubble me">${escapeHtml(text)}</div>
                <div class="chat-msg-meta">${timeStr} <span class="chat-checkmark">✓</span></div>
            </div>
        `;

        const container = document.getElementById('chatMessages');
        container.appendChild(msgEl);
        container.scrollTop = container.scrollHeight;

        input.value = '';
        input.focus();
    }

    function escapeHtml(str) {
        return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
    }

    // Auto-scroll on load
    window.addEventListener('load', () => {
        const c = document.getElementById('chatMessages');
        c.scrollTop = c.scrollHeight;
    });
</script>
</body>
</html>
