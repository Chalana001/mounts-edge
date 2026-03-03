<x-admin-layout>
    <div class="py-12 bg-[#FAF9F6] min-h-screen" x-data="{ activeTab: 'halls' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <h2 class="text-3xl font-serif text-[#1a2e2a] mb-6">Manage Weddings</h2>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 text-sm font-bold">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex gap-4 mb-8 border-b border-gray-300 pb-2">
                <button @click="activeTab = 'halls'" :class="activeTab === 'halls' ? 'border-b-2 border-[#E67E22] text-[#E67E22]' : 'text-gray-500'" class="pb-2 text-sm uppercase tracking-widest font-bold">Wedding Halls</button>
                <button @click="activeTab = 'packages'" :class="activeTab === 'packages' ? 'border-b-2 border-[#E67E22] text-[#E67E22]' : 'text-gray-500'" class="pb-2 text-sm uppercase tracking-widest font-bold">Packages</button>
                <button @click="activeTab = 'catering'" :class="activeTab === 'catering' ? 'border-b-2 border-[#E67E22] text-[#E67E22]' : 'text-gray-500'" class="pb-2 text-sm uppercase tracking-widest font-bold">Catering & Menu</button>
                <button @click="activeTab = 'decorations'" :class="activeTab === 'decorations' ? 'border-b-2 border-[#E67E22] text-[#E67E22]' : 'text-gray-500'" class="pb-2 text-sm uppercase tracking-widest font-bold">Decorations</button>
            </div>

            <div x-show="activeTab === 'halls'" x-data="{ hallModal: false, editHall: null, features: [''] }">
                <div class="flex justify-end mb-4">
                    <button @click="hallModal = true; editHall = null; features = ['']" class="bg-[#1a2e2a] text-white px-6 py-2 text-[10px] tracking-widest uppercase font-bold hover:bg-[#E67E22]">+ Add New Hall</button>
                </div>

                <div class="grid md:grid-cols-2 gap-6">
                    @forelse($hall instanceof \Illuminate\Database\Eloquent\Collection ? $hall : [$hall] as $h)
                        @if($h->id)
                        <div class="bg-white p-6 shadow-sm border border-gray-100 flex gap-4">
                            <img src="{{ asset($h->image) }}" class="w-32 h-24 object-cover rounded">
                            <div class="flex-1">
                                <h4 class="font-bold text-lg text-[#1a2e2a]">{{ $h->name }}</h4>
                                <p class="text-xs text-gray-500 mb-4">{{ $h->capacity }} • {{ $h->area }}</p>
                                <div class="flex gap-4">
                                    <button @click="editHall = {{ $h }}; features = {{ json_encode($h->features ?: ['']) }}; hallModal = true" class="text-[#E67E22] text-[10px] font-bold uppercase tracking-widest">Edit</button>
                                    <form action="{{ route('admin.weddings.hall.destroy', $h->id) }}" method="POST" onsubmit="return confirm('Delete this hall?');">
                                        @csrf @method('DELETE')
                                        <button class="text-red-500 text-[10px] font-bold uppercase tracking-widest">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endif
                    @empty
                        <p class="text-gray-500 text-sm">No halls added yet.</p>
                    @endforelse
                </div>

                <div x-show="hallModal" class="fixed inset-0 bg-black/60 z-50 flex items-center justify-center p-4" style="display: none;">
                    <div class="bg-white max-w-2xl w-full p-8 rounded-lg max-h-[90vh] overflow-y-auto">
                        <h3 class="text-2xl font-serif text-[#1a2e2a] mb-6" x-text="editHall ? 'Edit Wedding Hall' : 'Add New Wedding Hall'"></h3>
                        
                        <form :action="editHall ? `/admin/weddings/hall/${editHall.id}` : '{{ route('admin.weddings.hall.store') }}'" method="POST" enctype="multipart/form-data">
                            @csrf
                            <template x-if="editHall"><input type="hidden" name="_method" value="PUT"></template>
                            
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div><label class="text-[10px] uppercase text-gray-500">Name</label><input type="text" name="name" :value="editHall?.name" class="w-full border-gray-300 rounded" required></div>
                                <div><label class="text-[10px] uppercase text-gray-500">Tagline</label><input type="text" name="tagline" :value="editHall?.tagline" class="w-full border-gray-300 rounded" required></div>
                                <div><label class="text-[10px] uppercase text-gray-500">Capacity</label><input type="text" name="capacity" :value="editHall?.capacity" class="w-full border-gray-300 rounded" required></div>
                                <div><label class="text-[10px] uppercase text-gray-500">Area</label><input type="text" name="area" :value="editHall?.area" class="w-full border-gray-300 rounded" required></div>
                                <div><label class="text-[10px] uppercase text-gray-500">Style</label><input type="text" name="style" :value="editHall?.style" class="w-full border-gray-300 rounded" required></div>
                                
                                <div>
                                    <label class="text-[10px] uppercase text-gray-500">Image</label>
                                    <input type="file" name="image" class="w-full border-gray-300 rounded text-sm image-upload-input" accept="image/*">
                                    <img src="" class="mt-2 h-16 w-24 object-cover rounded shadow-sm image-preview hidden">
                                    <img :src="editHall?.image" class="mt-2 h-16 w-24 object-cover rounded shadow-sm existing-image" x-show="editHall?.image">
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="text-[10px] uppercase text-gray-500">Description</label>
                                <textarea name="description" :value="editHall?.description" rows="3" class="w-full border-gray-300 rounded" required></textarea>
                            </div>

                            <div class="mb-6 bg-gray-50 p-4 rounded border">
                                <label class="block text-xs uppercase font-bold mb-3 text-[#1a2e2a]">Features</label>
                                <div>
                                    <template x-for="(feat, index) in features" :key="index">
                                        <div class="flex gap-2 mb-2">
                                            <input type="text" name="features[]" x-model="features[index]" class="flex-1 border-gray-300 rounded text-sm" placeholder="e.g. Climate controlled">
                                            <button type="button" @click="features.splice(index, 1)" class="text-red-500 font-bold px-2">×</button>
                                        </div>
                                    </template>
                                    <button type="button" @click="features.push('')" class="text-xs text-[#E67E22] font-bold mt-2">+ Add Feature</button>
                                </div>
                            </div>

                            <div class="flex justify-end gap-4">
                                <button type="button" @click="hallModal = false" class="px-6 py-2 border text-xs uppercase font-bold">Cancel</button>
                                <button type="submit" class="bg-[#1a2e2a] text-white px-6 py-2 text-xs uppercase font-bold">Save Hall</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div x-show="activeTab === 'packages'" x-data="{ pkgModal: false, editPkg: null, includes: [{ title: '', rule: '', items: [''] }] }" style="display: none;">
                <div class="flex justify-end mb-4">
                    <button @click="pkgModal = true; editPkg = null; includes = [{ title: '', rule: '', items: [''] }]" class="bg-[#1a2e2a] text-white px-6 py-2 text-[10px] tracking-widest uppercase font-bold hover:bg-[#E67E22]">+ Add Package</button>
                </div>
                
                <div class="bg-white shadow-sm border rounded">
                    <table class="w-full text-left">
                        <tr class="bg-gray-50 border-b text-[10px] uppercase tracking-widest text-gray-500">
                            <th class="p-4">Package</th>
                            <th class="p-4">Guests</th>
                            <th class="p-4">Popular?</th>
                            <th class="p-4">Actions</th>
                        </tr>
                        @foreach($packages as $pkg)
                            @php
                                $incData = $pkg->includes ?? [];
                                $formattedInc = [];
                                if (!empty($incData)) {
                                    if (is_string($incData[0] ?? null)) {
                                        $formattedInc = [['title' => 'General', 'rule' => '', 'items' => $incData]];
                                    } else {
                                        $formattedInc = $incData;
                                    }
                                } else {
                                    $formattedInc = [['title' => '', 'rule' => '', 'items' => ['']]];
                                }
                            @endphp

                        <tr class="border-b">
                            <td class="p-4 font-bold text-[#1a2e2a]">{{ $pkg->name }}</td>
                            <td class="p-4 text-sm">{{ $pkg->guests }}</td>
                            <td class="p-4 text-sm">{{ $pkg->is_popular ? '⭐ Yes' : 'No' }}</td>
                            <td class="p-4 flex gap-4">
                                <button @click="editPkg = {{ $pkg }}; includes = {{ json_encode($formattedInc) }}; pkgModal = true" class="text-[#E67E22] text-[10px] font-bold uppercase">Edit</button>
                                <form action="{{ route('admin.weddings.packages.destroy', $pkg->id) }}" method="POST" onsubmit="return confirm('Delete this package?');">
                                    @csrf @method('DELETE')
                                    <button class="text-red-500 text-[10px] font-bold uppercase">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>

                <div x-show="pkgModal" class="fixed inset-0 bg-black/60 z-50 flex items-center justify-center p-4" style="display: none;">
                    <div class="bg-white max-w-3xl w-full p-8 rounded-lg max-h-[90vh] overflow-y-auto">
                        <h3 class="text-2xl font-serif text-[#1a2e2a] mb-6" x-text="editPkg ? 'Edit Package' : 'Add New Package'"></h3>
                        
                        <form :action="editPkg ? `/admin/weddings/packages/${editPkg.id}` : '{{ route('admin.weddings.packages.store') }}'" method="POST">
                            @csrf
                            <template x-if="editPkg"><input type="hidden" name="_method" value="PUT"></template>
                            
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div><label class="text-[10px] uppercase text-gray-500">Name</label><input type="text" name="name" :value="editPkg?.name" class="w-full border-gray-300 rounded" required></div>
                                <div><label class="text-[10px] uppercase text-gray-500">Guests</label><input type="text" name="guests" :value="editPkg?.guests" class="w-full border-gray-300 rounded" required></div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" name="is_popular" class="text-[#E67E22] rounded" :checked="editPkg?.is_popular">
                                    <span class="text-sm font-bold text-gray-700">Mark as 'Most Popular' Package</span>
                                </label>
                            </div>

<div class="mb-6 bg-gray-50 p-6 rounded border border-gray-200">
    <label class="block text-sm uppercase font-bold mb-4 text-[#1a2e2a] border-b pb-2">Menu Sections (Includes)</label>
    
    <div>
        <template x-for="(section, secIndex) in includes" :key="secIndex">
            <div class="mb-6 mt-6 bg-white p-4 border border-gray-200 rounded relative shadow-sm">
                
                <button type="button" @click="includes.splice(secIndex, 1)" class="absolute -top-4 right-4 bg-white border border-red-200 text-red-500 hover:bg-red-500 hover:text-white px-3 py-1 rounded text-xs font-bold shadow-sm transition-colors">
                    ✕ Remove Section
                </button>
                
                <div class="grid grid-cols-2 gap-4 mb-4 mt-2">
                    <div>
                        <label class="text-[10px] uppercase text-gray-500">Section Title</label>
                        <input type="text" :name="`includes[${secIndex}][title]`" x-model="section.title" class="w-full border-gray-300 rounded text-sm" placeholder="e.g. Salads" required>
                    </div>
                    <div>
                        <label class="text-[10px] uppercase text-gray-500">Rule (Optional)</label>
                        <input type="text" :name="`includes[${secIndex}][rule]`" x-model="section.rule" class="w-full border-gray-300 rounded text-sm" placeholder="e.g. Choice of x">
                    </div>
                </div>

                <div class="pl-4 border-l-2 border-[#E67E22]/30">
                    <label class="text-[10px] uppercase text-gray-500 mb-2 block">Items in this section</label>
                    <template x-for="(item, itemIndex) in section.items" :key="itemIndex">
                        <div class="flex gap-2 mb-2">
                            <input type="text" :name="`includes[${secIndex}][items][]`" x-model="section.items[itemIndex]" class="flex-1 border-gray-300 rounded text-sm" placeholder="e.g. Mixed Fruit" required>
                            <button type="button" @click="section.items.splice(itemIndex, 1)" class="text-red-500 font-bold px-3 hover:bg-red-50 rounded">×</button>
                        </div>
                    </template>
                    <button type="button" @click="section.items.push('')" class="text-[10px] text-[#E67E22] uppercase tracking-wider font-bold mt-2">+ Add Item</button>
                </div>
            </div>
        </template>

        <button type="button" @click="includes.push({title: '', rule: '', items: ['']})" class="mt-2 px-4 py-2 border-2 border-[#1a2e2a] text-[#1a2e2a] text-[10px] uppercase tracking-widest font-bold hover:bg-[#1a2e2a] hover:text-white transition-colors rounded">
            + Add New Section
        </button>
    </div>
</div>
                            <div class="flex justify-end gap-4">
                                <button type="button" @click="pkgModal = false" class="px-6 py-2 border text-xs uppercase font-bold">Cancel</button>
                                <button type="submit" class="bg-[#1a2e2a] text-white px-6 py-2 text-xs uppercase font-bold hover:bg-[#E67E22]">Save Package</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div x-show="activeTab === 'catering'" style="display: none;">
                <form action="{{ route('admin.weddings.catering.update') }}" method="POST" enctype="multipart/form-data" class="bg-white p-8 rounded shadow-sm border">
                    @csrf
                    <div class="grid md:grid-cols-2 gap-8">
                        <div>
                            <div class="mb-4"><label class="text-[10px] uppercase text-gray-500">Name</label><input type="text" name="name" value="{{ $catering->name }}" class="w-full border-gray-300 rounded" required></div>
                            <div class="mb-4"><label class="text-[10px] uppercase text-gray-500">Tagline</label><input type="text" name="tagline" value="{{ $catering->tagline }}" class="w-full border-gray-300 rounded" required></div>
                            <div class="mb-4"><label class="text-[10px] uppercase text-gray-500">Description</label><textarea name="description" rows="4" class="w-full border-gray-300 rounded" required>{{ $catering->description }}</textarea></div>
                            
                            <div class="mb-4">
                                <label class="text-[10px] uppercase text-gray-500">Main Image</label>
                                <input type="file" name="image" class="w-full border-gray-300 rounded text-sm mb-2 image-upload-input" accept="image/*">
                                <img src="" class="mt-2 h-20 w-32 object-cover rounded shadow-sm image-preview hidden">
                                @if($catering->image) 
                                    <img src="{{ asset($catering->image) }}" class="h-20 w-32 object-cover rounded shadow-sm mt-2 existing-image"> 
                                @endif
                            </div>
                        </div>

                        <div>
                            <div class="mb-4"><label class="text-[10px] uppercase text-gray-500">List Title (e.g. Menu Options)</label><input type="text" name="list_title" value="{{ $catering->list_title }}" class="w-full border-gray-300 rounded" required></div>
                            
                            <div class="mb-6 bg-gray-50 p-4 border rounded" x-data="{ items: {{ json_encode($catering->list_items ?: ['']) }} }">
                                <label class="block text-xs uppercase font-bold mb-3 text-[#1a2e2a]">Menu Items</label>
                                <template x-for="(item, index) in items" :key="index">
                                    <div class="flex gap-2 mb-2">
                                        <input type="text" name="list_items[]" x-model="items[index]" class="flex-1 border-gray-300 rounded text-sm">
                                        <button type="button" @click="items.splice(index, 1)" class="text-red-500 font-bold px-2">×</button>
                                    </div>
                                </template>
                                <button type="button" @click="items.push('')" class="text-xs text-[#E67E22] font-bold mt-2">+ Add Item</button>
                            </div>

                            <div class="mb-6 bg-gray-50 p-4 border rounded" x-data="{ tags: {{ json_encode($catering->tags ?: ['']) }} }">
                                <label class="block text-xs uppercase font-bold mb-3 text-[#1a2e2a]">Tags (e.g. Welcome Drinks)</label>
                                <template x-for="(tag, index) in tags" :key="index">
                                    <div class="flex gap-2 mb-2">
                                        <input type="text" name="tags[]" x-model="tags[index]" class="flex-1 border-gray-300 rounded text-sm">
                                        <button type="button" @click="tags.splice(index, 1)" class="text-red-500 font-bold px-2">×</button>
                                    </div>
                                </template>
                                <button type="button" @click="tags.push('')" class="text-xs text-[#E67E22] font-bold mt-2">+ Add Tag</button>
                            </div>
                            
                            <div class="flex justify-end"><button type="submit" class="bg-[#1a2e2a] text-white px-8 py-3 text-xs uppercase font-bold w-full hover:bg-[#E67E22] transition-colors">Save Catering Info</button></div>
                        </div>
                    </div>
                </form>
            </div>

            <div x-show="activeTab === 'decorations'" style="display: none;">
                 <form action="{{ route('admin.weddings.decoration.update') }}" method="POST" enctype="multipart/form-data" class="bg-white p-8 rounded shadow-sm border">
                    @csrf
                    <div class="grid md:grid-cols-2 gap-8">
                        <div>
                            <div class="mb-4"><label class="text-[10px] uppercase text-gray-500">Name</label><input type="text" name="name" value="{{ $decoration->name }}" class="w-full border-gray-300 rounded" required></div>
                            <div class="mb-4"><label class="text-[10px] uppercase text-gray-500">Tagline</label><input type="text" name="tagline" value="{{ $decoration->tagline }}" class="w-full border-gray-300 rounded" required></div>
                            <div class="mb-4"><label class="text-[10px] uppercase text-gray-500">Description</label><textarea name="description" rows="4" class="w-full border-gray-300 rounded" required>{{ $decoration->description }}</textarea></div>
                            
                            <div class="mb-4">
                                <label class="text-[10px] uppercase text-gray-500">Main Image</label>
                                <input type="file" name="image" class="w-full border-gray-300 rounded text-sm mb-2 image-upload-input" accept="image/*">
                                <img src="" class="mt-2 h-20 w-32 object-cover rounded shadow-sm image-preview hidden">
                                @if($decoration->image) 
                                    <img src="{{ asset($decoration->image) }}" class="h-20 w-32 object-cover rounded shadow-sm mt-2 existing-image"> 
                                @endif
                            </div>
                        </div>

                        <div>
                            <div class="mb-4"><label class="text-[10px] uppercase text-gray-500">List Title (e.g. Decoration Styles)</label><input type="text" name="list_title" value="{{ $decoration->list_title }}" class="w-full border-gray-300 rounded" required></div>
                            
                            <div class="mb-6 bg-gray-50 p-4 border rounded" x-data="{ items: {{ json_encode($decoration->list_items ?: ['']) }} }">
                                <label class="block text-xs uppercase font-bold mb-3 text-[#1a2e2a]">Style Items</label>
                                <template x-for="(item, index) in items" :key="index">
                                    <div class="flex gap-2 mb-2">
                                        <input type="text" name="list_items[]" x-model="items[index]" class="flex-1 border-gray-300 rounded text-sm">
                                        <button type="button" @click="items.splice(index, 1)" class="text-red-500 font-bold px-2">×</button>
                                    </div>
                                </template>
                                <button type="button" @click="items.push('')" class="text-xs text-[#E67E22] font-bold mt-2">+ Add Item</button>
                            </div>

                            <div class="mb-6 bg-gray-50 p-4 border rounded" x-data="{ tags: {{ json_encode($decoration->tags ?: ['']) }} }">
                                <label class="block text-xs uppercase font-bold mb-3 text-[#1a2e2a]">Tags (e.g. Kandyan Dancers)</label>
                                <template x-for="(tag, index) in tags" :key="index">
                                    <div class="flex gap-2 mb-2">
                                        <input type="text" name="tags[]" x-model="tags[index]" class="flex-1 border-gray-300 rounded text-sm">
                                        <button type="button" @click="tags.splice(index, 1)" class="text-red-500 font-bold px-2">×</button>
                                    </div>
                                </template>
                                <button type="button" @click="tags.push('')" class="text-xs text-[#E67E22] font-bold mt-2">+ Add Tag</button>
                            </div>
                            
                            <div class="flex justify-end"><button type="submit" class="bg-[#1a2e2a] text-white px-8 py-3 text-xs uppercase font-bold w-full hover:bg-[#E67E22] transition-colors">Save Decoration Info</button></div>
                        </div>
                    </div>
                </form>
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