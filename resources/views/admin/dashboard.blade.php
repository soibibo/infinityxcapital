<x-layouts.admin>
  <x-slot:title>Dashboard</x-slot:title>

  <div class="mb-6">
    <h1 class="text-2xl font-black text-gray-900">Dashboard</h1>
    <p class="text-sm text-gray-500 mt-1">Welcome back, {{ auth('admin')->user()->name }}</p>
  </div>

  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
      <div class="flex items-center justify-between mb-2">
        <span class="text-sm font-medium text-gray-500">Total Submissions</span>
        <span class="bg-red-100 text-red-600 p-2">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
        </span>
      </div>
      <p class="text-3xl font-black text-gray-900">{{ $totalSubmissions ?? 0 }}</p>
    </div>

    <div class="bg-white shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
      <div class="flex items-center justify-between mb-2">
        <span class="text-sm font-medium text-gray-500">Total Users</span>
        <span class="bg-blue-100 text-blue-600 p-2">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        </span>
      </div>
      <p class="text-3xl font-black text-gray-900">{{ $totalUsers ?? 0 }}</p>
    </div>

    <div class="bg-white shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
      <div class="flex items-center justify-between mb-2">
        <span class="text-sm font-medium text-gray-500">New Today</span>
        <span class="bg-green-100 text-green-600 p-2">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
        </span>
      </div>
      <p class="text-3xl font-black text-gray-900">{{ $todaySubmissions ?? 0 }}</p>
    </div>

    <div class="bg-white shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
      <div class="flex items-center justify-between mb-2">
        <span class="text-sm font-medium text-gray-500">Conversion</span>
        <span class="bg-purple-100 text-purple-600 p-2">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="20" x2="12" y2="10"/><line x1="18" y1="20" x2="18" y2="4"/><line x1="6" y1="20" x2="6" y2="16"/></svg>
        </span>
      </div>
      <p class="text-3xl font-black text-gray-900">{{ $conversionRate ?? '0%' }}</p>
    </div>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <div class="bg-white shadow-sm border border-gray-200 p-6 lg:col-span-2">
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
                  cornerRadius: 0,
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

    <div class="bg-white shadow-sm border border-gray-200 p-6">
      <h2 class="text-lg font-bold text-gray-900 mb-4">Top Country Statistics</h2>
      @if (count($countryData) > 0)
        <div x-data="{
          labels: {{ json_encode($countryLabels) }},
          data: {{ json_encode($countryData) }},
          colors: ['#5b4cdb', '#2a9d8f', '#e8487a', '#6b7c4a', '#f08050'],
          init() {
            const ctx = this.$refs.countryChart.getContext('2d');
            new Chart(ctx, {
              type: 'doughnut',
              data: {
                labels: this.labels,
                datasets: [{
                  data: this.data,
                  backgroundColor: this.colors,
                  borderWidth: 0,
                  borderRadius: 8,
                  spacing: 4,
                  hoverOffset: 4,
                }]
              },
              options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '65%',
                plugins: {
                  legend: {
                    position: 'top',
                    labels: {
                      usePointStyle: true,
                      pointStyle: 'rect',
                      padding: 12,
                      color: '#4b5563',
                      font: { size: 12 }
                    }
                  },
                  tooltip: {
                    backgroundColor: '#1f2937',
                    padding: 10,
                    cornerRadius: 0,
                  }
                }
              }
            });
          }
        }" class="h-64">
          <canvas x-ref="countryChart"></canvas>
        </div>
      @else
        <p class="text-sm text-gray-500 text-center py-8">No country data available.</p>
      @endif
    </div>
  </div>

  <div class="bg-white shadow-sm border border-gray-200 p-6">
    <div class="flex items-center gap-3 mb-5">
      <div class="bg-red-100 text-red-600 p-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
      </div>
      <h2 class="text-lg font-bold text-gray-900">Recent Giveaway Submissions</h2>
    </div>
    <div class="overflow-x-auto">
      <table class="w-full text-sm">
        <thead>
          <tr class="bg-gray-50 text-left">
            <th class="px-4 py-3 font-semibold text-gray-600">Name</th>
            <th class="px-4 py-3 font-semibold text-gray-600">Email</th>
            <th class="px-4 py-3 font-semibold text-gray-600">Car</th>
            <th class="px-4 py-3 font-semibold text-gray-600">Date</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($recentSubmissions ?? [] as $submission)
            <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
              <td class="px-4 py-3 text-gray-900">
                <div class="flex items-center gap-3">
                  <div class="w-8 h-8 bg-gray-100 text-gray-600 flex items-center justify-center text-xs font-bold">
                    {{ strtoupper(substr($submission->full_name, 0, 1)) }}
                  </div>
                  {{ $submission->full_name }}
                </div>
              </td>
              <td class="px-4 py-3 text-gray-600">{{ $submission->email }}</td>
              <td class="px-4 py-3 text-gray-600">{{ $submission->car_name }}</td>
              <td class="px-4 py-3 text-gray-500">{{ $submission->created_at->format('M d, Y') }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="4" class="px-4 py-8 text-center text-gray-400">No submissions yet.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</x-layouts.admin>
