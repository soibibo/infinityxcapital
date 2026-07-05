# Payment Methods + Admin Confirmation Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Add Bitcoin, Ethereum, and PayPal as user-selectable payment methods, record pending payments, and let admins confirm payments before users can submit again.

**Architecture:** Admin settings define which methods are enabled and their details. Payment page shows only enabled methods. Selecting a method stores `payment_method` and `payment_status = pending`. New admin payments page lists pending payments and allows confirmation. Giveaway form blocks emails with pending payments.

**Tech Stack:** Laravel, Livewire, PHP 8.4+, Tailwind CSS v4.

---

### Task 1: Add payment_method and payment_status Migration

**Files:**
- Create: `database/migrations/2026_07_04_230000_add_payment_method_and_status_to_giveaway_submissions.php`

- [ ] **Step 1: Create the migration**

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('giveaway_submissions', function (Blueprint $table) {
            $table->string('payment_method')->nullable()->after('paid_at');
            $table->string('payment_status')->default('pending')->after('payment_method');
        });
    }

    public function down(): void
    {
        Schema::table('giveaway_submissions', function (Blueprint $table) {
            $table->dropColumn(['payment_method', 'payment_status']);
        });
    }
};
```

- [ ] **Step 2: Run the migration on Windows**

```bash
php artisan migrate
```

---

### Task 2: Update Admin Settings for BTC/ETH/PayPal

**Files:**
- Modify: `app/Http/Controllers/Admin/SettingsController.php`
- Modify: `resources/views/admin/settings.blade.php`

- [ ] **Step 1: Replace SettingsController**

```php
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function index(): View
    {
        $paymentGateway = Setting::getValue('payment_gateway', 'offline');
        $settings = json_decode(Setting::getValue('payment_gateway_settings', '{}'), true) ?: [];

        return view('admin.settings', compact('paymentGateway', 'settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $gateways = ['stripe', 'paypal', 'coinbase', 'bitcoin', 'ethereum', 'offline'];

        $validated = $request->validate([
            'payment_gateway' => ['required', 'string', Rule::in($gateways)],
            'settings' => ['required', 'array'],
            'settings.stripe.publishable_key' => ['nullable', 'string'],
            'settings.stripe.secret_key' => ['nullable', 'string'],
            'settings.stripe.webhook_secret' => ['nullable', 'string'],
            'settings.paypal.client_id' => ['nullable', 'string'],
            'settings.paypal.client_secret' => ['nullable', 'string'],
            'settings.paypal.environment' => ['nullable', 'string', Rule::in(['sandbox', 'live'])],
            'settings.coinbase.api_key' => ['nullable', 'string'],
            'settings.coinbase.webhook_secret' => ['nullable', 'string'],
            'settings.bitcoin.wallet_address' => ['nullable', 'string'],
            'settings.ethereum.wallet_address' => ['nullable', 'string'],
            'settings.offline.instructions' => ['nullable', 'string'],
        ]);

        $selected = $validated['payment_gateway'];

        $rulesForSelected = match ($selected) {
            'stripe' => [
                'settings.stripe.publishable_key' => ['required', 'string'],
                'settings.stripe.secret_key' => ['required', 'string'],
            ],
            'paypal' => [
                'settings.paypal.client_id' => ['required', 'string'],
                'settings.paypal.client_secret' => ['required', 'string'],
            ],
            'coinbase' => [
                'settings.coinbase.api_key' => ['required', 'string'],
            ],
            'bitcoin' => [
                'settings.bitcoin.wallet_address' => ['required', 'string'],
            ],
            'ethereum' => [
                'settings.ethereum.wallet_address' => ['required', 'string'],
            ],
            'offline' => [
                'settings.offline.instructions' => ['required', 'string'],
            ],
        };

        $request->validate($rulesForSelected);

        $settings = Arr::mapWithKeys($gateways, function (string $gateway) use ($validated) {
            $group = $validated['settings'][$gateway] ?? [];

            return [$gateway => array_map('trim', array_map(fn ($value) => $value ?? '', $group))];
        });

        Setting::setValue('payment_gateway', $selected);
        Setting::setValue('payment_gateway_settings', json_encode($settings));

        return redirect()->route('admin.settings')->with('success', 'Payment gateway updated successfully.');
    }
}
```

- [ ] **Step 2: Update admin/settings.blade.php select options**

Add inside the `<select>`:

```blade
<option value="bitcoin" @selected($paymentGateway === 'bitcoin')>Bitcoin</option>
<option value="ethereum" @selected($paymentGateway === 'ethereum')>Ethereum</option>
```

- [ ] **Step 3: Add Bitcoin panel before PayPal**

```blade
        {{-- Bitcoin --}}
        <div x-show="gateway === 'bitcoin'" x-cloak class="space-y-4">
          <h2 class="text-sm font-semibold text-gray-900">Bitcoin Wallet</h2>

          <div>
            <label for="settings_bitcoin_wallet_address" class="block text-sm font-medium text-gray-700 mb-1">Wallet Address</label>
            <input
              type="text"
              id="settings_bitcoin_wallet_address"
              name="settings[bitcoin][wallet_address]"
              value="{{ old('settings.bitcoin.wallet_address', $settings['bitcoin']['wallet_address'] ?? '') }}"
              class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition-colors"
              placeholder="bc1..."
            />
            @error('settings.bitcoin.wallet_address')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>
        </div>
```

- [ ] **Step 4: Add Ethereum panel before PayPal**

```blade
        {{-- Ethereum --}}
        <div x-show="gateway === 'ethereum'" x-cloak class="space-y-4">
          <h2 class="text-sm font-semibold text-gray-900">Ethereum Wallet</h2>

          <div>
            <label for="settings_ethereum_wallet_address" class="block text-sm font-medium text-gray-700 mb-1">Wallet Address</label>
            <input
              type="text"
              id="settings_ethereum_wallet_address"
              name="settings[ethereum][wallet_address]"
              value="{{ old('settings.ethereum.wallet_address', $settings['ethereum']['wallet_address'] ?? '') }}"
              class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition-colors"
              placeholder="0x..."
            />
            @error('settings.ethereum.wallet_address')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>
        </div>
```

---

### Task 3: Update GiveawayForm to Block Pending Payments

**Files:**
- Modify: `app/Livewire/GiveawayForm.php`
- Modify: `resources/views/livewire/giveaway-form.blade.php`

- [ ] **Step 1: Add validation rule to GiveawayForm**

Add to the `submit()` method, before `$this->validate()`:

```php
        $existingPending = GiveawaySubmission::where('email', $this->email)
            ->where('payment_status', 'pending')
            ->exists();

        if ($existingPending) {
            $this->addError('email', 'You already have a submission awaiting payment confirmation. Please wait for admin approval.');
            return;
        }
```

- [ ] **Step 2: Ensure error displays in the form**

The form already has `@error('email')`. No change needed unless the error should be shown at the top.

---

### Task 4: Update PaymentController and Payment View

**Files:**
- Modify: `app/Http/Controllers/PaymentController.php`
- Modify: `resources/views/payment.blade.php`

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

        $gateway = Setting::getValue('payment_gateway', 'offline');
        $settings = json_decode(Setting::getValue('payment_gateway_settings', '{}'), true) ?: [];

        $enabledMethods = match ($gateway) {
            'bitcoin' => ['bitcoin'],
            'ethereum' => ['ethereum'],
            'paypal' => ['paypal'],
            'offline' => ['offline'],
            default => ['paypal'],
        };

        return view('payment', compact('submission', 'gateway', 'settings', 'enabledMethods'));
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

        $gateway = Setting::getValue('payment_gateway', 'offline');
        $allowed = match ($gateway) {
            'bitcoin' => ['bitcoin'],
            'ethereum' => ['ethereum'],
            'paypal' => ['paypal'],
            'offline' => ['offline'],
            default => ['paypal'],
        };

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

- [ ] **Step 2: Replace payment.blade.php**

```blade
<x-layouts.app>
  @push('title', 'Complete Payment — InfinityX Capital')

  <div class="min-h-screen bg-gray-50 flex items-center justify-center p-6">
    <div class="max-w-lg w-full bg-white rounded-3xl shadow-xl border border-gray-100 p-8"
      x-data="{ method: '{{ old('payment_method', $enabledMethods[0] ?? 'paypal') }}' }">
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
          <div class="grid grid-cols-3 gap-3">
            @if(in_array('bitcoin', $enabledMethods))
              <label class="cursor-pointer">
                <input type="radio" name="payment_method" value="bitcoin" x-model="method" class="peer sr-only">
                <div class="rounded-xl border border-gray-200 p-3 text-center hover:border-red-500 peer-checked:border-red-600 peer-checked:bg-red-50 transition-colors">
                  <span class="text-2xl">₿</span>
                  <p class="text-xs font-semibold text-gray-700 mt-1">Bitcoin</p>
                </div>
              </label>
            @endif
            @if(in_array('ethereum', $enabledMethods))
              <label class="cursor-pointer">
                <input type="radio" name="payment_method" value="ethereum" x-model="method" class="peer sr-only">
                <div class="rounded-xl border border-gray-200 p-3 text-center hover:border-red-500 peer-checked:border-red-600 peer-checked:bg-red-50 transition-colors">
                  <span class="text-2xl">Ξ</span>
                  <p class="text-xs font-semibold text-gray-700 mt-1">Ethereum</p>
                </div>
              </label>
            @endif
            @if(in_array('paypal', $enabledMethods))
              <label class="cursor-pointer">
                <input type="radio" name="payment_method" value="paypal" x-model="method" class="peer sr-only">
                <div class="rounded-xl border border-gray-200 p-3 text-center hover:border-red-500 peer-checked:border-red-600 peer-checked:bg-red-50 transition-colors">
                  <span class="text-2xl">P</span>
                  <p class="text-xs font-semibold text-gray-700 mt-1">PayPal</p>
                </div>
              </label>
            @endif
          </div>
          @error('payment_method')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <div x-show="method === 'bitcoin'" x-cloak class="bg-yellow-50 border border-yellow-200 rounded-xl p-4">
          <h3 class="text-sm font-bold text-yellow-800 mb-1">Bitcoin Payment</h3>
          <p class="text-sm text-yellow-700 mb-2">Send the exact fee to this wallet address:</p>
          <code class="block bg-white border border-yellow-300 rounded-lg p-2 text-xs break-all">{{ $settings['bitcoin']['wallet_address'] ?? 'Not configured' }}</code>
        </div>

        <div x-show="method === 'ethereum'" x-cloak class="bg-blue-50 border border-blue-200 rounded-xl p-4">
          <h3 class="text-sm font-bold text-blue-800 mb-1">Ethereum Payment</h3>
          <p class="text-sm text-blue-700 mb-2">Send the exact fee to this wallet address:</p>
          <code class="block bg-white border border-blue-300 rounded-lg p-2 text-xs break-all">{{ $settings['ethereum']['wallet_address'] ?? 'Not configured' }}</code>
        </div>

        <div x-show="method === 'paypal'" x-cloak class="bg-blue-50 border border-blue-200 rounded-xl p-4">
          <h3 class="text-sm font-bold text-blue-800 mb-1">PayPal Payment</h3>
          <p class="text-sm text-blue-700">You will be redirected to PayPal to complete the payment.</p>
        </div>

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

### Task 5: Create PaymentPendingController and View

**Files:**
- Create: `app/Http/Controllers/PaymentPendingController.php`
- Create: `resources/views/payment-pending.blade.php`

- [ ] **Step 1: Create controller**

```php
<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PaymentPendingController extends Controller
{
    public function index(): View
    {
        return view('payment-pending');
    }
}
```

- [ ] **Step 2: Create view**

```blade
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
```

---

### Task 6: Create Admin PaymentConfirmationController and View

**Files:**
- Create: `app/Http/Controllers/Admin/PaymentConfirmationController.php`
- Create: `resources/views/admin/payments/index.blade.php`

- [ ] **Step 1: Create controller**

```php
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GiveawaySubmission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentConfirmationController extends Controller
{
    public function index(): View
    {
        $pendingPayments = GiveawaySubmission::where('payment_status', 'pending')
            ->whereNotNull('payment_method')
            ->latest()
            ->get();

        return view('admin.payments.index', compact('pendingPayments'));
    }

    public function confirm(Request $request, GiveawaySubmission $submission): RedirectResponse
    {
        $submission->update(['payment_status' => 'confirmed']);

        return redirect()->route('admin.payments')->with('success', 'Payment confirmed successfully.');
    }
}
```

- [ ] **Step 2: Create view**

```blade
<x-layouts.admin>
  <x-slot:title>Payment Confirmations</x-slot:title>

  <div class="mb-6">
    <h1 class="text-2xl font-black text-gray-900">Payment Confirmations</h1>
    <p class="text-sm text-gray-500 mt-1">Review and confirm pending participant payments.</p>
  </div>

  @if (session('success'))
    <div class="mb-6 bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 text-sm">
      {{ session('success') }}
    </div>
  @endif

  <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
    <div class="overflow-x-auto">
      <table class="w-full text-sm">
        <thead>
          <tr class="border-b border-gray-200 text-left">
            <th class="pb-3 font-semibold text-gray-600">Name</th>
            <th class="pb-3 font-semibold text-gray-600">Email</th>
            <th class="pb-3 font-semibold text-gray-600">Car</th>
            <th class="pb-3 font-semibold text-gray-600">Method</th>
            <th class="pb-3 font-semibold text-gray-600">Fee</th>
            <th class="pb-3 font-semibold text-gray-600">Date</th>
            <th class="pb-3 font-semibold text-gray-600">Action</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($pendingPayments as $payment)
            <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
              <td class="py-3 text-gray-900">{{ $payment->full_name }}</td>
              <td class="py-3 text-gray-600">{{ $payment->email }}</td>
              <td class="py-3 text-gray-600">{{ $payment->car_name }}</td>
              <td class="py-3 text-gray-600 capitalize">{{ $payment->payment_method }}</td>
              <td class="py-3 text-gray-900 font-semibold">{{ $payment->car_fee }}</td>
              <td class="py-3 text-gray-500">{{ $payment->created_at->format('M d, Y') }}</td>
              <td class="py-3">
                <form method="POST" action="{{ route('admin.payments.confirm', $payment) }}">
                  @csrf
                  <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg px-4 py-1.5 text-xs transition-colors">
                    Confirm
                  </button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="py-8 text-center text-gray-400">No pending payments.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</x-layouts.admin>
```

---

### Task 7: Update Routes and Admin Navigation

**Files:**
- Modify: `routes/web.php`
- Modify: `resources/views/components/layouts/admin.blade.php`

- [ ] **Step 1: Add routes**

Add imports:
```php
use App\Http\Controllers\Admin\PaymentConfirmationController;
use App\Http\Controllers\PaymentPendingController;
```

Add public route:
```php
Route::get('/payment-pending', [PaymentPendingController::class, 'index'])->name('payment.pending');
```

Add inside admin authenticated routes:
```php
    Route::get('/payments', [PaymentConfirmationController::class, 'index'])->name('admin.payments');
    Route::post('/payments/{submission}/confirm', [PaymentConfirmationController::class, 'confirm'])->name('admin.payments.confirm');
```

- [ ] **Step 2: Add admin sidebar link**

Add in `resources/views/components/layouts/admin.blade.php` after Settings:

```blade
        <a href="{{ url('/admin/payments') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->is('admin/payments*') ? 'bg-red-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
          Payments
        </a>
```

---

### Task 8: Verify

- [ ] **Step 1: Run PHP syntax checks**

```bash
php -l app/Http/Controllers/PaymentController.php
php -l app/Http/Controllers/PaymentPendingController.php
php -l app/Http/Controllers/Admin/PaymentConfirmationController.php
php -l app/Http/Controllers/Admin/SettingsController.php
php -l app/Livewire/GiveawayForm.php
php -l database/migrations/2026_07_04_230000_add_payment_method_and_status_to_giveaway_submissions.php
```

Expected: "No syntax errors detected" for all files.

- [ ] **Step 2: Manual browser checks**

1. Admin settings: configure PayPal, Bitcoin, or Ethereum.
2. Submit participate form.
3. Payment page shows only enabled methods.
4. Select method, submit → redirect to `/payment-pending`.
5. Database shows `payment_method` and `payment_status = pending`.
6. Visit `/admin/payments`, confirm payment.
7. Try submitting again with same email → blocked with pending payment message.
