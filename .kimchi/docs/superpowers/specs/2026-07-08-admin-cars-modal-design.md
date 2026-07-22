# Admin Cars Page — Modal Save, Image Upload, and Add Car Design

## Goal
Fix the admin cars page at `/admin/cars` so that:
1. Editing a car in the modal persists changes reliably.
2. An admin can replace a car’s image.
3. An admin can add a new car.

## Current State
- `resources/views/admin/cars/index.blade.php` renders a list of cars with an inline bulk-update form and an Alpine.js-driven edit modal per car.
- `App\Http\Controllers\Admin\CarController` exposes only `index()` and `bulkUpdate()`.
- `routes/web.php` registers only `GET /admin/cars` and `PUT /admin/cars/bulk-update`.
- The modal form fields already submit through the bulk-update form, but:
  - The controller does not validate or store `image`.
  - There is no image file input in the modal.
  - There is no route or UI for creating a new car.

## Proposed Approach: Extend Existing Bulk-Update Pattern (Option A)
Keep the current bulk-update UI and add a single create flow. This minimizes changes and matches the existing codebase style.

### Backend Changes

#### `routes/web.php`
Add one new route inside the `admin` middleware group:
```php
Route::post('/cars', [CarController::class, 'store'])->name('admin.cars.store');
```

#### `App\Http\Controllers\Admin\CarController`
1. **Update `bulkUpdate()`** to:
   - Add `cars.*.image` validation as a nullable image file.
   - For each car, if an uploaded image is present, delete the old image from `public` storage and store the new one under `cars/`.
   - Fall back to the existing image path when no new file is uploaded.
   - Preserve the modal state on validation failure by redirecting back with the submitted `editing` value.

2. **Add `store(Request $request)`** to:
   - Validate required fields for a new car (`key`, `name`, `fee`, `sort_order`) plus optional fields and image.
   - Generate a URL-safe `key` if needed, or require the admin to provide one.
   - Store the uploaded image under `cars/`.
   - Create the `Car` record and redirect to the index with a success message.

### Frontend Changes

#### `resources/views/admin/cars/index.blade.php`
1. **Add hidden `editing` input** to the bulk-update form so validation errors can reopen the correct edit modal.
2. **Add image upload field** inside each edit modal:
   - Current image preview.
   - File input labeled “Replace Image”.
3. **Add “Add New Car” button** at the top of the page that opens a separate create modal.
4. **Add create modal** with a form posting to `admin.cars.store`, containing all required fields plus image upload.
5. **Ensure the bulk-update form uses `enctype="multipart/form-data"`** so file inputs submit correctly.

### File Storage
- Use `Storage::disk('public')`.
- Store car images in `storage/app/public/cars/`.
- Save the relative path (`cars/filename.ext`) in the `image` column.
- Old images are deleted only when a replacement is uploaded.

### Validation Rules
- Existing bulk-update rules remain, plus `cars.*.image` nullable image (`mimes:png,jpg,jpeg,svg,webp`, max 2048 KB).
- Create rules: `key` required/unique/string/max 20, `name` required/string/max 255, `fee` required/string/max 20, `sort_order` required/integer/min 0, plus optional fields matching the car schema, and `image` nullable image.

### Error Handling
- Validation failures redirect back to `/admin/cars` and reopen the modal that was being edited (via the `editing` value).
- Success flashes the existing session message style.

## Out of Scope
- Deleting cars.
- Cropping or resizing images.
- AJAX modal saves.
- Changing the public car display on the home page.
