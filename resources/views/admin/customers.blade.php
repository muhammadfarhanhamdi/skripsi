@extends('layouts.admin')

@section('title','Daftar Pelanggan - Klinik Cantik')

@section('content')
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-bold text-rose-600">Daftar Pelanggan</h2>
        <p class="mt-2">Pantau data pelanggan, email, dan riwayat kunjungan.</p>
        <div class="mt-6 space-y-4">
            <div class="rounded-lg border border-rose-100 p-4">
                <h3 class="text-lg font-semibold">Pelanggan Terbaru</h3>
                <p class="text-sm text-gray-600">Daftar pelanggan baru ditampilkan di sini.</p>
            </div>
            <div class="rounded-lg border border-rose-100 p-4">
                <h3 class="text-lg font-semibold">Kelola Data Pelanggan</h3>
                <p class="text-sm text-gray-600">Tambahkan atau edit informasi pelanggan saat diperlukan.</p>
            </div>
        </div>
    </div>
@endsection

