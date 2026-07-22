<x-layouts.app>
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
      <nav x-data="{ mobileMenuOpen: false }" class="bg-white shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4">
          <div class="flex items-center justify-between">
            <a href="{{ url('/') }}" class="flex items-center gap-3">
              <img src="img/tesla-logo.png" alt="Tesla Logo" class="w-12 h-10 object-contain">
              <div class="text-2xl font-black"><span class="text-red-600">infinityx</span><span class="text-gray-900">capital</span></div>
            </a>
            <div class="hidden md:flex items-center gap-8"><a href="#giveaway"
                class="text-gray-700 hover:text-red-600 font-medium text-sm transition-colors">Giveaway</a><a
                href="#info" class="text-gray-700 hover:text-red-600 font-medium text-sm transition-colors">Info</a><a
                href="#instruction"
                class="text-gray-700 hover:text-red-600 font-medium text-sm transition-colors">Instruction</a><a
                href="#participate"
                class="text-gray-700 hover:text-red-600 font-medium text-sm transition-colors">Participate</a><a
                href="#transactions"
                class="text-gray-700 hover:text-red-600 font-medium text-sm transition-colors">Transactions</a><a
                href="https://invest.infinityxcapital.com" target="_blank" rel="noreferrer"
                class="text-gray-700 hover:text-red-600 font-medium text-sm transition-colors">Investment</a><a
                href="{{ url('/participate') }}"><button
                  class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 h-10 py-2 bg-red-600 hover:bg-red-700 text-white font-bold px-6">Claim
                  Now</button></a></div><button @click="mobileMenuOpen = !mobileMenuOpen"
                :aria-expanded="mobileMenuOpen" class="md:hidden text-gray-700 focus:outline-none"><svg
                  x-show="!mobileMenuOpen" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                  viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                  stroke-linejoin="round" class="lucide lucide-menu w-6 h-6">
                  <line x1="4" x2="20" y1="12" y2="12"></line>
                  <line x1="4" x2="20" y1="6" y2="6"></line>
                  <line x1="4" x2="20" y1="18" y2="18"></line>
                </svg><svg x-show="mobileMenuOpen" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                  viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                  stroke-linejoin="round" class="lucide lucide-x w-6 h-6">
                  <path d="M18 6 6 18"></path>
                  <path d="m6 6 12 12"></path>
                </svg></button>
          </div>
          <div x-show="mobileMenuOpen" x-transition class="md:hidden mt-4 pb-2 border-t border-gray-100 pt-4">
            <div class="flex flex-col gap-3"><a href="#giveaway" @click="mobileMenuOpen = false"
                class="text-gray-700 hover:text-red-600 font-medium text-sm transition-colors">Giveaway</a><a
                href="#info" @click="mobileMenuOpen = false"
                class="text-gray-700 hover:text-red-600 font-medium text-sm transition-colors">Info</a><a
                href="#instruction" @click="mobileMenuOpen = false"
                class="text-gray-700 hover:text-red-600 font-medium text-sm transition-colors">Instruction</a><a
                href="#participate" @click="mobileMenuOpen = false"
                class="text-gray-700 hover:text-red-600 font-medium text-sm transition-colors">Participate</a><a
                href="#transactions" @click="mobileMenuOpen = false"
                class="text-gray-700 hover:text-red-600 font-medium text-sm transition-colors">Transactions</a><a
                href="https://invest.infinityxcapital.com" target="_blank" rel="noreferrer" @click="mobileMenuOpen = false"
                class="text-gray-700 hover:text-red-600 font-medium text-sm transition-colors">Investment</a><a
                href="{{ url('/participate') }}" @click="mobileMenuOpen = false"><button
                  class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 h-10 py-2 bg-red-600 hover:bg-red-700 text-white font-bold px-6">Claim
                  Now</button></a></div>
          </div>
        </div>
      </nav>
      <section id="giveaway"
        class="bg-gradient-to-br from-gray-50 via-white to-gray-100 min-h-screen relative overflow-hidden flex items-center">
        <div class="absolute inset-0 opacity-5">
          <div class="absolute top-0 right-0 w-96 h-96 bg-red-500 rounded-full blur-3xl"></div>
          <div class="absolute bottom-0 left-0 w-64 h-64 bg-red-400 rounded-full blur-3xl"></div>
        </div>
        <div class="container mx-auto px-6 py-16 relative z-10">
          <div class="grid lg:grid-cols-2 gap-8 items-center">
            <div style="opacity: 1; transform: none;">
              <div class="flex flex-wrap items-center gap-3 mb-8">
                <div
                  class="inline-flex items-center gap-2 bg-white border border-gray-200 rounded-full px-4 py-2 shadow-sm"
                  style="opacity: 1; transform: none;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" class="lucide lucide-circle-check-big w-4 h-4 text-red-600 fill-red-600">
                    <path d="M21.801 10A10 10 0 1 1 17 3.335"></path>
                    <path d="m9 11 3 3L22 4"></path>
                  </svg><span class="text-sm font-semibold text-gray-700">Official Event</span></div>
                <div
                  class="inline-flex items-center gap-2 bg-green-50 border border-green-200 rounded-full px-4 py-2 shadow-sm"
                  style="opacity: 1; transform: none;"><span class="relative flex w-2 h-2"><span
                      class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span><span
                      class="relative inline-flex rounded-full w-2 h-2 bg-green-500"></span></span><span
                    class="text-sm font-semibold text-green-700">LIVE — 12,872 joined</span></div>
              </div>
              <h1 class="text-5xl lg:text-7xl font-black text-gray-900 leading-tight">Win a <span
                  class="text-red-600">Brand New</span> Tesla Electric Car</h1>
              <p class="text-gray-600 mt-6 text-lg max-w-lg" style="opacity: 1;">Tesla, the world's leading electric
                vehicle manufacturer, is giving away brand new electric cars to participants worldwide. Claim your car
                today!</p>
              <div class="flex flex-col sm:flex-row gap-4 mt-8" style="opacity: 1; transform: none;"><a
                  href="{{ url('/participate') }}"><button
                    class="inline-flex items-center justify-center gap-2 whitespace-nowrap ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 h-10 bg-red-600 hover:bg-red-700 text-white px-8 py-6 text-lg font-bold rounded-xl shadow-lg shadow-red-200">
                    &#128663 -; Claim Your Free Car &rarr;</button></a><a href="#participate"><button
                    class="inline-flex items-center justify-center gap-2 whitespace-nowrap ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-background hover:text-accent-foreground h-10 border-2 border-gray-300 text-gray-800 hover:bg-gray-50 px-8 py-6 text-lg font-bold rounded-xl">View
                    All Models</button></a></div>
              <div class="flex items-center gap-6 mt-10"><span class="text-gray-500 text-sm font-medium">🔒 SSL
                  Secured</span><span class="text-gray-500 text-sm font-medium">✅ Verified</span><span
                  class="text-gray-500 text-sm font-medium">🌍 Global</span></div>
            </div>
            <div class="relative" style="opacity: 1; transform: none;">
              <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-3xl p-6 shadow-xl border border-red-100"><img
                  src="img/tesla-model-s.jpg" alt="Tesla Electric Car" class="w-full h-auto rounded-2xl">
                <div class="mt-4 text-center">
                  <p class="text-red-600 font-black text-2xl">Tesla Electric Car</p>
                  <p class="text-gray-500 mt-1">100% Free — Just Pay Delivery</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <section id="info" class="py-20 bg-white">
        <div class="container mx-auto px-6">
          <div class="text-center mb-12" style="opacity: 1; transform: none;">
            <h2 class="text-4xl font-black text-gray-900">Available <span class="text-red-600">Tesla Cars</span></h2>
            <p class="text-gray-600 mt-4 text-lg max-w-2xl mx-auto">Choose your preferred Tesla electric car. All models
              are brand new <strong class="text-red-600">2024–2025</strong> editions delivered straight to your door.
            </p>
          </div>
          <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div
              class="bg-gradient-to-br from-red-50 to-red-100 rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 text-center relative"
              style="opacity: 1; transform: none;">
              <div class="absolute top-3 right-3"><span
                  class="bg-red-600 text-white text-xs font-bold px-2 py-1 rounded-full">Most Popular</span></div><img
                src="img/tesla-model-3.jpg" alt="Tesla Model 3 2025" class="w-full h-32 object-contain rounded-xl mb-4">
              <h3 class="text-xl font-black text-gray-900">Tesla Model 3 2025</h3>
              <p class="text-red-600 font-bold text-lg mt-1">Electric Sedan</p>
              <p class="text-gray-500 text-sm mt-2">358mi range · 510hp</p>
              <div class="mt-4 bg-white rounded-xl py-2 px-4 border border-gray-200"><span
                  class="text-green-600 font-bold text-sm">FREE 🎉</span></div>
            </div>
            <div
              class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 text-center relative"
              style="opacity: 1; transform: none;">
              <div class="absolute top-3 right-3"><span
                  class="bg-red-600 text-white text-xs font-bold px-2 py-1 rounded-full">Best SUV</span></div><img
                src="img/tesla-model-y.jpg" alt="Tesla Model Y 2025" class="w-full h-32 object-contain rounded-xl mb-4">
              <h3 class="text-xl font-black text-gray-900">Tesla Model Y 2025</h3>
              <p class="text-red-600 font-bold text-lg mt-1">Electric SUV</p>
              <p class="text-gray-500 text-sm mt-2">330mi range · 384hp</p>
              <div class="mt-4 bg-white rounded-xl py-2 px-4 border border-gray-200"><span
                  class="text-green-600 font-bold text-sm">FREE 🎉</span></div>
            </div>
            <div
              class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 text-center relative"
              style="opacity: 1; transform: none;">
              <div class="absolute top-3 right-3"><span
                  class="bg-red-600 text-white text-xs font-bold px-2 py-1 rounded-full">Premium</span></div><img
                src="img/tesla-model-s.jpg" alt="Tesla Model S 2025" class="w-full h-32 object-contain rounded-xl mb-4">
              <h3 class="text-xl font-black text-gray-900">Tesla Model S 2025</h3>
              <p class="text-red-600 font-bold text-lg mt-1">Luxury Sedan</p>
              <p class="text-gray-500 text-sm mt-2">405mi range · 670hp</p>
              <div class="mt-4 bg-white rounded-xl py-2 px-4 border border-gray-200"><span
                  class="text-green-600 font-bold text-sm">FREE 🎉</span></div>
            </div>
            <div
              class="bg-gradient-to-br from-green-50 to-green-100 rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 text-center relative"
              style="opacity: 1; transform: none;">
              <div class="absolute top-3 right-3"><span
                  class="bg-red-600 text-white text-xs font-bold px-2 py-1 rounded-full">Eco Pick</span></div><img
                src="img/tesla-model-x.jpg" alt="Tesla Model X 2025" class="w-full h-32 object-contain rounded-xl mb-4">
              <h3 class="text-xl font-black text-gray-900">Tesla Model X 2025</h3>
              <p class="text-red-600 font-bold text-lg mt-1">Luxury SUV</p>
              <p class="text-gray-500 text-sm mt-2">348mi range · 670hp</p>
              <div class="mt-4 bg-white rounded-xl py-2 px-4 border border-gray-200"><span
                  class="text-green-600 font-bold text-sm">FREE 🎉</span></div>
            </div>
          </div>
        </div>
      </section>
      <section class="py-12 bg-gray-950">
        <div class="container mx-auto px-6">
          <div class="text-center mb-10" style="opacity: 1; transform: none;">
            <div
              class="inline-flex items-center gap-2 bg-red-600/20 border border-red-500/40 rounded-full px-4 py-1.5 mb-4">
              <span class="relative flex w-2 h-2"><span
                  class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span><span
                  class="relative inline-flex rounded-full w-2 h-2 bg-red-500"></span></span><span
                class="text-red-400 text-sm font-bold uppercase tracking-wide">Official Announcement</span></div>
            <h2 class="text-4xl font-black text-white">Tesla's <span class="text-red-500">Global Car</span> Giveaway
            </h2>
            <p class="text-gray-400 mt-3 text-lg max-w-2xl mx-auto">Watch Tesla's official announcement of their biggest
              car giveaway for all countries worldwide.</p>
          </div>
          <div class="max-w-sm mx-auto md:max-w-md" style="opacity: 1; transform: none;">
            <!-- Tabs -->
            <div class="flex rounded-xl overflow-hidden border border-gray-700 mb-4">
              <button onclick="switchTab('sec1','video')" id="sec1-tab-video"
                class="flex-1 py-2 text-sm font-bold transition-colors bg-red-600 text-white">&#9654; Video</button>
              <button onclick="switchTab('sec1','comments')" id="sec1-tab-comments"
                class="flex-1 py-2 text-sm font-bold transition-colors bg-gray-800 text-gray-400">&#128172; Comments</button>
            </div>
            <!-- Video panel -->
            <div id="sec1-video">
            <div
              class="relative rounded-2xl overflow-hidden shadow-2xl shadow-red-900/30 border border-gray-800 bg-black">
              <div class="relative w-full" style="padding-bottom: 177.78%;"><iframe src="https://www.youtube.com/embed/XTeWKmlNmN8?rel=0&modestbranding=1&fs=1&playsinline=1"
                  title="Tesla Official Announcement"
                  allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                  allowfullscreen="" class="absolute inset-0 w-full h-full"></iframe></div>
            </div>
            <div class="mt-4 flex items-center justify-between">
              <div class="flex items-center gap-3"><img src="img/tesla-logo.png" alt="Tesla"
                  class="w-10 h-10 rounded-full object-contain bg-white border border-red-600 p-0.5">
                <div>
                  <p class="text-white text-sm font-bold">Tesla Official</p>
                  <p class="text-gray-400 text-xs">28.4M subscribers</p>
                </div>
              </div><button
                class="px-4 py-2 rounded-full text-sm font-bold transition-colors bg-red-600 hover:bg-red-700 text-white">Subscribe</button>
            </div>
            <div class="mt-3 flex items-center gap-2 flex-wrap"><button
                class="flex items-center gap-1.5 bg-gray-800 hover:bg-gray-700 text-white text-xs font-semibold px-3 py-1.5 rounded-full transition-colors">👍 1.2M</button><button
                class="flex items-center gap-1.5 bg-gray-800 hover:bg-gray-700 text-white text-xs font-semibold px-3 py-1.5 rounded-full transition-colors">👎</button><button
                class="flex items-center gap-1.5 bg-gray-800 hover:bg-gray-700 text-white text-xs font-semibold px-3 py-1.5 rounded-full transition-colors">↗ Share</button><button
                class="flex items-center gap-1.5 bg-gray-800 hover:bg-gray-700 text-white text-xs font-semibold px-3 py-1.5 rounded-full transition-colors">⬇ Download</button></div>
            </div>
            <!-- Comments panel -->
            <div id="sec1-comments" style="display:none;">
            <div class="mt-4">
              <p class="text-gray-400 text-xs mb-3 font-semibold">Comments · 70,842</p>
              <div class="space-y-3">
                <div class="flex gap-3" style="opacity: 1; transform: none;">
                  <div
                    class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white text-xs font-bold shrink-0">
                    MJ</div>
                  <div class="flex-1">
                    <div class="flex items-center gap-2 mb-1"><span class="text-white text-xs font-bold">Mike
                        Johnson</span><span class="text-gray-500 text-xs">2 days ago</span><span
                        class="text-red-400 text-xs">📌 Pinned</span></div>
                    <p class="text-gray-300 text-xs leading-relaxed">Just received my Tesla Model 3 2024!! I paid the
                      delivery fee and within 9 days the car was at my door. This is REAL! 🚗⚡</p>
                    <div class="flex items-center gap-4 mt-1.5"><button
                        class="flex items-center gap-1 text-gray-500 hover:text-white text-xs"><svg
                          xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                          class="lucide lucide-thumbs-up w-3 h-3">
                          <path d="M7 10v12"></path>
                          <path
                            d="M15 5.88 14 10h5.83a2 2 0 0 1 1.92 2.56l-2.33 8A2 2 0 0 1 17.5 22H4a2 2 0 0 1-2-2v-8a2 2 0 0 1 2-2h2.76a2 2 0 0 0 1.79-1.11L12 2a3.13 3.13 0 0 1 3 3.88Z">
                          </path>
                        </svg> 48.2K</button><button
                        class="flex items-center gap-1 text-gray-500 hover:text-white text-xs"><svg
                          xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                          class="lucide lucide-thumbs-down w-3 h-3">
                          <path d="M17 14V2"></path>
                          <path
                            d="M9 18.12 10 14H4.17a2 2 0 0 1-1.92-2.56l2.33-8A2 2 0 0 1 6.5 2H20a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2h-2.76a2 2 0 0 0-1.79 1.11L12 22a3.13 3.13 0 0 1-3-3.88Z">
                          </path>
                        </svg></button><span class="text-gray-600 text-xs">Reply</span></div>
                  </div>
                </div>
                <div class="flex gap-3" style="opacity: 1; transform: none;">
                  <div
                    class="w-8 h-8 bg-pink-500 rounded-full flex items-center justify-center text-white text-xs font-bold shrink-0">
                    SW</div>
                  <div class="flex-1">
                    <div class="flex items-center gap-2 mb-1"><span class="text-white text-xs font-bold">Sarah
                        Williams</span><span class="text-gray-500 text-xs">1 day ago</span></div>
                    <p class="text-gray-300 text-xs leading-relaxed">I received my Tesla Model Y 2025 after paying the
                      delivery fee. I cried when I saw the car parked outside! 🙏</p>
                    <div class="flex items-center gap-4 mt-1.5"><button
                        class="flex items-center gap-1 text-gray-500 hover:text-white text-xs"><svg
                          xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                          class="lucide lucide-thumbs-up w-3 h-3">
                          <path d="M7 10v12"></path>
                          <path
                            d="M15 5.88 14 10h5.83a2 2 0 0 1 1.92 2.56l-2.33 8A2 2 0 0 1 17.5 22H4a2 2 0 0 1-2-2v-8a2 2 0 0 1 2-2h2.76a2 2 0 0 0 1.79-1.11L12 2a3.13 3.13 0 0 1 3 3.88Z">
                          </path>
                        </svg> 32.4K</button><button
                        class="flex items-center gap-1 text-gray-500 hover:text-white text-xs"><svg
                          xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                          class="lucide lucide-thumbs-down w-3 h-3">
                          <path d="M17 14V2"></path>
                          <path
                            d="M9 18.12 10 14H4.17a2 2 0 0 1-1.92-2.56l2.33-8A2 2 0 0 1 6.5 2H20a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2h-2.76a2 2 0 0 0-1.79 1.11L12 22a3.13 3.13 0 0 1-3-3.88Z">
                          </path>
                        </svg></button><span class="text-gray-600 text-xs">Reply</span></div>
                  </div>
                </div>
                <div class="flex gap-3" style="opacity: 1; transform: none;">
                  <div
                    class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center text-white text-xs font-bold shrink-0">
                    CM</div>
                  <div class="flex-1">
                    <div class="flex items-center gap-2 mb-1"><span class="text-white text-xs font-bold">Carlos
                        Mendez</span><span class="text-gray-500 text-xs">3 days ago</span></div>
                    <p class="text-gray-300 text-xs leading-relaxed">From Mexico! I received my Tesla Model 3 2024 after
                      paying the delivery fee. This giveaway is 100% real!</p>
                    <div class="flex items-center gap-4 mt-1.5"><button
                        class="flex items-center gap-1 text-gray-500 hover:text-white text-xs"><svg
                          xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                          class="lucide lucide-thumbs-up w-3 h-3">
                          <path d="M7 10v12"></path>
                          <path
                            d="M15 5.88 14 10h5.83a2 2 0 0 1 1.92 2.56l-2.33 8A2 2 0 0 1 17.5 22H4a2 2 0 0 1-2-2v-8a2 2 0 0 1 2-2h2.76a2 2 0 0 0 1.79-1.11L12 2a3.13 3.13 0 0 1 3 3.88Z">
                          </path>
                        </svg> 29.2K</button><button
                        class="flex items-center gap-1 text-gray-500 hover:text-white text-xs"><svg
                          xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                          class="lucide lucide-thumbs-down w-3 h-3">
                          <path d="M17 14V2"></path>
                          <path
                            d="M9 18.12 10 14H4.17a2 2 0 0 1-1.92-2.56l2.33-8A2 2 0 0 1 6.5 2H20a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2h-2.76a2 2 0 0 0-1.79 1.11L12 22a3.13 3.13 0 0 1-3-3.88Z">
                          </path>
                        </svg></button><span class="text-gray-600 text-xs">Reply</span></div>
                  </div>
                </div>
                <div class="flex gap-3" style="opacity: 1; transform: none;">
                  <div
                    class="w-8 h-8 bg-purple-600 rounded-full flex items-center justify-center text-white text-xs font-bold shrink-0">
                    DC</div>
                  <div class="flex-1">
                    <div class="flex items-center gap-2 mb-1"><span class="text-white text-xs font-bold">David
                        Chen</span><span class="text-gray-500 text-xs">2 days ago</span></div>
                    <p class="text-gray-300 text-xs leading-relaxed">I was skeptical at first but I paid the delivery
                      fee and received my Tesla Model S 2025. So real!</p>
                    <div class="flex items-center gap-4 mt-1.5"><button
                        class="flex items-center gap-1 text-gray-500 hover:text-white text-xs"><svg
                          xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                          class="lucide lucide-thumbs-up w-3 h-3">
                          <path d="M7 10v12"></path>
                          <path
                            d="M15 5.88 14 10h5.83a2 2 0 0 1 1.92 2.56l-2.33 8A2 2 0 0 1 17.5 22H4a2 2 0 0 1-2-2v-8a2 2 0 0 1 2-2h2.76a2 2 0 0 0 1.79-1.11L12 2a3.13 3.13 0 0 1 3 3.88Z">
                          </path>
                        </svg> 26.1K</button><button
                        class="flex items-center gap-1 text-gray-500 hover:text-white text-xs"><svg
                          xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                          class="lucide lucide-thumbs-down w-3 h-3">
                          <path d="M17 14V2"></path>
                          <path
                            d="M9 18.12 10 14H4.17a2 2 0 0 1-1.92-2.56l2.33-8A2 2 0 0 1 6.5 2H20a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2h-2.76a2 2 0 0 0-1.79 1.11L12 22a3.13 3.13 0 0 1-3-3.88Z">
                          </path>
                        </svg></button><span class="text-gray-600 text-xs">Reply</span></div>
                  </div>
                </div>
                <div class="flex gap-3" style="opacity: 1; transform: none;">
                  <div
                    class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center text-white text-xs font-bold shrink-0">
                    AO</div>
                  <div class="flex-1">
                    <div class="flex items-center gap-2 mb-1"><span class="text-white text-xs font-bold">Amara
                        Osei</span><span class="text-gray-500 text-xs">1 day ago</span></div>
                    <p class="text-gray-300 text-xs leading-relaxed">From Ghana I paid the delivery fee and
                      received my Tesla Model 3 2025! God bless Tesla!</p>
                    <div class="flex items-center gap-4 mt-1.5"><button
                        class="flex items-center gap-1 text-gray-500 hover:text-white text-xs"><svg
                          xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                          class="lucide lucide-thumbs-up w-3 h-3">
                          <path d="M7 10v12"></path>
                          <path
                            d="M15 5.88 14 10h5.83a2 2 0 0 1 1.92 2.56l-2.33 8A2 2 0 0 1 17.5 22H4a2 2 0 0 1-2-2v-8a2 2 0 0 1 2-2h2.76a2 2 0 0 0 1.79-1.11L12 2a3.13 3.13 0 0 1 3 3.88Z">
                          </path>
                        </svg> 24K</button><button
                        class="flex items-center gap-1 text-gray-500 hover:text-white text-xs"><svg
                          xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                          class="lucide lucide-thumbs-down w-3 h-3">
                          <path d="M17 14V2"></path>
                          <path
                            d="M9 18.12 10 14H4.17a2 2 0 0 1-1.92-2.56l2.33-8A2 2 0 0 1 6.5 2H20a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2h-2.76a2 2 0 0 0-1.79 1.11L12 22a3.13 3.13 0 0 1-3-3.88Z">
                          </path>
                        </svg></button><span class="text-gray-600 text-xs">Reply</span></div>
                  </div>
                </div>
              </div><button class="flex items-center gap-1 text-red-400 text-xs font-semibold mt-3 hover:text-red-300">▼ View 70,842 more comments</button>
            </div>
            </div><!-- end sec1-comments -->
          </div>
        </div>
      </section>
      <section class="bg-gray-950 py-12">
        <div class="container mx-auto px-6">
          <div class="text-center mb-10" style="opacity: 1; transform: none;">
            <h2 class="text-4xl font-black text-white">More <span class="text-red-500">Proof</span> from Winners</h2>
            <p class="text-gray-400 mt-3 text-lg max-w-2xl mx-auto">Watch real testimonials from Tesla car recipients
              around the world.</p>
          </div>
          <div class="max-w-sm mx-auto md:max-w-md" style="opacity: 1; transform: none;">
            <!-- Tabs -->
            <div class="flex rounded-xl overflow-hidden border border-gray-700 mb-4">
              <button onclick="switchTab('sec2','video')" id="sec2-tab-video"
                class="flex-1 py-2 text-sm font-bold transition-colors bg-red-600 text-white">&#9654; Video</button>
              <button onclick="switchTab('sec2','comments')" id="sec2-tab-comments"
                class="flex-1 py-2 text-sm font-bold transition-colors bg-gray-800 text-gray-400">&#128172; Comments</button>
            </div>
            <!-- Video panel -->
            <div id="sec2-video">
            <div
              class="relative rounded-2xl overflow-hidden shadow-2xl shadow-red-900/30 border border-gray-800 bg-black">
              <div class="relative w-full" style="padding-bottom: 177.78%;"><iframe src="https://www.youtube.com/embed/XDkzm_LR0Co?rel=0&modestbranding=1&fs=1&playsinline=1"
                  title="Tesla Winners Testimonials"
                  allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                  allowfullscreen="" class="absolute inset-0 w-full h-full"></iframe></div>
            </div>
            <div class="mt-4 flex items-center justify-between">
              <div class="flex items-center gap-3"><img src="img/tesla-logo.png" alt="Tesla"
                  class="w-10 h-10 rounded-full object-contain bg-white border border-red-600 p-0.5">
                <div>
                  <p class="text-white text-sm font-bold">Tesla Global</p>
                  <p class="text-gray-400 text-xs">12.8M subscribers</p>
                </div>
              </div><button
                class="px-4 py-2 rounded-full text-sm font-bold transition-colors bg-red-600 hover:bg-red-700 text-white">Subscribe</button>
            </div>
            </div>
            <!-- Comments panel -->
            <div id="sec2-comments" style="display:none;">
            <div class="mt-4">
              <p class="text-gray-400 text-xs mb-3 font-semibold">Comments · 75,600</p>
              <div class="space-y-3">
                <div class="flex gap-3" style="opacity: 1; transform: none;">
                  <div
                    class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white text-xs font-bold shrink-0">
                    MJ</div>
                  <div class="flex-1">
                    <div class="flex items-center gap-2 mb-1"><span class="text-white text-xs font-bold">Mike
                        Johnson</span><span class="text-gray-500 text-xs"><img src="https://flagcdn.com/w20/us.png" srcset="https://flagcdn.com/w40/us.png 2x" width="20" alt="USA" class="inline-block w-5 h-auto rounded-sm shadow-sm"> USA</span><span
                        class="text-gray-500 text-xs">2 days ago</span><span class="text-red-400 text-xs">📌</span>
                    </div>
                    <p class="text-gray-300 text-xs leading-relaxed">I received my Tesla car!! I paid the delivery fee
                      and within a week my brand new Tesla Model 3 arrived at my door. 🚗⚡</p>
                    <div class="flex items-center gap-4 mt-1.5"><button
                        class="flex items-center gap-1 text-gray-500 hover:text-white text-xs"><svg
                          xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                          class="lucide lucide-thumbs-up w-3 h-3">
                          <path d="M7 10v12"></path>
                          <path
                            d="M15 5.88 14 10h5.83a2 2 0 0 1 1.92 2.56l-2.33 8A2 2 0 0 1 17.5 22H4a2 2 0 0 1-2-2v-8a2 2 0 0 1 2-2h2.76a2 2 0 0 0 1.79-1.11L12 2a3.13 3.13 0 0 1 3 3.88Z">
                          </path>
                        </svg> 4,821</button><button
                        class="flex items-center gap-1 text-gray-500 hover:text-white text-xs"><svg
                          xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                          class="lucide lucide-thumbs-down w-3 h-3">
                          <path d="M17 14V2"></path>
                          <path
                            d="M9 18.12 10 14H4.17a2 2 0 0 1-1.92-2.56l2.33-8A2 2 0 0 1 6.5 2H20a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2h-2.76a2 2 0 0 0-1.79 1.11L12 22a3.13 3.13 0 0 1-3-3.88Z">
                          </path>
                        </svg></button></div>
                  </div>
                </div>
                <div class="flex gap-3" style="opacity: 1; transform: none;">
                  <div
                    class="w-8 h-8 bg-pink-500 rounded-full flex items-center justify-center text-white text-xs font-bold shrink-0">
                    SW</div>
                  <div class="flex-1">
                    <div class="flex items-center gap-2 mb-1"><span class="text-white text-xs font-bold">Sarah
                        Williams</span><span class="text-gray-500 text-xs"><img src="https://flagcdn.com/w20/us.png" srcset="https://flagcdn.com/w40/us.png 2x" width="20" alt="USA" class="inline-block w-5 h-auto rounded-sm shadow-sm"> USA</span><span
                        class="text-gray-500 text-xs">1 day ago</span></div>
                    <p class="text-gray-300 text-xs leading-relaxed">Just received my Tesla car after paying for the
                      delivery fee. I cried when I saw the car parked outside! 🙏</p>
                    <div class="flex items-center gap-4 mt-1.5"><button
                        class="flex items-center gap-1 text-gray-500 hover:text-white text-xs"><svg
                          xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                          class="lucide lucide-thumbs-up w-3 h-3">
                          <path d="M7 10v12"></path>
                          <path
                            d="M15 5.88 14 10h5.83a2 2 0 0 1 1.92 2.56l-2.33 8A2 2 0 0 1 17.5 22H4a2 2 0 0 1-2-2v-8a2 2 0 0 1 2-2h2.76a2 2 0 0 0 1.79-1.11L12 2a3.13 3.13 0 0 1 3 3.88Z">
                          </path>
                        </svg> 3,244</button><button
                        class="flex items-center gap-1 text-gray-500 hover:text-white text-xs"><svg
                          xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                          class="lucide lucide-thumbs-down w-3 h-3">
                          <path d="M17 14V2"></path>
                          <path
                            d="M9 18.12 10 14H4.17a2 2 0 0 1-1.92-2.56l2.33-8A2 2 0 0 1 6.5 2H20a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2h-2.76a2 2 0 0 0-1.79 1.11L12 22a3.13 3.13 0 0 1-3-3.88Z">
                          </path>
                        </svg></button></div>
                  </div>
                </div>
                <div class="flex gap-3" style="opacity: 1; transform: none;">
                  <div
                    class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center text-white text-xs font-bold shrink-0">
                    CM</div>
                  <div class="flex-1">
                    <div class="flex items-center gap-2 mb-1"><span class="text-white text-xs font-bold">Carlos
                        Mendez</span><span class="text-gray-500 text-xs"><img src="https://flagcdn.com/w20/mx.png" srcset="https://flagcdn.com/w40/mx.png 2x" width="20" alt="Mexico" class="inline-block w-5 h-auto rounded-sm shadow-sm"> Mexico</span><span
                        class="text-gray-500 text-xs">3 days ago</span></div>
                    <p class="text-gray-300 text-xs leading-relaxed">From Mexico! I received my Tesla car after paying
                      the delivery fee. This giveaway is 100% real.</p>
                    <div class="flex items-center gap-4 mt-1.5"><button
                        class="flex items-center gap-1 text-gray-500 hover:text-white text-xs"><svg
                          xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                          class="lucide lucide-thumbs-up w-3 h-3">
                          <path d="M7 10v12"></path>
                          <path
                            d="M15 5.88 14 10h5.83a2 2 0 0 1 1.92 2.56l-2.33 8A2 2 0 0 1 17.5 22H4a2 2 0 0 1-2-2v-8a2 2 0 0 1 2-2h2.76a2 2 0 0 0 1.79-1.11L12 2a3.13 3.13 0 0 1 3 3.88Z">
                          </path>
                        </svg> 2,918</button><button
                        class="flex items-center gap-1 text-gray-500 hover:text-white text-xs"><svg
                          xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                          class="lucide lucide-thumbs-down w-3 h-3">
                          <path d="M17 14V2"></path>
                          <path
                            d="M9 18.12 10 14H4.17a2 2 0 0 1-1.92-2.56l2.33-8A2 2 0 0 1 6.5 2H20a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2h-2.76a2 2 0 0 0-1.79 1.11L12 22a3.13 3.13 0 0 1-3-3.88Z">
                          </path>
                        </svg></button></div>
                  </div>
                </div>
                <div class="flex gap-3" style="opacity: 1; transform: none;">
                  <div
                    class="w-8 h-8 bg-purple-600 rounded-full flex items-center justify-center text-white text-xs font-bold shrink-0">
                    DC</div>
                  <div class="flex-1">
                    <div class="flex items-center gap-2 mb-1"><span class="text-white text-xs font-bold">David
                        Chen</span><span class="text-gray-500 text-xs"><img src="https://flagcdn.com/w20/cn.png" srcset="https://flagcdn.com/w40/cn.png 2x" width="20" alt="China" class="inline-block w-5 h-auto rounded-sm shadow-sm"> China</span><span
                        class="text-gray-500 text-xs">2 days ago</span></div>
                    <p class="text-gray-300 text-xs leading-relaxed">I was skeptical at first but I paid the delivery
                      fee and received my Tesla EV. Amazing!</p>
                    <div class="flex items-center gap-4 mt-1.5"><button
                        class="flex items-center gap-1 text-gray-500 hover:text-white text-xs"><svg
                          xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                          class="lucide lucide-thumbs-up w-3 h-3">
                          <path d="M7 10v12"></path>
                          <path
                            d="M15 5.88 14 10h5.83a2 2 0 0 1 1.92 2.56l-2.33 8A2 2 0 0 1 17.5 22H4a2 2 0 0 1-2-2v-8a2 2 0 0 1 2-2h2.76a2 2 0 0 0 1.79-1.11L12 2a3.13 3.13 0 0 1 3 3.88Z">
                          </path>
                        </svg> 2,611</button><button
                        class="flex items-center gap-1 text-gray-500 hover:text-white text-xs"><svg
                          xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                          class="lucide lucide-thumbs-down w-3 h-3">
                          <path d="M17 14V2"></path>
                          <path
                            d="M9 18.12 10 14H4.17a2 2 0 0 1-1.92-2.56l2.33-8A2 2 0 0 1 6.5 2H20a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2h-2.76a2 2 0 0 0-1.79 1.11L12 22a3.13 3.13 0 0 1-3-3.88Z">
                          </path>
                        </svg></button></div>
                  </div>
                </div>
                <div class="flex gap-3" style="opacity: 1; transform: none;">
                  <div
                    class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center text-white text-xs font-bold shrink-0">
                    AO</div>
                  <div class="flex-1">
                    <div class="flex items-center gap-2 mb-1"><span class="text-white text-xs font-bold">Amara
                        Osei</span><span class="text-gray-500 text-xs"><img src="https://flagcdn.com/w20/gh.png" srcset="https://flagcdn.com/w40/gh.png 2x" width="20" alt="Ghana" class="inline-block w-5 h-auto rounded-sm shadow-sm"> Ghana</span><span
                        class="text-gray-500 text-xs">1 day ago</span></div>
                    <p class="text-gray-300 text-xs leading-relaxed">From Ghana I paid for the delivery fee and
                      received my Tesla car! God bless Tesla!</p>
                    <div class="flex items-center gap-4 mt-1.5"><button
                        class="flex items-center gap-1 text-gray-500 hover:text-white text-xs"><svg
                          xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                          class="lucide lucide-thumbs-up w-3 h-3">
                          <path d="M7 10v12"></path>
                          <path
                            d="M15 5.88 14 10h5.83a2 2 0 0 1 1.92 2.56l-2.33 8A2 2 0 0 1 17.5 22H4a2 2 0 0 1-2-2v-8a2 2 0 0 1 2-2h2.76a2 2 0 0 0 1.79-1.11L12 2a3.13 3.13 0 0 1 3 3.88Z">
                          </path>
                        </svg> 2,403</button><button
                        class="flex items-center gap-1 text-gray-500 hover:text-white text-xs"><svg
                          xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                          class="lucide lucide-thumbs-down w-3 h-3">
                          <path d="M17 14V2"></path>
                          <path
                            d="M9 18.12 10 14H4.17a2 2 0 0 1-1.92-2.56l2.33-8A2 2 0 0 1 6.5 2H20a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2h-2.76a2 2 0 0 0-1.79 1.11L12 22a3.13 3.13 0 0 1-3-3.88Z">
                          </path>
                        </svg></button></div>
                  </div>
                </div>
              </div><button class="flex items-center gap-1 text-red-400 text-xs font-semibold mt-3 hover:text-red-300">▼ View 75,600 more comments</button>
            </div>
            </div><!-- end sec2-comments -->
          </div>
        </div>
      </section>
      <section class="py-20 bg-white">
        <div class="container mx-auto px-6">
          <div class="text-center mb-12" style="opacity: 1; transform: none;">
            <h2 class="text-4xl font-black text-gray-900">Straight from the <span class="text-red-600">CEO</span></h2>
            <p class="text-gray-600 mt-4 text-lg">Official announcements from Tesla's leadership</p>
          </div>
          <div class="grid md:grid-cols-2 gap-8 max-w-5xl mx-auto">
            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-md hover:shadow-xl transition-shadow"
              style="opacity: 1; transform: none;">
              <div class="flex items-center gap-3 mb-4"><img src="{{ asset('/img/elonmusk-main.png') }}" alt="Elon Musk"
                  class="w-12 h-12 rounded-full object-contain border-2 border-red-500">
                <div>
                  <div class="flex items-center gap-1"><span class="font-bold text-gray-900">Elon Musk</span><svg
                      xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                      stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                      class="lucide lucide-circle-check-big w-4 h-4 text-blue-500 fill-blue-500">
                      <path d="M21.801 10A10 10 0 1 1 17 3.335"></path>
                      <path d="m9 11 3 3L22 4"></path>
                    </svg></div><span class="text-gray-500 text-sm">CEO, Tesla, Inc.</span>
                </div>
              </div>
              <p class="text-gray-800 leading-relaxed mb-4">Tesla is committed to accelerating the world's transition to
                sustainable energy. As part of our mission, we're launching a worldwide giveaway of our electric
                vehicles — completely free. Just cover the delivery cost and a brand-new Tesla will be shipped directly
                to your door. 🚗⚡</p>
              <div class="flex items-center gap-4 text-gray-400 text-sm"><span>❤️ 128K</span><span>🔁 47K</span><span>💬
                  8.2K</span></div>
            </div>
            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-md hover:shadow-xl transition-shadow"
              style="opacity: 1; transform: none;">
              <div class="flex items-center gap-3 mb-4"><img src="img/tesla-logo.png" alt="Tesla Official"
                  class="w-12 h-12 rounded-full object-contain border-2 border-red-500 bg-white p-1">
                <div>
                  <div class="flex items-center gap-1"><span class="font-bold text-gray-900">Tesla Official</span><svg
                      xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                      stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                      class="lucide lucide-circle-check-big w-4 h-4 text-blue-500 fill-blue-500">
                      <path d="M21.801 10A10 10 0 1 1 17 3.335"></path>
                      <path d="m9 11 3 3L22 4"></path>
                    </svg></div><span class="text-gray-500 text-sm">@Tesla · Official Account</span>
                </div>
              </div>
              <p class="text-gray-800 leading-relaxed mb-4">📢 OFFICIAL ANNOUNCEMENT: Our global Tesla car giveaway is
                NOW LIVE! 🌍 Open to ALL countries. No purchase necessary — just cover the one-time delivery fee. Model
                3, Model Y, Model S, Model X and more available. Don't miss out! 🎁🚗</p>
              <div class="flex items-center gap-4 text-gray-400 text-sm"><span>❤️ 215K</span><span>🔁 89K</span><span>💬
                  14K</span></div>
            </div>
          </div>
        </div>
      </section>
      <section class="py-20 bg-gray-50" style="overflow: hidden;">
        <div class="container mx-auto px-6">
          <div class="text-center mb-12" style="opacity: 1; transform: none;">
            <h2 class="text-4xl font-black text-gray-900">What <span class="text-red-600">Winners</span> Are Saying</h2>
            <p class="text-gray-600 mt-4 text-lg">Real testimonials from verified Tesla car recipients</p>
          </div>
          <div class="max-w-xl mx-auto" style="overflow: hidden; position: relative;">
            <div id="testimonials-track" class="flex transition-transform duration-500 ease-in-out">
              <div class="w-full flex-shrink-0 min-w-full">
                <div class="bg-white rounded-2xl p-8 shadow-lg border border-gray-100 h-full w-full">
                  <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center text-red-600 font-bold">L</div>
                    <div>
                      <p class="font-bold text-gray-900">Liam O.</p>
                      <p class="text-gray-500 text-sm"><img src="https://flagcdn.com/w20/ie.png" srcset="https://flagcdn.com/w40/ie.png 2x" width="20" alt="Ireland" class="inline-block w-5 h-auto rounded-sm shadow-sm"> Ireland</p>
                    </div>
                  </div>
                  <p class="text-gray-700 leading-relaxed mb-4">"My Tesla Model 3 arrived in Dublin! I was skeptical but it's parked in my driveway right now. This is real!"</p>
                  <div class="bg-green-50 rounded-xl px-4 py-2 inline-block"><span class="text-green-700 font-bold text-sm">✅ Received: Tesla Model 3 2025 🚗</span></div>
                </div>
              </div>
              <div class="w-full flex-shrink-0 min-w-full">
                <div class="bg-white rounded-2xl p-8 shadow-lg border border-gray-100 h-full w-full">
                  <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center text-red-600 font-bold">M</div>
                    <div>
                      <p class="font-bold text-gray-900">Maria S.</p>
                      <p class="text-gray-500 text-sm"><img src="https://flagcdn.com/w20/ca.png" srcset="https://flagcdn.com/w40/ca.png 2x" width="20" alt="Canada" class="inline-block w-5 h-auto rounded-sm shadow-sm"> Canada</p>
                    </div>
                  </div>
                  <p class="text-gray-700 leading-relaxed mb-4">"I never win anything, but this giveaway changed my life. My Model Y is incredible. Thank you so much!"</p>
                  <div class="bg-green-50 rounded-xl px-4 py-2 inline-block"><span class="text-green-700 font-bold text-sm">✅ Received: Tesla Model Y 2024 🚗</span></div>
                </div>
              </div>
              <div class="w-full flex-shrink-0 min-w-full">
                <div class="bg-white rounded-2xl p-8 shadow-lg border border-gray-100 h-full w-full">
                  <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center text-red-600 font-bold">J</div>
                    <div>
                      <p class="font-bold text-gray-900">James B.</p>
                      <p class="text-gray-500 text-sm"><img src="https://flagcdn.com/w20/gb.png" srcset="https://flagcdn.com/w40/gb.png 2x" width="20" alt="UK" class="inline-block w-5 h-auto rounded-sm shadow-sm"> UK</p>
                    </div>
                  </div>
                  <p class="text-gray-700 leading-relaxed mb-4">"The delivery was fast and the car is spotless. Best thing I've ever done was entering this giveaway."</p>
                  <div class="bg-green-50 rounded-xl px-4 py-2 inline-block"><span class="text-green-700 font-bold text-sm">✅ Received: Tesla Model S 2025 🚗</span></div>
                </div>
              </div>
              <div class="w-full flex-shrink-0 min-w-full">
                <div class="bg-white rounded-2xl p-8 shadow-lg border border-gray-100 h-full w-full">
                  <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center text-red-600 font-bold">S</div>
                    <div>
                      <p class="font-bold text-gray-900">Sophie M.</p>
                      <p class="text-gray-500 text-sm"><img src="https://flagcdn.com/w20/au.png" srcset="https://flagcdn.com/w40/au.png 2x" width="20" alt="Australia" class="inline-block w-5 h-auto rounded-sm shadow-sm"> Australia</p>
                    </div>
                  </div>
                  <p class="text-gray-700 leading-relaxed mb-4">"I got the call last Tuesday and my Model X arrived on Friday. My whole family is in shock!"</p>
                  <div class="bg-green-50 rounded-xl px-4 py-2 inline-block"><span class="text-green-700 font-bold text-sm">✅ Received: Tesla Model X 2025 🚗</span></div>
                </div>
              </div>
              <div class="w-full flex-shrink-0 min-w-full">
                <div class="bg-white rounded-2xl p-8 shadow-lg border border-gray-100 h-full w-full">
                  <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center text-red-600 font-bold">N</div>
                    <div>
                      <p class="font-bold text-gray-900">Noah J.</p>
                      <p class="text-gray-500 text-sm"><img src="https://flagcdn.com/w20/de.png" srcset="https://flagcdn.com/w40/de.png 2x" width="20" alt="Germany" class="inline-block w-5 h-auto rounded-sm shadow-sm"> Germany</p>
                    </div>
                  </div>
                  <p class="text-gray-700 leading-relaxed mb-4">"The Cybertruck is an absolute beast. I still can't believe it's mine. Danke from Berlin!"</p>
                  <div class="bg-green-50 rounded-xl px-4 py-2 inline-block"><span class="text-green-700 font-bold text-sm">✅ Received: Tesla Cybertruck 2024 🚗</span></div>
                </div>
              </div>
              <div class="w-full flex-shrink-0 min-w-full">
                <div class="bg-white rounded-2xl p-8 shadow-lg border border-gray-100 h-full w-full">
                  <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center text-red-600 font-bold">E</div>
                    <div>
                      <p class="font-bold text-gray-900">Emma L.</p>
                      <p class="text-gray-500 text-sm"><img src="https://flagcdn.com/w20/fr.png" srcset="https://flagcdn.com/w40/fr.png 2x" width="20" alt="France" class="inline-block w-5 h-auto rounded-sm shadow-sm"> France</p>
                    </div>
                  </div>
                  <p class="text-gray-700 leading-relaxed mb-4">"I thought it was a scam until the truck pulled up to my apartment in Paris. Merci beaucoup!"</p>
                  <div class="bg-green-50 rounded-xl px-4 py-2 inline-block"><span class="text-green-700 font-bold text-sm">✅ Received: Tesla Model 3 2024 🚗</span></div>
                </div>
              </div>
              <div class="w-full flex-shrink-0 min-w-full">
                <div class="bg-white rounded-2xl p-8 shadow-lg border border-gray-100 h-full w-full">
                  <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center text-red-600 font-bold">O</div>
                    <div>
                      <p class="font-bold text-gray-900">Oliver K.</p>
                      <p class="text-gray-500 text-sm"><img src="https://flagcdn.com/w20/nl.png" srcset="https://flagcdn.com/w40/nl.png 2x" width="20" alt="Netherlands" class="inline-block w-5 h-auto rounded-sm shadow-sm"> Netherlands</p>
                    </div>
                  </div>
                  <p class="text-gray-700 leading-relaxed mb-4">"From signing up to driving away took less than two weeks. The Model Y is perfect for my family."</p>
                  <div class="bg-green-50 rounded-xl px-4 py-2 inline-block"><span class="text-green-700 font-bold text-sm">✅ Received: Tesla Model Y 2025 🚗</span></div>
                </div>
              </div>
              <div class="w-full flex-shrink-0 min-w-full">
                <div class="bg-white rounded-2xl p-8 shadow-lg border border-gray-100 h-full w-full">
                  <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center text-red-600 font-bold">I</div>
                    <div>
                      <p class="font-bold text-gray-900">Isabella R.</p>
                      <p class="text-gray-500 text-sm"><img src="https://flagcdn.com/w20/br.png" srcset="https://flagcdn.com/w40/br.png 2x" width="20" alt="Brazil" class="inline-block w-5 h-auto rounded-sm shadow-sm"> Brazil</p>
                    </div>
                  </div>
                  <p class="text-gray-700 leading-relaxed mb-4">"Minha família não acredita! The Model S is beautiful and drives like a dream. Obrigada!"</p>
                  <div class="bg-green-50 rounded-xl px-4 py-2 inline-block"><span class="text-green-700 font-bold text-sm">✅ Received: Tesla Model S 2025 🚗</span></div>
                </div>
              </div>
            </div>
            <div id="testimonials-indicators" class="flex justify-center gap-2 mt-6"><button data-index="0"
                class="w-3 h-3 rounded-full transition-colors bg-red-600"></button><button data-index="1"
                class="w-3 h-3 rounded-full transition-colors bg-gray-300"></button><button data-index="2"
                class="w-3 h-3 rounded-full transition-colors bg-gray-300"></button><button data-index="3"
                class="w-3 h-3 rounded-full transition-colors bg-gray-300"></button><button data-index="4"
                class="w-3 h-3 rounded-full transition-colors bg-gray-300"></button><button data-index="5"
                class="w-3 h-3 rounded-full transition-colors bg-gray-300"></button><button data-index="6"
                class="w-3 h-3 rounded-full transition-colors bg-gray-300"></button><button data-index="7"
                class="w-3 h-3 rounded-full transition-colors bg-gray-300"></button></div>
          </div>
        </div>
      </section>
      <section class="py-20 bg-white">
        <div class="container mx-auto px-6">
          <div class="text-center mb-12" style="opacity: 1; transform: none;">
            <h2 class="text-4xl font-black text-gray-900">Follow <span class="text-red-600">Tesla</span> Official</h2>
            <p class="text-gray-600 mt-4 text-lg max-w-xl mx-auto">Verified official social media accounts of Tesla
              worldwide.</p>
          </div>
          <div class="grid md:grid-cols-3 gap-6 max-w-4xl mx-auto"><a href="https://twitter.com/Tesla" target="_blank"
              rel="noreferrer"
              class="bg-white border border-gray-200 rounded-2xl p-6 shadow-md hover:shadow-xl transition-shadow group"
              style="opacity: 1; transform: none;">
              <div class="flex items-center gap-3 mb-4"><img src="img/tesla-logo.png" alt="Tesla Official"
                  class="w-12 h-12 rounded-full object-contain border-2 border-red-200 bg-white p-1">
                <div>
                  <div class="flex items-center gap-1"><span class="font-bold text-gray-900 text-sm">Tesla
                      Official</span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                      fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                      class="lucide lucide-circle-check-big w-4 h-4 text-blue-500 fill-blue-500">
                      <path d="M21.801 10A10 10 0 1 1 17 3.335"></path>
                      <path d="m9 11 3 3L22 4"></path>
                    </svg></div><span class="text-gray-500 text-xs">@Tesla</span>
                </div>
              </div>
              <p class="text-gray-600 text-sm mb-4">Official Tesla X account.</p>
              <div class="flex items-center justify-between"><span class="text-gray-400 text-xs">28.4M followers</span>
                <div class="bg-black rounded-full p-2 group-hover:scale-110 transition-transform"><svg
                    class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="currentColor">
                    <path
                      d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.747l7.737-8.835L1.254 2.25H8.08l4.258 5.63L18.244 2.25zm-1.161 17.52h1.833L7.084 4.126H5.117L17.083 19.77z">
                    </path>
                  </svg></div>
              </div>
            </a><a href="https://www.facebook.com/Tesla" target="_blank" rel="noreferrer"
              class="bg-white border border-gray-200 rounded-2xl p-6 shadow-md hover:shadow-xl transition-shadow group"
              style="opacity: 1; transform: none;">
              <div class="flex items-center gap-3 mb-4"><img src="img/tesla-logo.png" alt="Tesla"
                  class="w-12 h-12 rounded-full object-contain border-2 border-red-200 bg-white p-1">
                <div>
                  <div class="flex items-center gap-1"><span class="font-bold text-gray-900 text-sm">Tesla</span><svg
                      xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                      stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                      class="lucide lucide-circle-check-big w-4 h-4 text-blue-500 fill-blue-500">
                      <path d="M21.801 10A10 10 0 1 1 17 3.335"></path>
                      <path d="m9 11 3 3L22 4"></path>
                    </svg></div><span class="text-gray-500 text-xs">Tesla</span>
                </div>
              </div>
              <p class="text-gray-600 text-sm mb-4">Official Tesla Facebook page.</p>
              <div class="flex items-center justify-between"><span class="text-gray-400 text-xs">14.2M likes</span>
                <div class="bg-blue-600 rounded-full p-2 group-hover:scale-110 transition-transform"><svg
                    class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="currentColor">
                    <path
                      d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z">
                    </path>
                  </svg></div>
              </div>
            </a><a href="https://www.instagram.com/teslamotors/" target="_blank" rel="noreferrer"
              class="bg-white border border-gray-200 rounded-2xl p-6 shadow-md hover:shadow-xl transition-shadow group"
              style="opacity: 1; transform: none;">
              <div class="flex items-center gap-3 mb-4"><img src="img/tesla-logo.png" alt="Tesla"
                  class="w-12 h-12 rounded-full object-contain border-2 border-red-200 bg-white p-1">
                <div>
                  <div class="flex items-center gap-1"><span class="font-bold text-gray-900 text-sm">Tesla</span><svg
                      xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                      stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                      class="lucide lucide-circle-check-big w-4 h-4 text-blue-500 fill-blue-500">
                      <path d="M21.801 10A10 10 0 1 1 17 3.335"></path>
                      <path d="m9 11 3 3L22 4"></path>
                    </svg></div><span class="text-gray-500 text-xs">@teslamotors</span>
                </div>
              </div>
              <p class="text-gray-600 text-sm mb-4">Official Tesla Instagram.</p>
              <div class="flex items-center justify-between"><span class="text-gray-400 text-xs">12.8M followers</span>
                <div
                  class="bg-gradient-to-r from-purple-600 via-pink-500 to-orange-400 rounded-full p-2 group-hover:scale-110 transition-transform">
                  <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="currentColor">
                    <path
                      d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z">
                    </path>
                  </svg></div>
              </div>
            </a></div>
        </div>
      </section>
      <section id="instruction" class="py-20 bg-gray-50">
        <div class="container mx-auto px-6">
          <div class="text-center mb-12" style="opacity: 1; transform: none;">
            <h2 class="text-4xl font-black text-gray-900">How to Claim Your <span class="text-red-600">Tesla Car</span>
            </h2>
            <p class="text-gray-600 mt-4 text-lg max-w-xl mx-auto">Follow these simple steps to receive your brand new
              Tesla electric car giveaway</p>
          </div>
          <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="relative" style="opacity: 1; transform: none;">
              <div class="hidden lg:block absolute top-10 left-full w-full z-10"><svg xmlns="http://www.w3.org/2000/svg"
                  width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                  stroke-linecap="round" stroke-linejoin="round"
                  class="lucide lucide-arrow-right w-6 h-6 text-red-300 -ml-3">
                  <path d="M5 12h14"></path>
                  <path d="m12 5 7 7-7 7"></path>
                </svg></div>
              <div
                class="bg-white rounded-2xl p-6 shadow-md border border-gray-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 h-full">
                <div class="w-12 h-12 bg-red-600 rounded-xl flex items-center justify-center mb-4"><span
                    class="text-white font-black text-lg">01</span></div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Register Your Details</h3>
                <p class="text-gray-500 text-sm leading-relaxed">Enter your name, delivery address, and contact
                  information so Tesla can ship your car directly to you.</p>
              </div>
            </div>
            <div class="relative" style="opacity: 1; transform: none;">
              <div class="hidden lg:block absolute top-10 left-full w-full z-10"><svg xmlns="http://www.w3.org/2000/svg"
                  width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                  stroke-linecap="round" stroke-linejoin="round"
                  class="lucide lucide-arrow-right w-6 h-6 text-red-300 -ml-3">
                  <path d="M5 12h14"></path>
                  <path d="m12 5 7 7-7 7"></path>
                </svg></div>
              <div
                class="bg-white rounded-2xl p-6 shadow-md border border-gray-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 h-full">
                <div class="w-12 h-12 bg-red-600 rounded-xl flex items-center justify-center mb-4"><span
                    class="text-white font-black text-lg">02</span></div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Choose Your Tesla Car</h3>
                <p class="text-gray-500 text-sm leading-relaxed">Select your preferred Tesla model: Model 3, Model Y,
                  Model S, or Model X — all brand new!</p>
              </div>
            </div>
            <div class="relative" style="opacity: 1; transform: none;">
              <div class="hidden lg:block absolute top-10 left-full w-full z-10"><svg xmlns="http://www.w3.org/2000/svg"
                  width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                  stroke-linecap="round" stroke-linejoin="round"
                  class="lucide lucide-arrow-right w-6 h-6 text-red-300 -ml-3">
                  <path d="M5 12h14"></path>
                  <path d="m12 5 7 7-7 7"></path>
                </svg></div>
              <div
                class="bg-white rounded-2xl p-6 shadow-md border border-gray-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 h-full">
                <div class="w-12 h-12 bg-red-600 rounded-xl flex items-center justify-center mb-4"><span
                    class="text-white font-black text-lg">03</span></div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Pay Delivery Fee</h3>
                <p class="text-gray-500 text-sm leading-relaxed">Pay the small one-time delivery fee to cover shipping
                  and logistics. This is the only fee required.</p>
              </div>
            </div>
            <div class="relative" style="opacity: 1; transform: none;">
              <div
                class="bg-white rounded-2xl p-6 shadow-md border border-gray-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 h-full">
                <div class="w-12 h-12 bg-red-600 rounded-xl flex items-center justify-center mb-4"><span
                    class="text-white font-black text-lg">04</span></div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Receive Your Tesla Car</h3>
                <p class="text-gray-500 text-sm leading-relaxed">Your brand new Tesla electric car will be delivered to
                  your door within 7–14 business days. Enjoy!</p>
              </div>
            </div>
          </div>
          <div class="text-center mt-10" style="opacity: 1; transform: none;"><a
              href="{{ url('/participate') }}"><button
                class="inline-flex items-center justify-center gap-2 whitespace-nowrap ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 h-10 bg-red-600 hover:bg-red-700 text-white px-8 py-4 text-lg font-bold rounded-xl">🚗
                &#128663; Start Claiming Your Tesla Now &rarr;</button></a></div>
        </div>
      </section>
      <section id="participate" class="py-20 bg-gray-50">
        <div class="container mx-auto px-6">
          <div class="text-center mb-12" style="opacity: 1; transform: none;">
            <div
              class="inline-flex items-center gap-2 bg-red-600/10 border border-red-200 rounded-full px-4 py-1.5 mb-4">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-shield w-4 h-4 text-red-600">
                <path
                  d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z">
                </path>
              </svg><span class="text-red-600 text-sm font-bold uppercase tracking-wide">Official Tesla Global
                Giveaway</span></div>
            <h2 class="text-4xl md:text-5xl font-black text-gray-900">Choose Your <span class="text-red-600">Tesla
                Electric Car</span></h2>
            <p class="text-gray-500 mt-4 text-lg max-w-2xl mx-auto">Tesla is gifting brand new electric vehicles to
              participants worldwide.</p>
            <x-countdown-timer />
          </div>
          <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($cars as $car)
            <div class="bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 flex flex-col" style="opacity: 1; transform: none;">
              <div class="bg-gradient-to-br {{ $car->gradient ?? 'from-gray-900 to-gray-800' }} p-5 relative">
                @if($car->badge)
                <span class="absolute top-3 right-3 text-xs font-bold px-2 py-1 rounded-full bg-white/90 text-gray-900">{{ $car->badge }}</span>
                @endif
                <p class="text-white/70 text-xs font-semibold uppercase tracking-widest">{{ $car->category }}</p>
                <h3 class="text-white text-xl font-black mt-1">{{ $car->name }}</h3>
                <p class="text-white/60 text-sm">2025 Model</p>
                <img src="{{ asset($car->image) }}" alt="{{ $car->name }}" class="w-full h-40 object-contain rounded-xl mt-3">
              </div>
              <div class="p-5 flex flex-col flex-1">
                <div class="grid grid-cols-2 gap-2 mb-4">
                  <div class="bg-gray-50 rounded-xl p-2.5 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-zap w-3.5 h-3.5 text-red-500 shrink-0">
                      <path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"></path>
                    </svg>
                    <div>
                      <p class="text-xs text-gray-400">Power</p>
                      <p class="text-xs font-bold text-gray-800">{{ $car->power }}</p>
                    </div>
                  </div>
                  <div class="bg-gray-50 rounded-xl p-2.5 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-star w-3.5 h-3.5 text-red-500 shrink-0">
                      <path d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z"></path>
                    </svg>
                    <div>
                      <p class="text-xs text-gray-400">Range</p>
                      <p class="text-xs font-bold text-gray-800">{{ $car->range }}</p>
                    </div>
                  </div>
                  <div class="bg-gray-50 rounded-xl p-2.5 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-globe w-3.5 h-3.5 text-red-500 shrink-0">
                      <circle cx="12" cy="12" r="10"></circle>
                      <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path>
                      <path d="M2 12h20"></path>
                    </svg>
                    <div>
                      <p class="text-xs text-gray-400">Ships To</p>
                      <p class="text-xs font-bold text-gray-800">All Countries</p>
                    </div>
                  </div>
                  <div class="bg-gray-50 rounded-xl p-2.5 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock w-3.5 h-3.5 text-red-500 shrink-0">
                      <circle cx="12" cy="12" r="10"></circle>
                      <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                    <div>
                      <p class="text-xs text-gray-400">Delivery</p>
                      <p class="text-xs font-bold text-gray-800">{{ $car->delivery }}</p>
                    </div>
                  </div>
                </div>
                <div class="bg-red-50 border border-red-100 rounded-2xl p-4 mb-4 text-center">
                  <p class="text-xs text-gray-500 mb-1">One-Time Delivery Fee</p>
                  <p class="text-3xl font-black text-red-600">{{ $car->fee }}</p>
                  <p class="text-xs text-gray-400 mt-1">Covers shipping, customs &amp; logistics</p>
                </div>
                <div class="mt-auto">
                  <a href="{{ url('/participate') }}?car={{ $car->key }}" class="w-full bg-red-600 hover:bg-red-700 text-white font-black py-3.5 rounded-xl transition-colors text-sm flex items-center justify-center gap-2">
                    <span>Claim This Tesla Now &rarr;</span>
                  </a>
                </div>
              </div>
            </div>
            @endforeach
          </div>
          <div class="mt-10 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-3xl p-8 text-center shadow-xl"
            style="opacity: 1; transform: none;">
            <p class="font-black text-xl mb-2">⚡ Tesla Electric — Built for the Future</p>
            <p class="text-red-100 text-base max-w-3xl mx-auto leading-relaxed">Tesla is the world's <strong>leading
                electric vehicle manufacturer</strong>. Each participant is eligible for <strong>one vehicle
                only</strong>.</p>
          </div>
        </div>
      </section>
      <section id="transactions" class="py-20 bg-white">
        <div class="container mx-auto px-6">
          <div class="text-center mb-12" style="opacity: 1; transform: none;">
            <h2 class="text-4xl font-black text-gray-900">Live <span class="text-red-600">Deliveries</span></h2>
            <p class="text-gray-600 mt-4 text-lg max-w-xl mx-auto">Real-time updates of Tesla car deliveries happening
              right now across the world.</p>
          </div>
          <div class="max-w-3xl mx-auto bg-gray-50 rounded-2xl border border-gray-200 overflow-hidden"
            style="opacity: 1; transform: none;">
            <div class="bg-gray-900 text-white px-6 py-3 flex items-center justify-between text-sm font-semibold">
              <span>Live Delivery Feed</span><span class="flex items-center gap-2"><span
                  class="relative flex w-2 h-2"><span
                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span><span
                    class="relative inline-flex rounded-full w-2 h-2 bg-green-500"></span></span>LIVE</span></div>
            <div class="divide-y divide-gray-100">
              <div class="px-6 py-4 flex items-center justify-between" style="opacity: 1; height: auto;">
                <div class="flex items-center gap-3"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" class="lucide lucide-circle-check-big w-5 h-5 text-green-500 shrink-0">
                    <path d="M21.801 10A10 10 0 1 1 17 3.335"></path>
                    <path d="m9 11 3 3L22 4"></path>
                  </svg>
                  <div>
                    <p class="text-gray-900 font-bold text-sm">James O. <span class="text-gray-400 font-normal"><img src="https://flagcdn.com/w20/us.png" srcset="https://flagcdn.com/w40/us.png 2x" width="20" alt="USA" class="inline-block w-5 h-auto rounded-sm shadow-sm"> USA</span></p>
                    <p class="text-gray-500 text-xs">Tesla Model 3 2024 · Delivery confirmed ✓</p>
                  </div>
                </div>
                <div class="text-right">
                  <p class="text-red-600 font-bold text-sm">$319</p>
                  <p class="text-gray-400 text-xs">11 min ago</p>
                </div>
              </div>
              <div class="px-6 py-4 flex items-center justify-between" style="opacity: 1; height: auto;">
                <div class="flex items-center gap-3"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" class="lucide lucide-circle-check-big w-5 h-5 text-green-500 shrink-0">
                    <path d="M21.801 10A10 10 0 1 1 17 3.335"></path>
                    <path d="m9 11 3 3L22 4"></path>
                  </svg>
                  <div>
                    <p class="text-gray-900 font-bold text-sm">Fatima A. <span class="text-gray-400 font-normal"><img src="https://flagcdn.com/w20/ae.png" srcset="https://flagcdn.com/w40/ae.png 2x" width="20" alt="UAE" class="inline-block w-5 h-auto rounded-sm shadow-sm"> UAE</span></p>
                    <p class="text-gray-500 text-xs">Tesla Model 3 2025 · Car dispatched 🚚</p>
                  </div>
                </div>
                <div class="text-right">
                  <p class="text-red-600 font-bold text-sm">$329</p>
                  <p class="text-gray-400 text-xs">26 min ago</p>
                </div>
              </div>
              <div class="px-6 py-4 flex items-center justify-between" style="opacity: 1; height: auto;">
                <div class="flex items-center gap-3"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" class="lucide lucide-circle-check-big w-5 h-5 text-green-500 shrink-0">
                    <path d="M21.801 10A10 10 0 1 1 17 3.335"></path>
                    <path d="m9 11 3 3L22 4"></path>
                  </svg>
                  <div>
                    <p class="text-gray-900 font-bold text-sm">Kevin O. <span class="text-gray-400 font-normal"><img src="https://flagcdn.com/w20/ke.png" srcset="https://flagcdn.com/w40/ke.png 2x" width="20" alt="Kenya" class="inline-block w-5 h-auto rounded-sm shadow-sm"> Kenya</span></p>
                    <p class="text-gray-500 text-xs">Tesla Model S 2025 · Payment verified ✓</p>
                  </div>
                </div>
                <div class="text-right">
                  <p class="text-red-600 font-bold text-sm">$249</p>
                  <p class="text-gray-400 text-xs">8 min ago</p>
                </div>
              </div>
              <div class="px-6 py-4 flex items-center justify-between" style="opacity: 1; height: auto;">
                <div class="flex items-center gap-3"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" class="lucide lucide-circle-check-big w-5 h-5 text-green-500 shrink-0">
                    <path d="M21.801 10A10 10 0 1 1 17 3.335"></path>
                    <path d="m9 11 3 3L22 4"></path>
                  </svg>
                  <div>
                    <p class="text-gray-900 font-bold text-sm">Carlos R. <span class="text-gray-400 font-normal"><img src="https://flagcdn.com/w20/mx.png" srcset="https://flagcdn.com/w40/mx.png 2x" width="20" alt="Mexico" class="inline-block w-5 h-auto rounded-sm shadow-sm"> Mexico</span></p>
                    <p class="text-gray-500 text-xs">Tesla Model S 2025 · Payment verified ✓</p>
                  </div>
                </div>
                <div class="text-right">
                  <p class="text-red-600 font-bold text-sm">$289</p>
                  <p class="text-gray-400 text-xs">30 min ago</p>
                </div>
              </div>
              <div class="px-6 py-4 flex items-center justify-between" style="opacity: 1; height: auto;">
                <div class="flex items-center gap-3"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" class="lucide lucide-circle-check-big w-5 h-5 text-green-500 shrink-0">
                    <path d="M21.801 10A10 10 0 1 1 17 3.335"></path>
                    <path d="m9 11 3 3L22 4"></path>
                  </svg>
                  <div>
                    <p class="text-gray-900 font-bold text-sm">Pierre D. <span class="text-gray-400 font-normal"><img src="https://flagcdn.com/w20/fr.png" srcset="https://flagcdn.com/w40/fr.png 2x" width="20" alt="France" class="inline-block w-5 h-auto rounded-sm shadow-sm"> France</span></p>
                    <p class="text-gray-500 text-xs">Tesla Model S 2024 · Payment verified ✓</p>
                  </div>
                </div>
                <div class="text-right">
                  <p class="text-red-600 font-bold text-sm">$289</p>
                  <p class="text-gray-400 text-xs">55 min ago</p>
                </div>
              </div>
              <div class="px-6 py-4 flex items-center justify-between" style="opacity: 1; height: auto;">
                <div class="flex items-center gap-3"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" class="lucide lucide-circle-check-big w-5 h-5 text-green-500 shrink-0">
                    <path d="M21.801 10A10 10 0 1 1 17 3.335"></path>
                    <path d="m9 11 3 3L22 4"></path>
                  </svg>
                  <div>
                    <p class="text-gray-900 font-bold text-sm">Carlos R. <span class="text-gray-400 font-normal"><img src="https://flagcdn.com/w20/mx.png" srcset="https://flagcdn.com/w40/mx.png 2x" width="20" alt="Mexico" class="inline-block w-5 h-auto rounded-sm shadow-sm"> Mexico</span></p>
                    <p class="text-gray-500 text-xs">Tesla Model S 2025 · Payment verified ✓</p>
                  </div>
                </div>
                <div class="text-right">
                  <p class="text-red-600 font-bold text-sm">$289</p>
                  <p class="text-gray-400 text-xs">18 min ago</p>
                </div>
              </div>
              <div class="px-6 py-4 flex items-center justify-between" style="opacity: 1; height: auto;">
                <div class="flex items-center gap-3"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" class="lucide lucide-circle-check-big w-5 h-5 text-green-500 shrink-0">
                    <path d="M21.801 10A10 10 0 1 1 17 3.335"></path>
                    <path d="m9 11 3 3L22 4"></path>
                  </svg>
                  <div>
                    <p class="text-gray-900 font-bold text-sm">Sophie M. <span class="text-gray-400 font-normal"><img src="https://flagcdn.com/w20/gb.png" srcset="https://flagcdn.com/w40/gb.png 2x" width="20" alt="UK" class="inline-block w-5 h-auto rounded-sm shadow-sm"> UK</span></p>
                    <p class="text-gray-500 text-xs">Tesla Model Y 2024 · Car dispatched 🚚</p>
                  </div>
                </div>
                <div class="text-right">
                  <p class="text-red-600 font-bold text-sm">$329</p>
                  <p class="text-gray-400 text-xs">26 min ago</p>
                </div>
              </div>
              <div class="px-6 py-4 flex items-center justify-between" style="opacity: 1; height: auto;">
                <div class="flex items-center gap-3"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" class="lucide lucide-circle-check-big w-5 h-5 text-green-500 shrink-0">
                    <path d="M21.801 10A10 10 0 1 1 17 3.335"></path>
                    <path d="m9 11 3 3L22 4"></path>
                  </svg>
                  <div>
                    <p class="text-gray-900 font-bold text-sm">Raj P. <span class="text-gray-400 font-normal"><img src="https://flagcdn.com/w20/in.png" srcset="https://flagcdn.com/w40/in.png 2x" width="20" alt="India" class="inline-block w-5 h-auto rounded-sm shadow-sm"> India</span></p>
                    <p class="text-gray-500 text-xs">Tesla Model 3 2024 · Delivery confirmed ✓</p>
                  </div>
                </div>
                <div class="text-right">
                  <p class="text-red-600 font-bold text-sm">$289</p>
                  <p class="text-gray-400 text-xs">48 min ago</p>
                </div>
              </div>
              <div class="px-6 py-4 flex items-center justify-between" style="opacity: 1; height: auto;">
                <div class="flex items-center gap-3"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" class="lucide lucide-circle-check-big w-5 h-5 text-green-500 shrink-0">
                    <path d="M21.801 10A10 10 0 1 1 17 3.335"></path>
                    <path d="m9 11 3 3L22 4"></path>
                  </svg>
                  <div>
                    <p class="text-gray-900 font-bold text-sm">Anna S. <span class="text-gray-400 font-normal"><img src="https://flagcdn.com/w20/ru.png" srcset="https://flagcdn.com/w40/ru.png 2x" width="20" alt="Russia" class="inline-block w-5 h-auto rounded-sm shadow-sm"> Russia</span></p>
                    <p class="text-gray-500 text-xs">Tesla Model X 2024 · Shipment confirmed ✓</p>
                  </div>
                </div>
                <div class="text-right">
                  <p class="text-red-600 font-bold text-sm">$289</p>
                  <p class="text-gray-400 text-xs">10 min ago</p>
                </div>
              </div>
              <div class="px-6 py-4 flex items-center justify-between" style="opacity: 1; height: auto;">
                <div class="flex items-center gap-3"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" class="lucide lucide-circle-check-big w-5 h-5 text-green-500 shrink-0">
                    <path d="M21.801 10A10 10 0 1 1 17 3.335"></path>
                    <path d="m9 11 3 3L22 4"></path>
                  </svg>
                  <div>
                    <p class="text-gray-900 font-bold text-sm">Pierre D. <span class="text-gray-400 font-normal"><img src="https://flagcdn.com/w20/fr.png" srcset="https://flagcdn.com/w40/fr.png 2x" width="20" alt="France" class="inline-block w-5 h-auto rounded-sm shadow-sm"> France</span></p>
                    <p class="text-gray-500 text-xs">Tesla Model S 2024 · Payment verified ✓</p>
                  </div>
                </div>
                <div class="text-right">
                  <p class="text-red-600 font-bold text-sm">$329</p>
                  <p class="text-gray-400 text-xs">23 min ago</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <section class="bg-white py-16 md:py-20">
        <div class="container mx-auto px-6">
          <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-2">
              <div class="h-64 md:h-auto bg-gray-50 overflow-hidden">
                <img src="{{ asset('/img/elonmusk-main.png') }}" alt="Elon Musk" class="w-full h-full object-cover object-top">
              </div>
              <div class="p-8 md:p-12 flex flex-col justify-center">
                <div class="text-red-600 text-6xl leading-none font-serif mb-4">"</div>
                <blockquote class="text-xl md:text-2xl font-medium text-gray-900 leading-relaxed">
                  When something is important enough, you do it even if the odds are not in your favor.
                </blockquote>
                <p class="text-gray-500 font-semibold mt-4">— Elon Musk</p>
              </div>
            </div>
          </div>
        </div>
      </section>
      <footer class="bg-gray-900 py-10">
        <div class="container mx-auto px-6">
          <div class="flex flex-col md:flex-row justify-between items-center gap-6 mb-8">
            <div class="text-2xl font-black"><span class="text-red-600">infinityx</span><span class="text-white">capital</span></div>
            <div class="flex flex-wrap gap-6 text-sm"><a href="#giveaway"
                class="text-gray-400 hover:text-white transition-colors">Giveaway</a><a href="#info"
                class="text-gray-400 hover:text-white transition-colors">Info</a><a href="#instruction"
                class="text-gray-400 hover:text-white transition-colors">Instruction</a><a href="#participate"
                class="text-gray-400 hover:text-white transition-colors">Participate</a><a href="#transactions"
                class="text-gray-400 hover:text-white transition-colors">Transactions</a></div>
          </div>
          <div class="flex flex-wrap justify-center gap-4 mb-8"><span
              class="text-gray-500 text-xs font-semibold border border-gray-800 rounded-full px-3 py-1">🔒 SSL
              Secured</span><span
              class="text-gray-500 text-xs font-semibold border border-gray-800 rounded-full px-3 py-1">🚗 Tesla
              Certified</span><span
              class="text-gray-500 text-xs font-semibold border border-gray-800 rounded-full px-3 py-1">⚡ Electric
              Vehicle</span><span
              class="text-gray-500 text-xs font-semibold border border-gray-800 rounded-full px-3 py-1">✅ 10,000+
              Delivered</span><span
              class="text-gray-500 text-xs font-semibold border border-gray-800 rounded-full px-3 py-1">🌐 Official
              Event</span></div>
          <div class="border-t border-gray-800 mt-4 pt-8 text-center">
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-6">
              <a href="https://wa.me/14108301960" target="_blank" rel="noreferrer"
                class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white text-sm font-bold px-5 py-2.5 rounded-full transition-colors">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                </svg>
                WhatsApp +1 (410) 830-1960
              </a>
              <a href="https://t.me/+14108301960" target="_blank" rel="noreferrer"
                class="inline-flex items-center gap-2 bg-[#229ED9] hover:bg-[#1E8BC3] text-white text-sm font-bold px-5 py-2.5 rounded-full transition-colors">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/>
                </svg>
                Telegram +1 (410) 830-1960
              </a>
            </div>
            <p class="text-gray-500 text-sm max-w-3xl mx-auto">This is an official Tesla Motors global car giveaway
              event. Tesla is the world's leading electric vehicle manufacturer gifting brand new electric vehicles to
              participants worldwide.</p>
            <p class="text-gray-600 text-sm mt-4">© 2025 Tesla Motors Official Giveaway. All rights reserved.</p>
          </div>
        </div>
      </footer>
      <div id="social-proof-popup" class="fixed top-24 left-6 z-50 max-w-xs w-full pointer-events-none" style="display: none;">
        <div class="bg-white rounded-2xl shadow-2xl border border-gray-100 p-4 pointer-events-auto"
          style="opacity: 1; transform: none;">
          <div class="flex items-start gap-3">
            <div
              class="w-10 h-10 bg-gradient-to-br from-red-500 to-red-700 rounded-full flex items-center justify-center shrink-0">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-circle-check-big w-5 h-5 text-white">
                <path d="M21.801 10A10 10 0 1 1 17 3.335"></path>
                <path d="m9 11 3 3L22 4"></path>
              </svg></div>
            <div class="flex-1 min-w-0">
              <div class="flex items-center gap-2 flex-wrap"><span id="sp-name" class="font-bold text-gray-900 text-sm">James
                  O.</span><span id="sp-country" class="text-xs text-gray-500"><img src="https://flagcdn.com/w20/us.png" srcset="https://flagcdn.com/w40/us.png 2x" width="20" alt="USA" class="inline-block w-5 h-auto rounded-sm shadow-sm"> USA</span></div>
              <p class="text-xs text-gray-600 mt-0.5">Just paid delivery fee for <span id="sp-car"
                  class="inline-block px-2 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-700">Tesla Model 3
                  2024</span></p>
              <p id="sp-status" class="text-green-600 font-bold text-sm mt-1">🚗 Car confirmed &amp; dispatched! ($299 fee paid)</p>
            </div>
          </div>
          <div class="mt-2 h-1 bg-gray-100 rounded-full overflow-hidden">
            <div id="sp-progress" class="h-full bg-red-500 rounded-full" style="width: 64.9%;"></div>
          </div>
        </div>
      </div>
    </div>
</x-layouts.app>