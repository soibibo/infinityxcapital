<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CarController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PaymentConfirmationController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PaymentPendingController;
use App\Http\Controllers\ThankYouController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $cars = \App\Models\Car::where('is_active', true)
        ->orderBy('sort_order')
        ->get();

    return view('home', compact('cars'));
});

Route::get('/participate', function () {
    return view('participate');
})->name('participate');

Route::get('/payment', [PaymentController::class, 'index'])->name('payment');
Route::post('/payment', [PaymentController::class, 'process'])->name('payment.process');
Route::get('/thank-you', [ThankYouController::class, 'index'])->name('thank-you');
Route::get('/payment-pending', [PaymentPendingController::class, 'index'])->name('payment.pending');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
});

Route::post('/logout', [LoginController::class, 'destroy'])->name('logout')->middleware('auth');

// Admin guest routes (not logged in as admin)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AuthController::class, 'create'])->name('login');
        Route::post('/login', [AuthController::class, 'store']);
    });

    Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');
});

// Admin authenticated routes
Route::middleware('admin')->prefix('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index']);

    Route::get('/settings', [SettingsController::class, 'index'])->name('admin.settings');
    Route::post('/settings', [SettingsController::class, 'update'])->name('admin.settings.update');
    Route::delete('/settings/barcode/{method}', [SettingsController::class, 'removeBarcode'])->name('admin.settings.barcode.remove');

    Route::get('/payments', [PaymentConfirmationController::class, 'index'])->name('admin.payments');
    Route::post('/payments/{submission}/confirm', [PaymentConfirmationController::class, 'confirm'])->name('admin.payments.confirm');
    Route::post('/payments/{submission}/reject', [PaymentConfirmationController::class, 'reject'])->name('admin.payments.reject');

    Route::get('/cars', [CarController::class, 'index'])->name('admin.cars.index');
    Route::put('/cars/bulk-update', [CarController::class, 'bulkUpdate'])->name('admin.cars.bulk-update');
});
