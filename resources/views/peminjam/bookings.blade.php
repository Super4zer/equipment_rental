@extends('layouts.app')

@section('title', 'My Bookings')

@section('sidebar')
    @include('peminjam.partials.sidebar')
@endsection

@section('content')
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-slate-800 mb-2">Peminjaman Saya</h2>
        <p class="text-slate-600">Kelola dan pantau semua peminjaman alat Anda</p>
    </div>

    @if (session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="space-y-4">
        @forelse ($peminjamans as $peminjaman)
            <div class="card p-6">
                <div class="flex flex-col md:flex-row gap-6">
                    <!-- Alat Image -->
                    <div class="w-full md:w-48 h-48 bg-slate-100 rounded-lg overflow-hidden flex-shrink-0">
                        @if ($peminjaman->alat->gambar)
                            <img src="{{ asset('storage/' . $peminjaman->alat->gambar) }}"
                                alt="{{ $peminjaman->alat->nama_alat }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-300">
                                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                        @endif
                    </div>

                    <!-- Booking Details -->
                    <div class="flex-1">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-xl font-bold text-slate-800 mb-1">{{ $peminjaman->alat->nama_alat }}</h3>
                                <p class="text-sm text-slate-500">{{ $peminjaman->alat->kategori->nama_kategori }}</p>
                            </div>
                            <span
                                class="px-3 py-1 text-xs font-bold rounded-full 
                                {{ $peminjaman->status == 'menunggu' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                {{ $peminjaman->status == 'disetujui' ? 'bg-blue-100 text-blue-700' : '' }}
                                {{ $peminjaman->status == 'kembali' ? 'bg-emerald-100 text-emerald-700' : '' }}
                                {{ $peminjaman->status == 'ditolak' ? 'bg-red-100 text-red-700' : '' }}
                            ">
                                {{ ucfirst($peminjaman->status) }}
                            </span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                            <div>
                                <p class="text-xs text-slate-500 mb-1">Tanggal Pinjam</p>
                                <p class="font-semibold text-slate-800">
                                    {{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y') }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 mb-1">Tanggal Kembali</p>
                                <p class="font-semibold text-slate-800">
                                    {{ \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d M Y') }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 mb-1">Jumlah</p>
                                <p class="font-semibold text-slate-800">{{ $peminjaman->jumlah }} unit</p>
                            </div>
                        </div>

                        @if ($peminjaman->catatan)
                            <div class="bg-slate-50 rounded-lg p-3 mb-4">
                                <p class="text-xs text-slate-500 mb-1">Catatan</p>
                                <p class="text-sm text-slate-700">{{ $peminjaman->catatan }}</p>
                            </div>
                        @endif

                        <div class="flex items-center justify-between pt-4 border-t border-slate-100">
                            <div>
                                <p class="text-sm text-slate-500">Total Biaya</p>
                                <p class="text-2xl font-bold text-indigo-600">
                                    Rp {{ number_format($peminjaman->total_biaya, 0, ',', '.') }}
                                </p>
                            </div>

                            <div class="text-xs text-slate-500">
                                Dibuat: {{ $peminjaman->created_at->format('d M Y, H:i') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="card p-12 text-center">
                <svg class="w-16 h-16 mx-auto text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                    </path>
                </svg>
                <h3 class="text-xl font-bold text-slate-800 mb-2">Belum ada peminjaman</h3>
                <p class="text-slate-600 mb-4">Anda belum melakukan peminjaman alat apapun</p>
                <a href="{{ route('peminjam.browse') }}"
                    class="inline-block px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                    Mulai Browse Alat
                </a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if ($peminjamans->hasPages())
        <div class="mt-8">
            {{ $peminjamans->links() }}
        </div>
    @endif
@endsection
