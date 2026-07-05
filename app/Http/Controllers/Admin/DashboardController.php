<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GiveawaySubmission;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalSubmissions = GiveawaySubmission::count();
        $totalUsers = User::count();
        $todaySubmissions = GiveawaySubmission::whereDate('created_at', today())->count();
        $conversionRate = $totalUsers > 0
            ? round(($totalSubmissions / $totalUsers) * 100) . '%'
            : '0%';
        $recentSubmissions = GiveawaySubmission::latest()->take(10)->get();

        $countryStats = GiveawaySubmission::selectRaw('country, COUNT(*) as count')
            ->whereNotNull('country')
            ->groupBy('country')
            ->orderByDesc('count')
            ->limit(5)
            ->get();

        $countryLabels = $countryStats->pluck('country')->toArray();
        $countryData = $countryStats->pluck('count')->toArray();

        $chartLabels = [];
        $chartData = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $chartLabels[] = $date->format('M d');
            $chartData[] = GiveawaySubmission::whereDate('created_at', $date)->count();
        }

        return view('admin.dashboard', compact(
            'totalSubmissions',
            'totalUsers',
            'todaySubmissions',
            'conversionRate',
            'recentSubmissions',
            'countryLabels',
            'countryData',
            'chartLabels',
            'chartData'
        ));
    }
}
