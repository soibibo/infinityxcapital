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

        $transactionHistory = GiveawaySubmission::where('payment_status', 'confirmed')
            ->whereNotNull('payment_method')
            ->latest()
            ->get();

        return view('admin.payments.index', compact('pendingPayments', 'transactionHistory'));
    }

    public function confirm(Request $request, GiveawaySubmission $submission): RedirectResponse
    {
        $submission->update(['payment_status' => 'confirmed']);

        return redirect()->route('admin.payments')->with('success', 'Payment confirmed successfully.');
    }

    public function reject(Request $request, GiveawaySubmission $submission): RedirectResponse
    {
        $submission->update(['payment_status' => 'rejected']);

        return redirect()->route('admin.payments')->with('success', 'Payment rejected successfully.');
    }
}
