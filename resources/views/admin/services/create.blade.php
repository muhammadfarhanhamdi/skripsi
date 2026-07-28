@extends('layouts.admin')

@section('title','Tambah Layanan - Klinik Cantik')

@section('content')
    <div class="bg-white rounded-lg shadow p-6 max-w-xl mx-auto">
        <h2 class="text-2xl font-bold text-rose-600">Tambah Layanan</h2>
        <p class="mt-2 text-gray-600">Tambahkan treatment baru ke menu layanan.</p>

        <form method="POST" action="{{ route('admin.services.store') }}" class="mt-6 space-y-4">
            @csrf
            <label class="block">
                <span class="text-gray-700">Nama Layanan</span>
                <input type="text" name="name" value="{{ old('name') }}" class="mt-1 w-full rounded border-gray-300 shadow-sm" required>
            </label>
            <label class="block">
                <span class="text-gray-700">Deskripsi</span>
                <textarea name="description" class="mt-1 w-full rounded border-gray-300 shadow-sm">{{ old('description') }}</textarea>
            </label>
            <label class="block">
                <span class="text-gray-700">Harga</span>
                <input type="number" name="price" value="{{ old('price') }}" step="0.01" class="mt-1 w-full rounded border-gray-300 shadow-sm" required>
            </label>
            <label class="block">
                <span class="text-gray-700">Durasi</span>
                <input type="text" name="duration" value="{{ old('duration') }}" class="mt-1 w-full rounded border-gray-300 shadow-sm">
            </label>
            <div class="flex items-center justify-between">
                <a href="{{ route('admin.services.index') }}" class="text-rose-600 hover:underline">Batal</a>
                <button class="bg-pink-500 text-white px-4 py-2 rounded-lg">Simpan</button>
            </div>
        </form>
    </div>
@endsection

