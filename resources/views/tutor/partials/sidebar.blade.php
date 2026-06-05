{{-- resources/views/tutor/partials/sidebar.blade.php --}}
@php
    $currentRoute = Route::currentRouteName();
    $tutorUser    = \App\Models\Tutor::where('user_id', session('user.id'))->first();
    $tutorName    = $tutor->name ?? session('user.name') ?? 'Tutor';
    $initials     = strtoupper(implode('', array_map(fn($w) => $w[0] ?? '', array_slice(explode(' ', trim($tutorName)), 0, 2))));
@endphp

<aside class="siswa-sidebar">
    <div class="sidebar-profile">
        <img src="https://ui-avatars.com/api/?name={{ urlencode($tutorName) }}&background=000&color=fff&size=128"
             class="sidebar-avatar" alt="Avatar">
        <div class="sidebar-name">{{ explode(' ', trim($tutorName))[0] }}</div>
        <div class="sidebar-role" style="background:#000; color:#FBBF24;">TUTOR</div>
    </div>

    <nav class="sidebar-nav">
        {{-- Jadwal Saya --}}
        <a href="{{ route('tutor.jadwal') }}"
           class="sidebar-link {{ $currentRoute === 'tutor.jadwal' ? 'active' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                <line x1="16" y1="2" x2="16" y2="6"/>
                <line x1="8" y1="2" x2="8" y2="6"/>
                <line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
            Jadwal Saya
        </a>

        {{-- Pendapatan --}}
        <a href="{{ route('tutor.pendapatan') }}"
           class="sidebar-link {{ $currentRoute === 'tutor.pendapatan' ? 'active' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="1" x2="12" y2="23"/>
                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
            </svg>
            Pendapatan
        </a>

        {{-- Ulasan --}}
        <a href="{{ route('tutor.ulasan') }}"
           class="sidebar-link {{ $currentRoute === 'tutor.ulasan' ? 'active' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
            </svg>
            Ulasan Saya
        </a>

        {{-- Pesan --}}
        <a href="{{ route('tutor.pesan') }}"
           class="sidebar-link {{ $currentRoute === 'tutor.pesan' ? 'active' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
            </svg>
            Pesan
        </a>

        {{-- Pengaturan --}}
        <a href="{{ route('tutor.pengaturan') }}"
           class="sidebar-link {{ $currentRoute === 'tutor.pengaturan' ? 'active' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="3"/>
                <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/>
            </svg>
            Pengaturan
        </a>
    </nav>

    <form method="POST" action="{{ route('logout') }}" style="margin-top:auto; padding:24px;">
        @csrf
        <button type="submit" class="btn-outline"
                style="width:100%; border-color:transparent; color:#ef4444; font-weight:600;">
            Log out
        </button>
    </form>
</aside>
