<a href="{{ route('peminjam.browse') }}"
    class="{{ request()->routeIs('peminjam.browse') ? 'nav-link-active' : 'nav-link-inactive' }} flex items-center gap-3 px-4 py-3 rounded-md mb-1 text-sm transition-colors">
    <svg class="w-5 h-5 {{ request()->routeIs('peminjam.browse') ? 'text-indigo-600' : '' }}" fill="none"
        stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z">
        </path>
    </svg>
    Browse Alat
</a>

<a href="{{ route('peminjam.bookings') }}"
    class="{{ request()->routeIs('peminjam.bookings') ? 'nav-link-active' : 'nav-link-inactive' }} flex items-center gap-3 px-4 py-3 rounded-md mb-1 text-sm transition-colors">
    <svg class="w-5 h-5 {{ request()->routeIs('peminjam.bookings') ? 'text-indigo-600' : '' }}" fill="none"
        stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z">
        </path>
    </svg>
    My Bookings
</a>

<a href="{{ route('peminjam.favorites') }}"
    class="{{ request()->routeIs('peminjam.favorites') ? 'nav-link-active' : 'nav-link-inactive' }} flex items-center gap-3 px-4 py-3 rounded-md mb-1 text-sm transition-colors">
    <svg class="w-5 h-5 {{ request()->routeIs('peminjam.favorites') ? 'text-indigo-600' : '' }}" fill="none"
        stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
        </path>
    </svg>
    Favorites
</a>

<a href="{{ route('peminjam.notifications') }}"
    class="{{ request()->routeIs('peminjam.notifications') ? 'nav-link-active' : 'nav-link-inactive' }} flex items-center gap-3 px-4 py-3 rounded-md mb-1 text-sm transition-colors">
    <svg class="w-5 h-5 {{ request()->routeIs('peminjam.notifications') ? 'text-indigo-600' : '' }}" fill="none"
        stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
        </path>
    </svg>
    Notifikasi
</a>
