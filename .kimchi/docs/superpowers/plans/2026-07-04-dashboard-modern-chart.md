# Dashboard Modernization + Chart Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Modernize the admin dashboard and add a 7-day submissions trend chart using Chart.js and Alpine.js.

**Architecture:** Backend computes daily submission counts for the last 7 days and passes labels/data to the Blade view. The view renders an Alpine.js-driven Chart.js area chart and polishes the existing stat cards and table.

**Tech Stack:** Laravel, PHP 8.4+, Tailwind CSS v4, Vite, Alpine.js, Chart.js.

---

### Task 1: Install Chart.js

**Files:**
- Modify: `package.json`
- Modify: `package-lock.json` (via npm install)

- [ ] **Step 1: Install the dependency**

```bash
npm install chart.js
```

- [ ] **Step 2: Verify package.json contains chart.js**

Run: `cat package.json | grep chart.js`
Expected: a line like `"chart.js": "^4.x.x"` in `dependencies`.

---

### Task 2: Import Chart.js

**Files:**
- Modify: `resources/js/app.js`

- [ ] **Step 1: Update app.js to import Chart.js alongside Alpine.js**

```javascript
import Alpine from 'alpinejs';
import Chart from 'chart.js/auto';

window.Alpine = Alpine;
window.Chart = Chart;

Alpine.start();
```

---

### Task 3: Update DashboardController

**Files:**
- Modify: `app/Http/Controllers/Admin/DashboardController.php`

- [ ] **Step 1: Replace the controller body**

```php
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
            'chartLabels',
            'chartData'
        ));
    }
}
```

---

### Task 4: Modernize Dashboard View and Add Chart

**Files:**
- Modify: `resources/views/admin/dashboard.blade.php`

- [ ] **Step 1: Replace the view content**

```blade
<x-layouts.admin>
  <x-slot:title>Dashboard</x-slot:title>

  <div class="mb-6">
    <h1 class="text-2xl font-black text-gray-900">Dashboard</h1>
    <p class="text-sm text-gray-500 mt-1">Welcome back, {{ auth('admin')->user()->name }}</p>
  </div>

  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
      <div class="flex items-center justify-between mb-2">
        <span class="text-sm font-medium text-gray-500">Total Submissions</span>
        <span class="bg-red-100 text-red-600 p-2 rounded-lg">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
        </span>
      </div>
      <p class="text-3xl font-black text-gray-900">{{ $totalSubmissions ?? 0 }}</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
      <div class="flex items-center justify-between mb-2">
        <span class="text-sm font-medium text-gray-500">Total Users</span>
        <span class="bg-blue-100 text-blue-600 p-2 rounded-lg">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        </span>
      </div>
      <p class="text-3xl font-black text-gray-900">{{ $totalUsers ?? 0 }}</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
      <div class="flex items-center justify-between mb-2">
        <span class="text-sm font-medium text-gray-500">New Today</span>
        <span class="bg-green-100 text-green-600 p-2 rounded-lg">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
        </span>
      </div>
      <p class="text-3xl font-black text-gray-900">{{ $todaySubmissions ?? 0 }}</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
      <div class="flex items-center justify-between mb-2">
        <span class="text-sm font-medium text-gray-500">Conversion</span>
        <span class="bg-purple-100 text-purple-600 p-2 rounded-lg">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="20" x2="12" y2="10"/><line x1="18" y1="20" x2="18" y2="4"/><line x1="6" y1="20" x2="6" y2="16"/></svg>
        </span>
      </div>
      <p class="text-3xl font-black text-gray-900">{{ $conversionRate ?? '0%' }}</p>
    </div>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 lg:col-span-2">
      <h2 class="text-lg font-bold text-gray-900 mb-4">Submissions (Last 7 Days)</h2>
      <div x-data="{
        labels: {{ json_encode($chartLabels) }},
        data: {{ json_encode($chartData) }},
        init() {
          const ctx = this.$refs.chartCanvas.getContext('2d');
          new Chart(ctx, {
            type: 'line',
            data: {
              labels: this.labels,
              datasets: [{
                label: 'Submissions',
                data: this.data,
                borderColor: '#dc2626',
                backgroundColor: 'rgba(220, 38, 38, 0.1)',
                borderWidth: 2,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#dc2626',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6,
              }]
            },
            options: {
              responsive: true,
              maintainAspectRatio: false,
              plugins: {
                legend: { display: false },
                tooltip: {
                  backgroundColor: '#1f2937',
                  padding: 10,
                  cornerRadius: 8,
                }
              },
              scales: {
                y: {
                  beginAtZero: true,
                  grid: { color: '#f3f4f6' },
                  ticks: { color: '#6b7280', precision: 0 }
                },
                x: {
                  grid: { display: false },
                  ticks: { color: '#6b7280' }
                }
              }
            }
          });
        }
      }" class="h-80">
        <canvas x-ref="chartCanvas"></canvas>
      </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
      <h2 class="text-lg font-bold text-gray-900 mb-4">Quick Stats</h2>
      <div class="space-y-4">
        <div class="flex items-center justify-between">
          <span class="text-sm text-gray-600">Daily average</span>
          <span class="text-sm font-semibold text-gray-900">
            {{ round(array_sum($chartData) / max(count($chartData), 1), 1) }}
          </span>
        </div>
        <div class="flex items-center justify-between">
          <span class="text-sm text-gray-600">Best day</span>
          <span class="text-sm font-semibold text-gray-900">
            {{ max($chartData) }}
          </span>
        </div>
        <div class="flex items-center justify-between">
          <span class="text-sm text-gray-600">Total (7 days)</span>
          <span class="text-sm font-semibold text-gray-900">
            {{ array_sum($chartData) }}
          </span>
        </div>
      </div>
    </div>
  </div>

  <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
    <h2 class="text-lg font-bold text-gray-900 mb-4">Recent Giveaway Submissions</h2>
    <div class="overflow-x-auto">
      <table class="w-full text-sm">
        <thead>
          <tr class="border-b border-gray-200 text-left">
            <th class="pb-3 font-semibold text-gray-600">Name</th>
            <th class="pb-3 font-semibold text-gray-600">Email</th>
            <th class="pb-3 font-semibold text-gray-600">Car</th>
            <th class="pb-3 font-semibold text-gray-600">Date</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($recentSubmissions ?? [] as $submission)
            <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
              <td class="py-3 text-gray-900">{{ $submission->name }}</td>
              <td class="py-3 text-gray-600">{{ $submission->email }}</td>
              <td class="py-3 text-gray-600">{{ $submission->car }}</td>
              <td class="py-3 text-gray-500">{{ $submission->created_at->format('M d, Y') }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="4" class="py-8 text-center text-gray-400">No submissions yet.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</x-layouts.admin>
```

---

### Task 5: Verify

- [ ] **Step 1: Run PHP syntax check**

```bash
php -l app/Http/Controllers/Admin/DashboardController.php
```

Expected: "No syntax errors detected."

- [ ] **Step 2: Attempt npm build**

```bash
npm run build
```

Expected: build completes (may require reinstalling node_modules on the platform where build is run).

- [ ] **Step 3: Manual browser check**

Visit `/admin/dashboard`, log in as an admin, and verify:
- Stat cards have hover effect and cleaner layout.
- Chart renders with 7 days of data.
- Quick stats sidebar shows correct values.
- Recent submissions table is styled and hoverable.

---

## Self-Review Checklist

1. **Spec coverage:**
   - 7-day chart using Chart.js → Task 4.
   - Modernized stat cards → Task 4.
   - Quick stats sidebar → Task 4.
   - Polished table → Task 4.
   - Backend data computation → Task 3.
   - Chart.js dependency → Tasks 1 and 2.

2. **Placeholder scan:**
   - No TBD or TODO items.
   - All code blocks are complete.

3. **Type consistency:**
   - `chartLabels` and `chartData` passed from controller match the Alpine.js chart init.
