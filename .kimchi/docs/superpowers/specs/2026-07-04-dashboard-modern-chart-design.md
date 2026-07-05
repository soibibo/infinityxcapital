# Dashboard Modernization + Chart Design

## Goal
Modernize the admin dashboard appearance and add a 7-day submissions trend chart using Chart.js and Alpine.js.

## Context
The current dashboard shows four stat cards and a recent submissions table. It is functional but static and lacks trend visualization.

## Proposed Approach: Alpine.js + Chart.js Component
Use the existing Alpine.js setup to initialize a Chart.js area chart from server-computed data. Keep the implementation lightweight and styled with the existing Tailwind CSS theme.

## Data Model
No database schema changes. The `GiveawaySubmission` model already tracks `created_at`.

## Backend Changes

### `app/Http/Controllers/Admin/DashboardController.php`
- Compute the last 7 calendar days as labels.
- Count submissions per day.
- Pass `chartLabels` and `chartData` to the view.

## Frontend Changes

### `resources/views/admin/dashboard.blade.php`
- Add subtle hover lift and cleaner icon styling to the four stat cards.
- Add a new chart card titled "Submissions (Last 7 Days)" containing a `<canvas>`.
- Use Alpine.js to initialize Chart.js with server-provided labels and data.
- Polish the recent submissions table headers and row styling.

### JavaScript
- Install `chart.js` via npm.
- Import Chart.js in `resources/js/app.js` so it is available for Alpine-driven components.

## Files Changed
- `app/Http/Controllers/Admin/DashboardController.php`
- `resources/views/admin/dashboard.blade.php`
- `resources/js/app.js`
- `package.json`

## Validation
- Dashboard loads without JS errors.
- Chart renders with 7 data points and labels.
- Stat cards and table still display correctly.
- Responsive layout works on mobile and desktop.
