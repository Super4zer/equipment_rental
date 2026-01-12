@extends('layouts.app')

@section('title', 'Favorites')

@section('sidebar')
    @include('peminjam.partials.sidebar')
@endsection

@section('content')
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-slate-800 mb-2">Alat Favorit</h2>
        <p class="text-slate-600">Alat-alat yang tersedia dan mungkin Anda sukai</p>
    </div>

    <!-- Grid Layout -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
        @forelse ($favorites as $alat)
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

                    <!-- Favorite Heart Icon -->
                    <div class="absolute top-3 left-3">
                        <button
                            class="w-8 h-8 rounded-full bg-white/90 backdrop-blur-sm flex items-center justify-center hover:bg-white transition">
                            <svg class="w-5 h-5 text-red-500 fill-current" fill="currentColor" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                </path>
                            </svg>
                        </button>
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
                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                        </path>
                    </svg>
                    <h3 class="text-xl font-bold text-slate-800 mb-2">Belum ada favorit</h3>
                    <p class="text-slate-600 mb-4">Mulai tambahkan alat ke favorit Anda</p>
                    <a href="{{ route('peminjam.browse') }}"
                        class="inline-block px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                        Browse Alat
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if ($favorites->hasPages())
        <div class="mt-8">
            {{ $favorites->links() }}
        </div>
    @endif
@endsection
