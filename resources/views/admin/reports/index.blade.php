@extends('layouts.admin')

@section('title','Laporan Transaksi - Klinik Cantik')

@section('content')
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-rose-600">Laporan Transaksi</h2>
                <p class="mt-2 text-gray-600">Cetak laporan berdasarkan periode tertentu.</p>
            </div>
            <form method="GET" action="{{ route('admin.reports.index') }}" class="flex flex-col gap-3 sm:flex-row sm:items-center">
                <label class="flex items-center gap-2 text-sm text-gray-700">
                    Dari
                    <input type="date" name="from" value="{{ $from->format('Y-m-d') }}" class="rounded border-gray-300 p-2">
                </label>
                <label class="flex items-center gap-2 text-sm text-gray-700">
                    Sampai
                    <input type="date" name="to" value="{{ $to->format('Y-m-d') }}" class="rounded border-gray-300 p-2">
                </label>
                <button type="submit" class="bg-pink-500 text-white px-4 py-2 rounded-lg">Tampilkan</button>
            </form>
        </div>

        <div class="mt-6 overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Tanggal</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Pelanggan</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Layanan</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Kasir</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($transactions as $transaction)
                        <tr>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $transaction->created_at->format('d M Y') }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $transaction->customer->name ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $transaction->service->name ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $transaction->kasir->name ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">Rp {{ number_format($transaction->total, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6 flex items-center justify-between">
            <div class="text-sm text-gray-600">Total transaksi: {{ $transactions->count() }}</div>
            <a href="{{ route('admin.reports.index', ['from' => $from->format('Y-m-d'), 'to' => $to->format('Y-m-d')]) }}" class="bg-rose-500 text-white px-4 py-2 rounded-lg">Cetak Laporan</a>
        </div>
    </div>
@endsection

