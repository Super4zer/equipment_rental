@extends('layouts.app')

@section('title', 'Data Alat')

@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@section('content')
    <div class="card p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-slate-800">Data Alat</h2>
            <a href="{{ route('alat.create') }}"
                class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-medium text-sm">Tambah
                Alat</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 text-xs uppercase tracking-wider">
                        <th class="p-4 font-semibold">Gambar</th>
                        <th class="p-4 font-semibold">Nama Alat</th>
                        <th class="p-4 font-semibold">Kategori</th>
                        <th class="p-4 font-semibold">Stok</th>
                        <th class="p-4 font-semibold">Harga / Hari</th>
                        <th class="p-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($alats as $item)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="p-4">
                                @if ($item->gambar)
                                    <img src="{{ $item->gambar }}" alt="{{ $item->nama_alat }}"
                                        class="w-12 h-12 object-cover rounded-lg border border-slate-200">
                                @else
                                    <div
                                        class="w-12 h-12 bg-slate-100 rounded-lg flex items-center justify-center text-slate-400">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                @endif
                            </td>
                            <td class="p-4 text-slate-800 font-medium">{{ $item->nama_alat }}</td>
                            <td class="p-4 text-slate-600">{{ $item->kategori->nama_kategori }}</td>
                            <td class="p-4">
                                <span
                                    class="px-2 py-1 text-xs font-semibold rounded-full {{ $item->stok > 0 ? 'bg-emerald-100 text-emerald-600' : 'bg-red-100 text-red-600' }}">
                                    {{ $item->stok }} Tersedia
                                </span>
                            </td>
                            <td class="p-4 text-slate-700 font-medium">Rp
                                {{ number_format($item->harga_sewa_per_hari, 0, ',', '.') }}</td>
                            <td class="p-4 text-right flex justify-end gap-2 items-center h-full">
                                <a href="{{ route('alat.edit', $item) }}"
                                    class="text-indigo-600 hover:text-indigo-800 font-medium text-sm">Edit</a>
                                <form action="{{ route('alat.destroy', $item) }}" method="POST" class="inline"
                                    onsubmit="return confirm('Yakin ingin menghapus?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-rose-600 hover:text-rose-800 font-medium text-sm ml-2">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
