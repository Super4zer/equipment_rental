@extends('layouts.app')

@section('title', 'Kategori Alat')

@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@section('content')
    <div class="card p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-slate-800">Daftar Kategori</h2>
            <a href="{{ route('kategori.create') }}"
                class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-medium text-sm">Tambah
                Kategori</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 text-xs uppercase tracking-wider">
                        <th class="p-4 font-semibold">Nama Kategori</th>
                        <th class="p-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($kategori as $cat)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="p-4 text-slate-800 font-medium">{{ $cat->nama_kategori }}</td>
                            <td class="p-4 text-right flex justify-end gap-2">
                                <a href="{{ route('kategori.edit', $cat) }}"
                                    class="text-indigo-600 hover:text-indigo-800 font-medium text-sm">Edit</a>
                                <form action="{{ route('kategori.destroy', $cat) }}" method="POST" class="inline"
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
