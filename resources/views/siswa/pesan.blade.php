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
        .chat-search-wrap {
            position: relative;
        }
        .chat-search-icon {
            position: absolute;
            left: 11px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            pointer-events: none;
        }

        .chat-contact-list {
            flex: 1;
            overflow-y: auto;
        }
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
        .chat-contact-avatar-wrap {
            position: relative;
            flex-shrink: 0;
        }
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
        .chat-day-sep {
            text-align: center;
            margin: 8px 0;
        }
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

        /* Empty state */
        .chat-empty-state {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #9ca3af;
            gap: 12px;
            background: #fafafa;
        }
        .chat-empty-icon { font-size: 48px; }
        .chat-empty-text { font-size: 15px; font-weight: 600; color: #555; }
        .chat-empty-sub  { font-size: 13px; }

        /* No contacts */
        .chat-no-contacts {
            text-align: center;
            padding: 40px 16px;
            color: #aaa;
            font-size: 13px;
        }

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
    <a href="{{ route('siswa.dashboard') }}" class="app-brand">
        Brainova
    </a>
</header>
<div class="siswa-layout">

    @include('siswa.partials.sidebar')

    <main class="siswa-main">
        <div class="chat-wrapper">

            {{-- ══ Left: Contact List ══ --}}
            <div class="chat-contacts">
                <div class="chat-search-box">
                    <div class="chat-search-wrap">
                        <svg class="chat-search-icon" width="15" height="15" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                        </svg>
                        <input class="chat-search-input" type="text" placeholder="Cari tutor..."
                               oninput="filterContacts(this.value)">
                    </div>
                </div>

                <div class="chat-contact-list" id="contactList">
                    @forelse($tutors as $t)
                    @php $initials = strtoupper(substr($t->name, 0, 2)); @endphp
                    <a href="{{ route('siswa.pesan', ['tutor' => $t->id]) }}"
                       class="chat-contact-item {{ $activeTutor && $activeTutor->id == $t->id ? 'active' : '' }}"
                       style="text-decoration:none;"
                       data-name="{{ strtolower($t->name) }}">
                        <div class="chat-contact-avatar-wrap">
                            <div class="chat-contact-avatar initials"
                                 style="background:#FBBF24;width:44px;height:44px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:15px;font-weight:800;color:#000;border:2px solid #000;">
                                {{ $initials }}
                            </div>
                            <span class="chat-online-dot online"></span>
                        </div>
                        <div class="chat-contact-info">
                            <div class="chat-contact-name">{{ $t->name }}</div>
                            <div style="font-size:11px;color:#9ca3af;">{{ $t->subject?->nama_mapel ?? '' }}</div>
                        </div>
                    </a>
                    @empty
                    <div class="chat-no-contacts">
                        <div style="font-size:32px;margin-bottom:8px;">💬</div>
                        Belum ada tutor yang dihubungi.<br>
                        <small>Booking kelas terlebih dahulu.</small>
                    </div>
                    @endforelse
                </div>
            </div>

            {{-- ══ Right: Chat Window ══ --}}
            <div class="chat-window" id="chatWindow">

                @if($activeTutor)
                {{-- Header --}}
                <div class="chat-header">
                    <div class="chat-header-left">
                        <div style="width:40px;height:40px;border-radius:50%;background:#FBBF24;display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:800;color:#000;flex-shrink:0;border:2px solid #000;">
                            {{ strtoupper(substr($activeTutor->name, 0, 2)) }}
                        </div>
                        <div>
                            <div class="chat-header-name">{{ $activeTutor->name }}</div>
                            <div class="chat-header-status"><span class="dot"></span> Tutor Aktif</div>
                        </div>
                    </div>
                </div>

                {{-- Messages --}}
                <div class="chat-messages" id="chatMessages">
                    @forelse($messages as $msg)
                    @php $isMe = $msg->sender_id == session('user.id'); @endphp
                    <div class="chat-msg-row {{ $isMe ? 'me' : 'them' }}">
                        @if(!$isMe)
                        <div style="width:30px;height:30px;border-radius:50%;background:#FBBF24;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:800;color:#000;flex-shrink:0;border:2px solid #000;">
                            {{ strtoupper(substr($activeTutor->name, 0, 2)) }}
                        </div>
                        @endif
                        <div class="chat-bubble-wrap">
                            <div class="chat-bubble {{ $isMe ? 'me' : 'them' }}">{{ $msg->body }}</div>
                            <div class="chat-msg-meta">
                                {{ \Carbon\Carbon::parse($msg->created_at)->format('H:i') }}
                                @if($isMe)<span class="chat-checkmark">{{ $msg->is_read ? '✓✓' : '✓' }}</span>@endif
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="chat-empty-state">
                        <div class="chat-empty-icon">💬</div>
                        <div class="chat-empty-text">Mulai percakapan</div>
                        <div class="chat-empty-sub">Kirim pesan pertama kepada {{ $activeTutor->name }}</div>
                    </div>
                    @endforelse
                </div>

                {{-- Input form --}}
                <div class="chat-input-area">
                    <form method="POST" action="{{ route('siswa.pesan.kirim') }}" id="chatForm"
                          style="display:flex;flex:1;gap:10px;align-items:center;">
                        @csrf
                        <input type="hidden" name="receiver_id" value="{{ $activeTutorUserId }}">
                        <input class="chat-input-field" type="text" name="body" id="msgInput"
                               placeholder="Tulis pesan..."
                               onkeydown="if(event.key==='Enter'&&!event.shiftKey){event.preventDefault();this.closest('form').submit();}"
                               autocomplete="off">
                        <button type="submit" class="chat-send-btn" title="Kirim">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                 stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="22" y1="2" x2="11" y2="13"/>
                                <polygon points="22 2 15 22 11 13 2 9 22 2"/>
                            </svg>
                        </button>
                    </form>
                </div>

                @else
                {{-- No chat selected --}}
                <div class="chat-empty-state">
                    <div class="chat-empty-icon">💬</div>
                    <div class="chat-empty-text">Pilih tutor untuk memulai percakapan</div>
                    <div class="chat-empty-sub">Daftar tutor yang pernah Anda booking ada di sebelah kiri</div>
                </div>
                @endif

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

    // Auto-scroll to bottom of messages
    window.addEventListener('load', () => {
        const c = document.getElementById('chatMessages');
        if (c) c.scrollTop = c.scrollHeight;
    });
</script>
</body>
</html>
