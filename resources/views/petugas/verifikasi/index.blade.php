@extends('layouts.app')

@section('title', 'Verifikasi Peminjaman')

@section('sidebar')
    @include('petugas.partials.sidebar')
@endsection

@section('content')
    <div class="card p-6">
        <h2 class="text-xl font-bold text-slate-800 mb-6">Permintaan Peminjaman Menunggu Persetujuan</h2>

        @if ($peminjamans->isEmpty())
            <div class="text-center py-12">
                <div
                    class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-400">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-slate-900">Semua Beres!</h3>
                <p class="text-slate-500">Tidak ada permintaan peminjaman baru saat ini.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 text-xs uppercase tracking-wider">
                            <th class="p-4 font-semibold">User</th>
                            <th class="p-4 font-semibold">Alat</th>
                            <th class="p-4 font-semibold">Tanggal Pinjam</th>
                            <th class="p-4 font-semibold">Durasi</th>
                            <th class="p-4 font-semibold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($peminjamans as $pinjam)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="p-4">
                                    <div class="font-medium text-slate-800">{{ $pinjam->user->name }}</div>
                                    <div class="text-xs text-slate-500">{{ $pinjam->user->email }}</div>
                                </td>
                                <td class="p-4">
                                    <div class="font-medium text-slate-800">{{ $pinjam->alat->nama_alat }}</div>
                                    <div class="text-xs text-slate-500">{{ $pinjam->jumlah }} unit</div>
                                </td>
                                <td class="p-4 text-slate-700">
                                    {{ $pinjam->tanggal_pinjam->format('d M Y') }}
                                </td>
                                <td class="p-4 text-slate-700">
                                    {{ $pinjam->tanggal_pinjam->diffInDays($pinjam->tanggal_kembali) }} Hari
                                    <div class="text-xs text-slate-500">Kembali:
                                        {{ $pinjam->tanggal_kembali->format('d M') }}</div>
                                </td>
                                <td class="p-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        <form action="{{ route('verifikasi.approve', $pinjam) }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="px-3 py-1.5 bg-emerald-600 text-white rounded text-sm font-medium hover:bg-emerald-700 transition">Setuju</button>
                                        </form>

                                        <button
                                            onclick="document.getElementById('reject-modal-{{ $pinjam->id }}').classList.remove('hidden')"
                                            class="px-3 py-1.5 bg-rose-100 text-rose-600 rounded text-sm font-medium hover:bg-rose-200 transition">Tolak</button>
                                    </div>

                                    <!-- Reject Moral -->
                                    <div id="reject-modal-{{ $pinjam->id }}"
                                        class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
                                        <div class="bg-white rounded-xl shadow-xl max-w-sm w-full p-6 text-left">
                                            <h3 class="text-lg font-bold text-slate-900 mb-4">Tolak Peminjaman</h3>
                                            <form action="{{ route('verifikasi.reject', $pinjam) }}" method="POST">
                                                @csrf
                                                <div class="mb-4">
                                                    <label class="block text-sm font-medium text-slate-700 mb-2">Alasan
                                                        Penolakan</label>
                                                    <textarea name="reason" rows="3"
                                                        class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none"
                                                        required></textarea>
                                                </div>
                                                <div class="flex justify-end gap-2">
                                                    <button type="button"
                                                        onclick="document.getElementById('reject-modal-{{ $pinjam->id }}').classList.add('hidden')"
                                                        class="px-4 py-2 text-slate-600 hover:bg-slate-100 rounded-lg">Batal</button>
                                                    <button type="submit"
                                                        class="px-4 py-2 bg-rose-600 text-white rounded-lg hover:bg-rose-700">Kirim
                                                        Penolakan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
