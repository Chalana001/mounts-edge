<x-admin-layout>
    <div class="py-12 bg-[#FAF9F6] min-h-screen" x-data="{ activeTab: 'images', imageModal: false, editItem: null }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <h2 class="text-3xl font-serif text-[#1a2e2a] mb-6">Manage Gallery</h2>

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

            <div class="flex gap-4 mb-8 border-b border-gray-300 pb-2">
                <button @click="activeTab = 'images'" :class="activeTab === 'images' ? 'border-b-2 border-[#E67E22] text-[#E67E22]' : 'text-gray-500'" class="pb-2 text-sm uppercase tracking-widest font-bold">Gallery Images</button>
                <button @click="activeTab = 'categories'" :class="activeTab === 'categories' ? 'border-b-2 border-[#E67E22] text-[#E67E22]' : 'text-gray-500'" class="pb-2 text-sm uppercase tracking-widest font-bold">Categories</button>
            </div>

            <div x-show="activeTab === 'images'">
                <div class="flex justify-between items-center mb-6">
                    <p class="text-gray-500 text-sm">Upload and manage your gallery images here.</p>
                    <button @click="imageModal = true; editItem = null" class="bg-[#1a2e2a] text-white px-6 py-2 text-[10px] tracking-widest uppercase font-bold hover:bg-[#E67E22] transition-colors shadow-sm">
                        + Add New Image
                    </button>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
                    @forelse($items as $item)
                        <div class="bg-white rounded border border-gray-200 shadow-sm overflow-hidden group">
                            <div class="relative aspect-square">
                                <img src="{{ asset($item->image) }}" class="w-full h-full object-cover">
                                
                                <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-3">
                                    <button @click="editItem = {{ $item }}; imageModal = true" class="bg-[#E67E22] text-white p-2 rounded hover:bg-orange-600">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </button>
                                    
                                    <form action="{{ route('admin.gallery.items.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Delete this image?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="bg-red-500 text-white p-2 rounded hover:bg-red-600">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <div class="p-3">
                                <span class="text-[9px] uppercase tracking-widest text-[#E67E22] font-bold">{{ $item->category->name ?? 'Uncategorized' }}</span>
                                <p class="text-xs text-gray-600 truncate mt-1">{{ $item->description ?? 'No description' }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-10 text-gray-500 text-sm">No images found.</div>
                    @endforelse
                </div>

                <div x-show="imageModal" class="fixed inset-0 bg-black/60 z-50 flex items-center justify-center p-4" style="display: none;">
                    <div class="bg-white max-w-lg w-full p-8 rounded-lg">
                        <h3 class="text-2xl font-serif text-[#1a2e2a] mb-6" x-text="editItem ? 'Edit Image' : 'Upload New Image'"></h3>
                        
                        <form :action="editItem ? `/admin/gallery/items/${editItem.id}` : '{{ route('admin.gallery.items.store') }}'" method="POST" enctype="multipart/form-data">
                            @csrf
                            <template x-if="editItem"><input type="hidden" name="_method" value="PUT"></template>
                            
                            <div class="mb-4">
                                <label class="text-[10px] uppercase text-gray-500">Category</label>
                                <select name="gallery_category_id" class="w-full border-gray-300 rounded" required>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" x-bind:selected="editItem?.gallery_category_id == {{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="text-[10px] uppercase text-gray-500">Short Description</label>
                                <input type="text" name="description" :value="editItem?.description" class="w-full border-gray-300 rounded" placeholder="e.g. Luxury suite bedroom">
                            </div>

                            <div class="mb-6">
                                <label class="text-[10px] uppercase text-gray-500" x-text="editItem ? 'Image (Leave blank to keep current)' : 'Upload Image'"></label>
                                
                                <input type="file" name="image" class="w-full border-gray-300 rounded text-sm mb-2 image-upload-input" accept="image/*" x-bind:required="!editItem">
                                
                                <img src="" class="mt-2 h-20 w-32 object-cover rounded shadow-sm image-preview hidden">
                                <img :src="editItem?.image" class="h-20 w-32 object-cover rounded shadow-sm mt-2 existing-image" x-show="editItem?.image">
                            </div>

                            <div class="flex justify-end gap-4">
                                <button type="button" @click="imageModal = false" class="px-6 py-2 border text-xs uppercase font-bold">Cancel</button>
                                <button type="submit" class="bg-[#1a2e2a] text-white px-6 py-2 text-xs uppercase font-bold">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div x-show="activeTab === 'categories'" style="display: none;">
                <div class="grid md:grid-cols-3 gap-8">
                    <div class="md:col-span-1">
                        <div class="bg-white p-6 shadow-sm border border-gray-100 rounded-lg">
                            <h3 class="text-lg font-bold text-[#E67E22] uppercase tracking-widest text-xs mb-4">Add Category</h3>
                            <form action="{{ route('admin.gallery.categories.store') }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label class="text-[10px] uppercase text-gray-500">Name (e.g. Weddings)</label>
                                    <input type="text" name="name" class="w-full border-gray-300 rounded" required>
                                </div>
                                <button type="submit" class="w-full bg-[#1a2e2a] text-white px-4 py-3 text-[10px] tracking-widest uppercase font-bold hover:bg-[#E67E22]">Add Category</button>
                            </form>
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <div class="bg-white overflow-hidden shadow-sm border border-gray-100 rounded-lg p-6">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-gray-50 border-b text-[10px] uppercase tracking-widest text-gray-500">
                                        <th class="p-4">Category Name</th>
                                        <th class="p-4 text-center">Images Count</th>
                                        <th class="p-4 text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($categories as $category)
                                    <tr class="border-b border-gray-50 hover:bg-gray-50">
                                        <td class="p-4 font-bold text-[#1a2e2a] text-sm">{{ $category->name }}</td>
                                        <td class="p-4 text-xs font-bold text-[#E67E22] text-center">{{ $category->items_count }}</td>
                                        <td class="p-4 text-right">
                                            <form action="{{ route('admin.gallery.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Delete this category?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-[10px] font-bold uppercase tracking-widest {{ $category->items_count > 0 ? 'text-gray-400 cursor-not-allowed' : 'text-red-500' }}" {{ $category->items_count > 0 ? 'disabled' : '' }}>Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-6 text-gray-500 text-sm">No categories found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const imageInputs = document.querySelectorAll('.image-upload-input');
            const maxSizeInMB = 2; 
            const maxSizeInBytes = maxSizeInMB * 1024 * 1024;

            imageInputs.forEach(input => {
                input.addEventListener('change', function() {
                    const file = this.files[0];
                    // Find the parent container to locate the correct preview images
                    const parent = this.closest('div');
                    const previewImg = parent.querySelector('.image-preview');
                    const existingImg = parent.querySelector('.existing-image');

                    if (file) {
                        if (file.size > maxSizeInBytes) {
                            alert(`Warning! The selected image is too large. Please select an image smaller than ${maxSizeInMB}MB.`);
                            this.value = ''; // Clear the input
                            
                            // Hide preview, restore existing
                            if (previewImg) previewImg.classList.add('hidden');
                            if (existingImg) existingImg.style.display = 'block';
                        } else {
                            // Show preview, hide existing
                            if (previewImg) {
                                previewImg.src = URL.createObjectURL(file);
                                previewImg.classList.remove('hidden');
                            }
                            if (existingImg) existingImg.style.display = 'none';
                        }
                    } else {
                        // User canceled file selection
                        if (previewImg) previewImg.classList.add('hidden');
                        if (existingImg) existingImg.style.display = 'block';
                    }
                });
            });
        });
    </script>
</x-admin-layout>