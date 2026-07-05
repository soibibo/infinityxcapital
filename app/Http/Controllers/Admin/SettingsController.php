<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingsController extends Controller
{
    private array $methodKeys = ['bitcoin', 'ethereum', 'usdt', 'paypal'];

    public function index(): View
    {
        $methods = json_decode(Setting::getValue('payment_methods', '{}'), true) ?: [];

        foreach ($this->methodKeys as $key) {
            $methods[$key] = array_merge([
                'active' => false,
                'wallet_address' => '',
                'minimum_deposit' => '',
                'instructions' => '',
            ], $methods[$key] ?? []);
        }

        return view('admin.settings', compact('methods'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'methods' => ['required', 'array'],
            'methods.*.active' => ['nullable', 'boolean'],
            'methods.*.wallet_address' => ['nullable', 'string', 'max:255'],
            'methods.*.minimum_deposit' => ['nullable', 'string', 'max:50'],
            'methods.*.instructions' => ['nullable', 'string'],
            'methods.*.barcode' => ['nullable', 'image', 'mimes:png,jpg,jpeg,svg', 'max:2048'],
        ]);

        $existingMethods = json_decode(Setting::getValue('payment_methods', '{}'), true) ?: [];
        $methods = [];

        foreach ($this->methodKeys as $key) {
            $input = $validated['methods'][$key] ?? [];
            $active = filter_var($input['active'] ?? false, FILTER_VALIDATE_BOOLEAN);

            $method = [
                'active' => $active,
                'wallet_address' => trim($input['wallet_address'] ?? ''),
                'minimum_deposit' => trim($input['minimum_deposit'] ?? ''),
                'instructions' => trim($input['instructions'] ?? ''),
            ];

            if (in_array($key, ['bitcoin', 'ethereum', 'usdt'])) {
                if ($request->hasFile("methods.{$key}.barcode")) {
                    if (!empty($existingMethods[$key]['barcode'])) {
                        \Storage::disk('public')->delete($existingMethods[$key]['barcode']);
                    }
                    $path = $request->file("methods.{$key}.barcode")->store('barcodes', 'public');
                    $method['barcode'] = $path;
                } else {
                    $method['barcode'] = $existingMethods[$key]['barcode'] ?? '';
                }
            }

            if ($active) {
                $rules = [
                    "methods.{$key}.wallet_address" => ['required', 'string', 'max:255'],
                    "methods.{$key}.minimum_deposit" => ['required', 'string', 'max:50'],
                ];

                $request->validate($rules);
            }

            $methods[$key] = $method;
        }

        Setting::setValue('payment_methods', json_encode($methods));

        return redirect()->route('admin.settings')->with('success', 'Payment methods updated successfully.');
    }

    public function removeBarcode(string $method)
    {
        if (!in_array($method, ['bitcoin', 'ethereum', 'usdt'])) {
            return response()->json(['success' => false, 'message' => 'Invalid method'], 400);
        }

        $methods = json_decode(Setting::getValue('payment_methods', '{}'), true) ?: [];

        if (!empty($methods[$method]['barcode'])) {
            \Storage::disk('public')->delete($methods[$method]['barcode']);
            $methods[$method]['barcode'] = '';
            Setting::setValue('payment_methods', json_encode($methods));
        }

        return response()->json(['success' => true]);
    }
}
