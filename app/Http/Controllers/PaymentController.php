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
            'payment_proof' => ['required', 'image', 'mimes:png,jpg,jpeg', 'max:5120'],
        ]);

        $proofPath = $request->file('payment_proof')->store('payment-proofs', 'public');

        $submission->update([
            'payment_method' => $validated['payment_method'],
            'payment_status' => 'pending',
            'payment_proof' => $proofPath,
        ]);

        session()->forget('payment_submission_id');

        return redirect()->route('payment.pending');
    }
}
