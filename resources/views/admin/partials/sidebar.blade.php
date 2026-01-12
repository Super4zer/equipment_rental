<a href="{{ route('dashboard') }}"
    class="{{ request()->routeIs('dashboard') ? 'nav-link-active' : 'nav-link-inactive' }} flex items-center gap-3 px-4 py-3 rounded-md mb-1 text-sm transition-colors">
    <svg class="w-5 h-5 {{ request()->routeIs('dashboard') ? 'text-indigo-600' : '' }}" fill="none"
        stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
        </path>
    </svg>
    Dashboard
</a>

@if (Auth::user()->isAdmin() || Auth::user()->isPetugas())
    <a href="{{ route('users.index') }}"
        class="{{ request()->routeIs('users.*') ? 'nav-link-active' : 'nav-link-inactive' }} flex items-center gap-3 px-4 py-3 rounded-md mb-1 text-sm transition-colors">
        <svg class="w-5 h-5 {{ request()->routeIs('users.*') ? 'text-indigo-600' : '' }}" fill="none"
            stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
            </path>
        </svg>
        Kelola User
    </a>
    <a href="{{ route('kategori.index') }}"
        class="{{ request()->routeIs('kategori.*') ? 'nav-link-active' : 'nav-link-inactive' }} flex items-center gap-3 px-4 py-3 rounded-md mb-1 text-sm transition-colors">
        <svg class="w-5 h-5 {{ request()->routeIs('kategori.*') ? 'text-indigo-600' : '' }}" fill="none"
            stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
            </path>
        </svg>
        Kategori Alat
    </a>
    <a href="{{ route('alat.index') }}"
        class="{{ request()->routeIs('alat.*') ? 'nav-link-active' : 'nav-link-inactive' }} flex items-center gap-3 px-4 py-3 rounded-md mb-1 text-sm transition-colors">
        <svg class="w-5 h-5 {{ request()->routeIs('alat.*') ? 'text-indigo-600' : '' }}" fill="none"
            stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z">
            </path>
        </svg>
        Data Alat
    </a>
@endif
