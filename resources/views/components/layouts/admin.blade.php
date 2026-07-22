<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Admin Dashboard') — InfinityX Capital</title>
  <link rel="shortcut icon" href="{{ asset('img/favicon-1.ico') }}">
  @vite(['resources/css/app.css'])
  @livewireStyles
</head>
<body class="bg-gray-100 font-sans antialiased" x-data="{ mobileMenuOpen: false }">
  <div class="flex h-screen overflow-hidden">
    <aside class="hidden lg:flex lg:flex-col w-64 bg-gray-900 text-white">
      <div class="flex items-center gap-2 px-6 py-5 border-b border-gray-700">
        <span class="text-xl font-black tracking-tight">
          <span class="text-red-600">infinityx</span><span class="text-gray-300">capital</span>
        </span>
      </div>
      <nav class="flex-1 px-4 py-6 space-y-1">
        <a href="{{ url('/admin') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium transition-colors {{ request()->is('admin') ? 'bg-red-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
          Dashboard
        </a>
        <a href="{{ url('/admin/settings') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium transition-colors {{ request()->is('admin/settings*') ? 'bg-red-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
          Settings
        </a>
        <a href="{{ url('/admin/payments') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium transition-colors {{ request()->is('admin/payments*') ? 'bg-red-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
          Payments
          @if($pendingPaymentsCount > 0)
            <span class="ml-auto bg-red-600 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full min-w-[1.25rem] text-center">
              {{ $pendingPaymentsCount }}
            </span>
          @endif
        </a>
        <a href="{{ url('/admin/gift-card-types') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium transition-colors {{ request()->is('admin/gift-card-types*') ? 'bg-red-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="8" width="20" height="12" rx="2"/><path d="M12 8V4a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v4"/><path d="M12 8V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v4"/><path d="M12 20v-8"/><path d="M2 14h20"/></svg>
          Gift Card Types
        </a>
        <a href="{{ url('/admin/cars') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium transition-colors {{ request()->is('admin/cars*') ? 'bg-red-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2"/><circle cx="7" cy="17" r="2"/><path d="M9 17h6"/><circle cx="17" cy="17" r="2"/></svg>
          Cars
        </a>
      </nav>
      <div class="px-4 py-4 border-t border-gray-700">
        <form method="POST" action="{{ route('admin.logout') }}">
          @csrf
          <button type="submit" class="flex items-center gap-3 w-full px-3 py-2.5 text-sm font-medium text-gray-300 hover:bg-gray-800 hover:text-white transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
            Logout
          </button>
        </form>
      </div>
    </aside>

    <div class="flex-1 flex flex-col overflow-hidden">
      <header class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between lg:hidden">
        <button type="button" @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-600 hover:text-red-600 focus:outline-none">
          <svg x-show="!mobileMenuOpen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 12h18M3 6h18M3 18h18"/></svg>
          <svg x-show="mobileMenuOpen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>
        </button>
        <span class="text-lg font-black tracking-tight">
          <span class="text-red-600">infinityx</span><span class="text-gray-800">capital</span>
        </span>
        <form method="POST" action="{{ route('admin.logout') }}">
          @csrf
          <button type="submit" class="text-sm text-gray-600 hover:text-red-600 font-medium">Logout</button>
        </form>
      </header>

      <main class="flex-1 overflow-y-auto p-6">
        {{ $slot }}
      </main>
    </div>
  </div>

  <!-- Mobile sidebar overlay -->
  <div
    x-show="mobileMenuOpen"
    x-cloak
    class="fixed inset-0 z-40 lg:hidden"
    @click="mobileMenuOpen = false"
  >
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>
  </div>

  <!-- Mobile sidebar -->
  <aside
    x-show="mobileMenuOpen"
    x-cloak
    x-transition:enter="transform transition ease-in-out duration-300"
    x-transition:enter-start="-translate-x-full"
    x-transition:enter-end="translate-x-0"
    x-transition:leave="transform transition ease-in-out duration-300"
    x-transition:leave-start="translate-x-0"
    x-transition:leave-end="-translate-x-full"
    class="fixed inset-y-0 left-0 z-50 w-64 bg-gray-900 text-white lg:hidden flex flex-col"
  >
    <div class="flex items-center justify-between px-6 py-5 border-b border-gray-700">
      <span class="text-xl font-black tracking-tight">
        <span class="text-red-600">infinityx</span><span class="text-gray-300">capital</span>
      </span>
      <button type="button" @click="mobileMenuOpen = false" class="text-gray-400 hover:text-white">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>
      </button>
    </div>
    <nav class="flex-1 px-4 py-6 space-y-1">
      <a href="{{ url('/admin') }}" @click="mobileMenuOpen = false" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium transition-colors {{ request()->is('admin') ? 'bg-red-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
        Dashboard
      </a>
      <a href="{{ url('/admin/settings') }}" @click="mobileMenuOpen = false" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium transition-colors {{ request()->is('admin/settings*') ? 'bg-red-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06-.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
        Settings
      </a>
      <a href="{{ url('/admin/payments') }}" @click="mobileMenuOpen = false" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium transition-colors {{ request()->is('admin/payments*') ? 'bg-red-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
        Payments
        @if($pendingPaymentsCount > 0)
          <span class="ml-auto bg-red-600 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full min-w-[1.25rem] text-center">
            {{ $pendingPaymentsCount }}
          </span>
        @endif
      </a>
      <a href="{{ url('/admin/gift-card-types') }}" @click="mobileMenuOpen = false" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium transition-colors {{ request()->is('admin/gift-card-types*') ? 'bg-red-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="8" width="20" height="12" rx="2"/><path d="M12 8V4a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v4"/><path d="M12 8V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v4"/><path d="M12 20v-8"/><path d="M2 14h20"/></svg>
          Gift Card Types
        </a>
      <a href="{{ url('/admin/cars') }}" @click="mobileMenuOpen = false" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium transition-colors {{ request()->is('admin/cars*') ? 'bg-red-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2"/><circle cx="7" cy="17" r="2"/><path d="M9 17h6"/><circle cx="17" cy="17" r="2"/></svg>
          Cars
        </a>
    </nav>
    <div class="px-4 py-4 border-t border-gray-700">
      <form method="POST" action="{{ route('admin.logout') }}">
        @csrf
        <button type="submit" class="flex items-center gap-3 w-full px-3 py-2.5 text-sm font-medium text-gray-300 hover:bg-gray-800 hover:text-white transition-colors">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
          Logout
        </button>
      </form>
    </div>
  </aside>
  @livewireScripts
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
</body>
</html>
