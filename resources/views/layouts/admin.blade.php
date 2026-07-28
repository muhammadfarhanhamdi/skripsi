<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Klinik Kecantikan Ladisha')</title>
    <link rel="icon" href="{{ asset('logo.png') }}" type="image/png">
    @vite(['resources/css/app.css'])
  </head>
  <body class="antialiased bg-rose-50 text-gray-800 min-h-screen flex flex-col">
    <main class="flex-1 flex overflow-hidden">
      <aside class="w-72 bg-slate-950 text-slate-200 p-6 overflow-y-auto">
        @include('admin.partials.sidebar')
      </aside>

      <section class="flex-1 overflow-y-auto bg-slate-100 p-8">
        <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
          <div>
            <h1 class="text-2xl font-semibold text-slate-900">@yield('page_title', 'Dashboard')</h1>
            <p class="text-sm text-slate-500">Selamat datang, {{ Auth::user()->name }}.</p>
          </div>
          <div class="w-full md:w-auto">
            <div class="flex flex-wrap items-center gap-4 rounded-3xl border border-slate-200 bg-white px-6 py-4 shadow-sm">
              @php
                $user = Auth::user();
                $initials = collect(explode(' ', trim($user->name ?? 'U')))
                    ->filter()
                    ->take(2)
                    ->map(fn ($part) => strtoupper(mb_substr($part, 0, 1)))
                    ->implode('');
              @endphp
              <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-slate-900 to-slate-700 text-sm font-semibold text-white shadow-inner">
                {{ $initials ?: 'U' }}
              </div>
              <div class="min-w-0">
                <p class="truncate text-sm font-semibold text-slate-900">{{ $user->name }}</p>
                <p class="text-xs uppercase tracking-wide text-slate-500">{{ ucfirst($user->role ?? 'User') }}</p>
              </div>
              <div class="h-10 border-l border-slate-200"></div>
              <a href="{{ route('profile.edit') }}" class="inline-flex items-center rounded-full border border-slate-200 bg-slate-50 px-4 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-100">
                Profile
              </a>
              <form method="POST" action="{{ route('logout') }}" class="inline-flex">
                @csrf
                <button type="submit" class="inline-flex items-center gap-2 rounded-full bg-rose-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-rose-600">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M3 4.75A1.75 1.75 0 0 1 4.75 3h3.5a.75.75 0 0 1 0 1.5h-3.5a.25.25 0 0 0-.25.25v10a.25.25 0 0 0 .25.25h3.5a.75.75 0 0 1 0 1.5h-3.5A1.75 1.75 0 0 1 3 15.25v-10Zm10.28 1.72a.75.75 0 0 1 1.06 0l2.5 2.5a.75.75 0 0 1 0 1.06l-2.5 2.5a.75.75 0 1 1-1.06-1.06l1.22-1.22H7.75a.75.75 0 0 1 0-1.5h7.75l-1.22-1.22a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                  </svg>
                  Logout
                </button>
              </form>
            </div>
          </div>
        </div>

        @yield('content')
      </section>
    </main>

    <footer class="border-t border-slate-200 bg-slate-50">
      <div class="max-w-[1600px] mx-auto px-4 py-4 text-sm text-slate-500">© {{ date('Y') }} Klinik Kecantikan Ladisha</div>
    </footer>
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('form[data-confirm]').forEach(function (form) {
          form.addEventListener('submit', function (e) {
            var msg = form.getAttribute('data-confirm') || 'Apakah Anda yakin?';
            if (!confirm(msg)) e.preventDefault();
          });
        });

        document.querySelectorAll('[data-confirm]').forEach(function (el) {
          if ((el.tagName === 'A' || el.tagName === 'BUTTON') && !el.closest('form')) {
            el.addEventListener('click', function (e) {
              var msg = el.getAttribute('data-confirm');
              if (msg && !confirm(msg)) e.preventDefault();
            });
          }
        });
      });
    </script>
    @stack('scripts')
  </body>
</html>
