# Post-Submission Payment Flow Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** After a user submits the giveaway form, redirect them to a placeholder payment page that uses the admin-selected gateway, then record payment and show a thank-you page.

**Architecture:** Livewire `GiveawayForm` stores the new submission ID in session and redirects to `PaymentController::index`. Payment page displays submission summary and active gateway. `PaymentController::process` updates `paid_at` and redirects to the thank-you page.

**Tech Stack:** Laravel, Livewire, PHP 8.4+, Tailwind CSS v4, Vite.

---

### Task 1: Add paid_at Migration

**Files:**
- Create: `database/migrations/2026_07_04_220000_add_paid_at_to_giveaway_submissions_table.php`

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
            $table->timestamp('paid_at')->nullable()->after('country');
        });
    }

    public function down(): void
    {
        Schema::table('giveaway_submissions', function (Blueprint $table) {
            $table->dropColumn('paid_at');
        });
    }
};
```

- [ ] **Step 2: Run the migration**

```bash
php artisan migrate
```

---

### Task 2: Update GiveawayForm to Redirect After Submit

**Files:**
- Modify: `app/Livewire/GiveawayForm.php`

- [ ] **Step 1: Replace the submit() method**

```php
    public function submit()
    {
        $this->validate();

        $car = $this->models[$this->carModel] ?? $this->models['model_3'];

        $submission = GiveawaySubmission::create([
            'full_name' => $this->fullName,
            'email' => $this->email,
            'phone' => $this->phone,
            'car_model' => $this->carModel,
            'car_name' => $car['name'],
            'car_fee' => $car['fee'],
            'street' => $this->street,
            'city' => $this->city,
            'zip' => $this->zip,
            'country' => $this->country,
        ]);

        session()->put('payment_submission_id', $submission->id);

        return $this->redirectRoute('payment');
    }
```

---

### Task 3: Create PaymentController and View

**Files:**
- Create: `app/Http/Controllers/PaymentController.php`
- Create: `resources/views/payment.blade.php`

- [ ] **Step 1: Create PaymentController**

```php
<?php

namespace App\Http\Controllers;

use App\Models\GiveawaySubmission;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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

        return view('payment', compact('submission', 'gateway', 'settings'));
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

        $submission->update(['paid_at' => now()]);
        session()->forget('payment_submission_id');

        return redirect()->route('thank-you');
    }
}
```

- [ ] **Step 2: Create payment.blade.php**

```blade
<x-layouts.app>
  @push('title', 'Complete Payment — InfinityX Capital')

  <div class="min-h-screen bg-gray-50 flex items-center justify-center p-6">
    <div class="max-w-lg w-full bg-white rounded-3xl shadow-xl border border-gray-100 p-8">
      <div class="text-center mb-6">
        <div class="inline-flex items-center gap-2 bg-red-600/10 border border-red-200 rounded-full px-4 py-1.5 mb-4">
          <span class="text-red-600 text-sm font-bold uppercase tracking-wide">Secure Checkout</span>
        </div>
        <h1 class="text-2xl font-black text-gray-900">Complete Your Payment</h1>
        <p class="text-gray-500 mt-2 text-sm">Review your details and confirm the payment to finalize your entry.</p>
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
        <div class="flex justify-between text-sm">
          <span class="text-gray-500">Gateway</span>
          <span class="font-semibold text-gray-900 capitalize">{{ $gateway }}</span>
        </div>
        <div class="border-t border-gray-200 pt-3 flex justify-between items-center">
          <span class="text-gray-700 font-medium">Total Fee</span>
          <span class="text-2xl font-black text-red-600">{{ $submission->car_fee }}</span>
        </div>
      </div>

      @if($gateway === 'offline' && !empty($settings['offline']['instructions']))
        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 mb-6">
          <h3 class="text-sm font-bold text-yellow-800 mb-1">Payment Instructions</h3>
          <p class="text-sm text-yellow-700 whitespace-pre-line">{{ $settings['offline']['instructions'] }}</p>
        </div>
      @endif

      <form method="POST" action="{{ route('payment.process') }}">
        @csrf
        <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-black py-4 rounded-xl transition-all duration-300 text-lg shadow-lg shadow-red-200 hover:shadow-xl">
          Complete Payment
        </button>
      </form>

      <p class="text-center text-gray-400 text-xs mt-4">🔒 Secured by {{ ucfirst($gateway) }}</p>
    </div>
  </div>
</x-layouts.app>
```

---

### Task 4: Create ThankYouController and View

**Files:**
- Create: `app/Http/Controllers/ThankYouController.php`
- Create: `resources/views/thank-you.blade.php`

- [ ] **Step 1: Create ThankYouController**

```php
<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class ThankYouController extends Controller
{
    public function index(): View
    {
        return view('thank-you');
    }
}
```

- [ ] **Step 2: Create thank-you.blade.php**

```blade
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
```

---

### Task 5: Add Routes

**Files:**
- Modify: `routes/web.php`

- [ ] **Step 1: Add payment and thank-you routes**

Add inside the file (after existing routes):

```php
Route::get('/payment', [PaymentController::class, 'index'])->name('payment');
Route::post('/payment', [PaymentController::class, 'process'])->name('payment.process');
Route::get('/thank-you', [ThankYouController::class, 'index'])->name('thank-you');
```

Ensure the `PaymentController` and `ThankYouController` imports are at the top of `routes/web.php`.

---

### Task 6: Verify

- [ ] **Step 1: Run PHP syntax checks**

```bash
php -l app/Http/Controllers/PaymentController.php
php -l app/Http/Controllers/ThankYouController.php
php -l app/Livewire/GiveawayForm.php
php -l database/migrations/2026_07_04_220000_add_paid_at_to_giveaway_submissions_table.php
```

Expected: "No syntax errors detected" for all files.

- [ ] **Step 2: Run migrations**

```bash
php artisan migrate
```

Expected: migration completes successfully.

- [ ] **Step 3: Manual browser check**

1. Visit `/participate`, fill out and submit the form.
2. Confirm redirect to `/payment`.
3. Confirm `/payment` shows the car, fee, and active gateway.
4. Click "Complete Payment".
5. Confirm redirect to `/thank-you`.
6. Confirm the submission's `paid_at` column is set in the database.
