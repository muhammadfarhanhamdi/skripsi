@extends('layouts.admin')

@section('title','Admin Dashboard - Klinik Cantik')

@section('main-class','px-0 py-0')

@section('content')
    <div class="space-y-6">
            <div class="rounded-[32px] bg-white p-8 shadow-sm border border-slate-200">
                <div class="flex flex-col gap-6 xl:flex-row xl:items-center xl:justify-between">
                    <div>
                        <p class="text-sm uppercase tracking-[0.35em] text-slate-500">Dashboard</p>
                        <h1 class="mt-3 text-3xl font-semibold text-slate-900">Selamat Datang, {{ Auth::user()->name }}</h1>
                    </div>
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                        <div class="relative w-full sm:w-auto">
                            <input type="text" placeholder="Cari sesuatu..." class="w-full rounded-full border border-slate-200 bg-slate-50 px-4 py-3 pr-12 text-sm text-slate-700 focus:border-rose-400 focus:outline-none" />
                            <span class="pointer-events-none absolute inset-y-0 right-4 grid place-items-center text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                            </span>
                        </div>
                        <button class="inline-flex items-center justify-center rounded-full bg-rose-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-rose-500">Tambah Pesanan</button>
                    </div>
                </div>
            </div>

            <div class="grid gap-4 lg:grid-cols-4">
                    <div class="rounded-[28px] bg-white p-6 shadow-sm border border-slate-200">
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-400">Total Pendapatan</p>
                    <div class="mt-4 flex items-end justify-between gap-4">
                        <div>
                            <p class="text-3xl font-semibold text-slate-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                            <p class="mt-3 text-sm text-slate-500">vs bulan lalu +12,5%</p>
                        </div>
                        <div class="rounded-3xl bg-rose-100 px-3 py-2 text-rose-700">+12%</div>
                    </div>
                </div>

                    <div class="rounded-[28px] bg-white p-6 shadow-sm border border-slate-200">
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-400">Pengguna Aktif</p>
                    <div class="mt-4 flex items-end justify-between gap-4">
                        <div>
                            <p class="text-3xl font-semibold text-slate-900">{{ $activeUsers }}</p>
                            <p class="mt-3 text-sm text-slate-500">Jumlah kasir aktif.</p>
                        </div>
                        <div class="rounded-3xl bg-emerald-100 px-3 py-2 text-emerald-700">+8%</div>
                    </div>
                </div>

                    <div class="rounded-[28px] bg-white p-6 shadow-sm border border-slate-200">
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-400">Total Pesanan</p>
                    <div class="mt-4 flex items-end justify-between gap-4">
                        <div>
                            <p class="text-3xl font-semibold text-slate-900">{{ $totalOrders }}</p>
                            <p class="mt-3 text-sm text-slate-500">Semua transaksi tercatat.</p>
                        </div>
                        <div class="rounded-3xl bg-amber-100 px-3 py-2 text-amber-700">-3%</div>
                    </div>
                </div>

                    <div class="rounded-[28px] bg-white p-6 shadow-sm border border-slate-200">
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-400">Pelanggan</p>
                    <div class="mt-4 flex items-end justify-between gap-4">
                        <div>
                            <p class="text-3xl font-semibold text-slate-900">{{ $customers }}</p>
                            <p class="mt-3 text-sm text-slate-500">Total pelanggan terdaftar.</p>
                        </div>
                        <div class="rounded-3xl bg-cyan-100 px-3 py-2 text-cyan-700">+24%</div>
                    </div>
                </div>
            </div>

            <div class="grid gap-4 xl:grid-cols-[1.7fr_1fr]">
                <div class="rounded-[32px] bg-white p-6 shadow-sm border border-slate-200">
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                        <div>
                            <p class="text-base font-semibold text-slate-900">Ringkasan</p>
                            <p class="mt-1 text-sm text-slate-500">Performa bulanan untuk tahun ini.</p>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <button class="rounded-full border border-slate-200 px-4 py-2 text-sm text-slate-700 transition hover:bg-slate-50">Pendapatan</button>
                            <button class="rounded-full border border-slate-200 px-4 py-2 text-sm text-slate-700 transition hover:bg-slate-50">Pesanan</button>
                            <button class="rounded-full border border-slate-200 px-4 py-2 text-sm text-slate-700 transition hover:bg-slate-50">Laba</button>
                        </div>
                    </div>
                    <div class="mt-6 h-[340px] rounded-[28px] bg-gradient-to-b from-rose-50 to-white p-6">
                        <canvas id="overviewChart" class="h-full w-full"></canvas>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="rounded-[32px] bg-white p-6 shadow-sm border border-slate-200">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <p class="text-base font-semibold text-slate-900">Pesanan menurut Status</p>
                                <p class="mt-1 text-sm text-slate-500">Distribusi status pesanan.</p>
                            </div>
                            <div class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.25em] text-slate-500">{{ $totalOrders }} pesanan</div>
                        </div>

                        <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div class="flex h-48 items-center justify-center rounded-[28px] bg-slate-100">
                                <div class="h-40 w-40 rounded-full bg-gradient-to-br from-rose-500 to-rose-200"></div>
                            </div>
                            <div class="space-y-3">
                                <div class="flex items-center gap-3 rounded-3xl bg-rose-50 p-4">
                                    <div class="h-2.5 w-2.5 rounded-full bg-rose-500"></div>
                                    <div class="grow">
                                        <p class="text-sm font-semibold text-slate-900">Selesai</p>
                                        <p class="text-xs text-slate-500">65%</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3 rounded-3xl bg-emerald-50 p-4">
                                    <div class="h-2.5 w-2.5 rounded-full bg-emerald-500"></div>
                                    <div class="grow">
                                        <p class="text-sm font-semibold text-slate-900">Menunggu</p>
                                        <p class="text-xs text-slate-500">20%</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3 rounded-3xl bg-amber-50 p-4">
                                    <div class="h-2.5 w-2.5 rounded-full bg-amber-500"></div>
                                    <div class="grow">
                                        <p class="text-sm font-semibold text-slate-900">Diproses</p>
                                        <p class="text-xs text-slate-500">10%</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3 rounded-3xl bg-slate-50 p-4">
                                    <div class="h-2.5 w-2.5 rounded-full bg-slate-500"></div>
                                    <div class="grow">
                                        <p class="text-sm font-semibold text-slate-900">Dibatalkan</p>
                                        <p class="text-xs text-slate-500">5%</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-[32px] bg-white p-6 shadow-sm border border-slate-200">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <p class="text-base font-semibold text-slate-900">Target Bulanan</p>
                                <p class="mt-1 text-sm text-slate-500">Pantau kemajuan terhadap target.</p>
                            </div>
                            <span class="rounded-full bg-rose-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.25em] text-rose-700">88% Complete</span>
                        </div>

                        <div class="mt-6 space-y-4">
                            <div>
                                <div class="flex items-center justify-between text-sm text-slate-500">
                                    <span>Pendapatan Bulanan</span>
                                    <span>Rp {{ number_format($monthlyRevenue, 0, ',', '.') }} / Rp 50.000.000</span>
                                </div>
                                <div class="mt-2 h-2 rounded-full bg-slate-200">
                                    <div class="h-2 rounded-full bg-rose-500" style="width: 88%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex items-center justify-between text-sm text-slate-500">
                                    <span>Pelanggan Baru</span>
                                    <span>{{ $newCustomers }} / 1.000</span>
                                </div>
                                <div class="mt-2 h-2 rounded-full bg-slate-200">
                                    <div class="h-2 rounded-full bg-cyan-500" style="width: 65%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex items-center justify-between text-sm text-slate-500">
                                    <span>Tingkat Konversi</span>
                                    <span>{{ $conversionRate }}%</span>
                                </div>
                                <div class="mt-2 h-2 rounded-full bg-slate-200">
                                    <div class="h-2 rounded-full bg-slate-900" style="width: {{ $conversionRate }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const el = document.getElementById('overviewChart');
        if (!el) return;
        const ctx = el.getContext('2d');
        const labels = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        const data = @json($monthlyTotals ?? []);

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Pendapatan Bulanan',
                    data: data,
                    borderColor: '#FB7185',
                    backgroundColor: 'rgba(251,113,133,0.1)',
                    tension: 0.3,
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true } }
            }
        });
    });
</script>
@endpush

@endsection

