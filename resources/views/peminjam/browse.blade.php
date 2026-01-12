@extends('layouts.app')

@section('title', 'Browse Alat')

@section('sidebar')
    @include('peminjam.partials.sidebar')
@endsection

@section('content')
    <!-- Professional Hero Banner -->
    <div class="relative w-full rounded-2xl bg-gradient-to-br from-indigo-600 to-purple-700 overflow-hidden mb-8 shadow-xl">
        <div class="relative z-10 p-10 md:p-12 flex flex-col justify-center min-h-[200px]">
            <span
                class="inline-block py-1 px-3 rounded-full bg-white/20 border border-white/30 text-xs font-bold tracking-widest text-white mb-3 uppercase w-fit">Laboratorium</span>
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-2 leading-tight">Temukan Alat<br>Yang Anda Butuhkan
            </h2>
            <p class="text-indigo-100 text-lg max-w-lg">Cari dan pinjam alat laboratorium untuk menunjang produktivitas
                kerja Anda.</p>
        </div>

        <!-- Subtle Pattern -->
        <div class="absolute right-0 top-0 h-full w-1/2 opacity-10">
            <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                        <path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="1" />
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#grid)" />
            </svg>
        </div>
    </div>

    <!-- Search and Filter -->
    <form method="GET" action="{{ route('peminjam.browse') }}" class="mb-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="md:col-span-2">
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari nama alat atau deskripsi..."
                        class="w-full pl-10 pr-4 py-3 rounded-lg border border-slate-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 outline-none">
                    <svg class="w-5 h-5 text-slate-400 absolute left-3 top-3.5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>

            <div>
                <select name="kategori"
                    class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                    <option value="">Semua Kategori</option>
                    @foreach ($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" {{ request('kategori') == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit"
                    class="flex-1 px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-medium">
                    Cari
                </button>
                @if (request('search') || request('kategori') || request('available'))
                    <a href="{{ route('peminjam.browse') }}"
                        class="px-4 py-3 bg-slate-100 text-slate-600 rounded-lg hover:bg-slate-200 transition font-medium">
                        Reset
                    </a>
                @endif
            </div>
        </div>

        <div class="mt-4">
            <label class="inline-flex items-center">
                <input type="checkbox" name="available" value="1" {{ request('available') == '1' ? 'checked' : '' }}
                    class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                <span class="ml-2 text-sm text-slate-600">Hanya tampilkan alat yang tersedia</span>
            </label>
        </div>
    </form>

    <!-- Results Info -->
    <div class="flex justify-between items-center mb-6">
        <p class="text-slate-600">
            Menampilkan <span class="font-semibold">{{ $alats->count() }}</span> dari <span
                class="font-semibold">{{ $alats->total() }}</span> alat
        </p>
    </div>

    <!-- Grid Layout -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
        @forelse ($alats as $alat)
            <a href="{{ route('peminjam.alat.show', $alat) }}"
                class="card p-0 flex flex-col h-full group overflow-hidden hover:shadow-xl transition-all">
                <div class="relative aspect-[4/3] bg-slate-100 overflow-hidden">
                    @if ($alat->gambar)
                        <img src="{{ asset('storage/' . $alat->gambar) }}" alt="{{ $alat->nama_alat }}"
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    @else
                        <div class="absolute inset-0 flex items-center justify-center bg-slate-100 text-slate-300">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                    @endif

                    <div class="absolute top-3 right-3">
                        <span
                            class="px-2 py-1 text-xs font-bold rounded-md shadow-sm {{ $alat->stok > 0 ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                            {{ $alat->stok > 0 ? 'Tersedia' : 'Habis' }}
                        </span>
                    </div>
                </div>

                <div class="p-4 flex-1 flex flex-col">
                    <div class="mb-4">
                        <p class="text-xs text-indigo-600 font-semibold mb-1 uppercase tracking-wide">
                            {{ $alat->kategori->nama_kategori }}</p>
                        <h3 class="font-bold text-slate-800 text-lg leading-tight mb-1">{{ $alat->nama_alat }}</h3>
                        <p class="text-sm text-slate-500 line-clamp-2">{{ $alat->deskripsi }}</p>
                    </div>

                    <div class="mt-auto flex items-center justify-between pt-4 border-t border-slate-100">
                        <div>
                            <p class="text-slate-900 font-bold text-lg">
                                Rp {{ number_format($alat->harga_sewa_per_hari, 0, ',', '.') }}
                            </p>
                            <p class="text-xs text-slate-500">per hari</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-sm text-slate-600">Stok: {{ $alat->stok }}</span>
                        </div>
                    </div>
                </div>
            </a>
        @empty
            <div class="col-span-full">
                <div class="card p-12 text-center">
                    <svg class="w-16 h-16 mx-auto text-slate-300 mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="text-xl font-bold text-slate-800 mb-2">Tidak ada alat ditemukan</h3>
                    <p class="text-slate-600 mb-4">Coba ubah filter atau kata kunci pencarian Anda</p>
                    <a href="{{ route('peminjam.browse') }}"
                        class="inline-block px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                        Reset Pencarian
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if ($alats->hasPages())
        <div class="mt-8">
            {{ $alats->links() }}
        </div>
    @endif
@endsection
