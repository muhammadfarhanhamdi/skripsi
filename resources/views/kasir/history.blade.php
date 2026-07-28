@extends('layouts.kasir')

@section('title','Riwayat Transaksi - Klinik Cantik')
@section('page_title','Riwayat Transaksi')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-3xl shadow p-6">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-rose-600">Riwayat Transaksi</h2>
                <p class="mt-2 text-slate-600">Semua transaksi yang Anda proses ditampilkan di sini.</p>
            </div>
            <div class="flex items-center gap-3">
                <form method="GET" action="{{ route('kasir.history') }}" class="flex items-center gap-3">
                    <label class="text-sm text-slate-600">Filter member</label>
                    <select name="member_id" class="rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm">
                        <option value="">Semua member</option>
                        @foreach($members ?? [] as $m)
                            <option value="{{ $m->id }}" {{ (string)($memberId ?? '') === (string)$m->id ? 'selected' : '' }}>{{ $m->name }} — {{ $m->phone ?? '-' }}</option>
                        @endforeach
                    </select>
                    <button class="rounded-full bg-slate-100 px-3 py-2 text-sm text-slate-700 hover:bg-slate-200">Terapkan</button>
                </form>
                <a href="{{ route('kasir.dashboard') }}" class="inline-flex items-center gap-2 justify-center rounded-full border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-rose-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>

    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-slate-200 text-sm">
            <thead class="bg-slate-50 text-slate-600">
                <tr>
                    <th class="px-6 py-4 text-left font-semibold">Tanggal</th>
                    <th class="px-6 py-4 text-left font-semibold">Pelanggan</th>
                    <th class="px-6 py-4 text-left font-semibold">Layanan</th>
                    <th class="px-6 py-4 text-left font-semibold">Total</th>
                    <th class="px-6 py-4 text-left font-semibold">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 bg-white">
                @forelse ($transactions as $transaction)
                    <tr>
                        <td class="px-6 py-4 text-slate-700">{{ $transaction->created_at->format('d M Y H:i') }}</td>
                        <td class="px-6 py-4 text-slate-700">{{ $transaction->customer->name ?? 'Pelanggan baru' }}</td>
                        <td class="px-6 py-4 text-slate-700">
                            @if($transaction->items && $transaction->items->count())
                                @foreach($transaction->items as $it)
                                    <div>{{ $it->service->name }}@if(! $loop->last),@endif</div>
                                @endforeach
                            @else
                                {{ $transaction->service->name ?? '-' }}
                            @endif
                        </td>
                        <td class="px-6 py-4 text-rose-600">Rp {{ number_format($transaction->total, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-slate-700">
                            @if($transaction->paid_at)
                                <div class="font-medium text-emerald-600">Lunas</div>
                                <div class="text-xs text-slate-500">{{ ucfirst(str_replace('-', ' ', $transaction->payment_method ?? '-')) }}</div>
                            @else
                                <div class="font-medium text-amber-600">Belum lunas</div>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-slate-500">Belum ada transaksi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="bg-white rounded-3xl p-6 shadow-sm">
        {{ $transactions->appends(request()->query())->links() }}
    </div>
</div>
@endsection
