<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GiveawayController extends Controller
{
    public function participate()
    {
        return view('participate');
    }

    public function submit(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'car_model' => 'required|string|in:model_3,model_y,model_s,model_x',
            'street' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'zip' => 'required|string|max:20',
            'country' => 'required|string|size:2',
        ]);

        // Store in session for success display
        session()->flash('giveaway_submitted', true);
        session()->flash('giveaway_data', $validated);

        // Redirect back to the form with a success message
        return redirect()->route('participate')->with('success', true);
    }
}