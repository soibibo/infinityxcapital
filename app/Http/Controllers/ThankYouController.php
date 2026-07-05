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
