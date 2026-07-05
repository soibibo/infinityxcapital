# Payment Methods + Admin Confirmation Design

## Goal
Allow users to choose between Bitcoin, Ethereum, or PayPal on the payment page, record their selection as a pending payment, and require an admin to confirm the payment before the user can participate again.

## Context
The existing payment page shows a single admin-selected gateway and completes payment immediately. The admin settings page supports Stripe, PayPal, Coinbase, and Offline gateways. The giveaway submission flow currently allows unlimited submissions per email.

## Proposed Approach
Add Bitcoin and Ethereum to the admin settings. Redesign the payment page to show only admin-enabled methods as selectable options. Record the selected method and set `payment_status` to `pending`. Build an admin payment confirmations page. Block new submissions from emails with pending payments.

## Data Model Changes

### `giveaway_submissions` table
Add columns:
- `payment_method` — nullable string (`bitcoin`, `ethereum`, `paypal`)
- `payment_status` — string, default `pending`, values `pending` | `confirmed`

## Backend Changes

### Database Migration
Create migration adding `payment_method` and `payment_status` to `giveaway_submissions`.

### `app/Http/Controllers/Admin/SettingsController.php`
- Add validation rules for `bitcoin`, `ethereum`, and `paypal` settings.
- Save these to `payment_gateway_settings` JSON.
- Add validation ensuring at least one method is enabled (optional but recommended).

### `app/Livewire/GiveawayForm.php`
- Before validation, check if the submitted email already has a submission with `payment_status = pending`.
- If found, abort and show a validation error.

### `app/Http/Controllers/PaymentController.php`
- `index()`: Load submission from session, load enabled methods from settings.
- `process(Request $request)`: Validate selected `payment_method` is one of the enabled methods. Update submission with `payment_method` and `payment_status = pending`. Redirect to `payment-pending` route.

### New `app/Http/Controllers/Admin/PaymentConfirmationController.php`
- `index()`: List submissions where `payment_status = pending`.
- `confirm(Request $request, GiveawaySubmission $submission)`: Update `payment_status` to `confirmed`. Redirect back with success.

### New `app/Http/Controllers/PaymentPendingController.php`
- `index()`: Show pending confirmation page.

## Frontend Changes

### `resources/views/admin/settings.blade.php`
- Add Bitcoin and Ethereum panels with wallet address fields.
- Add PayPal panel with client ID, secret, environment fields.
- Convert gateway selector into multi-method enable toggles or keep single selector plus per-method details.

### `resources/views/payment.blade.php`
- Show selectable method cards (Bitcoin, Ethereum, PayPal) based on enabled methods.
- On selection, show method-specific instructions.
- Submit button records the choice and sets status to pending.

### `resources/views/payment-pending.blade.php` (new)
- Explain that the payment is pending admin confirmation.

### `resources/views/admin/payments/index.blade.php` (new)
- Table of pending payments.
- Confirm button per row.

### `resources/views/livewire/giveaway-form.blade.php`
- Show error when a previous submission from this email has a pending payment.

## Routes
```php
Route::get('/payment-pending', [PaymentPendingController::class, 'index'])->name('payment.pending');

Route::middleware('admin')->prefix('admin')->group(function () {
    Route::get('/payments', [PaymentConfirmationController::class, 'index'])->name('admin.payments');
    Route::post('/payments/{submission}/confirm', [PaymentConfirmationController::class, 'confirm'])->name('admin.payments.confirm');
});
```

## Validation
- Admin can configure Bitcoin, Ethereum, and PayPal settings.
- Only enabled methods appear on the payment page.
- Selecting a method and submitting records it with `payment_status = pending`.
- User is redirected to payment-pending page.
- Admin can view pending payments and confirm them.
- User with pending payment cannot submit the form again.

## Files Changed
- `app/Http/Controllers/Admin/SettingsController.php`
- `app/Http/Controllers/PaymentController.php`
- `app/Http/Controllers/PaymentPendingController.php` (new)
- `app/Http/Controllers/Admin/PaymentConfirmationController.php` (new)
- `app/Livewire/GiveawayForm.php`
- `resources/views/admin/settings.blade.php`
- `resources/views/payment.blade.php`
- `resources/views/payment-pending.blade.php` (new)
- `resources/views/admin/payments/index.blade.php` (new)
- `resources/views/livewire/giveaway-form.blade.php`
- `database/migrations/2026_07_04_xxxxxx_add_payment_method_and_status_to_giveaway_submissions.php` (new)
- `routes/web.php`
