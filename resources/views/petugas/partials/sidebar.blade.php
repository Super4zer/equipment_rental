<a href="{{ route('dashboard') }}"
    class="{{ request()->routeIs('dashboard') ? 'nav-link-active' : 'nav-link-inactive' }} flex items-center gap-3 px-4 py-3 rounded-md mb-1 text-sm transition-colors">
    <svg class="w-5 h-5 {{ request()->routeIs('dashboard') ? 'text-indigo-600' : '' }}" fill="none"
        stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
        </path>
    </svg>
    Overview
</a>
<a href="{{ route('verifikasi.index') }}"
    class="{{ request()->routeIs('verifikasi.*') ? 'nav-link-active' : 'nav-link-inactive' }} flex items-center gap-3 px-4 py-3 rounded-md mb-1 text-sm transition-colors">
    <svg class="w-5 h-5 {{ request()->routeIs('verifikasi.*') ? 'text-indigo-600' : '' }}" fill="none"
        stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
    </svg>
    Verifikasi Pinjam
</a>
<a href="{{ route('pengembalian.index') }}"
    class="{{ request()->routeIs('pengembalian.*') ? 'nav-link-active' : 'nav-link-inactive' }} flex items-center gap-3 px-4 py-3 rounded-md mb-1 text-sm transition-colors">
    <svg class="w-5 h-5 {{ request()->routeIs('pengembalian.*') ? 'text-indigo-600' : '' }}" fill="none"
        stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
    </svg>
    Pengembalian
</a>
