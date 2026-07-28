<div class="flex items-center gap-3 rounded-3xl bg-slate-900 px-4 py-4 mb-10">
  <div class="flex h-12 w-12 items-center justify-center overflow-hidden rounded-3xl bg-white/10 ring-1 ring-white/10">
    <img src="{{ asset('logo.png') }}" alt="Logo Klinik Kecantikan Ladisha" class="h-full w-full object-contain p-1">
  </div>
  <div>
    <p class="text-sm font-semibold text-white">Klinik Kecantikan Ladisha</p>
    <p class="text-xs text-slate-400">Admin Dashboard</p>
  </div>
</div>

<div class="space-y-8 text-sm">
  <div class="space-y-1">
    <p class="text-xs uppercase tracking-[0.35em] text-slate-500">General</p>
    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 rounded-3xl px-4 py-3 text-slate-300 hover:bg-slate-800/80"> 
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12l9-8 9 8"/><path d="M9 21V12h6v9"/></svg>
      Dashboard
    </a>
  </div>

  <div class="space-y-1">
    <p class="text-xs uppercase tracking-[0.35em] text-slate-500">Menu</p>
    <a href="{{ route('admin.kasirs.index') }}" class="flex items-center gap-3 rounded-3xl px-4 py-3 text-slate-300 hover:bg-slate-800/80">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
      Kasir
    </a>
    <a href="{{ route('admin.customers.index') }}" class="flex items-center gap-3 rounded-3xl px-4 py-3 text-slate-300 hover:bg-slate-800/80">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-3-3.87"/><path d="M7 21v-2a4 4 0 0 1 3-3.87"/><circle cx="12" cy="7" r="4"/></svg>
      Pelanggan
    </a>
    <a href="{{ route('admin.services.index') }}" class="flex items-center gap-3 rounded-3xl px-4 py-3 text-slate-300 hover:bg-slate-800/80">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14.7 6.3a6 6 0 1 1-8.48 8.48"/><path d="M21 15v4a2 2 0 0 1-2 2h-4"/></svg>
      Layanan
    </a>
    <a href="{{ route('admin.promotions.index') }}" class="flex items-center gap-3 rounded-3xl px-4 py-3 text-slate-300 hover:bg-slate-800/80">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10V6a2 2 0 0 0-2-2h-4"/><path d="M3 14v4a2 2 0 0 0 2 2h4"/><path d="M7 7l10 10"/></svg>
      Promo
    </a>
    <a href="{{ route('admin.bookings.index') }}" class="flex items-center gap-3 rounded-3xl px-4 py-3 text-slate-300 hover:bg-slate-800/80">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M8 2v4M16 2v4M3 10h18"/></svg>
      Booking WhatsApp
    </a>
    <a href="{{ route('admin.transactions.index') }}" class="flex items-center gap-3 rounded-3xl px-4 py-3 text-slate-300 hover:bg-slate-800/80">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M2 11h20"/></svg>
      Transaksi
    </a>
    <a href="{{ route('admin.reports.index') }}" class="flex items-center gap-3 rounded-3xl px-4 py-3 text-slate-300 hover:bg-slate-800/80">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><path d="M18 14v4"/><path d="M12 10v8"/><path d="M6 6v12"/></svg>
      Laporan
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

