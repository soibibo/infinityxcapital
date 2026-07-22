<x-layouts.admin>
  <x-slot:title>Gift Card Types</x-slot:title>

  <div class="mb-6 flex items-center justify-between">
    <div>
      <h1 class="text-2xl font-black text-gray-900">Gift Card Types</h1>
      <p class="text-sm text-gray-500 mt-1">Manage gift card types users can pay with.</p>
    </div>
    <button type="button" onclick="document.getElementById('create-modal').classList.remove('hidden')" class="bg-red-600 hover:bg-red-700 text-white font-semibold px-5 py-2.5 text-sm transition-colors">
      Create Type
    </button>
  </div>

  @if (session('success'))
    <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 text-sm">
      {{ session('success') }}
    </div>
  @endif

  <div class="bg-white shadow-sm border border-gray-200 p-6">
    <div class="overflow-x-auto">
      <table class="w-full text-sm">
        <thead>
          <tr class="bg-gray-50 text-left">
            <th class="px-4 py-3 font-semibold text-gray-600">Icon</th>
            <th class="px-4 py-3 font-semibold text-gray-600">Name</th>
            <th class="px-4 py-3 font-semibold text-gray-600">Code</th>
            <th class="px-4 py-3 font-semibold text-gray-600">Status</th>
            <th class="px-4 py-3 font-semibold text-gray-600">Created</th>
            <th class="px-4 py-3 font-semibold text-gray-600">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($types as $type)
            <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
              <td class="px-4 py-3">
                @if($type->icon)
                  <img src="{{ asset('storage/' . $type->icon) }}" alt="{{ $type->name }}" class="h-8 w-8 object-contain">
                @else
                  <div class="h-8 w-8 bg-gray-100 flex items-center justify-center text-xs font-bold text-gray-400">GC</div>
                @endif
              </td>
              <td class="px-4 py-3 font-semibold text-gray-900">{{ $type->name }}</td>
              <td class="px-4 py-3 font-mono text-gray-600">{{ $type->code }}</td>
              <td class="px-4 py-3">
                @if($type->is_active)
                  <span class="inline-flex items-center gap-1 bg-green-100 text-green-700 text-xs font-semibold px-2.5 py-1">Active</span>
                @else
                  <span class="inline-flex items-center gap-1 bg-gray-100 text-gray-500 text-xs font-semibold px-2.5 py-1">Inactive</span>
                @endif
              </td>
              <td class="px-4 py-3 text-gray-500">{{ $type->created_at->format('M d, Y') }}</td>
              <td class="px-4 py-3">
                <div class="flex items-center gap-2">
                  <button type="button" onclick="openEditModal({{ $type->id }}, '{{ $type->name }}', '{{ $type->code }}', {{ $type->is_active ? 'true' : 'false' }}, '{{ addslashes($type->instructions) }}', '{{ $type->icon ? asset('storage/' . $type->icon) : '' }}')" class="bg-gray-100 hover:bg-gray-200 text-gray-600 hover:text-gray-800 font-semibold px-3 py-1.5 text-xs transition-colors">
                    Edit
                  </button>
                  <form method="POST" action="{{ route('admin.gift-card-types.destroy', $type) }}" onsubmit="return confirm('Delete this gift card type?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-100 hover:bg-red-200 text-red-600 hover:text-red-700 font-semibold px-3 py-1.5 text-xs transition-colors">
                      Delete
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="px-4 py-8 text-center text-gray-400">No gift card types yet.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  {{-- Create Modal --}}
  <div id="create-modal" class="fixed inset-0 z-[100] hidden flex items-center justify-center p-4 bg-black/40 backdrop-blur-md">
    <div class="bg-white shadow-xl w-full max-w-md p-6">
      <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-bold text-gray-900">Create Gift Card Type</h3>
        <button type="button" onclick="document.getElementById('create-modal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>
        </button>
      </div>
      <form method="POST" action="{{ route('admin.gift-card-types.store') }}" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
          <input type="text" name="name" required maxlength="100" placeholder="e.g. iTunes Gift Card"
            class="w-full border border-gray-300 px-4 py-2.5 text-sm focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition-colors">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Code</label>
          <input type="text" name="code" required maxlength="50" placeholder="e.g. itunes"
            class="w-full border border-gray-300 px-4 py-2.5 text-sm focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition-colors lowercase">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Instructions</label>
          <textarea name="instructions" rows="3"
            class="w-full border border-gray-300 px-4 py-2.5 text-sm focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition-colors"></textarea>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Icon</label>
          <input type="file" name="icon" accept="image/png,image/jpg,image/jpeg,image/svg+xml"
            class="w-full border border-gray-300 px-4 py-2.5 text-sm file:mr-4 file:py-2 file:px-4 file:border-0 file:rounded-none file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 transition-colors">
        </div>
        <div class="flex items-center gap-2">
          <input type="hidden" name="is_active" value="0">
          <input type="checkbox" name="is_active" id="create-active" value="1" checked
            class="w-4 h-4 text-red-600 border-gray-300 focus:ring-red-500">
          <label for="create-active" class="text-sm font-medium text-gray-700">Active</label>
        </div>
        <div class="flex justify-end gap-3 mt-6">
          <button type="button" onclick="document.getElementById('create-modal').classList.add('hidden')" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-5 py-2.5 text-sm transition-colors">Cancel</button>
          <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-semibold px-6 py-2.5 text-sm transition-colors">Create</button>
        </div>
      </form>
    </div>
  </div>

  {{-- Edit Modal --}}
  <div id="edit-modal" class="fixed inset-0 z-[100] hidden flex items-center justify-center p-4 bg-black/40 backdrop-blur-md">
    <div class="bg-white shadow-xl w-full max-w-md p-6">
      <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-bold text-gray-900">Edit Gift Card Type</h3>
        <button type="button" onclick="document.getElementById('edit-modal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>
        </button>
      </div>
      <form id="edit-form" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
          <input type="text" name="name" id="edit-name" required maxlength="100"
            class="w-full border border-gray-300 px-4 py-2.5 text-sm focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition-colors">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Code</label>
          <input type="text" name="code" id="edit-code" required maxlength="50"
            class="w-full border border-gray-300 px-4 py-2.5 text-sm focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition-colors lowercase">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Instructions</label>
          <textarea name="instructions" id="edit-instructions" rows="3"
            class="w-full border border-gray-300 px-4 py-2.5 text-sm focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition-colors"></textarea>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Icon</label>
          <input type="file" name="icon" accept="image/png,image/jpg,image/jpeg,image/svg+xml"
            class="w-full border border-gray-300 px-4 py-2.5 text-sm file:mr-4 file:py-2 file:px-4 file:border-0 file:rounded-none file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 transition-colors">
          <div id="edit-icon-preview" class="mt-2 hidden">
            <div class="flex items-center justify-between mb-1">
              <p class="text-xs text-gray-500">Current icon:</p>
            </div>
            <img id="edit-icon-img" src="" alt="Icon" class="h-12 border border-gray-200 object-contain">
          </div>
        </div>
        <div class="flex items-center gap-2">
          <input type="hidden" name="is_active" value="0">
          <input type="checkbox" name="is_active" id="edit-active" value="1"
            class="w-4 h-4 text-red-600 border-gray-300 focus:ring-red-500">
          <label for="edit-active" class="text-sm font-medium text-gray-700">Active</label>
        </div>
        <div class="flex justify-end gap-3 mt-6">
          <button type="button" onclick="document.getElementById('edit-modal').classList.add('hidden')" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-5 py-2.5 text-sm transition-colors">Cancel</button>
          <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-semibold px-6 py-2.5 text-sm transition-colors">Update</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    function openEditModal(id, name, code, active, instructions, iconUrl) {
      document.getElementById('edit-form').action = '{{ url('/admin/gift-card-types') }}/' + id;
      document.getElementById('edit-name').value = name;
      document.getElementById('edit-code').value = code;
      document.getElementById('edit-instructions').value = instructions;
      document.getElementById('edit-active').checked = active;
      var preview = document.getElementById('edit-icon-preview');
      var img = document.getElementById('edit-icon-img');
      if (iconUrl) {
        img.src = iconUrl;
        preview.classList.remove('hidden');
      } else {
        preview.classList.add('hidden');
      }
      document.getElementById('edit-modal').classList.remove('hidden');
    }
  </script>
</x-layouts.admin>
