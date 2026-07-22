# Admin Cars Page — Modal Save, Image Upload, and Add Car Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Fix the admin cars page so modal edits save reliably, images can be changed, and new cars can be added.

**Architecture:** Extend the existing bulk-update pattern with one new `store` route. The bulk-update form gains file-upload support and a hidden modal identifier; the controller stores uploaded car images and deletes replaced ones. A new "Add Car" modal posts to the `store` route.

**Tech Stack:** Laravel, Blade, Alpine.js, PHPUnit, Laravel Storage (public disk).

---

### Task 1: Add the create-car route

**Files:**
- Modify: `routes/web.php`

- [ ] **Step 1: Add POST route for new cars**

Insert inside the `Route::middleware('admin')->prefix('admin')->group(...)` block, immediately after the bulk-update route:

```php
Route::post('/cars', [CarController::class, 'store'])->name('admin.cars.store');
```

- [ ] **Step 2: Verify route list**

Run:
```bash
php artisan route:list --name=admin.cars
```

Expected output includes:
```
GET|HEAD  admin/cars .......... admin.cars.index
PUT       admin/cars/bulk-update .. admin.cars.bulk-update
POST      admin/cars ............ admin.cars.store
```

---

### Task 2: Add a Car factory for tests

**Files:**
- Create: `database/factories/CarFactory.php`

- [ ] **Step 1: Create the factory**

```php
<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CarFactory extends Factory
{
    protected $model = \App\Models\Car::class;

    public function definition(): array
    {
        return [
            'key' => $this->faker->unique()->slug(2),
            'name' => $this->faker->words(2, true),
            'desc' => $this->faker->sentence(),
            'fee' => '$' . $this->faker->numberBetween(100, 999),
            'image' => null,
            'category' => $this->faker->word(),
            'badge' => $this->faker->word(),
            'power' => $this->faker->sentence(),
            'range' => $this->faker->sentence(),
            'delivery' => $this->faker->sentence(),
            'gradient' => 'from-gray-900 to-gray-800',
            'sort_order' => $this->faker->numberBetween(0, 100),
            'is_active' => true,
        ];
    }
}
```

- [ ] **Step 2: Run factory smoke test**

Run:
```bash
php artisan tinker --execute="echo \App\Models\Car::factory()->make()->name;"
```

Expected: a generated car name is printed with no errors.

---

### Task 3: Write CarController tests

**Files:**
- Create: `tests/Feature/Admin/CarControllerTest.php`

- [ ] **Step 1: Create test file**

```php
<?php

namespace Tests\Feature\Admin;

use App\Models\Admin;
use App\Models\Car;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CarControllerTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): Admin
    {
        return Admin::factory()->create();
    }

    public function test_guests_cannot_access_car_routes(): void
    {
        $this->get(route('admin.cars.index'))->assertForbidden();
        $this->put(route('admin.cars.bulk-update'))->assertForbidden();
        $this->post(route('admin.cars.store'))->assertForbidden();
    }

    public function test_index_displays_cars(): void
    {
        $car = Car::factory()->create();

        $response = $this->actingAs($this->admin(), 'admin')
            ->get(route('admin.cars.index'));

        $response->assertOk();
        $response->assertSee($car->name);
    }

    public function test_bulk_update_updates_car_fields(): void
    {
        $car = Car::factory()->create(['name' => 'Old Name']);

        $response = $this->actingAs($this->admin(), 'admin')
            ->put(route('admin.cars.bulk-update'), [
                'cars' => [
                    $car->id => [
                        'id' => $car->id,
                        'name' => 'New Name',
                        'fee' => '$499',
                        'desc' => 'Updated desc',
                        'category' => 'Sedan',
                        'badge' => 'Hot',
                        'power' => '600 hp',
                        'range' => '400 mi',
                        'delivery' => '3 days',
                        'gradient' => 'from-black to-white',
                        'sort_order' => 5,
                        'is_active' => '1',
                    ],
                ],
            ]);

        $response->assertRedirect(route('admin.cars.index'));
        $response->assertSessionHas('success');

        $car->refresh();
        $this->assertEquals('New Name', $car->name);
        $this->assertEquals('$499', $car->fee);
        $this->assertEquals(5, $car->sort_order);
        $this->assertTrue($car->is_active);
    }

    public function test_bulk_update_stores_uploaded_image_and_deletes_old(): void
    {
        Storage::fake('public');

        $oldFile = UploadedFile::fake()->image('old.png');
        $oldPath = $oldFile->store('cars', 'public');

        $car = Car::factory()->create(['image' => $oldPath]);
        $newFile = UploadedFile::fake()->image('new.png');

        $this->actingAs($this->admin(), 'admin')
            ->put(route('admin.cars.bulk-update'), [
                'cars' => [
                    $car->id => [
                        'id' => $car->id,
                        'name' => $car->name,
                        'fee' => $car->fee,
                        'sort_order' => $car->sort_order,
                        'is_active' => '1',
                        'image' => $newFile,
                    ],
                ],
            ]);

        $car->refresh();
        Storage::disk('public')->assertExists($car->image);
        Storage::disk('public')->assertMissing($oldPath);
    }

    public function test_store_creates_car_with_image(): void
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->image('tesla.png');

        $response = $this->actingAs($this->admin(), 'admin')
            ->post(route('admin.cars.store'), [
                'key' => 'tesla-model-3',
                'name' => 'Tesla Model 3',
                'fee' => '$299',
                'desc' => 'Electric sedan',
                'category' => 'Sedan',
                'badge' => 'Popular',
                'power' => '510 hp',
                'range' => '358 mi',
                'delivery' => '7–10 days',
                'gradient' => 'from-gray-900 to-gray-800',
                'sort_order' => 1,
                'image' => $file,
            ]);

        $response->assertRedirect(route('admin.cars.index'));
        $response->assertSessionHas('success');

        $car = Car::where('key', 'tesla-model-3')->first();
        $this->assertNotNull($car);
        $this->assertEquals('Tesla Model 3', $car->name);
        Storage::disk('public')->assertExists($car->image);
    }

    public function test_store_validates_required_fields(): void
    {
        $response = $this->actingAs($this->admin(), 'admin')
            ->post(route('admin.cars.store'), []);

        $response->assertSessionHasErrors(['key', 'name', 'fee', 'sort_order']);
    }
}
```

- [ ] **Step 2: Run the new tests and confirm they fail**

Run:
```bash
php artisan test tests/Feature/Admin/CarControllerTest.php
```

Expected: failures because the `store` route and image logic do not yet exist.

---

### Task 4: Implement backend changes in CarController

**Files:**
- Modify: `app/Http/Controllers/Admin/CarController.php`

- [ ] **Step 1: Add imports**

At the top of the file, add:

```php
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
```

- [ ] **Step 2: Update bulkUpdate to handle images**

Replace the current `bulkUpdate` body with:

```php
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
```

- [ ] **Step 3: Add store method**

Add after `bulkUpdate`:

```php
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
```

- [ ] **Step 4: Run CarController tests**

Run:
```bash
php artisan test tests/Feature/Admin/CarControllerTest.php
```

Expected: all tests pass.

---

### Task 5: Update the cars index view

**Files:**
- Modify: `resources/views/admin/cars/index.blade.php`

- [ ] **Step 1: Add multipart encoding and modal state to the bulk form**

Change the opening form tag from:

```blade
<form id="cars-form" method="POST" action="{{ route('admin.cars.bulk-update') }}" x-data="{ editing: '{{ old('editing', '') }}' }">
```

to:

```blade
<form id="cars-form" method="POST" action="{{ route('admin.cars.bulk-update') }}" enctype="multipart/form-data" x-data="{ editing: '{{ old('editing', '') }}' }">
```

Immediately after `@method('PUT')`, add:

```blade
<input type="hidden" name="editing" :value="editing">
```

- [ ] **Step 2: Add the "Add New Car" button**

After the `<p class="text-sm text-gray-500 mb-6">…</p>` line and before the bulk form, add:

```blade
<div class="mb-4 flex justify-end">
  <button type="button" @click="editing = 'new'" class="bg-red-600 hover:bg-red-700 text-white font-semibold px-5 py-2.5 text-sm transition-colors">
    Add New Car
  </button>
</div>
```

- [ ] **Step 3: Add image upload field to each edit modal**

Inside each edit modal, after the Sort Order block and before the action buttons, add:

```blade
<div>
  <label class="block text-sm font-medium text-gray-700 mb-1">Image</label>
  @if($car->image)
    <div class="mb-2 flex items-center gap-3">
      <img src="{{ asset('storage/' . $car->image) }}" alt="{{ $car->name }}" class="h-16 w-16 object-contain border border-gray-200 rounded">
      <span class="text-xs text-gray-500">Current image</span>
    </div>
  @endif
  <input type="file" name="cars[{{ $car->id }}][image]" accept="image/png,image/jpg,image/jpeg,image/svg+xml,image/webp" class="w-full border border-gray-300 px-4 py-2.5 text-sm file:mr-4 file:py-2 file:px-4 file:border-0 file:rounded-none file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 transition-colors">
  @error('cars.' . $car->id . '.image')
    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
  @enderror
</div>
```

- [ ] **Step 4: Add the create-car modal**

After the `@endforeach` closing the cars loop and before the bottom Save Changes button, add:

```blade
<template x-teleport="body">
  <div
    x-show="editing === 'new'"
    x-cloak
    class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/40 backdrop-blur-md"
    style="background-color: rgba(0,0,0,0.4); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px);"
  >
    <div class="bg-white shadow-xl w-full max-w-lg p-6" @click.away="editing = ''">
      <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-bold text-gray-900">Add New Car</h3>
        <button type="button" @click="editing = ''" class="text-gray-400 hover:text-gray-600">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>
        </button>
      </div>

      <form method="POST" action="{{ route('admin.cars.store') }}" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Key</label>
            <input type="text" name="key" value="{{ old('key') }}" class="w-full border border-gray-300 px-4 py-2.5 text-sm focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition-colors">
            @error('key')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Car Name</label>
            <input type="text" name="name" value="{{ old('name') }}" class="w-full border border-gray-300 px-4 py-2.5 text-sm focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition-colors">
            @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
          </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Fee</label>
            <input type="text" name="fee" value="{{ old('fee') }}" class="w-full border border-gray-300 px-4 py-2.5 text-sm focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition-colors">
            @error('fee')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Sort Order</label>
            <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0" class="w-full border border-gray-300 px-4 py-2.5 text-sm focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition-colors">
            @error('sort_order')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
          </div>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
          <input type="text" name="desc" value="{{ old('desc') }}" class="w-full border border-gray-300 px-4 py-2.5 text-sm focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition-colors">
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
            <input type="text" name="category" value="{{ old('category') }}" class="w-full border border-gray-300 px-4 py-2.5 text-sm focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition-colors">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Badge</label>
            <input type="text" name="badge" value="{{ old('badge') }}" class="w-full border border-gray-300 px-4 py-2.5 text-sm focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition-colors">
          </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Power</label>
            <input type="text" name="power" value="{{ old('power') }}" class="w-full border border-gray-300 px-4 py-2.5 text-sm focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition-colors">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Range</label>
            <input type="text" name="range" value="{{ old('range') }}" class="w-full border border-gray-300 px-4 py-2.5 text-sm focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition-colors">
          </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Delivery</label>
            <input type="text" name="delivery" value="{{ old('delivery') }}" class="w-full border border-gray-300 px-4 py-2.5 text-sm focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition-colors">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Gradient Class</label>
            <input type="text" name="gradient" value="{{ old('gradient') }}" class="w-full border border-gray-300 px-4 py-2.5 text-sm focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition-colors">
          </div>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Image</label>
          <input type="file" name="image" accept="image/png,image/jpg,image/jpeg,image/svg+xml,image/webp" class="w-full border border-gray-300 px-4 py-2.5 text-sm file:mr-4 file:py-2 file:px-4 file:border-0 file:rounded-none file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 transition-colors">
          @error('image')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div class="mt-6 flex justify-end gap-3">
          <button type="button" @click="editing = ''" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-5 py-2.5 text-sm transition-colors">Cancel</button>
          <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-semibold px-6 py-2.5 text-sm transition-colors">Create Car</button>
        </div>
      </form>
    </div>
  </div>
</template>
```

- [ ] **Step 5: Update existing image preview in list**

The list already shows `asset($car->image)`. Because uploaded images are stored under the public disk with paths like `cars/filename.png`, change that line to:

```blade
<img src="{{ $car->image ? asset('storage/' . $car->image) : asset('img/placeholder-car.png') }}" alt="{{ $car->name }}" class="w-full h-full object-contain">
```

If `public/img/placeholder-car.png` does not exist, use a transparent 1x1 pixel or omit the fallback by keeping `asset($car->image)` only when `$car->image` is set. For this implementation, wrap the existing `<img>` in an `@if($car->image)` check or use the `storage/` prefix as shown above.

---

### Task 6: Verify in browser and run full test suite

**Files:**
- All of the above

- [ ] **Step 1: Run the full test suite**

```bash
php artisan test
```

Expected: all tests pass.

- [ ] **Step 2: Ensure the storage link exists**

Run:
```bash
php artisan storage:link
```

Expected: `The [public/storage] link already exists.` or `The [public/storage] link has been connected to [storage/app/public].`.

- [ ] **Step 3: Manual browser check (local)**

1. Log in to `/admin/login`.
2. Visit `/admin/cars`.
3. Click "Add New Car", fill the form, upload an image, and submit. Confirm the car appears in the list with the image.
4. Click the pencil icon on a car, change a field, upload a new image, and click "Save Changes". Confirm the update persists and the image changes.
5. Toggle a car off with the switch and click the bottom "Save Changes". Confirm the toggle persists after reload.

---

## Spec Coverage Check

| Spec Requirement | Task |
|---|---|
| Modal edits persist reliably | Task 4 (bulkUpdate), Task 5 (editing hidden input + enctype) |
| Images can be changed | Task 4 (image upload handling), Task 5 (image input in modal) |
| New cars can be added | Task 1 (route), Task 4 (store), Task 5 (create modal + button) |
| Validation errors reopen modal | Task 5 (editing hidden input) |
| Existing patterns followed | All tasks (uses public disk storage, admin middleware, existing styling) |

## Placeholder Scan

- No "TBD", "TODO", or "implement later" items.
- Every code block contains concrete code.
- Every test assertion is explicit.
