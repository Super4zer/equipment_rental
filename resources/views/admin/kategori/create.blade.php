@extends('layouts.app')

@section('title', 'Tambah Kategori')

@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="card p-6">
            <h2 class="text-xl font-bold text-slate-800 mb-6">Tambah Kategori Baru</h2>

            <form action="{{ route('kategori.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Nama Kategori</label>
                    <input type="text" name="nama_kategori"
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"
                        required>
                </div>

                <div class="flex justify-end gap-3 pt-4">
                    <a href="{{ route('kategori.index') }}"
                        class="px-4 py-2 bg-slate-100 text-slate-600 rounded-lg hover:bg-slate-200 transition font-medium">Batal</a>
                    <button type="submit"
                        class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-medium">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
