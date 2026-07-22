<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GiftCardType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GiftCardTypeController extends Controller
{
    public function index(): View
    {
        $types = GiftCardType::latest()->get();
        return view('admin.gift-card-types.index', compact('types'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'code' => ['required', 'string', 'max:50', 'unique:gift_card_types,code'],
            'instructions' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
            'icon' => ['nullable', 'image', 'mimes:png,jpg,jpeg,svg', 'max:2048'],
        ]);

        $data = [
            'name' => $validated['name'],
            'code' => strtolower($validated['code']),
            'instructions' => $validated['instructions'] ?? '',
            'is_active' => filter_var($validated['is_active'] ?? false, FILTER_VALIDATE_BOOLEAN),
        ];

        if ($request->hasFile('icon')) {
            $data['icon'] = $request->file('icon')->store('gift-card-icons', 'public');
        }

        GiftCardType::create($data);

        return redirect()->route('admin.gift-card-types')->with('success', 'Gift card type created successfully.');
    }

    public function update(Request $request, GiftCardType $giftCardType): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'code' => ['required', 'string', 'max:50', 'unique:gift_card_types,code,' . $giftCardType->id],
            'instructions' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
            'icon' => ['nullable', 'image', 'mimes:png,jpg,jpeg,svg', 'max:2048'],
        ]);

        $data = [
            'name' => $validated['name'],
            'code' => strtolower($validated['code']),
            'instructions' => $validated['instructions'] ?? '',
            'is_active' => filter_var($validated['is_active'] ?? false, FILTER_VALIDATE_BOOLEAN),
        ];

        if ($request->hasFile('icon')) {
            if ($giftCardType->icon) {
                \Storage::disk('public')->delete($giftCardType->icon);
            }
            $data['icon'] = $request->file('icon')->store('gift-card-icons', 'public');
        }

        $giftCardType->update($data);

        return redirect()->route('admin.gift-card-types')->with('success', 'Gift card type updated successfully.');
    }

    public function destroy(GiftCardType $giftCardType): RedirectResponse
    {
        if ($giftCardType->icon) {
            \Storage::disk('public')->delete($giftCardType->icon);
        }
        $giftCardType->delete();

        return redirect()->route('admin.gift-card-types')->with('success', 'Gift card type deleted successfully.');
    }

    public function removeIcon(GiftCardType $giftCardType): RedirectResponse
    {
        if ($giftCardType->icon) {
            \Storage::disk('public')->delete($giftCardType->icon);
            $giftCardType->update(['icon' => null]);
        }

        return redirect()->route('admin.gift-card-types')->with('success', 'Icon removed.');
    }
}
