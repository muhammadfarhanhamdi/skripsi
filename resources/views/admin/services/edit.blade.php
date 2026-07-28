@extends('layouts.admin')

@section('title','Edit Layanan - Klinik Cantik')

@section('content')
    <div class="bg-white rounded-lg shadow p-6 max-w-xl mx-auto">
        <h2 class="text-2xl font-bold text-rose-600">Edit Layanan</h2>
        <p class="mt-2 text-gray-600">Perbarui detail layanan.</p>

        @include('shared.alert', ['type' => 'success', 'message' => session('success')])
        @if(session('error'))
            @include('shared.alert', ['type' => 'error', 'message' => session('error')])
        @endif

        <form method="POST" action="{{ route('admin.services.update', $service) }}" class="mt-6 space-y-4">
            @csrf
            @method('PUT')
            <label class="block">
                <span class="text-gray-700">Nama Layanan</span>
                <input type="text" name="name" value="{{ old('name', $service->name) }}" class="mt-1 w-full rounded border-gray-300 shadow-sm" required>
                @error('name')<p class="mt-2 text-sm text-rose-600">{{ $message }}</p>@enderror
            </label>
            <label class="block">
                <span class="text-gray-700">Deskripsi</span>
                <textarea name="description" class="mt-1 w-full rounded border-gray-300 shadow-sm">{{ old('description', $service->description) }}</textarea>
                @error('description')<p class="mt-2 text-sm text-rose-600">{{ $message }}</p>@enderror
            </label>
            <label class="block">
                <span class="text-gray-700">Harga</span>
                <input type="number" name="price" value="{{ old('price', $service->price) }}" step="0.01" class="mt-1 w-full rounded border-gray-300 shadow-sm" required>
                @error('price')<p class="mt-2 text-sm text-rose-600">{{ $message }}</p>@enderror
            </label>
            <label class="block">
                <span class="text-gray-700">Durasi</span>
                <input type="text" name="duration" value="{{ old('duration', $service->duration) }}" class="mt-1 w-full rounded border-gray-300 shadow-sm">
                @error('duration')<p class="mt-2 text-sm text-rose-600">{{ $message }}</p>@enderror
            </label>
            <div class="flex items-center justify-between">
                <a href="{{ route('admin.services.index') }}" class="text-rose-600 hover:underline">Batal</a>
                <button class="bg-pink-500 text-white px-4 py-2 rounded-lg">Perbarui</button>
            </div>
        </form>
    </div>
@endsection

