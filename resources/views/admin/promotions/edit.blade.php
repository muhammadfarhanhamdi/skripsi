@extends('layouts.admin')

@section('title','Edit Promo - Klinik Cantik')

@section('content')
    <div class="bg-white rounded-lg shadow p-6 max-w-xl mx-auto">
        <h2 class="text-2xl font-bold text-rose-600">Edit Promo</h2>
        <p class="mt-2 text-gray-600">Perbarui detail promo.</p>

        <form method="POST" action="{{ route('admin.promotions.update', $promotion) }}" class="mt-6 space-y-4">
            @csrf
            @method('PUT')
            <label class="block">
                <span class="text-gray-700">Kode Promo</span>
                <input type="text" name="code" value="{{ old('code', $promotion->code) }}" class="mt-1 w-full rounded border-gray-300 shadow-sm" required>
            </label>
            <label class="block">
                <span class="text-gray-700">Judul</span>
                <input type="text" name="title" value="{{ old('title', $promotion->title) }}" class="mt-1 w-full rounded border-gray-300 shadow-sm" required>
            </label>
            <label class="block">
                <span class="text-gray-700">Deskripsi</span>
                <textarea name="description" class="mt-1 w-full rounded border-gray-300 shadow-sm">{{ old('description', $promotion->description) }}</textarea>
            </label>
            <label class="block">
                <span class="text-gray-700">Diskon (%)</span>
                <input type="number" name="discount_percent" value="{{ old('discount_percent', $promotion->discount_percent) }}" class="mt-1 w-full rounded border-gray-300 shadow-sm" required>
            </label>
            <label class="flex items-center gap-3">
                <input type="checkbox" name="active" value="1" {{ old('active', $promotion->active) ? 'checked' : '' }}>
                <span class="text-gray-700">Aktifkan promo</span>
            </label>
            <div class="flex items-center justify-between">
                <a href="{{ route('admin.promotions.index') }}" class="text-rose-600 hover:underline">Batal</a>
                <button class="bg-pink-500 text-white px-4 py-2 rounded-lg">Perbarui</button>
            </div>
        </form>
    </div>
@endsection

