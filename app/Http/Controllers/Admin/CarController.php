<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
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
                'image' => 'nullable|image|mimes:png,jpg,jpeg,svg,webp|max:2048',
            ])->validate();

            $validated['is_active'] = filter_var($data['is_active'] ?? false, FILTER_VALIDATE_BOOLEAN);

            $fileKey = "cars.{$id}.image";
            if ($request->hasFile($fileKey)) {
                if ($car->image && Storage::disk('public')->exists($car->image)) {
                    Storage::disk('public')->delete($car->image);
                }
                $validated['image'] = $request->file($fileKey)->store('cars', 'public');
            } else {
                unset($validated['image']);
            }

            $car->update($validated);
        }

        return redirect()->route('admin.cars.index')
            ->with('success', 'Cars updated successfully.');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'key' => 'required|string|max:20|unique:cars,key',
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
            'image' => 'nullable|image|mimes:png,jpg,jpeg,svg,webp|max:2048',
        ]);

        $validated['key'] = strtolower(preg_replace('/[^a-z0-9_-]/', '-', $validated['key']));
        $validated['is_active'] = true;

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('cars', 'public');
        }

        Car::create($validated);

        return redirect()->route('admin.cars.index')
            ->with('success', 'Car created successfully.');
    }

    public function destroy(Car $car): RedirectResponse
    {
        if ($car->image && Storage::disk('public')->exists($car->image)) {
            Storage::disk('public')->delete($car->image);
        }

        $car->delete();

        return redirect()->route('admin.cars.index')
            ->with('success', 'Car deleted successfully.');
    }
}
