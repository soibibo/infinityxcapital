<div>
  <div class="grid lg:grid-cols-2 gap-10">
    {{-- Car Selection Card --}}
    <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden hover:shadow-2xl transition-all duration-300">
      <div class="bg-gradient-to-br from-gray-900 to-gray-800 p-6 text-center">
        <img src="{{ asset($selectedCar['image']) }}" alt="{{ $selectedCar['name'] }}"
          class="w-full h-48 object-contain rounded-xl mb-4 transition-all duration-300">
        <h3 class="text-white text-2xl font-black">Choose Your Tesla Car</h3>
        <p class="text-white/60 text-sm">{{ $selectedCar['name'] }}</p>
      </div>
      <div class="p-6 space-y-4">
        @foreach($models as $key => $model)
        <div class="bg-gray-50 rounded-xl p-4">
          <label class="flex items-center gap-3 cursor-pointer">
            <input type="radio" wire:model.live="carModel" name="carModel" value="{{ $key }}"
              id="car-{{ $key }}"
              class="w-5 h-5 text-red-600 border-gray-300 focus:ring-red-500 shrink-0">
            <img src="{{ asset($model['image']) }}" alt="{{ $model['name'] }}" class="w-16 h-12 object-contain rounded-lg bg-white border border-gray-200 shrink-0">
            <div class="flex-1 min-w-0">
              <p class="font-bold text-gray-900">{{ $model['name'] }}</p>
              <p class="text-xs text-gray-500">{{ $model['desc'] }}</p>
            </div>
            <span class="ml-auto text-red-600 font-bold text-sm shrink-0">{{ $model['fee'] }}</span>
          </label>
        </div>
        @endforeach
      </div>
    </div>

    {{-- Delivery Form Card --}}
    <div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-8">
      <div class="text-center mb-6">
        <div class="inline-flex items-center gap-2 bg-green-50 border border-green-200 rounded-full px-4 py-1.5">
          <span class="relative flex w-2 h-2"><span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
          <span class="relative inline-flex rounded-full w-2 h-2 bg-green-500"></span></span>
          <span class="text-green-700 text-sm font-semibold">Personal Information</span>
        </div>
      </div>

      @if($submitted)
      <div class="bg-green-50 border border-green-200 rounded-2xl p-6 text-center">
        <div class="flex items-center justify-center gap-3 mb-2">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check-big w-8 h-8 text-green-500"><path d="M21.801 10A10 10 0 1 1 17 3.335"/><path d="m9 11 3 3L22 4"/></svg>
          <h3 class="text-green-800 font-bold text-xl">✅ Claim Submitted!</h3>
        </div>
        <div class="text-left bg-white rounded-xl p-4 space-y-2">
          <p class="text-gray-700 text-sm"><strong>Name:</strong> {{ $fullName }}</p>
          <p class="text-gray-700 text-sm"><strong>Email:</strong> {{ $email }}</p>
          <p class="text-gray-700 text-sm"><strong>Phone:</strong> {{ $phone }}</p>
          <p class="text-gray-700 text-sm"><strong>Car:</strong> {{ $selectedCar['name'] }}</p>
          <p class="text-gray-700 text-sm"><strong>Fee:</strong> {{ $selectedCar['fee'] }}</p>
          <p class="text-gray-700 text-sm"><strong>Delivery:</strong> {{ $street }}, {{ $city }}, {{ $zip }}</p>
          <p class="text-gray-700 text-sm"><strong>Country:</strong> {{ $country }}</p>
        </div>
        <p class="text-green-600 text-sm mt-3 font-semibold">🚗 Your car is being prepared for delivery!</p>
      </div>
      @else
      <form wire:submit="submit" class="space-y-5">
        <div>
          <label for="fullName" class="block text-sm font-bold text-gray-700 mb-1">Full Name <span class="text-red-500">*</span></label>
          <input type="text" id="fullName" wire:model="fullName" placeholder="John Doe"
            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition-colors">
          @error('fullName') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>
        <div>
          <label for="email" class="block text-sm font-bold text-gray-700 mb-1">Email Address <span class="text-red-500">*</span></label>
          <input type="email" id="email" wire:model="email" placeholder="you@example.com"
            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition-colors">
          @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>
        <div>
          <label for="phone" class="block text-sm font-bold text-gray-700 mb-1">Phone Number <span class="text-red-500">*</span></label>
          <input type="tel" id="phone" wire:model="phone" placeholder="+1 (555) 000-0000"
            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition-colors">
          @error('phone') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        <div class="pt-2 border-t border-gray-200">
          <div class="text-center mb-4">
            <div class="inline-flex items-center gap-2 bg-red-600/10 border border-red-200 rounded-full px-4 py-1.5">
              <span class="text-red-600 text-sm font-bold uppercase tracking-wide">Delivery Address</span>
            </div>
          </div>
          <div>
            <label for="street" class="block text-sm font-bold text-gray-700 mb-1">Street Address <span class="text-red-500">*</span></label>
            <input type="text" id="street" wire:model="street" placeholder="123 Main Street, Apt 4B"
              class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition-colors">
            @error('street') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
          </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div>
            <label for="city" class="block text-sm font-bold text-gray-700 mb-1">City <span class="text-red-500">*</span></label>
            <input type="text" id="city" wire:model="city" placeholder="New York"
              class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition-colors">
            @error('city') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
          </div>
          <div>
            <label for="zip" class="block text-sm font-bold text-gray-700 mb-1">ZIP / Postal <span class="text-red-500">*</span></label>
            <input type="text" id="zip" wire:model="zip" placeholder="10001"
              class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition-colors">
            @error('zip') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
          </div>
        </div>

        <div>
          <label for="country" class="block text-sm font-bold text-gray-700 mb-1">Country <span class="text-red-500">*</span></label>
          <select id="country" wire:model="country"
            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition-colors bg-white">
            <option value="">Select your country</option>
            <option value="US">United States</option>
            <option value="CA">Canada</option>
            <option value="GB">United Kingdom</option>
            <option value="DE">Germany</option>
            <option value="FR">France</option>
            <option value="AU">Australia</option>
            <option value="JP">Japan</option>
            <option value="BR">Brazil</option>
            <option value="MX">Mexico</option>
            <option value="IN">India</option>
            <option value="NG">Nigeria</option>
            <option value="ZA">South Africa</option>
            <option value="GH">Ghana</option>
            <option value="KE">Kenya</option>
            <option value="AE">UAE</option>
            <option value="SG">Singapore</option>
            <option value="HK">Hong Kong</option>
            <option value="KR">South Korea</option>
            <option value="CN">China</option>
            <option value="RU">Russia</option>
          </select>
          @error('country') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        <button type="submit"
          class="w-full bg-red-600 hover:bg-red-700 text-white font-black py-4 rounded-xl transition-all duration-300 text-lg flex items-center justify-center gap-2 shadow-lg shadow-red-200 hover:shadow-xl">
          <span>🚗 Order {{ $selectedCar['name'] }} Now →</span>
        </button>
        <p class="text-center text-gray-400 text-xs mt-4">🔒 Your information is secured with 256-bit SSL encryption</p>
      </form>
      @endif
    </div>
  </div>
</div>
