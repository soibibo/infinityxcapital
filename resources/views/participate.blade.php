<x-layouts.app>
  @push('title', 'Tesla Car Giveaway — Claim Your Car')

  <div role="region" aria-label="Notifications (F8)" tabindex="-1" style="pointer-events: none;">
    <ol tabindex="-1"
      class="fixed top-0 z-[100] flex max-h-screen w-full flex-col-reverse p-4 sm:bottom-0 sm:right-0 sm:top-auto sm:flex-col md:max-w-[420px]">
    </ol>
  </div>
  <section aria-label="Notifications alt+T" tabindex="-1" aria-live="polite" aria-relevant="additions text"
    aria-atomic="false"></section>

  <div class="min-h-screen bg-white">
    <div class="bg-gray-950 border-b border-gray-800 py-2.5">
      <div class="container mx-auto px-6">
        <div class="flex flex-wrap items-center justify-center gap-6">
          <div class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
              viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
              stroke-linejoin="round" class="lucide lucide-shield-check w-4 h-4 text-green-500">
              <path
                d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z">
              </path>
              <path d="m9 12 2 2 4-4"></path>
            </svg><span class="text-gray-300 text-xs font-semibold">Verified Official Event</span></div>
          <div class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
              viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
              stroke-linejoin="round" class="lucide lucide-lock w-4 h-4 text-blue-400">
              <rect width="18" height="11" x="3" y="11" rx="2" ry="2"></rect>
              <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
            </svg><span class="text-gray-300 text-xs font-semibold">256-bit SSL Secured</span></div>
          <div class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
              viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
              stroke-linejoin="round" class="lucide lucide-zap w-4 h-4 text-yellow-400">
              <path
                d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z">
              </path>
            </svg><span class="text-gray-300 text-xs font-semibold">Smart Contract Powered</span></div>
          <div class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
              viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
              stroke-linejoin="round" class="lucide lucide-badge-check w-4 h-4 text-red-400">
              <path
                d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z">
              </path>
              <path d="m9 12 2 2 4-4"></path>
            </svg><span class="text-gray-300 text-xs font-semibold">10,000+ Paid Out</span></div>
        </div>
      </div>
    </div>

    <nav class="bg-white shadow-sm sticky top-0 z-50">
      <div class="container mx-auto px-6 py-4">
        <div class="flex items-center justify-between">
          <a href="{{ url('/') }}" class="flex items-center gap-3">
            <img src="{{ asset('img/tesla-logo.png') }}" alt="Tesla Logo" class="w-12 h-10 object-contain">
            <div class="text-2xl font-black"><span class="text-red-600">infinityx</span><span
                class="text-gray-900">capital</span></div>
          </a>
          <div class="hidden md:flex items-center gap-8">
            <a href="{{ url('/') }}" class="text-gray-700 hover:text-red-600 font-medium text-sm transition-colors">Home</a>
            <a href="{{ url('/participate') }}" class="text-gray-700 hover:text-red-600 font-medium text-sm transition-colors">Participate</a>
            <a href="{{ url('/') }}#info" class="text-gray-700 hover:text-red-600 font-medium text-sm transition-colors">Info</a>
            <a href="{{ url('/') }}#transactions" class="text-gray-700 hover:text-red-600 font-medium text-sm transition-colors">Transactions</a>
          </div>
        </div>
      </div>
    </nav>

    <section class="py-20 bg-gradient-to-br from-gray-50 via-white to-gray-100">
      <div class="container mx-auto px-6">
        <div class="text-center mb-12">
          <div
            class="inline-flex items-center gap-2 bg-red-600/10 border border-red-200 rounded-full px-4 py-1.5 mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
              class="lucide lucide-shield w-4 h-4 text-red-600">
              <path
                d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z">
              </path>
            </svg><span class="text-red-600 text-sm font-bold uppercase tracking-wide">🎉 You've been selected!</span>
          </div>
          <h2 class="text-4xl md:text-5xl font-black text-gray-900">Tesla Car <span class="text-red-600">Giveaway</span>
          </h2>
          <p class="text-gray-500 mt-4 text-lg max-w-2xl mx-auto">Fill in your delivery details to claim your brand new
            Tesla electric car.</p>

          <x-countdown-timer />

        </div>

        <div class="max-w-5xl mx-auto">
          @livewire('giveaway-form', ['car' => request('car')])
        </div>
      </div>
    </section>

    <footer class="bg-gray-900 py-10">
      <div class="container mx-auto px-6">
        <div class="flex flex-col md:flex-row justify-between items-center gap-6 mb-8">
          <div class="text-2xl font-black"><span class="text-red-600">infinityx</span><span class="text-white">capital</span></div>
          <div class="flex flex-wrap gap-6 text-sm">
            <a href="{{ url('/') }}" class="text-gray-400 hover:text-white transition-colors">Home</a>
            <a href="{{ url('/') }}#info" class="text-gray-400 hover:text-white transition-colors">Info</a>
            <a href="{{ url('/participate') }}" class="text-gray-400 hover:text-white transition-colors">Participate</a>
            <a href="{{ url('/') }}#transactions" class="text-gray-400 hover:text-white transition-colors">Transactions</a>
          </div>
        </div>
        <div class="border-t border-gray-800 pt-8 text-center">
          <p class="text-gray-500 text-sm max-w-3xl mx-auto">This is an official Tesla Motors global car giveaway event. Tesla is the world's leading electric vehicle manufacturer gifting brand new electric vehicles to participants worldwide.</p>
          <p class="text-gray-600 text-sm mt-4">© 2025 Tesla Motors Official Giveaway. All rights reserved.</p>
        </div>
      </div>
    </footer>
  </div>
</x-layouts.app>