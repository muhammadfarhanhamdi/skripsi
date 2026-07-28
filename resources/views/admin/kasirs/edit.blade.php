@extends('layouts.admin')

@section('title','Edit Kasir - Klinik Cantik')

@section('content')
    <div class="bg-white rounded-lg shadow p-6 max-w-xl mx-auto">
        <h2 class="text-2xl font-bold text-rose-600">Edit Kasir</h2>
        <p class="mt-2 text-gray-600">Perbarui informasi kasir.</p>

        <form method="POST" action="{{ route('admin.kasirs.update', $kasir) }}" class="mt-6 space-y-4">
            @csrf
            @method('PUT')
            <label class="block">
                <span class="text-gray-700">Nama</span>
                <input type="text" name="name" value="{{ old('name', $kasir->name) }}" class="mt-1 w-full rounded border-gray-300 shadow-sm" required>
            </label>
            <label class="block">
                <span class="text-gray-700">Email</span>
                <input type="email" name="email" value="{{ old('email', $kasir->email) }}" class="mt-1 w-full rounded border-gray-300 shadow-sm" required>
            </label>
            <label class="block">
                <span class="text-gray-700">Password Baru (opsional)</span>
                <input type="password" name="password" class="mt-1 w-full rounded border-gray-300 shadow-sm">
            </label>
            <label class="block">
                <span class="text-gray-700">Konfirmasi Password</span>
                <input type="password" name="password_confirmation" class="mt-1 w-full rounded border-gray-300 shadow-sm">
            </label>
            <div class="flex items-center justify-between">
                <a href="{{ route('admin.kasirs.index') }}" class="text-rose-600 hover:underline">Batal</a>
                <button class="bg-pink-500 text-white px-4 py-2 rounded-lg">Perbarui</button>
            </div>
        </form>
    </div>
@endsection

