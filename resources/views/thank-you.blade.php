<x-layouts.app>
  @push('title', 'Thank You — InfinityX Capital')

  <div class="min-h-screen bg-gray-50 flex items-center justify-center p-6">
    <div class="max-w-lg w-full bg-white rounded-3xl shadow-xl border border-gray-100 p-8 text-center">
      <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-6">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg>
      </div>
      <h1 class="text-3xl font-black text-gray-900 mb-2">Payment Received!</h1>
      <p class="text-gray-500 mb-6">Your submission and payment have been received. We are preparing your car for delivery.</p>
      <a href="{{ url('/') }}" class="inline-flex items-center justify-center bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-8 rounded-xl transition-colors">
        Back to Home
      </a>
    </div>
  </div>
</x-layouts.app>
