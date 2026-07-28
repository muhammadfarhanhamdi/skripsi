<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Klinik Kecantikan Ladisha')</title>
    <link rel="icon" href="{{ asset('logo.png') }}" type="image/png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
  </head>
  <body class="antialiased bg-rose-50 text-gray-800 min-h-screen flex flex-col">
    <main class="flex-1 @yield('main-class', '')">
      @yield('content')
    </main>

    <footer class="mt-0 border-t border-slate-200 bg-slate-50">
      <div class="max-w-[1600px] mx-auto px-4 py-4 text-sm text-slate-500">© {{ date('Y') }} Klinik Kecantikan Ladisha</div>
    </footer>
  </body>
</html>
