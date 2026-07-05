# Payment Gateway Settings Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Update the admin settings page so admins can select a payment gateway and enter/store its configuration details, with dynamic panels powered by Alpine.js.

**Architecture:** Keep the existing `payment_gateway` key as the active provider selector. Add one JSON setting `payment_gateway_settings` that holds credentials per provider. The Blade view uses Alpine.js to show only the panel for the selected gateway.

**Tech Stack:** Laravel 12 (assumed from project structure), PHP 8.4+, Tailwind CSS v4, Vite, Alpine.js v3, PHPUnit.

---

### Task 1: Install Alpine.js

**Files:**
- Modify: `package.json`
- Modify: `package-lock.json` (via npm install)

- [ ] **Step 1: Install the dependency**

```bash
npm install alpinejs
```

- [ ] **Step 2: Verify package.json contains alpinejs**

Run: `cat package.json | grep alpinejs`
Expected: a line like `"alpinejs": "^3.x.x"` in `dependencies`.

---

### Task 2: Initialize Alpine.js

**Files:**
- Modify: `resources/js/app.js`

- [ ] **Step 1: Replace the contents of app.js**

```javascript
import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
```

- [ ] **Step 2: Verify Vite picks up the new module**

Run: `npm run build`
Expected: build completes with no "module not found" errors.

---

### Task 3: Add Feature Tests for SettingsController

**Files:**
- Create: `tests/Feature/Admin/SettingsControllerTest.php`

- [ ] **Step 1: Create the test file**

```php
<?php

namespace Tests\Feature\Admin;

use App\Models\Admin;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SettingsControllerTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): Admin
    {
        return Admin::factory()->create();
    }

    public function test_guests_cannot_access_settings(): void
    {
        $this->get(route('admin.settings'))->assertForbidden();
        $this->post(route('admin.settings.update'))->assertForbidden();
    }

    public function test_settings_page_shows_gateway_form(): void
    {
        $admin = $this->admin();

        $response = $this->actingAs($admin, 'admin')
            ->get(route('admin.settings'));

        $response->assertOk();
        $response->assertSee('Payment Gateway');
        $response->assertSee('stripe');
        $response->assertSee('paypal');
        $response->assertSee('coinbase');
        $response->assertSee('offline');
    }

    public function test_update_saves_selected_gateway_and_details(): void
    {
        $admin = $this->admin();

        $response = $this->actingAs($admin, 'admin')
            ->post(route('admin.settings.update'), [
                'payment_gateway' => 'stripe',
                'settings' => [
                    'stripe' => [
                        'publishable_key' => 'pk_test_123',
                        'secret_key' => 'sk_test_123',
                        'webhook_secret' => 'whsec_123',
                    ],
                    'paypal' => [
                        'client_id' => '',
                        'client_secret' => '',
                        'environment' => 'sandbox',
                    ],
                    'coinbase' => [
                        'api_key' => '',
                        'webhook_secret' => '',
                    ],
                    'offline' => [
                        'instructions' => '',
                    ],
                ],
            ]);

        $response->assertRedirect(route('admin.settings'));
        $response->assertSessionHas('success');

        $this->assertEquals('stripe', Setting::getValue('payment_gateway'));

        $saved = json_decode(Setting::getValue('payment_gateway_settings'), true);
        $this->assertEquals('pk_test_123', $saved['stripe']['publishable_key']);
        $this->assertEquals('sk_test_123', $saved['stripe']['secret_key']);
        $this->assertEquals('whsec_123', $saved['stripe']['webhook_secret']);
    }

    public function test_validation_requires_fields_for_selected_gateway(): void
    {
        $admin = $this->admin();

        $response = $this->actingAs($admin, 'admin')
            ->post(route('admin.settings.update'), [
                'payment_gateway' => 'stripe',
                'settings' => [
                    'stripe' => [
                        'publishable_key' => '',
                        'secret_key' => '',
                        'webhook_secret' => '',
                    ],
                ],
            ]);

        $response->assertSessionHasErrors([
            'settings.stripe.publishable_key',
            'settings.stripe.secret_key',
        ]);
    }

    public function test_update_saves_paypal_configuration(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin, 'admin')
            ->post(route('admin.settings.update'), [
                'payment_gateway' => 'paypal',
                'settings' => [
                    'stripe' => [
                        'publishable_key' => '',
                        'secret_key' => '',
                        'webhook_secret' => '',
                    ],
                    'paypal' => [
                        'client_id' => 'paypal_client',
                        'client_secret' => 'paypal_secret',
                        'environment' => 'live',
                    ],
                    'coinbase' => [
                        'api_key' => '',
                        'webhook_secret' => '',
                    ],
                    'offline' => [
                        'instructions' => '',
                    ],
                ],
            ]);

        $this->assertEquals('paypal', Setting::getValue('payment_gateway'));

        $saved = json_decode(Setting::getValue('payment_gateway_settings'), true);
        $this->assertEquals('paypal_client', $saved['paypal']['client_id']);
        $this->assertEquals('live', $saved['paypal']['environment']);
    }
}
```

- [ ] **Step 2: Create the Admin factory**

Because `Admin::factory()->create()` requires a factory, create `database/factories/AdminFactory.php`:

```php
<?php

namespace Database\Factories;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminFactory extends Factory
{
    protected $model = Admin::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }
}
```

- [ ] **Step 3: Run the tests to confirm they fail**

Run: `php artisan test tests/Feature/Admin/SettingsControllerTest.php`
Expected: FAIL because the controller does not yet accept `settings` input.

---

### Task 4: Update SettingsController

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
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function index(): View
    {
        $paymentGateway = Setting::getValue('payment_gateway', 'stripe');
        $settings = json_decode(Setting::getValue('payment_gateway_settings', '{}'), true) ?: [];

        return view('admin.settings', compact('paymentGateway', 'settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $gateways = ['stripe', 'paypal', 'coinbase', 'offline'];

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

- [ ] **Step 2: Run the tests**

Run: `php artisan test tests/Feature/Admin/SettingsControllerTest.php`
Expected: PASS.

---

### Task 5: Update the Admin Settings View

**Files:**
- Modify: `resources/views/admin/settings.blade.php`

- [ ] **Step 1: Replace the view content**

```blade
<x-layouts.admin>
  <x-slot:title>Settings</x-slot:title>

  <div class="mb-6">
    <h1 class="text-2xl font-black text-gray-900">Settings</h1>
    <p class="text-sm text-gray-500 mt-1">Configure application settings</p>
  </div>

  @if (session('success'))
    <div class="mb-6 bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 text-sm">
      {{ session('success') }}
    </div>
  @endif

  <div
    class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 max-w-2xl"
    x-data="{ gateway: '{{ old('payment_gateway', $paymentGateway) }}' }"
  >
    <form method="POST" action="{{ route('admin.settings.update') }}">
      @csrf

      <div class="space-y-6">
        <div>
          <label for="payment_gateway" class="block text-sm font-medium text-gray-700 mb-1">Payment Gateway</label>
          <select
            id="payment_gateway"
            name="payment_gateway"
            x-model="gateway"
            class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition-colors"
          >
            <option value="stripe" @selected($paymentGateway === 'stripe')>Stripe</option>
            <option value="paypal" @selected($paymentGateway === 'paypal')>PayPal</option>
            <option value="coinbase" @selected($paymentGateway === 'coinbase')>Coinbase</option>
            <option value="offline" @selected($paymentGateway === 'offline')>Offline / Manual</option>
          </select>
          @error('payment_gateway')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        {{-- Stripe --}}
        <div x-show="gateway === 'stripe'" x-cloak class="space-y-4">
          <h2 class="text-sm font-semibold text-gray-900">Stripe Credentials</h2>

          <div>
            <label for="settings_stripe_publishable_key" class="block text-sm font-medium text-gray-700 mb-1">Publishable Key</label>
            <input
              type="text"
              id="settings_stripe_publishable_key"
              name="settings[stripe][publishable_key]"
              value="{{ old('settings.stripe.publishable_key', $settings['stripe']['publishable_key'] ?? '') }}"
              class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition-colors"
              placeholder="pk_live_..."
            />
            @error('settings.stripe.publishable_key')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label for="settings_stripe_secret_key" class="block text-sm font-medium text-gray-700 mb-1">Secret Key</label>
            <input
              type="text"
              id="settings_stripe_secret_key"
              name="settings[stripe][secret_key]"
              value="{{ old('settings.stripe.secret_key', $settings['stripe']['secret_key'] ?? '') }}"
              class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition-colors"
              placeholder="sk_live_..."
            />
            @error('settings.stripe.secret_key')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label for="settings_stripe_webhook_secret" class="block text-sm font-medium text-gray-700 mb-1">Webhook Secret</label>
            <input
              type="text"
              id="settings_stripe_webhook_secret"
              name="settings[stripe][webhook_secret]"
              value="{{ old('settings.stripe.webhook_secret', $settings['stripe']['webhook_secret'] ?? '') }}"
              class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition-colors"
              placeholder="whsec_..."
            />
            @error('settings.stripe.webhook_secret')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>
        </div>

        {{-- PayPal --}}
        <div x-show="gateway === 'paypal'" x-cloak class="space-y-4">
          <h2 class="text-sm font-semibold text-gray-900">PayPal Credentials</h2>

          <div>
            <label for="settings_paypal_client_id" class="block text-sm font-medium text-gray-700 mb-1">Client ID</label>
            <input
              type="text"
              id="settings_paypal_client_id"
              name="settings[paypal][client_id]"
              value="{{ old('settings.paypal.client_id', $settings['paypal']['client_id'] ?? '') }}"
              class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition-colors"
            />
            @error('settings.paypal.client_id')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label for="settings_paypal_client_secret" class="block text-sm font-medium text-gray-700 mb-1">Client Secret</label>
            <input
              type="text"
              id="settings_paypal_client_secret"
              name="settings[paypal][client_secret]"
              value="{{ old('settings.paypal.client_secret', $settings['paypal']['client_secret'] ?? '') }}"
              class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition-colors"
            />
            @error('settings.paypal.client_secret')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label for="settings_paypal_environment" class="block text-sm font-medium text-gray-700 mb-1">Environment</label>
            <select
              id="settings_paypal_environment"
              name="settings[paypal][environment]"
              class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition-colors"
            >
              <option value="sandbox" @selected((old('settings.paypal.environment', $settings['paypal']['environment'] ?? 'sandbox')) === 'sandbox')>Sandbox</option>
              <option value="live" @selected((old('settings.paypal.environment', $settings['paypal']['environment'] ?? 'sandbox')) === 'live')>Live</option>
            </select>
            @error('settings.paypal.environment')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>
        </div>

        {{-- Coinbase --}}
        <div x-show="gateway === 'coinbase'" x-cloak class="space-y-4">
          <h2 class="text-sm font-semibold text-gray-900">Coinbase Credentials</h2>

          <div>
            <label for="settings_coinbase_api_key" class="block text-sm font-medium text-gray-700 mb-1">API Key</label>
            <input
              type="text"
              id="settings_coinbase_api_key"
              name="settings[coinbase][api_key]"
              value="{{ old('settings.coinbase.api_key', $settings['coinbase']['api_key'] ?? '') }}"
              class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition-colors"
            />
            @error('settings.coinbase.api_key')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label for="settings_coinbase_webhook_secret" class="block text-sm font-medium text-gray-700 mb-1">Webhook Secret</label>
            <input
              type="text"
              id="settings_coinbase_webhook_secret"
              name="settings[coinbase][webhook_secret]"
              value="{{ old('settings.coinbase.webhook_secret', $settings['coinbase']['webhook_secret'] ?? '') }}"
              class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition-colors"
            />
            @error('settings.coinbase.webhook_secret')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>
        </div>

        {{-- Offline / Manual --}}
        <div x-show="gateway === 'offline'" x-cloak class="space-y-4">
          <h2 class="text-sm font-semibold text-gray-900">Offline Payment Instructions</h2>

          <div>
            <label for="settings_offline_instructions" class="block text-sm font-medium text-gray-700 mb-1">Instructions</label>
            <textarea
              id="settings_offline_instructions"
              name="settings[offline][instructions]"
              rows="4"
              class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition-colors"
            >{{ old('settings.offline.instructions', $settings['offline']['instructions'] ?? '') }}</textarea>
            @error('settings.offline.instructions')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>
        </div>

        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-semibold rounded-xl px-6 py-2.5 text-sm transition-colors">
          Save Settings
        </button>
      </div>
    </form>
  </div>
</x-layouts.admin>
```

- [ ] **Step 2: Add x-cloak styles**

Ensure `x-cloak` is hidden before Alpine initializes. Add to `resources/css/app.css` (or the existing global CSS):

```css
[x-cloak] {
  display: none !important;
}
```

If `resources/css/app.css` does not exist, create it and import it in `resources/js/app.js`:

```javascript
import '../css/app.css';
```

---

### Task 6: Run Full Verification

- [ ] **Step 1: Run PHPUnit**

```bash
php artisan test
```

Expected: all tests pass, including the new `SettingsControllerTest`.

- [ ] **Step 2: Build frontend assets**

```bash
npm run build
```

Expected: Vite builds without errors.

- [ ] **Step 3: Manual browser check**

Visit `/admin/settings`, log in as an admin, and verify:
- Selecting each gateway shows only its panel.
- Saving stores the values and shows the success message.
- Validation errors appear when required fields for the selected gateway are empty.

---

## Self-Review Checklist

1. **Spec coverage:**
   - JSON blob storage for gateway settings → Task 4.
   - Dynamic panel UI with Alpine.js → Tasks 2 and 5.
   - Fields per gateway (Stripe, PayPal, Coinbase, offline) → Task 5.
   - Validation requiring fields only for selected gateway → Task 4.
   - Alpine.js dependency → Task 1.

2. **Placeholder scan:**
   - No TBD, TODO, or "implement later" items.
   - All code blocks contain complete, runnable code.

3. **Type consistency:**
   - Setting keys used in controller match form field names in the view.
   - Test assertions match the JSON structure saved by the controller.
