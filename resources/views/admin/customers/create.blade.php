@extends('layouts.admin')

@section('title','Tambah Pelanggan - Klinik Cantik')

@section('content')
    <div class="bg-white rounded-lg shadow p-6 max-w-xl mx-auto">
        <h2 class="text-2xl font-bold text-rose-600">Tambah Pelanggan</h2>
        <p class="mt-2 text-gray-600">Masukkan data pelanggan baru.</p>

        <form method="POST" action="{{ route('admin.customers.store') }}" class="mt-6 space-y-4">
            @csrf
            <label class="block">
                <span class="text-gray-700">Nama</span>
                <input type="text" name="name" value="{{ old('name') }}" class="mt-1 w-full rounded border-gray-300 shadow-sm" required>
            </label>
            <label class="block">
                <span class="text-gray-700">Telepon</span>
                <input type="text" name="phone" value="{{ old('phone') }}" class="mt-1 w-full rounded border-gray-300 shadow-sm">
            </label>
            <label class="block">
                <span class="text-gray-700">Email</span>
                <input type="email" name="email" value="{{ old('email') }}" class="mt-1 w-full rounded border-gray-300 shadow-sm">
            </label>
            <label class="block">
                <span class="text-gray-700">Catatan</span>
                <textarea name="notes" class="mt-1 w-full rounded border-gray-300 shadow-sm">{{ old('notes') }}</textarea>
            </label>
            <label class="flex items-center gap-3 text-gray-700">
                <input type="checkbox" name="is_member" value="1" {{ old('is_member') ? 'checked' : '' }} class="h-4 w-4 rounded border-gray-300 text-rose-600 focus:ring-rose-500">
                <span>Daftarkan sebagai member</span>
            </label>
            <div class="flex items-center justify-between">
                <a href="{{ route('admin.customers.index') }}" class="text-rose-600 hover:underline">Batal</a>
                <button class="bg-pink-500 text-white px-4 py-2 rounded-lg">Simpan</button>
            </div>
        </form>
    </div>
@endsection

