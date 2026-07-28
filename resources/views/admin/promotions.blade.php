@extends('layouts.admin')

@section('title','Kelola Promo - Klinik Cantik')

@section('content')
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-bold text-rose-600">Kelola Promo</h2>
        <p class="mt-2">Atur promo dan diskon khusus untuk pelanggan klinik.</p>
        <div class="mt-6 space-y-4">
            <div class="rounded-lg border border-rose-100 p-4">
                <h3 class="text-lg font-semibold">Promo Aktif</h3>
                <p class="text-sm text-gray-600">Tampilkan promo yang sedang berjalan dengan opsi edit atau nonaktifkan.</p>
            </div>
            <div class="rounded-lg border border-rose-100 p-4">
                <h3 class="text-lg font-semibold">Buat Promo Baru</h3>
                <p class="text-sm text-gray-600">Form pembuatan promo baru bisa ditambahkan di sini.</p>
            </div>
        </div>
    </div>
@endsection

