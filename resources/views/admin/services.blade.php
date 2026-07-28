@extends('layouts.admin')

@section('title','Kelola Layanan - Klinik Cantik')

@section('content')
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-bold text-rose-600">Kelola Layanan</h2>
        <p class="mt-2">Tambahkan, edit, atau hapus layanan kecantikan yang tersedia untuk pelanggan.</p>
        <div class="mt-6 space-y-4">
            <div class="rounded-lg border border-rose-100 p-4">
                <h3 class="text-lg font-semibold">Tambah Layanan Baru</h3>
                <p class="text-sm text-gray-600">Form input layanan akan dibuat di sini.</p>
            </div>
            <div class="rounded-lg border border-rose-100 p-4">
                <h3 class="text-lg font-semibold">Daftar Layanan</h3>
                <p class="text-sm text-gray-600">Tampilkan daftar layanan saat ini dan tombol untuk edit/hapus.</p>
            </div>
        </div>
    </div>
@endsection

