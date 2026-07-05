<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CarController extends Controller
{
    public function index(): View
    {
        $cars = Car::orderBy('sort_order')->get();
        return view('admin.cars.index', compact('cars'));
    }

    public function bulkUpdate(Request $request): RedirectResponse
    {
        $cars = $request->input('cars', []);

        foreach ($cars as $id => $data) {
            $car = Car::find($id);

            if (! $car) {
                continue;
            }

            $validated = validator($data, [
                'name' => 'required|string|max:255',
                'fee' => 'required|string|max:20',
                'desc' => 'nullable|string|max:255',
                'category' => 'nullable|string|max:255',
                'badge' => 'nullable|string|max:255',
                'power' => 'nullable|string|max:255',
                'range' => 'nullable|string|max:255',
                'delivery' => 'nullable|string|max:255',
                'gradient' => 'nullable|string|max:255',
                'sort_order' => 'required|integer|min:0',
                'is_active' => 'boolean',
            ])->validate();

            $validated['is_active'] = filter_var($data['is_active'] ?? false, FILTER_VALIDATE_BOOLEAN);

            $car->update($validated);
        }

        return redirect()->route('admin.cars.index')->with('success', 'Cars updated successfully.');
    }
}
