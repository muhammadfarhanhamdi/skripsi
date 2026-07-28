@extends('layouts.kasir')

@section('title','Belum Bayar - Klinik Cantik')
@section('page_title','Belum Bayar')

@section('content')
    <div class="space-y-6">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-rose-600">Transaksi Belum Bayar</h2>
                    <p class="mt-2 text-slate-600">Daftar transaksi yang sudah dibuat, biasanya setelah treatment selesai, lalu tinggal dilunasi.</p>
                </div>
                <a href="{{ route('kasir.dashboard') }}" class="inline-flex items-center gap-2 justify-center rounded-full border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-rose-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Kembali ke Dashboard
                </a>
            </div>

            @if(session('status'))
                <div class="mt-4 rounded-2xl bg-emerald-50 p-4 text-sm text-emerald-700 ring-1 ring-emerald-200">
                    {{ session('status') }}
                </div>
            @endif
        </div>

        <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="px-6 py-4 text-left font-semibold">Tanggal</th>
                        <th class="px-6 py-4 text-left font-semibold">Pelanggan</th>
                        <th class="px-6 py-4 text-left font-semibold">Jasa Pesanan</th>
                        <th class="px-6 py-4 text-left font-semibold">Status Layanan</th>
                        <th class="px-6 py-4 text-left font-semibold">Total</th>
                        <th class="px-6 py-4 text-left font-semibold"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @forelse($transactions as $transaction)
                            <tr>
                                <td class="px-6 py-4 text-slate-700">{{ $transaction->created_at->format('d M Y H:i') }}</td>
                                <td class="px-6 py-4 text-slate-700">
                                <div class="font-medium text-slate-900">{{ $transaction->customer->name ?? 'Pelanggan baru' }}</div>
                                <div class="text-xs text-slate-500">{{ $transaction->customer->phone ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 text-slate-700">
                                @if($transaction->items && $transaction->items->count())
                                    <div class="space-y-1">
                                        @foreach($transaction->items as $item)
                                            <div class="rounded-2xl bg-slate-50 px-3 py-2">
                                                <div class="font-medium text-slate-900">{{ $item->service->name }}</div>
                                                <div class="text-xs text-slate-500">Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="rounded-2xl bg-slate-50 px-3 py-2">
                                        <div class="font-medium text-slate-900">{{ $transaction->service->name ?? '-' }}</div>
                                        <div class="text-xs text-slate-500">Rp {{ number_format($transaction->price, 0, ',', '.') }}</div>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $status = '-';
                                    if ($transaction->booking && $transaction->booking->status) {
                                        $status = ucfirst($transaction->booking->status);
                                    } elseif (! empty($transaction->queue_status)) {
                                        $status = ucfirst($transaction->queue_status);
                                    } else {
                                        $status = 'Menunggu';
                                    }
                                @endphp
                                <span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-700">{{ $status }}</span>
                            </td>
                            <td class="px-6 py-4 text-rose-600 font-semibold">Rp {{ number_format($transaction->total, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('kasir.transactions.receipt', $transaction) }}" class="rounded-full bg-rose-500 px-3 py-2 text-xs font-semibold text-white hover:bg-rose-600">Lihat Struk &amp; Bayar</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-slate-500">Tidak ada transaksi belum bayar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="bg-white rounded-3xl p-6 shadow-sm">{{ $transactions->links() }}</div>
    </div>
@endsection
