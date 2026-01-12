@extends('layouts.app')

@section('title', $alat->nama_alat)

@section('sidebar')
    @include('peminjam.partials.sidebar')
@endsection

@section('content')
    <div class="mb-6">
        <a href="{{ route('peminjam.browse') }}"
            class="inline-flex items-center text-indigo-600 hover:text-indigo-700 font-medium">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Kembali ke Browse
        </a>
    </div>

    @if (session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Image Section -->
        <div class="card p-0 overflow-hidden">
            <div class="aspect-square bg-slate-100 relative">
                @if ($alat->gambar)
                    <img src="{{ asset('storage/' . $alat->gambar) }}" alt="{{ $alat->nama_alat }}"
                        class="w-full h-full object-cover">
                @else
                    <div class="absolute inset-0 flex items-center justify-center text-slate-300">
                        <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                @endif

                <div class="absolute top-4 right-4">
                    <span
                        class="px-3 py-2 text-sm font-bold rounded-lg shadow-lg {{ $alat->stok > 0 ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                        {{ $alat->stok > 0 ? 'Tersedia' : 'Habis' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Details Section -->
        <div class="space-y-6">
            <div>
                <p class="text-sm text-indigo-600 font-semibold mb-2 uppercase tracking-wide">
                    {{ $alat->kategori->nama_kategori }}
                </p>
                <h1 class="text-3xl font-bold text-slate-800 mb-4">{{ $alat->nama_alat }}</h1>
                <p class="text-slate-600 leading-relaxed">{{ $alat->deskripsi }}</p>
            </div>

            <div class="card p-6 bg-gradient-to-br from-indigo-50 to-purple-50 border-2 border-indigo-100">
                <div class="flex items-baseline gap-2 mb-2">
                    <span class="text-4xl font-bold text-indigo-600">
                        Rp {{ number_format($alat->harga_sewa_per_hari, 0, ',', '.') }}
                    </span>
                    <span class="text-slate-600">/ hari</span>
                </div>
                <p class="text-sm text-slate-500">Harga sewa per hari</p>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="card p-4">
                    <p class="text-sm text-slate-500 mb-1">Stok Tersedia</p>
                    <p class="text-2xl font-bold text-slate-800">{{ $alat->stok }} unit</p>
                </div>
                <div class="card p-4">
                    <p class="text-sm text-slate-500 mb-1">Kategori</p>
                    <p class="text-lg font-semibold text-slate-800">{{ $alat->kategori->nama_kategori }}</p>
                </div>
            </div>

            @if ($alat->stok > 0)
                <a href="{{ route('peminjam.create', ['alat' => $alat->id]) }}"
                    class="block w-full px-6 py-4 bg-indigo-600 text-white text-center rounded-lg hover:bg-indigo-700 transition font-bold text-lg shadow-lg hover:shadow-xl">
                    <svg class="w-6 h-6 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Ajukan Peminjaman
                </a>
            @else
                <button disabled
                    class="block w-full px-6 py-4 bg-slate-300 text-slate-500 text-center rounded-lg cursor-not-allowed font-bold text-lg">
                    Stok Habis
                </button>
            @endif

            <div class="card p-6 bg-slate-50">
                <h3 class="font-bold text-slate-800 mb-3">Informasi Peminjaman</h3>
                <ul class="space-y-2 text-sm text-slate-600">
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-indigo-600 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        Peminjaman akan diverifikasi oleh petugas
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-indigo-600 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        Pastikan mengembalikan alat sesuai jadwal
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-indigo-600 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        Keterlambatan akan dikenakan denda
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection
