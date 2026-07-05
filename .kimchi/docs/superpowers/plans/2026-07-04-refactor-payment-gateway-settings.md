# Refactored Payment Gateway Settings Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Replace the single-dropdown gateway settings with a modern list of toggleable payment methods and make the payment page show only active methods.

**Architecture:** Store methods as JSON in `payment_methods` setting. Admin settings view renders cards with toggles and expandable fields. Payment controller filters active methods and passes them to the payment view.

**Tech Stack:** Laravel, PHP 8.4+, Tailwind CSS v4, Alpine.js.

---

### Task 1: Rewrite SettingsController

**Files:**
- Modify: `app/Http/Controllers/Admin/SettingsController.php`

- [ ] **Step 1: Replace the controller body**

```php
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingsController extends Controller
{
    private array $methodKeys = ['bitcoin', 'ethereum', 'usdt', 'paypal'];

    public function index(): View
    {
        $methods = json_decode(Setting::getValue('payment_methods', '{}'), true) ?: [];

        foreach ($this->methodKeys as $key) {
            $methods[$key] = array_merge([
                'active' => false,
                'wallet_address' => '',
                'minimum_deposit' => '',
                'instructions' => '',
            ], $methods[$key] ?? []);
        }

        return view('admin.settings', compact('methods'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'methods' => ['required', 'array'],
            'methods.*.active' => ['nullable', 'boolean'],
            'methods.*.wallet_address' => ['nullable', 'string', 'max:255'],
            'methods.*.minimum_deposit' => ['nullable', 'string', 'max:50'],
            'methods.*.instructions' => ['nullable', 'string'],
        ]);

        $methods = [];

        foreach ($this->methodKeys as $key) {
            $input = $validated['methods'][$key] ?? [];
            $active = filter_var($input['active'] ?? false, FILTER_VALIDATE_BOOLEAN);

            $method = [
                'active' => $active,
                'wallet_address' => trim($input['wallet_address'] ?? ''),
                'minimum_deposit' => trim($input['minimum_deposit'] ?? ''),
                'instructions' => trim($input['instructions'] ?? ''),
            ];

            if ($active) {
                $rules = [
                    "methods.{$key}.wallet_address" => ['required', 'string', 'max:255'],
                    "methods.{$key}.minimum_deposit" => ['required', 'string', 'max:50'],
                ];

                $request->validate($rules);
            }

            $methods[$key] = $method;
        }

        Setting::setValue('payment_methods', json_encode($methods));

        return redirect()->route('admin.settings')->with('success', 'Payment methods updated successfully.');
    }
}
```

---

### Task 2: Redesign Admin Settings View

**Files:**
- Modify: `resources/views/admin/settings.blade.php`

- [ ] **Step 1: Replace the entire view content**

```blade
<x-layouts.admin>
  <x-slot:title>Settings</x-slot:title>

  <div class="mb-6">
    <h1 class="text-2xl font-black text-gray-900">Manual Deposit Method</h1>
    <p class="text-sm text-gray-500 mt-1">Configure application settings</p>
  </div>

  @if (session('success'))
    <div class="mb-6 bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 text-sm">
      {{ session('success') }}
    </div>
  @endif

  <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 max-w-3xl">
    <h2 class="text-lg font-bold text-gray-900 mb-1">Setup Payment Methods</h2>
    <p class="text-sm text-gray-500 mb-6">All the Deposit Payment Methods Setup for user</p>

    <form method="POST" action="{{ route('admin.settings.update') }}" x-data="{ expanded: '{{ old('expanded', '') }}' }">
      @csrf

      <div class="space-y-4">
        @php
          $methodConfig = [
            'bitcoin' => ['name' => 'Bitcoin', 'code' => 'BTC', 'icon' => '₿', 'color' => 'bg-orange-100 text-orange-600'],
            'ethereum' => ['name' => 'Ethereum', 'code' => 'ETH', 'icon' => 'Ξ', 'color' => 'bg-indigo-100 text-indigo-600'],
            'usdt' => ['name' => 'USDT', 'code' => 'ERC20', 'icon' => '₮', 'color' => 'bg-green-100 text-green-600'],
            'paypal' => ['name' => 'PayPal', 'code' => 'PAYPAL', 'icon' => 'P', 'color' => 'bg-blue-100 text-blue-600'],
          ];
        @endphp

        @foreach($methodConfig as $key => $config)
          @php
            $method = $methods[$key];
            $isActive = old("methods.{$key}.active", $method['active'] ? '1' : '') === '1';
          @endphp
          <div class="border border-gray-200 rounded-xl overflow-hidden" x-data="{ active: {{ $isActive ? 'true' : 'false' }} }">
            <div class="p-4 flex items-center gap-4">
              <div class="w-10 h-10 rounded-full {{ $config['color'] }} flex items-center justify-center text-lg font-bold">
                {{ $config['icon'] }}
              </div>
              <div class="flex-1">
                <div class="flex items-center gap-2">
                  <h3 class="font-bold text-gray-900">{{ $config['name'] }}</h3>
                  <span class="text-[10px] font-bold bg-gray-900 text-white px-1.5 py-0.5 rounded">{{ $config['code'] }}</span>
                </div>
                <p class="text-xs text-gray-500">Minimum Deposit: {{ old("methods.{$key}.minimum_deposit", $method['minimum_deposit']) ?: '0' }} USD</p>
              </div>
              <div class="flex items-center gap-3">
                @if($isActive)
                  <span class="bg-green-100 text-green-700 text-xs font-semibold px-3 py-1 rounded-full">Activated</span>
                @else
                  <span class="bg-yellow-100 text-yellow-700 text-xs font-semibold px-3 py-1 rounded-full">Deactivated</span>
                @endif
                <button type="button" @click="active = !active; expanded = '{{ $key }}'" class="text-gray-400 hover:text-gray-600">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
                </button>
              </div>
            </div>

            <div x-show="active || expanded === '{{ $key }}'" x-cloak class="border-t border-gray-100 bg-gray-50 p-4 space-y-4">
              <input type="hidden" name="methods[{{ $key }}][active]" :value="active ? '1' : '0'">

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                  @if($key === 'paypal') PayPal Email / Merchant ID @else Wallet Address @endif
                </label>
                <input
                  type="text"
                  name="methods[{{ $key }}][wallet_address]"
                  value="{{ old("methods.{$key}.wallet_address", $method['wallet_address']) }}"
                  class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition-colors"
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
                  value="{{ old("methods.{$key}.minimum_deposit", $method['minimum_deposit']) }}"
                  class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition-colors"
                />
                @error("methods.{$key}.minimum_deposit")
                  <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Instructions</label>
                <textarea
                  name="methods[{{ $key }}][instructions]"
                  rows="2"
                  class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition-colors"
                >{{ old("methods.{$key}.instructions", $method['instructions']) }}</textarea>
              </div>
            </div>
          </div>
        @endforeach
      </div>

      <div class="mt-6 flex justify-end">
        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-semibold rounded-xl px-6 py-2.5 text-sm transition-colors">
          Save Settings
        </button>
      </div>
    </form>
  </div>
</x-layouts.admin>
```

---

### Task 3: Update PaymentController

**Files:**
- Modify: `app/Http/Controllers/PaymentController.php`

- [ ] **Step 1: Replace PaymentController**

```php
<?php

namespace App\Http\Controllers;

use App\Models\GiveawaySubmission;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function index(): View|RedirectResponse
    {
        $submissionId = session('payment_submission_id');

        if (! $submissionId) {
            return redirect()->route('home');
        }

        $submission = GiveawaySubmission::find($submissionId);

        if (! $submission) {
            session()->forget('payment_submission_id');
            return redirect()->route('home');
        }

        $methods = json_decode(Setting::getValue('payment_methods', '{}'), true) ?: [];
        $activeMethods = array_filter($methods, fn ($method) => ($method['active'] ?? false) === true);

        if (empty($activeMethods)) {
            return redirect()->route('home')->with('error', 'No payment methods are available.');
        }

        return view('payment', compact('submission', 'activeMethods'));
    }

    public function process(Request $request): RedirectResponse
    {
        $submissionId = session('payment_submission_id');

        if (! $submissionId) {
            return redirect()->route('home');
        }

        $submission = GiveawaySubmission::find($submissionId);

        if (! $submission) {
            session()->forget('payment_submission_id');
            return redirect()->route('home');
        }

        $methods = json_decode(Setting::getValue('payment_methods', '{}'), true) ?: [];
        $activeMethods = array_filter($methods, fn ($method) => ($method['active'] ?? false) === true);
        $allowed = array_keys($activeMethods);

        $validated = $request->validate([
            'payment_method' => ['required', 'string', Rule::in($allowed)],
        ]);

        $submission->update([
            'payment_method' => $validated['payment_method'],
            'payment_status' => 'pending',
        ]);

        session()->forget('payment_submission_id');

        return redirect()->route('payment.pending');
    }
}
```

---

### Task 4: Update Payment View

**Files:**
- Modify: `resources/views/payment.blade.php`

- [ ] **Step 1: Replace payment.blade.php**

```blade
<x-layouts.app>
  @push('title', 'Complete Payment — InfinityX Capital')

  <div class="min-h-screen bg-gray-50 flex items-center justify-center p-6">
    <div class="max-w-lg w-full bg-white rounded-3xl shadow-xl border border-gray-100 p-8"
      x-data="{ method: '{{ old('payment_method', array_key_first($activeMethods)) }}' }">
      <div class="text-center mb-6">
        <div class="inline-flex items-center gap-2 bg-red-600/10 border border-red-200 rounded-full px-4 py-1.5 mb-4">
          <span class="text-red-600 text-sm font-bold uppercase tracking-wide">Secure Checkout</span>
        </div>
        <h1 class="text-2xl font-black text-gray-900">Complete Your Payment</h1>
        <p class="text-gray-500 mt-2 text-sm">Select a payment method and confirm your entry.</p>
      </div>

      <div class="bg-gray-50 rounded-2xl p-5 space-y-3 mb-6">
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

      <form method="POST" action="{{ route('payment.process') }}" class="space-y-5">
        @csrf

        <div>
          <label class="block text-sm font-bold text-gray-700 mb-2">Payment Method</label>
          <div class="grid grid-cols-2 gap-3">
            @foreach($activeMethods as $key => $method)
              @php
                $methodConfig = [
                  'bitcoin' => ['label' => 'Bitcoin', 'icon' => '₿'],
                  'ethereum' => ['label' => 'Ethereum', 'icon' => 'Ξ'],
                  'usdt' => ['label' => 'USDT', 'icon' => '₮'],
                  'paypal' => ['label' => 'PayPal', 'icon' => 'P'],
                ][$key];
              @endphp
              <label class="cursor-pointer">
                <input type="radio" name="payment_method" value="{{ $key }}" x-model="method" class="peer sr-only">
                <div class="rounded-xl border border-gray-200 p-3 text-center hover:border-red-500 peer-checked:border-red-600 peer-checked:bg-red-50 transition-colors">
                  <span class="text-2xl">{{ $methodConfig['icon'] }}</span>
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

        @foreach($activeMethods as $key => $method)
          <div x-show="method === '{{ $key }}'" x-cloak class="bg-gray-50 border border-gray-200 rounded-xl p-4">
            <h3 class="text-sm font-bold text-gray-900 mb-1 capitalize">{{ $key }} Payment</h3>
            @if(!empty($method['instructions']))
              <p class="text-sm text-gray-600 mb-2">{{ $method['instructions'] }}</p>
            @endif
            @if(!empty($method['wallet_address']))
              <p class="text-xs text-gray-500 mb-1">@if($key === 'paypal') PayPal account @else Wallet address @endif</p>
              <code class="block bg-white border border-gray-300 rounded-lg p-2 text-xs break-all">{{ $method['wallet_address'] }}</code>
            @endif
          </div>
        @endforeach

        <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-black py-4 rounded-xl transition-all duration-300 text-lg shadow-lg shadow-red-200 hover:shadow-xl">
          I Have Paid
        </button>
      </form>

      <p class="text-center text-gray-400 text-xs mt-4">🔒 Your payment will be confirmed by an admin shortly.</p>
    </div>
  </div>
</x-layouts.app>
```

---

### Task 5: Verify

- [ ] **Step 1: Run PHP syntax checks**

```bash
php -l app/Http/Controllers/Admin/SettingsController.php
php -l app/Http/Controllers/PaymentController.php
php -l resources/views/admin/settings.blade.php
php -l resources/views/payment.blade.php
```

Expected: "No syntax errors detected" for all files.

- [ ] **Step 2: Manual browser checks**

1. Visit `/admin/settings`.
2. Toggle Bitcoin active, enter wallet address and minimum deposit, save.
3. Visit `/participate`, submit form.
4. Payment page shows Bitcoin as a selectable method.
5. Select Bitcoin, submit → redirect to `/payment-pending`.
6. Admin `/admin/payments` shows the pending payment.
