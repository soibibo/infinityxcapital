# Refactored Payment Gateway Settings Design

## Goal
Replace the single-dropdown payment gateway settings with a modern list-based UI where each method (Bitcoin, Ethereum, USDT, PayPal) can be individually activated/deactivated and configured. The payment page then shows only the active methods as user-selectable options.

## Context
Current settings use `payment_gateway` (single key) and `payment_gateway_settings` (JSON). The payment page shows one method based on the selected gateway. The user wants a design matching a manual deposit methods list with activation toggles.

## Proposed Approach
Store all methods in one JSON setting `payment_methods`. Each method has `active`, `wallet_address`, `minimum_deposit`, and `instructions`. The settings view renders a card list with toggles and expandable config fields. The payment page filters active methods and lets users select one.

## Data Model

Key: `payment_methods`
Value shape (JSON):

```json
{
  "bitcoin": {
    "active": true,
    "wallet_address": "bc1...",
    "minimum_deposit": "10",
    "instructions": "Send BTC to this address"
  },
  "ethereum": {
    "active": true,
    "wallet_address": "0x...",
    "minimum_deposit": "10",
    "instructions": "Send ETH to this address"
  },
  "usdt": {
    "active": false,
    "wallet_address": "",
    "minimum_deposit": "10",
    "instructions": ""
  },
  "paypal": {
    "active": false,
    "wallet_address": "paypal@example.com",
    "minimum_deposit": "100",
    "instructions": "Send via PayPal"
  }
}
```

## Backend Changes

### `app/Http/Controllers/Admin/SettingsController.php`
- Replace existing payment gateway logic.
- Validate nested `methods[<method>][active|wallet_address|minimum_deposit|instructions]`.
- Require `wallet_address` and `minimum_deposit` when a method is active.
- Save to `payment_methods` JSON setting.

### `app/Http/Controllers/PaymentController.php`
- Load `payment_methods` JSON.
- Filter methods where `active` is true.
- Pass `activeMethods` to the payment view.
- Validate selected `payment_method` is in the active list.

## Frontend Changes

### `resources/views/admin/settings.blade.php`
- Remove the gateway dropdown and per-gateway panels.
- Add "Setup Payment Methods" header and subtitle.
- Render a card for each method with:
  - Icon/logo
  - Name + network label (BTC, ETH, USDT, PAYPAL)
  - Minimum Deposit
  - Activated/Deactivated badge
  - Toggle switch
- Expandable section per method with inputs for wallet address, minimum deposit, instructions.
- Keep existing Tailwind card styling.

### `resources/views/payment.blade.php`
- Replace single-method display with selectable cards for all active methods.
- Show selected method's instructions, wallet address, and minimum deposit.
- Submit records selected method.

## Files Changed
- `app/Http/Controllers/Admin/SettingsController.php`
- `resources/views/admin/settings.blade.php`
- `app/Http/Controllers/PaymentController.php`
- `resources/views/payment.blade.php`

## Validation
- Admin can activate/deactivate each method.
- Active methods require wallet address and minimum deposit.
- Payment page shows only active methods.
- Selecting a method and submitting records it correctly.
