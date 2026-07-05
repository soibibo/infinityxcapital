# Post-Submission Payment Flow Design

## Goal
After a user submits their details on the participate page, redirect them to a payment page where they can complete a placeholder payment. The payment page uses the gateway selected in admin settings and records the payment by setting `paid_at` on the submission.

## Context
The participate page uses a Livewire `GiveawayForm` component. Currently, after submission it sets `$submitted = true` and shows a success summary inline. The admin settings page now stores a `payment_gateway` key and `payment_gateway_settings` JSON.

## Proposed Approach: Session-Based Redirect
Store the newly created submission ID in the session after Livewire submission, redirect to a dedicated `/payment` route, process the placeholder payment, then redirect to `/thank-you`.

## Backend Changes

### Database Migration
Create a new migration to add `paid_at` (nullable timestamp) to the `giveaway_submissions` table.

### `app/Livewire/GiveawayForm.php`
- After validation and creation, store the new submission ID in session:
  ```php
  session()->put('payment_submission_id', $submission->id);
  ```
- Redirect to the payment route:
  ```php
  return $this->redirectRoute('payment');
  ```

### `app/Http/Controllers/PaymentController.php` (new)
- `index()`:
  - Read `payment_submission_id` from session.
  - Load the submission; if missing, redirect home.
  - Load active gateway and settings from `Setting::getValue`.
  - Pass `submission`, `gateway`, and `settings` to `payment` view.
- `process(Request $request)`:
  - Read submission ID from session.
  - Load submission; abort/redirect if missing.
  - Update `paid_at` to the current timestamp.
  - Clear `payment_submission_id` from session.
  - Redirect to `thank-you` route.

### `app/Http/Controllers/ThankYouController.php` (new)
- `index()`: Return the `thank-you` view.

### `routes/web.php`
- Add routes:
  ```php
  Route::get('/payment', [PaymentController::class, 'index'])->name('payment');
  Route::post('/payment', [PaymentController::class, 'process'])->name('payment.process');
  Route::get('/thank-you', [ThankYouController::class, 'index'])->name('thank-you');
  ```

## Frontend Changes

### `resources/views/payment.blade.php` (new)
- Match the existing participate page styling.
- Show a summary card with:
  - Selected car name
  - Fee amount
  - Active payment gateway name
- Show a "Complete Payment" button posting to `payment.process`.
- For offline/manual gateway, show the configured instructions before the button.

### `resources/views/thank-you.blade.php` (new)
- Simple success page confirming:
  - Submission received
  - Payment completed
  - Redirect link back to home

### `resources/views/livewire/giveaway-form.blade.php`
- Remove or keep the inline success message; after redirect the component will not be visible.

## Security & UX Considerations
- Payment page reads submission from session, preventing direct access without prior submission.
- After payment, session key is cleared so the page cannot be reused.
- No real payment processing is implemented (placeholder flow).

## Files Changed
- `app/Livewire/GiveawayForm.php`
- `app/Http/Controllers/PaymentController.php` (new)
- `app/Http/Controllers/ThankYouController.php` (new)
- `resources/views/payment.blade.php` (new)
- `resources/views/thank-you.blade.php` (new)
- `database/migrations/2026_07_04_xxxxxx_add_paid_at_to_giveaway_submissions.php` (new)
- `routes/web.php`

## Validation
- Submitting the participate form creates a submission and redirects to `/payment`.
- `/payment` displays the correct car, fee, and active gateway.
- Clicking "Complete Payment" sets `paid_at` and redirects to `/thank-you`.
- Direct access to `/payment` without a session redirects home.
