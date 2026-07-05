<x-layouts.admin>
  <x-slot:title>Settings</x-slot:title>

  <div class="mb-6">
    <h1 class="text-2xl font-black text-gray-900">Manual Deposit Method</h1>
    <p class="text-sm text-gray-500 mt-1">Configure application settings</p>
  </div>

  @if (session('success'))
    <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 text-sm">
      {{ session('success') }}
    </div>
  @endif

  <div class="bg-white shadow-sm border border-gray-200 p-6">
    <h2 class="text-lg font-bold text-gray-900 mb-1">Setup Payment Methods</h2>
    <p class="text-sm text-gray-500 mb-6">All the Deposit Payment Methods Setup for user</p>

    <form id="settings-form" method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" x-data="{ expanded: '{{ old('expanded', '') }}' }">
      @csrf

      <div class="space-y-4">
        @php
          $methodConfig = [
            'bitcoin' => ['name' => 'Bitcoin', 'code' => 'BTC', 'icon' => asset('img/crypto-img-logo/Bitcoin.svg.webp'), 'color' => 'bg-orange-100'],
            'ethereum' => ['name' => 'Ethereum', 'code' => 'ETH', 'icon' => asset('img/crypto-img-logo/ethereum-logo.png'), 'color' => 'bg-indigo-100'],
            'usdt' => ['name' => 'USDT', 'code' => 'ERC20', 'icon' => asset('img/crypto-img-logo/tether-logo.webp'), 'color' => 'bg-green-100'],
            'paypal' => ['name' => 'PayPal', 'code' => 'PAYPAL', 'icon' => asset('img/crypto-img-logo/PayPal-logo.png'), 'color' => 'bg-blue-100'],
          ];
        @endphp

        @foreach($methodConfig as $key => $config)
          @php
            $method = $methods[$key];
            $isActive = old("methods.{$key}.active", $method['active'] ? '1' : '') === '1';
          @endphp
          <div class="border border-gray-200" x-data="{ active: {{ $isActive ? 'true' : 'false' }}, removed: false }">
            <div class="p-4 flex items-center gap-4">
              <div class="w-10 h-10 rounded-full {{ $config['color'] }} flex items-center justify-center p-1.5">
                <img src="{{ $config['icon'] }}" alt="{{ $config['name'] }}" class="w-full h-full object-contain">
              </div>
              <div class="flex-1">
                <div class="flex items-center gap-2">
                  <h3 class="font-bold text-gray-900">{{ $config['name'] }}</h3>
                  <span class="text-[10px] font-bold bg-gray-900 text-white px-1.5 py-0.5">{{ $config['code'] }}</span>
                </div>
                <p class="text-xs text-gray-500">Minimum Deposit: {{ old("methods.{$key}.minimum_deposit", $method['minimum_deposit']) ?: '0' }} USD</p>
              </div>
              <div class="flex items-center gap-3">
                <div class="flex items-center gap-3">
                  <button
                    type="button"
                    @click="active = !active"
                    :class="active ? 'bg-red-600' : 'bg-gray-200'"
                    class="relative inline-flex h-7 w-12 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 shrink-0"
                  >
                    <span class="sr-only"></span>
                    <span
                      :class="active ? 'translate-x-6' : 'translate-x-1'"
                      class="inline-block h-5 w-5 transform rounded-full bg-white shadow transition-transform"
                    ></span>
                  </button>
                  <span class="text-sm font-medium text-gray-700 min-w-[50px]" x-text="active ? 'Active' : 'Inactive'"></span>
                </div>
                <button type="button" @click="expanded = expanded === '{{ $key }}' ? '' : '{{ $key }}'" class="bg-gray-100 hover:bg-gray-200 text-gray-500 hover:text-gray-700 p-1.5 transition-colors">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
                </button>
              </div>
            </div>

            <input type="hidden" name="methods[{{ $key }}][active]" :value="active ? '1' : '0'">

            <template x-teleport="body">
              <div x-show="expanded === '{{ $key }}'" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/40 backdrop-blur-md" style="background-color: rgba(0,0,0,0.4); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px);">
                <div class="bg-white shadow-xl w-full max-w-lg p-6" @click.away="expanded = ''">
                  <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-gray-900">Edit {{ $config['name'] }} Settings</h3>
                    <button type="button" @click="expanded = ''" class="text-gray-400 hover:text-gray-600">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>
                    </button>
                  </div>

                <div class="space-y-4">
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                      @if($key === 'paypal') PayPal Email / Merchant ID @else Wallet Address @endif
                    </label>
                    <input
                      type="text"
                      name="methods[{{ $key }}][wallet_address]"
                      form="settings-form"
                      value="{{ old("methods.{$key}.wallet_address", $method['wallet_address']) }}"
                      class="w-full border border-gray-300 px-4 py-2.5 text-sm focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition-colors"
                    />
                    @error("methods.{$key}.wallet_address")
                      <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                  </div>

                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Minimum Deposit (USD)</label>
                    <input
                      type="text"
                      name="methods[{{ $key }}][minimum_deposit]"
                      form="settings-form"
                      value="{{ old("methods.{$key}.minimum_deposit", $method['minimum_deposit']) }}"
                      class="w-full border border-gray-300 px-4 py-2.5 text-sm focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition-colors"
                    />
                    @error("methods.{$key}.minimum_deposit")
                      <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                  </div>

                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Instructions</label>
                    <textarea
                      name="methods[{{ $key }}][instructions]"
                      form="settings-form"
                      rows="3"
                      class="w-full border border-gray-300 px-4 py-2.5 text-sm focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition-colors"
                    >{{ old("methods.{$key}.instructions", $method['instructions']) }}</textarea>
                  </div>

                  @if($key !== 'paypal')
                    <div>
                      <label class="block text-sm font-medium text-gray-700 mb-1">Barcode / QR Code</label>
                      <input
                        type="file"
                        name="methods[{{ $key }}][barcode]"
                        form="settings-form"
                        accept="image/png,image/jpg,image/jpeg,image/svg+xml"
                        class="w-full border border-gray-300 px-4 py-2.5 text-sm file:mr-4 file:py-2 file:px-4 file:border-0 file:rounded-none file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 transition-colors"
                      />
                      @if(!empty($method['barcode']))
                        <div class="mt-3" x-show="!removed" x-cloak>
                          <div class="flex items-center justify-between mb-1">
                            <p class="text-xs text-gray-500">Current barcode:</p>
                            <button
                              type="button"
                              @click="fetch('{{ route('admin.settings.barcode.remove', $key) }}', { method: 'DELETE', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' } }).then(() => removed = true)"
                              class="text-red-600 hover:text-red-700 text-xs font-medium flex items-center gap-1"
                            >
                              <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>
                              Remove
                            </button>
                          </div>
                          <img src="{{ asset('storage/' . $method['barcode']) }}" alt="{{ $config['name'] }} barcode" class="h-32 border border-gray-200 object-contain">
                        </div>
                      @endif
                    </div>
                  @endif
                </div>

                <div class="mt-6 flex justify-end gap-3">
                  <button type="button" @click="expanded = ''" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-5 py-2.5 text-sm transition-colors">Cancel</button>
                  <button type="button" @click="expanded = ''" class="bg-red-600 hover:bg-red-700 text-white font-semibold px-6 py-2.5 text-sm transition-colors">Done</button>
                </div>
              </div>
            </template>
          </div>
        @endforeach
      </div>

      <div class="mt-6 flex justify-end">
        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-semibold px-6 py-2.5 text-sm transition-colors">
          Save Settings
        </button>
      </div>
    </form>
  </div>
</x-layouts.admin>
