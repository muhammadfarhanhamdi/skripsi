@extends('layouts.clinic')

@section('title','Buat Kasir - Klinik Cantik')

@section('content')
    <div class="max-w-md mx-auto bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-semibold mb-4 text-rose-600">Buat Akun Kasir</h2>
        <p class="text-sm text-gray-500 mb-4">Hanya admin yang dapat membuat akun kasir.</p>
        <form method="POST" action="{{ route('admin.kasir.store') }}">
            @csrf
            <label class="block mb-3">Nama Kasir
                <input type="text" name="name" value="{{ old('name') }}" class="w-full border p-2 rounded" required>
            </label>
            <label class="block mb-3">Email Kasir
                <input type="email" name="email" value="{{ old('email') }}" class="w-full border p-2 rounded" required>
            </label>
            <label class="block mb-3">Password
                <input type="password" name="password" class="w-full border p-2 rounded" required>
            </label>
            <label class="block mb-4">Konfirmasi Password
                <input type="password" name="password_confirmation" class="w-full border p-2 rounded" required>
            </label>
            <div class="flex items-center justify-between">
                <button class="bg-rose-500 text-white px-4 py-2 rounded">Buat Kasir</button>
                <a href="{{ route('admin.dashboard') }}" class="text-sm text-rose-600">Kembali</a>
            </div>
        </form>
    </div>
@endsection
