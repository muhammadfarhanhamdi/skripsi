@extends('layouts.clinic')

@section('title','Login - Klinik Kecantikan Ladisha')

@section('content')
    <div class="min-h-[calc(100vh-4rem)] px-4 py-10 sm:px-6 lg:px-8">
        <div class="mx-auto grid min-h-[calc(100vh-6rem)] max-w-6xl overflow-hidden rounded-[36px] border border-slate-200 bg-white shadow-[0_30px_80px_rgba(15,23,42,0.12)] lg:grid-cols-[1.05fr_0.95fr]">
            <div class="relative flex items-end overflow-hidden bg-gradient-to-br from-slate-950 via-slate-900 to-rose-900 p-8 sm:p-10 lg:p-12">
                <div class="absolute inset-0 opacity-25" style="background-image: radial-gradient(circle at top left, rgba(244,63,94,0.45), transparent 30%), radial-gradient(circle at 80% 20%, rgba(255,255,255,0.18), transparent 26%), radial-gradient(circle at 30% 80%, rgba(248,113,113,0.25), transparent 28%);"></div>
                <div class="relative z-10 max-w-xl text-white">
                    <div class="inline-flex items-center gap-3 rounded-full border border-white/15 bg-white/10 px-4 py-2 text-sm font-medium text-white/90 backdrop-blur">
                        <span class="flex h-2.5 w-2.5 rounded-full bg-emerald-400"></span>
                        Klinik Kecantikan Ladisha Panel
                    </div>
                    <h1 class="mt-6 text-4xl font-semibold leading-tight sm:text-5xl">Masuk dengan tampilan yang lebih modern dan nyaman.</h1>
                    <p class="mt-4 max-w-lg text-sm leading-6 text-slate-200 sm:text-base">Akses cepat untuk admin dan kasir, dengan tampilan yang rapi, elegan, dan tetap fokus pada proses kerja harian.</p>

                    <div class="mt-10 grid gap-4 sm:grid-cols-3">
                        <div class="rounded-3xl border border-white/10 bg-white/10 p-4 backdrop-blur">
                            <p class="text-xs uppercase tracking-[0.25em] text-slate-300">Cepat</p>
                            <p class="mt-2 text-lg font-semibold">Login ringkas</p>
                        </div>
                        <div class="rounded-3xl border border-white/10 bg-white/10 p-4 backdrop-blur">
                            <p class="text-xs uppercase tracking-[0.25em] text-slate-300">Aman</p>
                            <p class="mt-2 text-lg font-semibold">Role-based access</p>
                        </div>
                        <div class="rounded-3xl border border-white/10 bg-white/10 p-4 backdrop-blur">
                            <p class="text-xs uppercase tracking-[0.25em] text-slate-300">Rapi</p>
                            <p class="mt-2 text-lg font-semibold">UI modern</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-center bg-slate-50 px-6 py-10 sm:px-10 lg:px-12">
                <div class="w-full max-w-md rounded-[32px] border border-slate-200 bg-white p-8 shadow-sm sm:p-10">
                    <div class="flex items-center gap-4">
                        <div class="flex h-14 w-14 items-center justify-center overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                            <img src="{{ asset('logo.png') }}" alt="Logo Klinik Kecantikan Ladisha" class="h-full w-full object-contain p-1">
                        </div>
                        <div>
                            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-rose-500">Selamat Datang</p>
                            <h2 class="mt-1 text-2xl font-semibold text-slate-900">Masuk ke akun Anda</h2>
                        </div>
                    </div>

                    <p class="mt-4 text-sm leading-6 text-slate-500">Gunakan email dan password yang sudah terdaftar untuk masuk ke dashboard admin atau kasir.</p>

                    @if($errors->any())
                        <div class="mt-6 rounded-2xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-700">
                            <p class="font-semibold">Login gagal</p>
                            <p class="mt-1">Periksa kembali email dan password Anda.</p>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-5">
                        @csrf

                        <label class="block">
                            <span class="text-sm font-medium text-slate-700">Email</span>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" class="mt-2 w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-rose-400 focus:bg-white focus:ring-4 focus:ring-rose-100" required>
                        </label>

                        <label class="block">
                            <span class="text-sm font-medium text-slate-700">Password</span>
                            <input type="password" name="password" placeholder="Masukkan password" class="mt-2 w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-rose-400 focus:bg-white focus:ring-4 focus:ring-rose-100" required>
                        </label>

                        <div class="flex items-center justify-between gap-4">
                            <label class="flex items-center gap-2 text-sm text-slate-600">
                                <input type="checkbox" name="remember" class="h-4 w-4 rounded border-slate-300 text-rose-500 focus:ring-rose-400">
                                Ingat saya
                            </label>
                            <span class="text-xs text-slate-400">Akses admin & kasir</span>
                        </div>

                        <button class="inline-flex w-full items-center justify-center rounded-2xl bg-rose-500 px-5 py-3.5 text-sm font-semibold text-white shadow-lg shadow-rose-200 transition hover:bg-rose-600 hover:shadow-xl hover:shadow-rose-200 focus:outline-none focus:ring-4 focus:ring-rose-100">
                            Masuk Sekarang
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
