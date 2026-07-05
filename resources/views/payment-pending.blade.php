<x-layouts.app>
  @push('title', 'Payment Pending — InfinityX Capital')

  <div class="min-h-screen bg-gray-50 flex items-center justify-center p-6">
    <div class="max-w-lg w-full bg-white rounded-3xl shadow-xl border border-gray-100 p-8 text-center">
      <div class="inline-flex items-center justify-center w-16 h-16 bg-yellow-100 rounded-full mb-6">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-yellow-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
      </div>
      <h1 class="text-3xl font-black text-gray-900 mb-2">Payment Pending</h1>
      <p class="text-gray-500 mb-6">Your payment has been submitted and is awaiting admin confirmation. You will receive an email once confirmed.</p>
      <a href="{{ url('/') }}" class="inline-flex items-center justify-center bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-8 rounded-xl transition-colors">
        Back to Home
      </a>
    </div>
  </div>
</x-layouts.app>
