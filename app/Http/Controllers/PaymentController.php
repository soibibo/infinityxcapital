<?php

namespace App\Http\Controllers;

use App\Models\GiftCardType;
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
        unset($activeMethods['gift_card']);

        $giftCardTypes = GiftCardType::active()->get();

        $allActiveMethods = $activeMethods;
        foreach ($giftCardTypes as $type) {
            $allActiveMethods[$type->code] = [
                'active' => true,
                'is_gift_card_type' => true,
                'id' => $type->id,
                'name' => $type->name,
                'icon' => $type->icon ? asset('storage/' . $type->icon) : null,
                'instructions' => $type->instructions,
            ];
        }

        if (empty($allActiveMethods)) {
            return redirect()->route('home')->with('error', 'No payment methods are available.');
        }

        return view('payment', compact('submission', 'allActiveMethods', 'giftCardTypes'));
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
        unset($activeMethods['gift_card']);
        $allowed = array_keys($activeMethods);

        $giftCardTypes = GiftCardType::active()->get();
        $giftCardTypeCodes = $giftCardTypes->pluck('code')->toArray();
        $allowed = array_merge($allowed, $giftCardTypeCodes);

        $rules = [
            'payment_method' => ['required', 'string', Rule::in($allowed)],
        ];

        $isGiftCardType = in_array($request->input('payment_method'), $giftCardTypeCodes);

        if ($isGiftCardType) {
            $rules['gift_card_code'] = ['required', 'string', 'max:255'];
            $rules['payment_proof'] = ['required', 'image', 'mimes:png,jpg,jpeg', 'max:5120'];
        } else {
            $rules['payment_proof'] = ['required', 'image', 'mimes:png,jpg,jpeg', 'max:5120'];
        }

        $validated = $request->validate($rules);

        $proofPath = $request->file('payment_proof')->store('payment-proofs', 'public');

        $updateData = [
            'payment_method' => $validated['payment_method'],
            'payment_status' => 'pending',
            'payment_proof' => $proofPath,
        ];

        if ($isGiftCardType) {
            $type = $giftCardTypes->firstWhere('code', $validated['payment_method']);
            $updateData['gift_card_type_id'] = $type->id;
            $updateData['gift_card_code'] = $validated['gift_card_code'];
        }

        $submission->update($updateData);

        session()->forget('payment_submission_id');

        return redirect()->route('payment.pending');
    }
}
