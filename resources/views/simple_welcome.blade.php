@extends('layouts.clinic')

@section('title','Selamat Datang - Klinik Kecantikan Ladisha')

@section('content')
    <div class="relative overflow-hidden bg-gradient-to-b from-rose-50 via-white to-rose-50">
        <div class="mx-auto max-w-6xl px-4 py-24 sm:px-6 lg:px-8">
            <div class="rounded-[2rem] border border-rose-100 bg-white/90 p-10 shadow-xl shadow-rose-200/30 backdrop-blur">
                <div class="grid gap-12 lg:grid-cols-[1.3fr_0.7fr] lg:items-center">
                    <div class="space-y-8 text-left">
                        <div class="inline-flex items-center gap-2 rounded-full bg-rose-100 px-4 py-2 text-sm font-semibold text-rose-700">
                            <span class="h-2.5 w-2.5 rounded-full bg-rose-500"></span>
                            Platform Manajemen Klinik Kecantikan
                        </div>
                        <div>
                            <h1 class="text-5xl font-extrabold tracking-tight text-rose-600 sm:text-6xl">Kelola Booking, Transaksi, dan Pelayanan dengan Mudah</h1>
                            <p class="mt-6 max-w-2xl text-lg leading-8 text-slate-600">Sistem klinik yang dirancang untuk mempercepat proses kasir dan membantu tim Anda memberikan layanan kecantikan terbaik secara terorganisir.</p>
                        </div>
                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                            <a href="{{ route('login.show') }}" class="inline-flex items-center justify-center rounded-full bg-rose-600 px-8 py-4 text-base font-semibold text-white shadow-lg shadow-rose-200 transition hover:bg-rose-700">Masuk Sekarang</a>
                            <div class="text-sm text-slate-500">Hubungi admin untuk pendaftaran akun baru.</div>
                        </div>
                    </div>

                    <div class="rounded-[1.5rem] bg-rose-50 p-8 shadow-inner shadow-rose-100">
                        <div class="space-y-6">
                            <div class="rounded-3xl bg-white p-6 shadow-sm">
                                <h2 class="text-xl font-semibold text-rose-600">Manfaat Utama</h2>
                                <ul class="mt-4 space-y-3 text-slate-600">
                                    <li>• Laporan transaksi dan layanan otomatis</li>
                                    <li>• Pemantauan status booking real-time</li>
                                    <li>• Data pelanggan tersimpan aman</li>
                                </ul>
                            </div>
                            <div class="rounded-3xl bg-white p-6 shadow-sm">
                                <h2 class="text-xl font-semibold text-rose-600">Apa yang Bisa Dilakukan</h2>
                                <ul class="mt-4 space-y-3 text-slate-600">
                                    <li>• Tambah layanan dan promosi baru</li>
                                    <li>• Kelola pelanggan dan transaksi</li>
                                    <li>• Cek riwayat perawatan dengan cepat</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
