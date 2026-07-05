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
