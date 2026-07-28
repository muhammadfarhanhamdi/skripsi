@extends('layouts.clinic')

@section('title','Welcome - Klinik Cantik')

@section('content')
    <div class="space-y-8 text-center">
        <h1 class="text-5xl font-extrabold tracking-tight text-rose-600">Selamat Datang di Klinik Kecantikan Ladisha</h1>
        <p class="text-lg text-gray-600 max-w-3xl mx-auto">Kelola janji temu, layanan, dan pelanggan dengan cepat melalui sistem kami yang mudah digunakan. Login untuk melihat dashboard dan mulai mengatur perawatan kecantikan Anda.</p>

        <div class="grid gap-6 md:grid-cols-3 mx-auto max-w-4xl text-left">
            <div class="rounded-3xl border border-rose-100 bg-white p-6 shadow-sm">
                <h2 class="text-xl font-semibold text-rose-600">Fitur Utama</h2>
                <ul class="mt-4 space-y-3 text-gray-600">
                    <li>• Kelola layanan kecantikan dan promosi</li>
                    <li>• Catat transaksi dan riwayat pelanggan</li>
                    <li>• Pantau status booking secara real-time</li>
                </ul>
            </div>
            <div class="rounded-3xl border border-rose-100 bg-white p-6 shadow-sm">
                <h2 class="text-xl font-semibold text-rose-600">Keunggulan</h2>
                <ul class="mt-4 space-y-3 text-gray-600">
                    <li>• Antarmuka sederhana dan responsif</li>
                    <li>• Data pelanggan tersimpan aman</li>
                    <li>• Dukungan penuh untuk tim klinik</li>
                </ul>
            </div>
            <div class="rounded-3xl border border-rose-100 bg-white p-6 shadow-sm">
                <h2 class="text-xl font-semibold text-rose-600">Mulai</h2>
                <p class="mt-4 text-gray-600">Jika Anda sudah memiliki akun, masuk sekarang. Jika belum, silakan hubungi admin klinik untuk pendaftaran.</p>
            </div>
        </div>

        <div class="flex justify-center">
            <a href="{{ route('login.show') }}" class="inline-flex items-center justify-center rounded-full bg-rose-600 px-8 py-4 text-white shadow-lg transition hover:bg-rose-700">Masuk ke Dashboard</a>
        </div>
    </div>
@endsection
