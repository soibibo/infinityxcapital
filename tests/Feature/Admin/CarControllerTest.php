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

    public function test_destroy_deletes_car_and_image(): void
    {
        Storage::fake('public');
        $path = UploadedFile::fake()->image('car.png')->store('cars', 'public');
        $car = Car::factory()->create(['image' => $path]);

        $this->actingAs($this->admin(), 'admin')
            ->delete(route('admin.cars.destroy', $car))
            ->assertRedirect(route('admin.cars.index'))
            ->assertSessionHas('success');

        $this->assertNull(Car::find($car->id));
        Storage::disk('public')->assertMissing($path);
    }

    public function test_guests_cannot_delete_cars(): void
    {
        $car = Car::factory()->create();

        $this->delete(route('admin.cars.destroy', $car))->assertForbidden();
    }
}
