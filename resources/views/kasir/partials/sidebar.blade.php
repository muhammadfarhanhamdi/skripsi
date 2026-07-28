<div class="flex items-center gap-3 rounded-3xl bg-slate-900 px-4 py-4 mb-10">
  <div class="flex h-12 w-12 items-center justify-center overflow-hidden rounded-3xl bg-white/10 ring-1 ring-white/10">
    <img src="{{ asset('logo.png') }}" alt="Logo Klinik Kecantikan Ladisha" class="h-full w-full object-contain p-1">
  </div>
  <div>
    <p class="text-sm font-semibold text-white">Klinik Kecantikan Ladisha</p>
    <p class="text-xs text-slate-400">Panel Kasir</p>
  </div>
</div>

<div class="space-y-8 text-sm">
  <div class="space-y-1">
    <p class="text-xs uppercase tracking-[0.35em] text-slate-500">Menu</p>
    <a href="{{ route('kasir.dashboard') }}" class="flex items-center gap-3 rounded-3xl px-4 py-3 text-slate-300 hover:bg-slate-800/80"> 
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12l9-8 9 8"/><path d="M9 21V12h6v9"/></svg>
      Dashboard
    </a>
    <a href="{{ route('kasir.transactions') }}" class="flex items-center gap-3 rounded-3xl px-4 py-3 text-slate-300 hover:bg-slate-800/80">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 10h18"/><path d="M7 6h10"/><path d="M12 6v12"/></svg>
      Buat Transaksi
    </a>
    <a href="{{ route('kasir.customers.create') }}" class="flex items-center gap-3 rounded-3xl px-4 py-3 text-slate-300 hover:bg-slate-800/80">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14"/><path d="M5 12h14"/><path d="M17 3a4 4 0 0 1 0 8"/><path d="M7 13a4 4 0 0 1 0-8"/></svg>
      Tambah Member
    </a>
    <a href="{{ route('kasir.history') }}" class="flex items-center gap-3 rounded-3xl px-4 py-3 text-slate-300 hover:bg-slate-800/80">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 4v6h-6"/><path d="M3 20a9 9 0 1 1 6.5 2.8L3 20z"/></svg>
      Riwayat
    </a>
    <a href="{{ route('kasir.unpaid') }}" class="flex items-center gap-3 rounded-3xl px-4 py-3 text-slate-300 hover:bg-slate-800/80">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M8 12h8"/><path d="M8 16h5"/></svg>
      Belum Bayar
    </a>
    <a href="{{ route('kasir.bookings') }}" class="flex items-center gap-3 rounded-3xl px-4 py-3 text-slate-300 hover:bg-slate-800/80">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M8 2v4M16 2v4M3 10h18"/></svg>
      Booking
    </a>
  </div>

  <div class="space-y-1 border-t border-slate-800/60 pt-6">
    <p class="text-xs uppercase tracking-[0.35em] text-slate-500">Akun</p>
    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 rounded-3xl px-4 py-3 text-slate-300 hover:bg-slate-800/80">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 12a4 4 0 1 0-4-4 4 4 0 0 0 4 4z"/><path d="M6 18a6 6 0 0 1 12 0"/></svg>
      Edit Profil
    </a>
    <form method="POST" action="{{ route('logout') }}" class="mt-2">
      @csrf
      <button type="submit" class="flex w-full items-center gap-3 rounded-3xl px-4 py-3 text-left text-slate-300 hover:bg-slate-800/80">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><path d="M16 17l5-5-5-5"/><path d="M21 12H9"/></svg>
        Logout
      </button>
    </form>
  </div>
</div>
