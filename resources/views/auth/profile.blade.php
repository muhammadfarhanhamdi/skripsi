@php
    $layout = Auth::user()->role === 'admin' ? 'layouts.admin' : (Auth::user()->role === 'kasir' ? 'layouts.kasir' : 'layouts.clinic');
@endphp

@extends($layout)

@section('title','Edit Profil - Klinik Cantik')
@section('page_title','Edit Profil')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="max-w-3xl mx-auto rounded-3xl bg-white p-8 shadow-lg shadow-slate-200/70">
        <h2 class="text-2xl font-semibold text-slate-900">Edit Profil</h2>
        <p class="mt-2 text-sm text-slate-500">Perbarui informasi akun Anda di sini.</p>

        @if(session('status'))
            <div class="mt-6 rounded-2xl bg-emerald-50 p-4 text-sm text-emerald-700 ring-1 ring-emerald-200">
                {{ session('status') }}
            </div>
        @endif

    <form method="POST" action="{{ route('profile.update') }}">
        @csrf

        <div class="grid gap-6">
            <label class="block">
                <span class="text-sm font-medium text-slate-700">Nama</span>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-200" required>
                @error('name') <p class="mt-2 text-sm text-rose-600">{{ $message }}</p> @enderror
            </label>

            <label class="block">
                <span class="text-sm font-medium text-slate-700">Email</span>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-200" required>
                @error('email') <p class="mt-2 text-sm text-rose-600">{{ $message }}</p> @enderror
            </label>

            <label class="block">
                <span class="text-sm font-medium text-slate-700">Password baru <span class="text-slate-400">(opsional)</span></span>
                <input type="password" name="password" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-200">
                @error('password') <p class="mt-2 text-sm text-rose-600">{{ $message }}</p> @enderror
            </label>

            <label class="block">
                <span class="text-sm font-medium text-slate-700">Konfirmasi password</span>
                <input type="password" name="password_confirmation" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-200">
            </label>
        </div>

        <div class="mt-6 flex items-center gap-3">
            <button type="submit" class="rounded-full bg-rose-500 px-6 py-3 text-white font-semibold transition hover:bg-rose-600">Simpan Perubahan</button>
            <a href="{{ url()->previous() }}" class="text-sm text-slate-500 hover:text-slate-700">Batal</a>
        </div>
    </form>
</div>
@endsection
