@extends('layouts.app')

@section('title', 'Discover Tools')

@section('sidebar')
    @include('peminjam.partials.sidebar')
@endsection

@section('content')
    <!-- Professional Hero Banner -->
    <div class="relative w-full rounded-2xl bg-slate-900 overflow-hidden mb-10 shadow-xl">
        <div class="relative z-10 p-10 md:p-14 flex flex-col justify-center min-h-[220px]">
            <span
                class="inline-block py-1 px-3 rounded-full bg-indigo-500/20 border border-indigo-500/30 text-xs font-bold tracking-widest text-indigo-300 mb-4 uppercase w-fit">Laboratorium</span>
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-2 leading-tight">Peminjaman Alat <br>Untuk Profesional.
            </h2>
            <p class="text-slate-400 text-lg max-w-lg mb-6">Temukan alat yang anda butuhkan untuk menunjang produktivitas
                kerja.</p>
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

    <!-- Toolbar -->
    <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mb-8">
        <div class="flex overflow-x-auto pb-2 gap-2 custom-scrollbar w-full sm:w-auto">
            <button class="px-4 py-2 bg-slate-800 text-white rounded-lg text-sm font-semibold shadow-sm">All Tools</button>
            <button
                class="px-4 py-2 bg-white text-slate-600 border border-slate-200 rounded-lg text-sm font-semibold hover:bg-slate-50 transition">Photography</button>
            <button
                class="px-4 py-2 bg-white text-slate-600 border border-slate-200 rounded-lg text-sm font-semibold hover:bg-slate-50 transition">Videography</button>
            <button
                class="px-4 py-2 bg-white text-slate-600 border border-slate-200 rounded-lg text-sm font-semibold hover:bg-slate-50 transition">Audio</button>
        </div>

        <div class="relative w-full sm:w-64">
            <input type="text" placeholder="Search tools..."
                class="w-full pl-10 pr-4 py-2 rounded-lg border border-slate-300 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none text-sm">
            <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>
    </div>

    <!-- Grid Layout -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach (\App\Models\Alat::all() as $alat)
            <div class="card p-0 flex flex-col h-full group overflow-hidden hover:shadow-lg transition-shadow">
                <div class="relative aspect-[4/3] bg-slate-100 overflow-hidden">
                    @if ($alat->gambar)
                        <img src="{{ $alat->gambar }}" alt="{{ $alat->nama_alat }}"
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
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
                            {{ $alat->stok > 0 ? 'Available' : 'Out of Stock' }}
                        </span>
                    </div>
                </div>

                <div class="p-4 flex-1 flex flex-col">
                    <div class="mb-4">
                        <p class="text-xs text-indigo-600 font-semibold mb-1 uppercase tracking-wide">
                            {{ $alat->kategori->nama_kategori }}</p>
                        <h3 class="font-bold text-slate-800 text-lg leading-tight mb-1">{{ $alat->nama_alat }}</h3>
                    </div>

                    <div class="mt-auto flex items-center justify-between pt-4 border-t border-slate-100">
                        <p class="text-slate-900 font-bold text-lg">
                            Rp {{ number_format($alat->harga_sewa_per_hari, 0, ',', '.') }} <span
                                class="text-xs font-normal text-slate-500">/ hari</span>
                        </p>
                        <button
                            class="p-2 rounded-lg bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                                </path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
