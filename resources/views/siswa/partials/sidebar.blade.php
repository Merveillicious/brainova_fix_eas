{{-- resources/views/siswa/partials/sidebar.blade.php --}}
@php
    $currentRoute = Route::currentRouteName();
@endphp

<aside class="siswa-sidebar">
    <div class="sidebar-profile">
        <img src="https://ui-avatars.com/api/?name={{ urlencode($student->name ?? 'S') }}&background=000&color=fff"
             class="sidebar-avatar" alt="Avatar">
        <div class="sidebar-name">{{ explode(' ', trim($student->name ?? 'Siswa'))[0] }}</div>
        <div class="sidebar-role">Siswa</div>
    </div>

    <nav class="sidebar-nav">
        {{-- Beranda --}}
        <a href="{{ route('siswa.dashboard') }}"
           class="sidebar-link {{ $currentRoute === 'siswa.dashboard' ? 'active' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                <polyline points="9 22 9 12 15 12 15 22"/>
            </svg>
            Beranda
        </a>

        {{-- Jadwal Kelas --}}
        <a href="{{ route('siswa.jadwal') }}"
           class="sidebar-link {{ $currentRoute === 'siswa.jadwal' ? 'active' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                <line x1="16" y1="2" x2="16" y2="6"/>
                <line x1="8" y1="2" x2="8" y2="6"/>
                <line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
            Jadwal Kelas
        </a>

        {{-- Pembayaran --}}
        <a href="{{ route('siswa.pembayaran') }}"
           class="sidebar-link {{ $currentRoute === 'siswa.pembayaran' ? 'active' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="5" width="20" height="14" rx="2"/>
                <line x1="2" y1="10" x2="22" y2="10"/>
            </svg>
            Pembayaran
        </a>

        {{-- Ulasan Saya --}}
        <a href="{{ route('siswa.ulasan') }}"
           class="sidebar-link {{ $currentRoute === 'siswa.ulasan' ? 'active' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
            </svg>
            Ulasan Saya
        </a>

        {{-- Pesan --}}
        <a href="{{ route('siswa.pesan') }}"
           class="sidebar-link {{ $currentRoute === 'siswa.pesan' ? 'active' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
            </svg>
            Pesan
        </a>

        {{-- Pengaturan --}}
        <a href="{{ route('siswa.pengaturan') }}"
           class="sidebar-link {{ $currentRoute === 'siswa.pengaturan' ? 'active' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="3"/>
                <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/>
            </svg>
            Pengaturan
        </a>

        {{-- Logout --}}
        <div style="padding: 4px 16px; margin-top: 4px;">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        style="width:100%; display:flex; align-items:center; gap:12px; padding:10px 12px; background:none; border:none; border-radius:10px; font-size:14px; font-weight:600; color:#ef4444; cursor:pointer; font-family:inherit; transition:background .15s;"
                        onmouseover="this.style.background='#fef2f2'"
                        onmouseout="this.style.background='none'">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                        <polyline points="16 17 21 12 16 7"/>
                        <line x1="21" y1="12" x2="9" y2="12"/>
                    </svg>
                    Log out
                </button>
            </form>
        </div>
    </nav>
</aside>
