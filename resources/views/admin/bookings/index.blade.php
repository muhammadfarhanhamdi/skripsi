@extends('layouts.admin')

@section('title','Booking WhatsApp - Klinik Cantik')

@section('content')
    <div class="space-y-6">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <p class="text-sm uppercase tracking-[0.3em] text-slate-500">Admin</p>
                    <h2 class="mt-2 text-2xl font-semibold text-slate-900">Booking WhatsApp</h2>
                    <p class="mt-2 text-sm text-slate-500">Booking diinput oleh admin setelah pelanggan menghubungi via WhatsApp.</p>
                </div>
                <a href="{{ route('admin.bookings.create') }}" class="inline-flex items-center justify-center rounded-full bg-rose-500 px-5 py-3 text-sm font-semibold text-white transition hover:bg-rose-600">Tambah Booking</a>
            </div>

            @if(session('success'))
                <div class="mt-4 rounded-2xl bg-emerald-50 p-4 text-sm text-emerald-700 ring-1 ring-emerald-200">{{ session('success') }}</div>
            @endif
        </div>

        <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="px-6 py-4 text-left font-semibold">Tanggal</th>
                        <th class="px-6 py-4 text-left font-semibold">Pelanggan</th>
                        <th class="px-6 py-4 text-left font-semibold">Layanan</th>
                        <th class="px-6 py-4 text-left font-semibold">Sumber</th>
                        <th class="px-6 py-4 text-left font-semibold">Status</th>
                        <th class="px-6 py-4 text-left font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @forelse($bookings as $booking)
                        @php
                            $statusClass = match($booking->status) {
                                'confirmed' => 'bg-sky-100 text-sky-700 ring-sky-200',
                                'arrived' => 'bg-amber-100 text-amber-700 ring-amber-200',
                                'completed' => 'bg-emerald-100 text-emerald-700 ring-emerald-200',
                                'canceled' => 'bg-rose-100 text-rose-700 ring-rose-200',
                                default => 'bg-slate-100 text-slate-700 ring-slate-200',
                            };
                            $statusLabel = match($booking->status) {
                                'confirmed' => 'Dikonfirmasi',
                                'arrived' => 'Datang',
                                'completed' => 'Selesai',
                                'canceled' => 'Batal',
                                default => 'Menunggu',
                            };
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
                            <td class="px-6 py-4 text-slate-700">{{ ucfirst($booking->source) }}</td>
                            <td class="px-6 py-4"><span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold ring-1 {{ $statusClass }}">{{ $statusLabel }}</span></td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('admin.bookings.edit', $booking) }}" class="inline-flex items-center justify-center rounded-full border border-slate-200 bg-white px-4 py-2 text-xs font-semibold text-slate-700 transition hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-rose-100">Edit</a>
                                    <form action="{{ route('admin.bookings.destroy', $booking) }}" method="POST" data-confirm="Hapus booking ini?">
                                        @csrf
                                        @method('DELETE')
                                        <button class="inline-flex items-center justify-center rounded-full bg-rose-500 px-4 py-2 text-xs font-semibold text-white transition hover:bg-rose-600 focus:outline-none focus:ring-2 focus:ring-rose-200">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-slate-500">Belum ada booking.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="rounded-3xl bg-white p-6 shadow-sm">{{ $bookings->links() }}</div>
    </div>
@endsection
