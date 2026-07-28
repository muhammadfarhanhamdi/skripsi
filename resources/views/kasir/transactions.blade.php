@extends('layouts.kasir')

@section('title','Buat Transaksi - Klinik Cantik')
@section('page_title','Buat Transaksi')

@section('content')
<div class="bg-white rounded-3xl shadow p-6">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-2xl font-bold text-rose-600">Buat Transaksi</h2>
            <p class="mt-2 text-slate-600">Pilih pelanggan, layanan, lalu selesaikan pembayaran.</p>
        </div>
        <a href="{{ route('kasir.dashboard') }}" class="inline-flex items-center gap-2 justify-center rounded-full border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-rose-100">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali ke Dashboard
        </a>
    </div>

    @include('shared.alert', ['type' => 'success', 'message' => session('status')])
    @if($errors->any())
        @include('shared.alert', ['type' => 'error', 'message' => 'Periksa kembali input formulir di bawah ini.'])
    @endif

    <form method="POST" action="{{ route('kasir.transactions.store') }}" class="mt-6 grid gap-6 lg:grid-cols-[1.5fr_1fr]">
        @csrf

        <div class="space-y-6">
            <div class="rounded-3xl border border-slate-200 bg-slate-50 p-6">
                <h3 class="text-lg font-semibold text-slate-900">Data Pelanggan</h3>
                <div class="mt-4 space-y-4">
                    <label class="block">
                        <span class="text-sm font-medium text-slate-700">Pilih pelanggan</span>
                        <div class="flex items-center gap-3">
                            <select id="customerSelect" name="customer_id" class="mt-2 flex-1 rounded-xl border border-slate-300 bg-white px-4 py-3">
                                <option value="">Pelanggan baru / tanpa akun</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}" data-phone="{{ $customer->phone }}" data-email="{{ $customer->email }}" data-member="{{ $customer->is_member ? '1' : '0' }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>{{ $customer->name }} — {{ $customer->phone ?? 'No phone' }}@if($customer->is_member) (Member)@endif</option>
                                @endforeach
                            </select>
                            <button type="button" id="clearCustomer" class="mt-2 hidden rounded-full bg-white border border-slate-200 px-3 py-2 text-sm text-slate-700">Batal</button>
                        </div>
                        @error('customer_id')<p class="mt-2 text-sm text-rose-600">{{ $message }}</p>@enderror
                        <p class="mt-2 text-xs text-slate-500">Pelanggan member ditandai dengan <span class="font-semibold">(Member)</span>.</p>
                    </label>

                    <div class="grid gap-4 md:grid-cols-2">
                        <label class="block">
                            <span class="text-sm font-medium text-slate-700">Nama pelanggan</span>
                            <input id="customerName" type="text" name="customer_name" value="{{ old('customer_name') }}" class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-3">
                            @error('customer_name')<p class="mt-2 text-sm text-rose-600">{{ $message }}</p>@enderror
                        </label>
                        <label class="block">
                            <span class="text-sm font-medium text-slate-700">Telepon</span>
                            <input id="customerPhone" type="text" name="customer_phone" value="{{ old('customer_phone') }}" class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-3">
                            @error('customer_phone')<p class="mt-2 text-sm text-rose-600">{{ $message }}</p>@enderror
                        </label>
                    </div>

                    <label class="block">
                        <span class="text-sm font-medium text-slate-700">Email</span>
                        <input id="customerEmail" type="email" name="customer_email" value="{{ old('customer_email') }}" class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-3">
                        @error('customer_email')<p class="mt-2 text-sm text-rose-600">{{ $message }}</p>@enderror
                    </label>

                    <label class="flex items-center gap-3 text-slate-700">
                        <input type="checkbox" name="is_member" value="1" {{ old('is_member') ? 'checked' : '' }} class="h-4 w-4 rounded border-slate-300 text-rose-600 focus:ring-rose-500">
                        <span>Daftarkan sebagai member</span>
                    </label>
                </div>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-slate-50 p-6">
                <h3 class="text-lg font-semibold text-slate-900">Detail Layanan</h3>
                <div class="mt-4 space-y-4">
                    <label class="block">
                        <span class="text-sm font-medium text-slate-700">Pilih layanan</span>
                        <div id="servicesContainer" class="space-y-3 mt-2">
                            <div class="service-row flex gap-3">
                                <select name="service_id[]" class="service-select flex-1 rounded-xl border border-slate-300 bg-white px-4 py-3" required>
                                    <option value="">Pilih layanan</option>
                                    @foreach ($services as $service)
                                        <option value="{{ $service->id }}" data-price="{{ $service->price }}">{{ $service->name }} — Rp {{ number_format($service->price, 0, ',', '.') }}</option>
                                    @endforeach
                                </select>
                                <button type="button" class="remove-service hidden rounded-full bg-red-50 px-3 py-2 text-red-600">&times;</button>
                            </div>
                        </div>
                        <button type="button" id="addService" class="mt-3 inline-flex items-center gap-2 rounded-full bg-white border border-slate-200 px-3 py-2 text-sm text-slate-700">Tambah layanan</button>
                    </label>

                    <label class="block">
                        <span class="text-sm font-medium text-slate-700">Pilih promo</span>
                        <select id="promotion" name="promotion_id" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-4 py-3">
                            <option value="">Tidak ada promo</option>
                            @foreach ($promotions as $promotion)
                                <option value="{{ $promotion->id }}" data-discount="{{ $promotion->discount_percent }}" {{ old('promotion_id') == $promotion->id ? 'selected' : '' }}>{{ $promotion->title }} — {{ $promotion->discount_percent }}%</option>
                            @endforeach
                        </select>
                        @error('promotion_id')<p class="mt-2 text-sm text-rose-600">{{ $message }}</p>@enderror
                    </label>

                    <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-4 text-sm text-slate-600">
                        Transaksi dibuat terlebih dahulu. Pembayaran dicatat setelah treatment selesai.
                    </div>
                </div>
            </div>
        </div>

        <aside class="space-y-6">
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-slate-900">Ringkasan Pembayaran</h3>
                <dl class="mt-4 space-y-3 text-sm text-slate-700">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                        <dt>Harga layanan</dt>
                        <dd id="priceLabel">Rp 0</dd>
                    </div>
                    <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                        <dt>Diskon promo</dt>
                        <dd id="discountLabel">0%</dd>
                    </div>
                    <div class="flex items-center justify-between pt-3">
                        <dt class="font-semibold">Total bayar</dt>
                        <dd id="totalLabel" class="text-2xl font-semibold text-rose-600">Rp 0</dd>
                    </div>
                </dl>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-slate-50 p-6">
                <button type="submit" class="w-full rounded-full bg-rose-500 px-6 py-3 text-white font-semibold transition hover:bg-rose-600">Proses Transaksi</button>
            </div>
        </aside>
    </form>
</div>

    <script>
    const servicesContainer = document.getElementById('servicesContainer');
    const addServiceBtn = document.getElementById('addService');
    const promotionSelect = document.getElementById('promotion');
    const priceLabel = document.getElementById('priceLabel');
    const discountLabel = document.getElementById('discountLabel');
    const totalLabel = document.getElementById('totalLabel');

    function createServiceRow() {
        const row = document.createElement('div');
        row.className = 'service-row flex gap-3';
        row.innerHTML = servicesContainer.querySelector('.service-row').innerHTML;
        // show remove button on cloned
        row.querySelector('.remove-service').classList.remove('hidden');
        return row;
    }

    addServiceBtn.addEventListener('click', () => {
        servicesContainer.appendChild(createServiceRow());
        attachListeners();
        updateSummary();
    });

    function attachListeners() {
        document.querySelectorAll('.service-select').forEach(el => el.removeEventListener('change', updateSummary));
        document.querySelectorAll('.service-select').forEach(el => el.addEventListener('change', updateSummary));
        document.querySelectorAll('.remove-service').forEach(btn => {
            btn.removeEventListener('click', removeServiceRow);
            btn.addEventListener('click', removeServiceRow);
        });
    }

    function removeServiceRow(e) {
        const row = e.currentTarget.closest('.service-row');
        row.remove();
        updateSummary();
    }

    function updateSummary() {
        const selects = document.querySelectorAll('.service-select');
        let sum = 0;
        selects.forEach(s => {
            const price = parseFloat(s.selectedOptions[0]?.dataset.price || 0);
            sum += price;
        });
        const promotionOption = promotionSelect.selectedOptions[0];
        const discount = parseFloat(promotionOption?.dataset.discount || 0);
        const total = sum ? Math.round(sum * (100 - discount)) / 100 : 0;

        priceLabel.textContent = `Rp ${sum.toLocaleString('id-ID')}`;
        discountLabel.textContent = `${discount}%`;
        totalLabel.textContent = `Rp ${total.toLocaleString('id-ID')}`;
    }

    promotionSelect.addEventListener('change', updateSummary);
    attachListeners();
    updateSummary();
    
    // customer autofill/disable logic
    const customerSelect = document.getElementById('customerSelect');
    const clearCustomerBtn = document.getElementById('clearCustomer');
    const customerName = document.getElementById('customerName');
    const customerPhone = document.getElementById('customerPhone');
    const customerEmail = document.getElementById('customerEmail');

    function setCustomerFieldsFromOption(opt) {
        const phone = opt?.dataset?.phone || '';
        const email = opt?.dataset?.email || '';
        customerName.value = opt?.textContent?.split(' — ')[0] || '';
        customerPhone.value = phone;
        customerEmail.value = email;
        // disable inputs when existing customer selected
        customerName.disabled = !!opt?.value;
        customerPhone.disabled = !!opt?.value;
        customerEmail.disabled = !!opt?.value;
        clearCustomerBtn.classList.toggle('hidden', !opt?.value);
    }

    customerSelect.addEventListener('change', (e) => {
        const opt = customerSelect.selectedOptions[0];
        if (opt && opt.value) {
            setCustomerFieldsFromOption(opt);
        } else {
            // enable and clear inputs if no customer selected
            customerName.disabled = false;
            customerPhone.disabled = false;
            customerEmail.disabled = false;
            customerName.value = '';
            customerPhone.value = '';
            customerEmail.value = '';
            clearCustomerBtn.classList.add('hidden');
        }
    });

    clearCustomerBtn.addEventListener('click', () => {
        customerSelect.value = '';
        customerSelect.dispatchEvent(new Event('change'));
    });

    // Initialize if old selection exists
    if (customerSelect.selectedOptions[0] && customerSelect.selectedOptions[0].value) {
        setCustomerFieldsFromOption(customerSelect.selectedOptions[0]);
    }

    </script>
@endsection
