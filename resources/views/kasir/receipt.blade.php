@extends('layouts.kasir')

@section('title','Struk Transaksi - Klinik Cantik')
@section('page_title','Struk Transaksi')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="bg-white rounded-3xl shadow p-6 no-print">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-rose-600">Struk Transaksi</h2>
                <p class="mt-2 text-slate-600">Cetak atau simpan bukti pembayaran pelanggan.</p>
            </div>
            <button onclick="window.print()" class="rounded-full bg-rose-500 px-5 py-3 text-white hover:bg-rose-600 transition no-print">Cetak Struk</button>
        </div>
    </div>

    @include('shared.alert', ['type' => 'success', 'message' => session('status')])
    @if($errors->any())
        @include('shared.alert', ['type' => 'error', 'message' => 'Periksa kembali data pembayaran.'])
    @endif

    <style>
        @media print {
            /* hide everything except printable area */
            body * { visibility: hidden; }
            #printableReceipt, #printableReceipt * { visibility: visible; }
            #printableReceipt { position: absolute; left: 0; top: 0; width: 100%; padding: 0.5rem; margin: 0; background: #fff; color: #000; }
            /* remove rounded corners and shadows for cleaner print */
            #printableReceipt .rounded-3xl, #printableReceipt .rounded-2xl { border-radius: 0 !important; box-shadow: none !important; }
            /* hide interactive elements inside printable area */
            #printableReceipt .no-print { display: none !important; }
            /* neutralize background colors */
            * { background: transparent !important; }
            /* tighten font sizes for print */
            #printableReceipt .text-2xl { font-size: 18px; }
        }
    </style>

    <div id="printableReceipt" class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="mb-4 print-header">
            <img src="{{ asset('logo.png') }}" alt="logo" style="height:44px;" />
            <div class="mt-2">
                <strong class="block">Klinik Kecantikan Ladisha</strong>
            </div>
        </div>
        <div class="grid gap-4 md:grid-cols-2">
            <div>
                <p class="text-sm text-slate-500">No. Transaksi</p>
                <p class="mt-2 text-lg font-semibold text-slate-900">#{{ $transaction->id }}</p>
            </div>
            <div>
                <p class="text-sm text-slate-500">Tanggal</p>
                <p class="mt-2 text-lg font-semibold text-slate-900">{{ $transaction->created_at->format('d M Y H:i') }}</p>
            </div>
        </div>

        <div class="mt-6 rounded-3xl border border-dashed border-slate-300 bg-slate-50 p-4 text-sm text-slate-700">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="font-semibold text-slate-900">Status Pembayaran</p>
                    <p class="text-slate-500">@if($transaction->paid_at) Sudah lunas @else Belum lunas, akan dibayar setelah treatment selesai @endif</p>
                </div>
                <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $transaction->paid_at ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">{{ $transaction->paid_at ? 'Lunas' : 'Belum Lunas' }}</span>
            </div>
        </div>

        <div class="mt-6 grid gap-4 md:grid-cols-2">
            <div class="rounded-3xl bg-slate-50 p-4">
                <p class="text-sm text-slate-500">Pelanggan</p>
                <p class="mt-2 font-semibold text-slate-900">{{ $transaction->customer->name ?? 'Pelanggan baru' }}</p>
                <p class="text-sm text-slate-500">{{ $transaction->customer->phone ?? '-' }}</p>
            </div>
            <div class="rounded-3xl bg-slate-50 p-4">
                <p class="text-sm text-slate-500">Kasir</p>
                <p class="mt-2 font-semibold text-slate-900">{{ $transaction->kasir->name ?? Auth::user()->name }}</p>
                <p class="text-sm text-slate-500">{{ $transaction->service->name ?? '-' }}</p>
            </div>
        </div>

        <div class="mt-6 space-y-3 border-t border-slate-200 pt-4 text-sm text-slate-700">
            @php
                $hasItems = $transaction->items && $transaction->items->count();
                $subtotal = $hasItems ? $transaction->items->sum('price') : ($transaction->price ?? 0);
                $discountPercent = $transaction->discount_percent ?? 0;
                $discountAmount = $discountPercent > 0 ? round($subtotal * ($discountPercent / 100)) : 0;
            @endphp

            @if($hasItems)
                @foreach($transaction->items as $item)
                <div class="flex justify-between">
                    <span>{{ $item->service->name }}</span>
                    <span>Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                </div>
                @endforeach
                <div class="flex justify-between">
                    <span>Diskon</span>
                    <span>Rp {{ number_format($discountAmount, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-lg font-semibold text-rose-600">
                    <span>Total</span>
                    <span>Rp {{ number_format($transaction->total, 0, ',', '.') }}</span>
                </div>
            @else
                <div class="flex justify-between">
                    <span>Harga layanan</span>
                    <span>Rp {{ number_format($transaction->price, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Diskon</span>
                    <span>Rp {{ number_format($discountAmount, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-lg font-semibold text-rose-600">
                    <span>Total</span>
                    <span>Rp {{ number_format($transaction->total, 0, ',', '.') }}</span>
                </div>
            @endif
            @if($transaction->promotion)
            <div class="text-slate-500">Promo: {{ $transaction->promotion->title }}</div>
            @endif
            @if($transaction->paid_at)
                <div class="rounded-2xl bg-slate-50 p-4 text-sm text-slate-700">
                    <div class="flex justify-between py-2">
                        <span class="font-medium">Metode Pembayaran</span>
                        <span>{{ ucfirst(str_replace('-', ' ', $transaction->payment_method ?? '')) }}</span>
                    </div>
                    <div class="flex justify-between py-2">
                        <span class="font-medium">Nominal Bayar</span>
                        <span>Rp {{ number_format($transaction->paid_amount ?? $transaction->total, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between py-2">
                        <span class="font-medium">Kembalian</span>
                        <span>Rp {{ number_format($transaction->change_amount ?? 0, 0, ',', '.') }}</span>
                    </div>
                </div>
            @endif
            <div class="mt-4 flex flex-wrap gap-3">
                @if(! $transaction->paid_at)
                    <form method="POST" action="{{ route('kasir.transactions.settle', $transaction) }}" class="settle-payment-form no-print" data-confirm="Konfirmasi pelunasan transaksi ini?">
                        @csrf
                        <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                            <div class="w-full sm:w-auto">
                                <select name="payment_method" class="payment-method-select rounded-full border border-slate-300 bg-white px-4 py-2 text-sm text-slate-700">
                                    <option value="cash">Tunai</option>
                                    <option value="e-wallet">E-Wallet</option>
                                    <option value="transfer">Transfer</option>
                                </select>
                                @error('payment_method')<p class="mt-2 text-sm text-rose-600">{{ $message }}</p>@enderror
                            </div>

                            <div class="flex-1">
                                    <div class="cash-amount-group hidden flex items-center justify-between gap-3 bg-white rounded-2xl border border-slate-200 px-3 py-2">
                                    <input type="number" name="paid_amount" step="0.01" min="{{ $transaction->total }}" placeholder="Bayar Rp" value="{{ old('paid_amount') }}" class="paid-amount w-full sm:w-56 bg-transparent text-sm text-slate-700 outline-none" />
                                    <div class="text-right hidden sm:block">
                                        <p class="text-xs text-slate-500 mb-1">Masukkan nominal tunai untuk melihat kembalian.</p>
                                        <p class="cash-change-preview text-sm font-medium text-slate-700"></p>
                                    </div>
                                </div>
                                <div id="cashValidationAlert" class="mt-2 hidden text-sm font-medium text-rose-600">Uang tidak cukup</div>
                                @error('paid_amount')<p class="mt-2 text-sm text-rose-600">{{ $message }}</p>@enderror
                                <div class="sm:hidden mt-2 text-sm text-slate-500 cash-mobile-info">Masukkan nominal tunai untuk melihat kembalian.<div class="cash-change-preview text-sm font-medium text-slate-700"></div></div>
                            </div>

                            <div class="w-full sm:w-auto">
                                <button type="submit" class="submit-payment rounded-full bg-emerald-500 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-600">Lunasi Pembayaran</button>
                            </div>
                        </div>
                    </form>
                @endif
                <a href="{{ route('kasir.transactions') }}" class="inline-block rounded-full bg-slate-100 px-4 py-2 text-sm text-slate-700 hover:bg-slate-200 no-print">Kembali ke Kasir</a>
            </div>
            @if($errors->has('paid_amount'))
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        var msg = {{ json_encode($errors->first('paid_amount')) }};
                        // show modal with server-side validation message
                        function showModalServer(m) {
                            var modal = document.getElementById('validationModal');
                            if (!modal) return;
                            modal.querySelector('.validation-message').textContent = m;
                            modal.classList.remove('hidden');
                        }
                        showModalServer(msg);
                    });
                </script>
            @endif

            <!-- Validation modal -->
            <div id="validationModal" class="hidden fixed inset-0 z-50 flex items-center justify-center no-print">
                <div class="fixed inset-0 bg-black/40"></div>
                <div class="relative max-w-md w-full bg-white rounded-2xl shadow-lg p-6 mx-4">
                    <h3 class="text-lg font-semibold text-slate-900">Validasi</h3>
                    <p class="mt-3 text-sm text-slate-700 validation-message">Pesan validasi</p>
                    <div class="mt-6 text-right">
                        <button id="validationClose" class="rounded-full bg-rose-500 px-4 py-2 text-sm font-semibold text-white hover:bg-rose-600">Tutup</button>
                    </div>
                </div>
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    var form = document.querySelector('.settle-payment-form');
                    if (! form) return;
                    var select = form.querySelector('.payment-method-select');
                    var cashGroup = form.querySelector('.cash-amount-group');
                    var paidInput = form.querySelector('input[name="paid_amount"]');
                    var changePreview = form.querySelector('.cash-change-preview');
                    var submitButton = form.querySelector('.submit-payment');
                    var totalAmount = parseFloat('{{ $transaction->total }}');

                    function formatCurrency(value) {
                        return 'Rp ' + value.toLocaleString('id-ID', {minimumFractionDigits: 0, maximumFractionDigits: 2});
                    }

                    function updateCashPreview() {
                        var value = parseFloat(paidInput.value);
                        if (Number.isNaN(value)) {
                            changePreview.textContent = 'Masukkan nominal tunai untuk melihat kembalian.';
                            submitButton.disabled = true;
                            return;
                        }

                        var change = value - totalAmount;
                        if (change < 0) {
                            changePreview.textContent = 'Nominal kurang ' + formatCurrency(Math.abs(change)) + '. Masukkan lebih besar atau pilih metode lain.';
                            submitButton.disabled = true;
                        } else {
                            changePreview.textContent = 'Kembalian: ' + formatCurrency(change);
                            submitButton.disabled = false;
                        }
                    }

                    function toggleCashField() {
                        if (select.value === 'cash') {
                            cashGroup.classList.remove('hidden');
                            paidInput.required = true;
                            updateCashPreview();
                        } else {
                            cashGroup.classList.add('hidden');
                            paidInput.required = false;
                            paidInput.value = '';
                            changePreview.textContent = '';
                            submitButton.disabled = false;
                        }
                    }

                    select.addEventListener('change', toggleCashField);
                    paidInput.addEventListener('input', updateCashPreview);
                    // show change preview also on mobile helper
                    var cashMobileInfo = form.querySelector('.cash-mobile-info');
                    var mobileChangePreview = cashMobileInfo ? cashMobileInfo.querySelector('.cash-change-preview') : null;

                    function updateCashPreview() {
                        var value = parseFloat(paidInput.value);
                        var alertEl = document.getElementById('cashValidationAlert');
                        if (Number.isNaN(value)) {
                            if (changePreview) changePreview.textContent = 'Masukkan nominal tunai untuk melihat kembalian.';
                            if (mobileChangePreview) mobileChangePreview.textContent = '';
                            if (alertEl) alertEl.classList.add('hidden');
                            submitButton.disabled = true;
                            return;
                        }

                        var change = value - totalAmount;
                        if (change < 0) {
                            var msg = 'Nominal kurang Rp ' + Math.abs(change).toLocaleString('id-ID') + '. Masukkan lebih besar atau pilih metode lain.';
                            if (changePreview) changePreview.textContent = msg;
                            if (mobileChangePreview) mobileChangePreview.textContent = msg;
                            if (alertEl) {
                                alertEl.textContent = 'Uang tidak cukup';
                                alertEl.classList.remove('hidden');
                            }
                            submitButton.disabled = true;
                        } else {
                            var formatted = 'Kembalian: Rp ' + change.toLocaleString('id-ID');
                            if (changePreview) changePreview.textContent = formatted;
                            if (mobileChangePreview) mobileChangePreview.textContent = formatted;
                            if (alertEl) alertEl.classList.add('hidden');
                            submitButton.disabled = false;
                        }
                    }

                    toggleCashField();

                    // Modal show/hide helpers
                    function showModal(msg) {
                        var modal = document.getElementById('validationModal');
                        if (!modal) return;
                        modal.querySelector('.validation-message').textContent = msg;
                        modal.classList.remove('hidden');
                    }
                    function hideModal() {
                        var modal = document.getElementById('validationModal');
                        if (!modal) return;
                        modal.classList.add('hidden');
                    }

                    var validationClose = document.getElementById('validationClose');
                    if (validationClose) validationClose.addEventListener('click', hideModal);

                    // On submit, if validation blocks submission, show modal with the message
                    form.addEventListener('submit', function (e) {
                        if (submitButton.disabled) {
                            e.preventDefault();
                            // prefer detailed preview message if present
                            var msg = (changePreview && changePreview.textContent && changePreview.textContent.trim() !== '') ? changePreview.textContent : 'Ada kesalahan validasi. Periksa input Anda.';
                            showModal(msg);
                        }
                    });
                });
            </script>
        </div>
    </div>
</div>
@endsection