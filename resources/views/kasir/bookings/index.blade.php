@extends('layouts.kasir')

@section('title','Booking - Klinik Cantik')
@section('page_title','Booking WhatsApp')

@section('content')
    <div class="space-y-6">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <p class="text-sm uppercase tracking-[0.3em] text-slate-500">Kasir</p>
                    <h2 class="mt-2 text-2xl font-semibold text-slate-900">Daftar Booking</h2>
                    <p class="mt-2 text-sm text-slate-500">Booking yang dicatat admin dari WhatsApp ditampilkan di sini.</p>
                </div>
                <a href="{{ route('kasir.dashboard') }}" class="inline-flex items-center gap-2 justify-center rounded-full border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-rose-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Kembali ke Dashboard
                </a>
            </div>
        </div>

        <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="px-6 py-4 text-left font-semibold">Tanggal</th>
                        <th class="px-6 py-4 text-left font-semibold">Pelanggan</th>
                        <th class="px-6 py-4 text-left font-semibold">Layanan</th>
                        <th class="px-6 py-4 text-left font-semibold">Status</th>
                        <th class="px-6 py-4 text-left font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @forelse($bookings as $booking)
                        @php
                            $statusClass = $booking->status_class;
                            $statusLabel = $booking->status_label;
                        @endphp
                        <tr>
                            <td class="px-6 py-4 text-slate-700">{{ $booking->booking_date->format('d M Y') }} @if($booking->booking_time) <span class="text-slate-400">{{ $booking->booking_time }}</span> @endif</td>
                            <td class="px-6 py-4 text-slate-700">
                                <div class="font-medium text-slate-900">{{ $booking->customer_name }}</div>
                                <div class="text-xs text-slate-500">{{ $booking->customer_phone ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 text-slate-700">
                                @if($booking->items && $booking->items->count())
                                    <div class="space-y-1">
                                        @foreach($booking->items as $item)
                                            <div>{{ $item->service->name ?? '-' }}</div>
                                        @endforeach
                                    </div>
                                @else
                                    {{ $booking->service->name ?? '-' }}
                                @endif
                            </td>
                            <td class="px-6 py-4"><span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold ring-1 {{ $statusClass }}">{{ $statusLabel }}</span></td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-2">
                                    @if($booking->status !== 'arrived' && $booking->status !== 'completed' && $booking->status !== 'canceled')
                                        <form action="{{ route('kasir.bookings.status', $booking) }}" method="POST" class="inline-flex" data-confirm="Tandai pelanggan ini sudah datang?">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="arrived">
                                            <button class="inline-flex items-center justify-center rounded-full bg-amber-500 px-4 py-2 text-xs font-semibold text-white transition hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-amber-200">Datang</button>
                                        </form>
                                    @endif

                                    @if($booking->status === 'arrived')
                                        <form action="{{ route('kasir.bookings.status', $booking) }}" method="POST" class="inline-flex" data-confirm="Tandai layanan selesai untuk booking ini?">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="completed">
                                            <button class="inline-flex items-center justify-center rounded-full bg-emerald-500 px-4 py-2 text-xs font-semibold text-white transition hover:bg-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-200">Selesai</button>
                                        </form>
                                    @endif

                                    @if($booking->status !== 'completed' && $booking->status !== 'canceled')
                                        <form action="{{ route('kasir.bookings.status', $booking) }}" method="POST" class="inline-flex" data-confirm="Batalkan booking ini? Tindakan ini tidak dapat dibatalkan.">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="canceled">
                                            <button class="inline-flex items-center justify-center rounded-full bg-rose-500 px-4 py-2 text-xs font-semibold text-white transition hover:bg-rose-600 focus:outline-none focus:ring-2 focus:ring-rose-200">Batalkan</button>
                                        </form>
                                    @endif

                                    @if(! $booking->transaction)
                                        <form action="{{ route('kasir.bookings.convert', $booking) }}" method="POST" class="inline-flex" data-confirm="Konversi booking ini menjadi transaksi?">
                                            @csrf
                                            <button class="inline-flex items-center justify-center rounded-full bg-slate-900 px-4 py-2 text-xs font-semibold text-white transition hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-slate-200">Jadikan Transaksi</button>
                                        </form>
                                    @else
                                        <span class="text-xs text-slate-400">Sudah dikonversi</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-slate-500">Belum ada booking.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="rounded-3xl bg-white p-6 shadow-sm">{{ $bookings->links() }}</div>
    </div>
@endsection
