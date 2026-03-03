<x-admin-layout>
    <div class="py-12 bg-[#FAF9F6] min-h-screen" x-data="{ roomModal: false, editRoom: null, selectedFeatures: [] }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 text-sm font-bold">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6 text-sm font-bold">
                    {{ session('error') }}
                </div>
            @endif

            <div class="mb-16">
                <h2 class="text-3xl font-serif text-[#1a2e2a] mb-6">Manage Room Types</h2>
                <div class="grid md:grid-cols-3 gap-8">
                    <div class="md:col-span-1">
                        <div class="bg-white p-6 shadow-sm border border-gray-100 rounded-lg">
                            <h3 class="text-lg font-bold text-[#E67E22] uppercase tracking-widest text-xs mb-4">Add New Type</h3>
                            <form action="{{ route('admin.room-types.store') }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label class="block text-[10px] tracking-widest uppercase text-gray-500 mb-2">Name</label>
                                    <input type="text" name="name" class="w-full border-gray-300 rounded-md" required>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-[10px] tracking-widest uppercase text-gray-500 mb-2">Slug</label>
                                    <input type="text" name="slug" class="w-full border-gray-300 rounded-md" required>
                                </div>
                                <div class="mb-6">
                                    <label class="block text-[10px] tracking-widest uppercase text-gray-500 mb-2">SVG Icon</label>
                                    <textarea name="icon" rows="2" class="w-full border-gray-300 rounded-md" required></textarea>
                                </div>
                                <button type="submit" class="w-full bg-[#1a2e2a] text-white px-4 py-3 text-[10px] tracking-widest uppercase font-bold hover:bg-[#E67E22]">Save Type</button>
                            </form>
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <div class="bg-white overflow-hidden shadow-sm border border-gray-100 rounded-lg p-6 h-full">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-gray-50 border-b text-[10px] uppercase tracking-widest text-gray-500">
                                        <th class="p-4">Name</th>
                                        <th class="p-4">Slug</th>
                                        <th class="p-4">Rooms</th>
                                        <th class="p-4 text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($roomTypes as $type)
                                    <tr class="border-b border-gray-50 hover:bg-gray-50">
                                        <td class="p-4 font-bold text-[#1a2e2a] text-sm">{{ $type->name }}</td>
                                        <td class="p-4 text-xs text-gray-600">{{ $type->slug }}</td>
                                        <td class="p-4 text-xs font-bold text-[#E67E22]">{{ $type->rooms_count }}</td>
                                        <td class="p-4 text-right">
                                            <form action="{{ route('admin.room-types.destroy', $type->id) }}" method="POST" onsubmit="return confirm('Delete this room type?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-[10px] font-bold uppercase tracking-widest {{ $type->rooms_count > 0 ? 'text-gray-400 cursor-not-allowed' : 'text-red-500' }}" {{ $type->rooms_count > 0 ? 'disabled' : '' }}>Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="border-gray-300 mb-12">

            <div>
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-3xl font-serif text-[#1a2e2a]">Manage Rooms</h2>
                    <button @click="roomModal = true; editRoom = null; selectedFeatures = []" class="bg-[#E67E22] text-white px-6 py-2 text-[10px] tracking-widest uppercase font-bold hover:bg-[#1a2e2a] transition-colors shadow-sm">
                        + Add New Room
                    </button>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
                    <div class="p-6 text-gray-900 overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-[#1a2e2a] text-white text-[10px] uppercase tracking-widest">
                                    <th class="p-4">Image</th>
                                    <th class="p-4">Name</th>
                                    <th class="p-4">Type</th>
                                    <th class="p-4">Capacity</th>
                                    <th class="p-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($rooms as $room)
                                <tr class="border-b border-gray-50 hover:bg-gray-50 transition-colors">
                                    <td class="p-4"><img src="{{ $room->image }}" class="w-20 h-14 object-cover rounded shadow-sm"></td>
                                    <td class="p-4 font-bold text-[#1a2e2a]">{{ $room->name }}</td>
                                    <td class="p-4 text-sm text-gray-600">{{ $room->roomType->name ?? 'N/A' }}</td>
                                    <td class="p-4 text-sm text-gray-600">{{ $room->capacity }}</td>
                                    <td class="p-4">
                                        <div class="flex items-center gap-4">
                                            <button @click="editRoom = {{ $room }}; selectedFeatures = {{ $room->features->pluck('id') }}; roomModal = true" class="text-[#E67E22] hover:text-[#1a2e2a] text-[10px] font-bold tracking-widest uppercase">Edit</button>
                                            
                                            <form action="{{ route('admin.rooms.destroy', $room->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this room?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 text-[10px] font-bold tracking-widest uppercase">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-10 text-gray-500 text-sm">No rooms found. Click "+ Add New Room" to get started.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
        </div>

        <div x-show="roomModal" class="fixed inset-0 bg-black/60 z-50 flex items-center justify-center p-4" style="display: none;">
            <div class="bg-white max-w-4xl w-full p-8 rounded-lg max-h-[90vh] overflow-y-auto">
                <h3 class="text-2xl font-serif text-[#1a2e2a] mb-6" x-text="editRoom ? 'Edit Room: ' + editRoom.name : 'Add New Room'"></h3>
                
                <form :action="editRoom ? `/admin/rooms/${editRoom.id}` : '{{ route('admin.rooms.store') }}'" method="POST" enctype="multipart/form-data">
                    @csrf
                    <template x-if="editRoom"><input type="hidden" name="_method" value="PUT"></template>
                    
                    <div class="grid md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-[10px] tracking-widest uppercase text-gray-500 mb-2">Room Name</label>
                            <input type="text" name="name" :value="editRoom?.name" class="w-full border-gray-300 rounded" required>
                        </div>
                        <div>
                            <label class="block text-[10px] tracking-widest uppercase text-gray-500 mb-2">Room Type</label>
                            <select name="room_type_id" class="w-full border-gray-300 rounded" required>
                                @foreach($roomTypes as $type)
                                    <option value="{{ $type->id }}" x-bind:selected="editRoom?.room_type_id == {{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] tracking-widest uppercase text-gray-500 mb-2">Tagline</label>
                            <input type="text" name="tagline" :value="editRoom?.tagline" class="w-full border-gray-300 rounded" required>
                        </div>
                        <div>
                            <label class="block text-[10px] tracking-widest uppercase text-gray-500 mb-2">Capacity</label>
                            <input type="text" name="capacity" :value="editRoom?.capacity" class="w-full border-gray-300 rounded" required>
                        </div>
                        <div>
                            <label class="block text-[10px] tracking-widest uppercase text-gray-500 mb-2">Size</label>
                            <input type="text" name="size" :value="editRoom?.size" class="w-full border-gray-300 rounded" required>
                        </div>
                        <div>
                            <label class="block text-[10px] tracking-widest uppercase text-gray-500 mb-2" x-text="editRoom ? 'Room Image (Leave blank to keep current)' : 'Room Image'"></label>
                            <input type="file" name="image" id="image_input" accept="image/*" class="w-full border-gray-300 text-sm" x-bind:required="!editRoom">
                            <div class="mt-2">
                                <img id="image_preview" src="" class="h-16 rounded object-cover shadow-sm hidden">
                                <img :src="editRoom?.image" class="h-16 rounded object-cover shadow-sm existing-image" x-show="editRoom?.image">
                            </div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-[10px] tracking-widest uppercase text-gray-500 mb-2">Description</label>
                        <textarea name="description" :value="editRoom?.description" rows="4" class="w-full border-gray-300 rounded" required></textarea>
                    </div>

                    <div class="mb-8">
                        <label class="block text-[10px] tracking-widest uppercase text-gray-500 mb-4">Select Features</label>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            @foreach($features as $feature)
                                <label class="flex items-center space-x-2 cursor-pointer">
                                    <input type="checkbox" name="features[]" value="{{ $feature->id }}" 
                                           x-bind:checked="selectedFeatures.includes({{ $feature->id }})"
                                           class="text-[#E67E22] rounded focus:ring-[#E67E22]">
                                    <span class="text-sm text-gray-700">{{ $feature->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex justify-end gap-4 pt-6 border-t border-gray-100">
                        <button type="button" @click="roomModal = false" class="px-6 py-2 border text-xs uppercase font-bold tracking-widest">Cancel</button>
                        <button type="submit" class="bg-[#1a2e2a] text-white px-8 py-2 text-xs uppercase font-bold tracking-widest hover:bg-[#E67E22]">Save Room</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const imageInput = document.getElementById('image_input');
            const imagePreview = document.getElementById('image_preview');
            const existingImage = document.querySelector('.existing-image');
            
            const maxSizeInMB = 2; 
            const maxSizeInBytes = maxSizeInMB * 1024 * 1024;

            if (imageInput && imagePreview) {
                imageInput.addEventListener('change', function() {
                    const file = this.files[0];
                    if (file) {
                        if (file.size > maxSizeInBytes) {
                            alert(`Warning! The selected image is too large. Please select an image smaller than ${maxSizeInMB}MB.`);
                            this.value = ''; 
                            imagePreview.classList.add('hidden');
                            if(existingImage) existingImage.style.display = 'block';
                            return; 
                        }
                        
                        imagePreview.classList.remove('hidden');
                        imagePreview.src = URL.createObjectURL(file);
                        if(existingImage) existingImage.style.display = 'none';
                    }
                });
            }
        });
    </script>
</x-admin-layout>