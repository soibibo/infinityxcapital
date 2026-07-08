<x-layouts.admin>
  <x-slot:title>Cars</x-slot:title>

  <div class="mb-6">
    <h1 class="text-2xl font-black text-gray-900">Available Cars</h1>
    <p class="text-sm text-gray-500 mt-1">Manage car models, delivery fees, and visibility.</p>
  </div>

  @if(session('success'))
    <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 text-sm font-semibold">
      {{ session('success') }}
    </div>
  @endif

  <div class="bg-white shadow-sm border border-gray-200 p-6">
    <h2 class="text-lg font-bold text-gray-900 mb-1">Car Inventory</h2>
    <p class="text-sm text-gray-500 mb-6">Edit car details and toggle availability for users.</p>

    <div class="mb-4 flex justify-end">
      <button type="button" @click="editing = 'new'" class="bg-red-600 hover:bg-red-700 text-white font-semibold px-5 py-2.5 text-sm transition-colors">
        Add New Car
      </button>
    </div>

    <form id="cars-form" method="POST" action="{{ route('admin.cars.bulk-update') }}" enctype="multipart/form-data" x-data="{ editing: '{{ old('editing', '') }}' }">
      @csrf
      @method('PUT')
      <input type="hidden" name="editing" :value="editing">

      <div class="space-y-4">
        @foreach($cars as $car)
          <div class="border border-gray-200" x-data="{ active: {{ old('cars.' . $car->id . '.is_active', $car->is_active ? 'true' : 'false') }} }">
            <div class="p-4 flex items-center gap-4">
              <div class="w-12 h-12 rounded-lg bg-gray-100 flex items-center justify-center p-1.5 shrink-0">
                @if($car->image)
                  <img src="{{ asset('storage/' . $car->image) }}" alt="{{ $car->name }}" class="w-full h-full object-contain">
                @endif
              </div>
              <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2">
                  <h3 class="font-bold text-gray-900 truncate">{{ $car->name }}</h3>
                  <span class="text-[10px] font-bold bg-gray-900 text-white px-1.5 py-0.5 shrink-0">{{ strtoupper($car->key) }}</span>
                </div>
                <p class="text-xs text-gray-500 truncate">{{ $car->category ?: 'No category' }} · Fee: {{ $car->fee }}</p>
              </div>
              <div class="flex items-center gap-3">
                <button
                  type="button"
                  @click="active = !active"
                  :class="active ? 'bg-red-600' : 'bg-gray-200'"
                  class="relative inline-flex h-7 w-12 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 shrink-0"
                >
                  <span class="sr-only">Toggle active</span>
                  <span
                    :class="active ? 'translate-x-6' : 'translate-x-1'"
                    class="inline-block h-5 w-5 transform rounded-full bg-white shadow transition-transform"
                  ></span>
                </button>
                <span class="text-sm font-medium text-gray-700 min-w-[55px]" x-text="active ? 'Active' : 'Inactive'"></span>

                <button type="button" @click="editing = editing === '{{ $car->id }}' ? '' : '{{ $car->id }}'" class="bg-gray-100 hover:bg-gray-200 text-gray-500 hover:text-gray-700 p-1.5 transition-colors">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9M16.5 3.5a2.121 2.121 0 1 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                </button>
              </div>
            </div>

            <input type="hidden" name="cars[{{ $car->id }}][is_active]" :value="active ? '1' : '0'">
            <input type="hidden" name="cars[{{ $car->id }}][id]" value="{{ $car->id }}">

            <template x-teleport="body">
              <div
                x-show="editing === '{{ $car->id }}'"
                x-cloak
                class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/40 backdrop-blur-md"
                style="background-color: rgba(0,0,0,0.4); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px);"
              >
                <div class="bg-white shadow-xl w-full max-w-lg p-6" @click.away="editing = ''">
                  <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-gray-900">Edit {{ $car->name }}</h3>
                    <button type="button" @click="editing = ''" class="text-gray-400 hover:text-gray-600">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>
                    </button>
                  </div>

                  <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                      <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Car Name</label>
                        <input type="text" name="cars[{{ $car->id }}][name]" value="{{ old('cars.' . $car->id . '.name', $car->name) }}" class="w-full border border-gray-300 px-4 py-2.5 text-sm focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition-colors">
                        @error('cars.' . $car->id . '.name')
                          <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                      </div>
                      <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Fee</label>
                        <input type="text" name="cars[{{ $car->id }}][fee]" value="{{ old('cars.' . $car->id . '.fee', $car->fee) }}" class="w-full border border-gray-300 px-4 py-2.5 text-sm focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition-colors">
                        @error('cars.' . $car->id . '.fee')
                          <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                      </div>
                    </div>

                    <div>
                      <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                      <input type="text" name="cars[{{ $car->id }}][desc]" value="{{ old('cars.' . $car->id . '.desc', $car->desc) }}" class="w-full border border-gray-300 px-4 py-2.5 text-sm focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition-colors">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                      <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                        <input type="text" name="cars[{{ $car->id }}][category]" value="{{ old('cars.' . $car->id . '.category', $car->category) }}" class="w-full border border-gray-300 px-4 py-2.5 text-sm focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition-colors">
                      </div>
                      <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Badge</label>
                        <input type="text" name="cars[{{ $car->id }}][badge]" value="{{ old('cars.' . $car->id . '.badge', $car->badge) }}" class="w-full border border-gray-300 px-4 py-2.5 text-sm focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition-colors">
                      </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                      <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Power</label>
                        <input type="text" name="cars[{{ $car->id }}][power]" value="{{ old('cars.' . $car->id . '.power', $car->power) }}" class="w-full border border-gray-300 px-4 py-2.5 text-sm focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition-colors">
                      </div>
                      <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Range</label>
                        <input type="text" name="cars[{{ $car->id }}][range]" value="{{ old('cars.' . $car->id . '.range', $car->range) }}" class="w-full border border-gray-300 px-4 py-2.5 text-sm focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition-colors">
                      </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                      <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Delivery</label>
                        <input type="text" name="cars[{{ $car->id }}][delivery]" value="{{ old('cars.' . $car->id . '.delivery', $car->delivery) }}" class="w-full border border-gray-300 px-4 py-2.5 text-sm focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition-colors">
                      </div>
                      <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Gradient Class</label>
                        <input type="text" name="cars[{{ $car->id }}][gradient]" value="{{ old('cars.' . $car->id . '.gradient', $car->gradient) }}" class="w-full border border-gray-300 px-4 py-2.5 text-sm focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition-colors">
                      </div>
                    </div>

                    <div>
                      <label class="block text-sm font-medium text-gray-700 mb-1">Sort Order</label>
                      <input type="number" name="cars[{{ $car->id }}][sort_order]" value="{{ old('cars.' . $car->id . '.sort_order', $car->sort_order) }}" min="0" class="w-full border border-gray-300 px-4 py-2.5 text-sm focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition-colors">
                    </div>

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
                  </div>

                  <div class="mt-6 flex justify-end gap-3">
                    <button type="button" @click="editing = ''" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-5 py-2.5 text-sm transition-colors">Cancel</button>
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-semibold px-6 py-2.5 text-sm transition-colors">Save Changes</button>
                  </div>
                </div>
              </div>
            </template>
          </div>
        @endforeach
      </div>

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

      <div class="mt-6 flex justify-end">
        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-semibold px-6 py-2.5 text-sm transition-colors">
          Save Changes
        </button>
      </div>
    </form>
  </div>
</x-layouts.admin>
