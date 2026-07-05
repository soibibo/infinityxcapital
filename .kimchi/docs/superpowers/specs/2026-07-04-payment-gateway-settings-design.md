# Payment Gateway Settings Design

## Goal
Update the admin settings page so administrators can enter and save configuration details for each supported payment gateway, using a modern grouped-form UI.

## Context
The current settings page only lets the user select a gateway (`stripe`, `paypal`, `coinbase`, `offline`) but provides no input fields for the credentials or instructions required by each provider.

## Proposed Approach: JSON Settings Blob
Store all gateway-specific configuration in a single JSON setting named `payment_gateway_settings`. The existing `payment_gateway` setting remains the active provider selector.

## Data Model

Key: `payment_gateway_settings`
Value shape (JSON):

```json
{
  "stripe": {
    "publishable_key": "pk_live_...",
    "secret_key": "sk_live_...",
    "webhook_secret": "whsec_..."
  },
  "paypal": {
    "client_id": "...",
    "client_secret": "...",
    "environment": "sandbox"
  },
  "coinbase": {
    "api_key": "...",
    "webhook_secret": "..."
  },
  "offline": {
    "instructions": "Bank transfer to ..."
  }
}
```

## Backend Changes

### `app/Http/Controllers/Admin/SettingsController.php`
- `index()`: Load `payment_gateway` and `payment_gateway_settings` (decoded to an array) and pass both to the view.
- `update()`: Validate:
  - `payment_gateway` is required and one of `stripe`, `paypal`, `coinbase`, `offline`.
  - Nested fields under `settings[<provider>]` are strings.
  - Required rules apply only to the currently selected provider.
  - Trim all string values before saving.
- Persist:
  - `Setting::setValue('payment_gateway', $validated['payment_gateway'])`
  - `Setting::setValue('payment_gateway_settings', json_encode($validated['settings']))`

## Frontend Changes

### `resources/views/admin/settings.blade.php`
- Add Alpine.js to toggle the visible gateway detail panel based on the dropdown value.
- Preserve existing Tailwind styling: white card, rounded-2xl, red focus ring, red Save Settings button.
- Render grouped inputs per gateway:
  - **Stripe**: Publishable key, Secret key, Webhook secret
  - **PayPal**: Client ID, Client secret, Environment (sandbox/live select)
  - **Coinbase**: API key, Webhook secret
  - **Offline / Manual**: Multi-line instructions textarea
- Show validation errors below the relevant input.
- Pre-fill existing saved values.

## JavaScript Dependency
- Install `alpinejs` via npm.
- Initialize Alpine.js in the project's main JavaScript entry (e.g., `resources/js/app.js`).

## Security & UX Considerations
- Inputs remain visible to admins for easy editing; placeholder hints can be shown for secret fields.
- Redirect back with the existing success flash message.
- Trim whitespace from submitted values.

## Files Changed
- `app/Http/Controllers/Admin/SettingsController.php`
- `resources/views/admin/settings.blade.php`
- `package.json`
- `resources/js/app.js`

## Validation
- Admin can select each gateway and see only its relevant fields.
- Saving stores the selected gateway and its details.
- Validation errors display under the correct field.
- Existing success message still appears after save.
