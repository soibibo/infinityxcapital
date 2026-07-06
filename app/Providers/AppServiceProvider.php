<?php

namespace App\Providers;

use App\Models\GiveawaySubmission;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('components.layouts.admin', function ($view) {
            $pendingPaymentsCount = GiveawaySubmission::where('payment_status', 'pending')
                ->whereNotNull('payment_method')
                ->count();

            $view->with('pendingPaymentsCount', $pendingPaymentsCount);
        });
    }
}
