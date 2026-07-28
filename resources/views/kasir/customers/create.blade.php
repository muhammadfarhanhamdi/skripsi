@extends('layouts.kasir')

@section('title','Tambah Member - Klinik Cantik')
@section('page_title','Tambah Member')

@section('content')
<div class="bg-white rounded-3xl shadow p-6 max-w-3xl mx-auto">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-2xl font-bold text-rose-600">Tambah Member Baru</h2>
            <p class="mt-2 text-slate-600">Daftarkan pelanggan sebagai member tanpa membuat transaksi terlebih dahulu.</p>
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

    <div class="mt-6 flex items-start justify-between gap-4">
        @if($existingMembers->isNotEmpty())
            <div class="flex-1 rounded-3xl border border-slate-200 bg-slate-50 p-4">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <h3 class="text-sm font-semibold text-slate-800">Daftar member yang sudah ada</h3>
                        <p class="mt-1 text-sm text-slate-600">Pilih nama yang sudah terdaftar jika pelanggan Anda pernah menjadi member.</p>
                    </div>
                    <div class="w-48">
                        <input id="memberSearch" type="text" placeholder="Cari member..." class="mt-1 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm" />
                    </div>
                </div>

                <div class="mt-4 max-h-64 overflow-y-auto">
                    <table class="min-w-full divide-y divide-slate-200 text-sm bg-white">
                        <thead class="bg-slate-50 text-slate-600">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold">Nama</th>
                                <th class="px-4 py-3 text-left font-semibold">Telepon</th>
                                <th class="px-4 py-3 text-left font-semibold">Email</th>
                                <th class="px-4 py-3 text-left font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="memberTableBody" class="divide-y divide-slate-100">
                            @foreach($existingMembers as $member)
                                <tr data-search="{{ strtolower($member->name . ' ' . ($member->phone ?? '') . ' ' . ($member->email ?? '')) }}" class="hover:bg-slate-50">
                                    <td class="px-4 py-3">{{ $member->name }}</td>
                                    <td class="px-4 py-3">{{ $member->phone ?? '-' }}</td>
                                    <td class="px-4 py-3">{{ $member->email ?? '-' }}</td>
                                    <td class="px-4 py-3">
                                        <button type="button" class="choose-member inline-flex items-center gap-2 rounded-full bg-white border px-3 py-1 text-xs font-medium text-rose-700 hover:bg-rose-50" 
                                            data-name="{{ $member->name }}" data-phone="{{ $member->phone ?? '' }}" data-email="{{ $member->email ?? '' }}">
                                            Pilih
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        <div class="shrink-0">
            <button id="showMemberFormBtn" type="button" class="inline-flex items-center justify-center rounded-full bg-rose-500 px-6 py-3 text-sm font-semibold text-white transition hover:bg-rose-600">Tambah Member</button>
        </div>
    </div>

    <div id="memberFormContainer" class="mt-6 space-y-6 hidden">
        <form method="POST" action="{{ route('kasir.customers.store') }}" class="">
            @csrf

        <div class="grid gap-6 md:grid-cols-2">
            <label class="block">
                <span class="text-sm font-medium text-slate-700">Nama</span>
                <input type="text" name="name" value="{{ old('name') }}" class="mt-2 w-full rounded-3xl border border-slate-300 bg-slate-50 px-4 py-3" required>
                @error('name')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
            </label>
            <label class="block">
                <span class="text-sm font-medium text-slate-700">Telepon</span>
                <input type="text" name="phone" value="{{ old('phone') }}" class="mt-2 w-full rounded-3xl border border-slate-300 bg-slate-50 px-4 py-3">
                @error('phone')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
            </label>
        </div>

        <div class="grid gap-6 md:grid-cols-2">
            <label class="block">
                <span class="text-sm font-medium text-slate-700">Email</span>
                <input type="email" name="email" value="{{ old('email') }}" class="mt-2 w-full rounded-3xl border border-slate-300 bg-slate-50 px-4 py-3">
                @error('email')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
            </label>
            <label class="flex items-center gap-3 mt-6 text-slate-700">
                <input type="checkbox" name="is_member" value="1" {{ old('is_member') ? 'checked' : '' }} class="h-4 w-4 rounded border-slate-300 text-rose-600 focus:ring-rose-500">
                <span>Daftarkan sebagai member</span>
            </label>
        </div>

        <label class="block">
            <span class="text-sm font-medium text-slate-700">Catatan</span>
            <textarea name="notes" rows="4" class="mt-2 w-full rounded-3xl border border-slate-300 bg-slate-50 px-4 py-3">{{ old('notes') }}</textarea>
            @error('notes')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
        </label>

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <button type="button" id="cancelAddMember" class="inline-flex items-center justify-center rounded-full border border-slate-300 bg-white px-6 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-100">Batal</button>
            <button type="submit" class="inline-flex items-center justify-center rounded-full bg-rose-500 px-6 py-3 text-sm font-semibold text-white transition hover:bg-rose-600">Simpan Member</button>
        </div>
    </form>
</div>

    <script>
        (function () {
            const showBtn = document.getElementById('showMemberFormBtn');
            const formContainer = document.getElementById('memberFormContainer');
            const cancelBtn = document.getElementById('cancelAddMember');
            const searchInput = document.getElementById('memberSearch');
            const memberTableBody = document.getElementById('memberTableBody');

            if (showBtn && formContainer) {
                showBtn.addEventListener('click', function () {
                    formContainer.classList.remove('hidden');
                    formContainer.scrollIntoView({ behavior: 'smooth', block: 'center' });
                });
            }

            if (cancelBtn && formContainer) {
                cancelBtn.addEventListener('click', function () {
                    formContainer.classList.add('hidden');
                    showBtn && showBtn.focus();
                });
            }

            // Client-side search/filter for member table
            if (searchInput && memberTableBody) {
                searchInput.addEventListener('input', function (e) {
                    const q = e.target.value.trim().toLowerCase();
                    const rows = Array.from(memberTableBody.querySelectorAll('tr'));
                    if (q === '') {
                        rows.forEach(r => r.style.display = '');
                        return;
                    }
                    rows.forEach(r => {
                        const hay = (r.getAttribute('data-search') || '').toLowerCase();
                        r.style.display = hay.includes(q) ? '' : 'none';
                    });
                });

                // delegate click on choose-member buttons
                memberTableBody.addEventListener('click', function (e) {
                    const btn = e.target.closest('.choose-member');
                    if (!btn) return;
                    const name = btn.getAttribute('data-name') || '';
                    const phone = btn.getAttribute('data-phone') || '';
                    const email = btn.getAttribute('data-email') || '';

                    // show form and populate
                    formContainer.classList.remove('hidden');
                    document.querySelector('input[name="name"]').value = name;
                    document.querySelector('input[name="phone"]').value = phone;
                    document.querySelector('input[name="email"]').value = email;
                    const memberCheck = document.querySelector('input[name="is_member"]');
                    if (memberCheck) memberCheck.checked = true;
                    formContainer.scrollIntoView({ behavior: 'smooth', block: 'center' });
                });
            }
        })();
    </script>

@endsection
