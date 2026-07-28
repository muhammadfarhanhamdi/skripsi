@extends('layouts.kasir')

@section('title','Kasir Dashboard - Klinik Cantik')
@section('page_title','Dashboard Kasir')

@section('content')
<div class="space-y-6">
    <section class="rounded-3xl bg-white p-6 shadow-sm border border-slate-200">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-sm uppercase tracking-[0.3em] text-rose-600">Kasir</p>
                <h2 class="mt-2 text-3xl font-semibold text-slate-900">Dashboard Transaksi</h2>
                <p class="mt-3 max-w-2xl text-slate-600">Kelola proses pembayaran dan layanan pelanggan secara cepat. Lihat ringkasan kinerja dan akses fitur transaksi langsung dari halaman ini.</p>
            </div>

            <div class="grid gap-3 sm:grid-cols-2">
                <a href="{{ route('kasir.transactions') }}" class="inline-flex items-center justify-center rounded-full bg-rose-500 px-5 py-3 text-sm font-semibold text-white transition hover:bg-rose-600">Buat Transaksi</a>
            </div>
        </div>
    </section>

    <section class="grid gap-4 xl:grid-cols-[1.5fr_1fr]">
        <div class="grid gap-4 md:grid-cols-3">
            <article class="rounded-3xl bg-white p-6 shadow-sm border border-slate-200">
                <p class="text-sm text-slate-500">Transaksi selesai</p>
                <p class="mt-4 text-4xl font-semibold text-slate-900">{{ number_format($transactionCount) }}</p>
                <p class="mt-3 text-sm text-slate-500">Jumlah transaksi yang sudah diproses oleh Anda.</p>
            </article>

            

            <article class="rounded-3xl bg-white p-6 shadow-sm border border-slate-200">
                <p class="text-sm text-slate-500">Belum bayar</p>
                <p class="mt-4 text-4xl font-semibold text-amber-600">{{ number_format($unpaidCount) }}</p>
                <p class="mt-3 text-sm text-slate-500">Transaksi yang sudah dibuat tetapi pembayarannya belum dilunasi.</p>
            </article>

            <article class="rounded-3xl bg-white p-6 shadow-sm border border-slate-200">
                <p class="text-sm text-slate-500">Total pendapatan</p>
                <p class="mt-4 text-4xl font-semibold text-rose-600">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                <p class="mt-3 text-sm text-slate-500">Total pemasukan dari transaksi Anda.</p>
            </article>
        </div>

        <div class="rounded-3xl bg-rose-500/10 p-6 shadow-sm border border-rose-200">
            <p class="text-sm uppercase tracking-[0.3em] text-rose-600">Catatan Cepat</p>
            <h3 class="mt-3 text-2xl font-semibold text-slate-900">Fokus pada layanan dan pembayaran</h3>
            <ul class="mt-6 space-y-4 text-sm text-slate-700">
                <li class="rounded-2xl bg-white p-4 shadow-sm">
                    <strong class="block font-semibold text-slate-900">Periksa antrian</strong>
                    Pastikan pelanggan yang menunggu dilayani sesuai urutan dan pembayaran dicatat dengan benar.
                </li>
                <li class="rounded-2xl bg-white p-4 shadow-sm">
                    <strong class="block font-semibold text-slate-900">Gunakan promo</strong>
                    Terapkan promo yang berlaku untuk layanan agar pelanggan mendapatkan potongan harga.
                </li>
                <li class="rounded-2xl bg-white p-4 shadow-sm">
                    <strong class="block font-semibold text-slate-900">Selesaikan transaksi</strong>
                    Selesaikan pembayaran segera agar riwayat dan laporan kasir selalu up-to-date.
                </li>
            </ul>
        </div>
    </section>

    <section class="grid gap-4 md:grid-cols-4">
        <a href="{{ route('kasir.transactions') }}" class="group block rounded-3xl bg-white p-6 shadow-sm border border-slate-200 transition hover:-translate-y-0.5 hover:shadow-md">
            <div class="flex items-center justify-between gap-3">
                <span class="font-semibold text-slate-900">Mulai Transaksi</span>
                <span class="rounded-full bg-rose-500 px-3 py-1 text-xs font-semibold text-white">Cepat</span>
            </div>
            <p class="mt-4 text-sm text-slate-500">Buka form transaksi baru untuk pelanggan.</p>
        </a>

        <a href="{{ route('kasir.customers.create') }}" class="group block rounded-3xl bg-white p-6 shadow-sm border border-slate-200 transition hover:-translate-y-0.5 hover:shadow-md">
            <div class="flex items-center justify-between gap-3">
                <span class="font-semibold text-slate-900">Daftarkan Member</span>
                <span class="rounded-full bg-rose-100 px-3 py-1 text-xs font-semibold text-rose-700">Member</span>
            </div>
            <p class="mt-4 text-sm text-slate-500">Buat akun member baru tanpa membuat transaksi terlebih dahulu.</p>
        </a>

        <a href="{{ route('kasir.history') }}" class="group block rounded-3xl bg-white p-6 shadow-sm border border-slate-200 transition hover:-translate-y-0.5 hover:shadow-md">
            <div class="flex items-center justify-between gap-3">
                <span class="font-semibold text-slate-900">Lihat Riwayat</span>
                <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">Detail</span>
            </div>
            <p class="mt-4 text-sm text-slate-500">Telusuri transaksi sebelumnya dan cek total penjualan.</p>
        </a>

        <a href="{{ route('kasir.unpaid') }}" class="group block rounded-3xl bg-white p-6 shadow-sm border border-slate-200 transition hover:-translate-y-0.5 hover:shadow-md">
            <div class="flex items-center justify-between gap-3">
                <span class="font-semibold text-slate-900">Belum Bayar</span>
                <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">Lunas nanti</span>
            </div>
            <p class="mt-4 text-sm text-slate-500">Kelola transaksi yang sudah selesai treatment tetapi belum dibayar.</p>
        </a>

        
    </section>
</div>
@endsection
