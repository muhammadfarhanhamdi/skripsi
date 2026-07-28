@extends('layouts.admin')

@section('title','Edit Booking - Klinik Cantik')

@section('content')
    <div class="mx-auto max-w-4xl rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <h2 class="text-2xl font-semibold text-slate-900">Edit Booking WhatsApp</h2>
        <p class="mt-2 text-sm text-slate-500">Perbarui booking yang sudah dicatat admin.</p>

        <form method="POST" action="{{ route('admin.bookings.update', $booking) }}" class="mt-8 grid gap-6 lg:grid-cols-2">
            @csrf
            @method('PUT')

            <label class="block lg:col-span-2">
                <span class="text-sm font-medium text-slate-700">Pelanggan terdaftar</span>
                <select id="customerSelect" name="customer_id" class="mt-2 w-full rounded-2xl border border-slate-300 bg-white px-4 py-3">
                    <option value="" disabled hidden>Pilih member terdaftar</option>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}" data-phone="{{ $customer->phone }}" {{ old('customer_id', $booking->customer_id) == $customer->id ? 'selected' : '' }}>{{ $customer->name }}</option>
                    @endforeach
                </select>
            </label>

            <label class="block">
                <span class="text-sm font-medium text-slate-700">Nama pelanggan</span>
                <input id="customerName" type="text" name="customer_name" value="{{ old('customer_name', $booking->customer_name) }}" readonly class="mt-2 w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900" placeholder="Pilih member untuk melihat nama">
            </label>

            <label class="block">
                <span class="text-sm font-medium text-slate-700">Nomor WhatsApp</span>
                <input id="customerPhone" type="text" name="customer_phone" value="{{ old('customer_phone', $booking->customer_phone) }}" readonly class="mt-2 w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900" placeholder="Pilih member untuk melihat nomor">
            </label>

            @php
                $selectedServices = old('service_id', $booking->items->pluck('service_id')->toArray());
            @endphp
            <div class="lg:col-span-2">
                <span class="text-sm font-medium text-slate-700">Layanan yang dipesan</span>
                <div class="mt-3 grid gap-3 sm:grid-cols-2">
                    @foreach($services as $service)
                        <label class="flex cursor-pointer items-start gap-3 rounded-2xl border border-slate-200 bg-slate-50 p-4 transition hover:border-rose-300 hover:bg-rose-50/60">
                            <input type="checkbox" name="service_id[]" value="{{ $service->id }}" {{ in_array($service->id, $selectedServices) ? 'checked' : '' }} class="mt-1 h-4 w-4 rounded border-slate-300 text-rose-500 focus:ring-rose-400">
                            <div>
                                <p class="font-medium text-slate-900">{{ $service->name }}</p>
                                <p class="text-sm text-slate-500">Rp {{ number_format($service->price, 0, ',', '.') }}</p>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>

            <label class="block">
                <span class="text-sm font-medium text-slate-700">Tanggal booking</span>
                <input type="date" name="booking_date" value="{{ old('booking_date', optional($booking->booking_date)->format('Y-m-d')) }}" class="mt-2 w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900" required>
            </label>

            <label class="block">
                <span class="text-sm font-medium text-slate-700">Jam booking</span>
                <input type="time" name="booking_time" value="{{ old('booking_time', $booking->booking_time) }}" class="mt-2 w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900">
            </label>

            <label class="block">
                <span class="text-sm font-medium text-slate-700">Status</span>
                <select name="status" class="mt-2 w-full rounded-2xl border border-slate-300 bg-white px-4 py-3">
                    @foreach(['pending' => 'Menunggu', 'confirmed' => 'Dikonfirmasi', 'arrived' => 'Datang', 'completed' => 'Selesai', 'canceled' => 'Batal'] as $value => $label)
                        <option value="{{ $value }}" {{ old('status', $booking->status) === $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </label>

            <label class="block lg:col-span-2">
                <span class="text-sm font-medium text-slate-700">Catatan</span>
                <textarea name="notes" rows="4" class="mt-2 w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900">{{ old('notes', $booking->notes) }}</textarea>
            </label>

            <div class="lg:col-span-2 flex items-center justify-between gap-4">
                <a href="{{ route('admin.bookings.index') }}" class="inline-flex items-center justify-center rounded-full border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-rose-100">Batal</a>
                <button class="inline-flex items-center justify-center rounded-full bg-rose-500 px-5 py-3 text-sm font-semibold text-white transition hover:bg-rose-600 focus:outline-none focus:ring-2 focus:ring-rose-200">Simpan Perubahan</button>
            </div>
        </form>
    </div>

    <script>
        const customerSelect = document.getElementById('customerSelect');
        const customerName = document.getElementById('customerName');
        const customerPhone = document.getElementById('customerPhone');

        function syncCustomer() {
            const option = customerSelect.selectedOptions[0];
            if (option && option.value) {
                customerName.value = option.textContent.replace(' (Member)', '').trim();
                customerPhone.value = option.dataset.phone || '';
                customerName.readOnly = true;
                customerPhone.readOnly = true;
            } else {
                customerName.readOnly = false;
                customerPhone.readOnly = false;
            }
        }

        customerSelect.addEventListener('change', syncCustomer);
        syncCustomer();
    </script>
@endsection
