@extends('layouts.app')

@section('title', 'Notifikasi')

@section('sidebar')
    @include('peminjam.partials.sidebar')
@endsection

@section('content')
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-slate-800 mb-2">Notifikasi</h2>
        <p class="text-slate-600">Lihat semua notifikasi terkait peminjaman Anda</p>
    </div>

    <div class="space-y-4">
        @forelse ($notifications as $notification)
            <div class="card p-6 {{ $notification->is_read ? 'bg-white' : 'bg-indigo-50 border-l-4 border-indigo-600' }}">
                <div class="flex items-start gap-4">
                    <!-- Icon -->
                    <div class="flex-shrink-0">
                        @if ($notification->type == 'peminjaman_disetujui')
                            <div class="w-12 h-12 rounded-full bg-emerald-100 flex items-center justify-center">
                                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                        @elseif ($notification->type == 'peminjaman_ditolak')
                            <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center">
                                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </div>
                        @elseif ($notification->type == 'pengembalian_diproses')
                            <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        @else
                            <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center">
                                <svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                                    </path>
                                </svg>
                            </div>
                        @endif
                    </div>

                    <!-- Content -->
                    <div class="flex-1">
                        <div class="flex items-start justify-between mb-2">
                            <h3 class="font-bold text-slate-800 text-lg">{{ $notification->title }}</h3>
                            @if (!$notification->is_read)
                                <span class="px-2 py-1 text-xs font-bold bg-indigo-600 text-white rounded-full">Baru</span>
                            @endif
                        </div>

                        <p class="text-slate-600 mb-3">{{ $notification->message }}</p>

                        @if ($notification->peminjaman)
                            <div class="bg-slate-50 rounded-lg p-4 mb-3">
                                <div class="grid grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <p class="text-slate-500 mb-1">Alat</p>
                                        <p class="font-semibold text-slate-800">
                                            {{ $notification->peminjaman->alat->nama_alat }}</p>
                                    </div>
                                    <div>
                                        <p class="text-slate-500 mb-1">Jumlah</p>
                                        <p class="font-semibold text-slate-800">{{ $notification->peminjaman->jumlah }} unit
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-slate-500 mb-1">Tanggal Pinjam</p>
                                        <p class="font-semibold text-slate-800">
                                            {{ \Carbon\Carbon::parse($notification->peminjaman->tanggal_pinjam)->format('d M Y') }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-slate-500 mb-1">Tanggal Kembali</p>
                                        <p class="font-semibold text-slate-800">
                                            {{ \Carbon\Carbon::parse($notification->peminjaman->tanggal_kembali)->format('d M Y') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="flex items-center justify-between">
                            <p class="text-xs text-slate-500">
                                {{ $notification->created_at->diffForHumans() }}
                            </p>

                            @if ($notification->peminjaman)
                                <a href="{{ route('peminjam.bookings') }}"
                                    class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">
                                    Lihat Detail Peminjaman →
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="card p-12 text-center">
                <svg class="w-16 h-16 mx-auto text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                    </path>
                </svg>
                <h3 class="text-xl font-bold text-slate-800 mb-2">Belum ada notifikasi</h3>
                <p class="text-slate-600 mb-4">Notifikasi akan muncul di sini ketika ada update peminjaman</p>
                <a href="{{ route('peminjam.browse') }}"
                    class="inline-block px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                    Browse Alat
                </a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if ($notifications->hasPages())
        <div class="mt-8">
            {{ $notifications->links() }}
        </div>
    @endif
@endsection
