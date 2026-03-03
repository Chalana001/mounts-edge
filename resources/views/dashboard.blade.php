<x-admin-layout>
    <div class="py-12 bg-[#FAF9F6] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <h2 class="text-3xl font-serif text-[#1a2e2a] mb-6">Admin Dashboard</h2>

            <div class="bg-[#1a2e2a] rounded-xl shadow-lg p-8 mb-8 text-white relative overflow-hidden">
                <div class="relative z-10">
                    <h3 class="text-3xl font-serif mb-2">Welcome back, {{ auth()->user()->name ?? 'Admin' }}! 👋</h3>
                    <p class="text-gray-300 font-light text-sm tracking-wide">Manage your hotel rooms, weddings, gallery and overall system settings from here.</p>
                </div>
                <div class="absolute -right-10 -top-24 opacity-10">
                    <svg width="300" height="300" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2L2 22h20L12 2zm0 4l7.5 15h-15L12 6z"/>
                    </svg>
                </div>
            </div>

            <h4 class="text-xs uppercase tracking-widest text-gray-500 font-bold mb-4 ml-1">Quick Actions</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
                
                <a href="{{ route('admin.rooms.index') }}" class="group bg-white p-6 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition-all hover:border-[#E67E22] flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-[#1a2e2a]/5 text-[#1a2e2a] flex items-center justify-center group-hover:bg-[#E67E22] group-hover:text-white transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                    </div>
                    <div>
                        <h5 class="font-bold text-[#1a2e2a] group-hover:text-[#E67E22] transition-colors">Manage Rooms</h5>
                        <p class="text-xs text-gray-500 mt-1">Add, edit, or delete hotel rooms</p>
                    </div>
                </a>

                <a href="{{ route('admin.weddings.index') }}" class="group bg-white p-6 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition-all hover:border-[#E67E22] flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-[#1a2e2a]/5 text-[#1a2e2a] flex items-center justify-center group-hover:bg-[#E67E22] group-hover:text-white transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                        </svg>
                    </div>
                    <div>
                        <h5 class="font-bold text-[#1a2e2a] group-hover:text-[#E67E22] transition-colors">Manage Weddings</h5>
                        <p class="text-xs text-gray-500 mt-1">Update halls, packages & menus</p>
                    </div>
                </a>

                <a href="{{ route('admin.gallery.index') }}" class="group bg-white p-6 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition-all hover:border-[#E67E22] flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-[#1a2e2a]/5 text-[#1a2e2a] flex items-center justify-center group-hover:bg-[#E67E22] group-hover:text-white transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <h5 class="font-bold text-[#1a2e2a] group-hover:text-[#E67E22] transition-colors">Manage Gallery</h5>
                        <p class="text-xs text-gray-500 mt-1">Upload and organize images</p>
                    </div>
                </a>

            </div>

            <h4 class="text-xs uppercase tracking-widest text-gray-500 font-bold mb-4 ml-1">System Overview</h4>
            <div class="grid grid-cols-2 lg:grid-cols-5 gap-6">
                <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm text-center lg:text-left">
                    <p class="text-[10px] uppercase tracking-widest text-gray-500 font-bold">Total Rooms</p>
                    <h3 class="text-3xl font-serif text-[#1a2e2a] mt-2">{{ \App\Models\Room::count() ?? 0 }}</h3>
                </div>
                
                <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm text-center lg:text-left">
                    <p class="text-[10px] uppercase tracking-widest text-gray-500 font-bold">Room Types</p>
                    <h3 class="text-3xl font-serif text-[#1a2e2a] mt-2">{{ \App\Models\RoomType::count() ?? 0 }}</h3>
                </div>
                
                <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm text-center lg:text-left">
                    <p class="text-[10px] uppercase tracking-widest text-gray-500 font-bold">Wedding Pkgs</p>
                    <h3 class="text-3xl font-serif text-[#1a2e2a] mt-2">{{ \App\Models\WeddingPackage::count() ?? 0 }}</h3>
                </div>

                <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm text-center lg:text-left">
                    <p class="text-[10px] uppercase tracking-widest text-gray-500 font-bold">Wedding Halls</p>
                    <h3 class="text-3xl font-serif text-[#1a2e2a] mt-2">{{ \App\Models\WeddingHall::count() ?? 0 }}</h3>
                </div>

                <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm text-center lg:text-left">
                    <p class="text-[10px] uppercase tracking-widest text-gray-500 font-bold">Gallery Photos</p>
                    <h3 class="text-3xl font-serif text-[#1a2e2a] mt-2">{{ \App\Models\GalleryItem::count() ?? 0 }}</h3>
                </div>
            </div>

        </div>
    </div>
</x-admin-layout>