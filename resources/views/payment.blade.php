<x-layouts.app>
  @push('title', 'Complete Payment — InfinityX Capital')

  <div class="min-h-screen bg-gray-50 flex items-center justify-center p-6">
    <div class="max-w-lg w-full bg-white shadow-xl border border-gray-100 p-8"
      x-data="{ method: '{{ old('payment_method', array_key_first($activeMethods)) }}' }">
      <div class="text-center mb-6">
        <div class="inline-flex items-center gap-2 bg-red-600/10 border border-red-200 px-4 py-1.5 mb-4">
          <span class="text-red-600 text-sm font-bold uppercase tracking-wide">Secure Checkout</span>
        </div>
        <h1 class="text-2xl font-black text-gray-900">Complete Your Payment</h1>
        <p class="text-gray-500 mt-2 text-sm">Select a payment method and confirm your entry.</p>
      </div>

      <div class="bg-gray-50 p-5 space-y-3 mb-6">
        <div class="flex justify-between text-sm">
          <span class="text-gray-500">Name</span>
          <span class="font-semibold text-gray-900">{{ $submission->full_name }}</span>
        </div>
        <div class="flex justify-between text-sm">
          <span class="text-gray-500">Email</span>
          <span class="font-semibold text-gray-900">{{ $submission->email }}</span>
        </div>
        <div class="flex justify-between text-sm">
          <span class="text-gray-500">Car</span>
          <span class="font-semibold text-gray-900">{{ $submission->car_name }}</span>
        </div>
        <div class="border-t border-gray-200 pt-3 flex justify-between items-center">
          <span class="text-gray-700 font-medium">Total Fee</span>
          <span class="text-2xl font-black text-red-600">{{ $submission->car_fee }}</span>
        </div>
      </div>

      @php
        $methodConfigMap = [
          'bitcoin' => ['label' => 'Bitcoin', 'icon' => asset('img/crypto-img-logo/Bitcoin.svg.webp')],
          'ethereum' => ['label' => 'Ethereum', 'icon' => asset('img/crypto-img-logo/ethereum-logo.png')],
          'usdt' => ['label' => 'USDT', 'icon' => asset('img/crypto-img-logo/tether-logo.webp')],
          'paypal' => ['label' => 'PayPal', 'icon' => asset('img/crypto-img-logo/PayPal-logo.png')],
        ];
      @endphp

      <form method="POST" action="{{ route('payment.process') }}" enctype="multipart/form-data" class="space-y-5" x-data="{ submitting: false }" @submit="submitting = true">
        @csrf

        <div>
          <label class="block text-sm font-bold text-gray-700 mb-2">Payment Method</label>
          <div class="grid grid-cols-2 gap-3">
            @foreach($activeMethods as $key => $method)
              @php($methodConfig = $methodConfigMap[$key])
              <label class="cursor-pointer">
                <input type="radio" name="payment_method" value="{{ $key }}" x-model="method" class="peer sr-only">
                <div class="border border-gray-200 p-3 text-center hover:border-red-500 peer-checked:border-red-600 peer-checked:bg-red-50 transition-colors">
                  <img src="{{ $methodConfig['icon'] }}" alt="{{ $methodConfig['label'] }}" class="h-8 w-8 object-contain mx-auto">
                  <p class="text-xs font-semibold text-gray-700 mt-1">{{ $methodConfig['label'] }}</p>
                  <p class="text-[10px] text-gray-500">Min: {{ $method['minimum_deposit'] ?? '0' }} USD</p>
                </div>
              </label>
            @endforeach
          </div>
          @error('payment_method')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label class="block text-sm font-bold text-gray-700 mb-2">Payment Proof</label>
          <input
            type="file"
            name="payment_proof"
            accept="image/png,image/jpg,image/jpeg"
            required
            class="w-full border border-gray-300 px-4 py-2.5 text-sm file:mr-4 file:py-2 file:px-4 file:border-0 file:rounded-none file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 transition-colors"
          />
          <p class="text-xs text-gray-500 mt-1">Upload a screenshot or photo of your payment confirmation.</p>
          @error('payment_proof')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        @foreach($activeMethods as $key => $method)
          @php($methodConfig = $methodConfigMap[$key])
          <div x-show="method === '{{ $key }}'" x-cloak class="bg-gray-50 border border-gray-200 p-4">
            <div class="flex items-center gap-2 mb-2">
              <img src="{{ $methodConfig['icon'] }}" alt="{{ $methodConfig['label'] }}" class="h-5 w-5 object-contain">
              <h3 class="text-sm font-bold text-gray-900 capitalize">{{ $key }} Payment</h3>
            </div>
            @if(!empty($method['instructions']))
              <p class="text-sm text-gray-600 mb-3">{{ $method['instructions'] }}</p>
            @endif
            @if(!empty($method['wallet_address']))
              <p class="text-xs text-gray-500 mb-1">@if($key === 'paypal') PayPal account @else Wallet address @endif</p>
              <code class="block bg-white border border-gray-300 p-2 text-xs break-all">{{ $method['wallet_address'] }}</code>
            @endif
            @if(!empty($method['barcode']))
              <div class="mt-3">
                <p class="text-xs text-gray-500 mb-1">Scan barcode to pay:</p>
                <img src="{{ asset('storage/' . $method['barcode']) }}" alt="{{ $methodConfig['label'] }} barcode" class="h-40 border border-gray-300 object-contain mx-auto">
              </div>
            @endif
          </div>
        @endforeach

        <button type="submit" :disabled="submitting" class="w-full bg-red-600 hover:bg-red-700 disabled:opacity-70 disabled:cursor-not-allowed text-white font-black py-4 transition-all duration-300 text-lg shadow-lg shadow-red-200 hover:shadow-xl flex items-center justify-center gap-2">
          <span x-show="!submitting">I Have Paid</span>
          <span x-show="submitting" class="flex items-center gap-2">
            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Processing...
          </span>
        </button>
      </form>

      <p class="text-center text-gray-400 text-xs mt-4">🔒 Your payment will be confirmed by an admin shortly.</p>
    </div>
  </div>
</x-layouts.app>