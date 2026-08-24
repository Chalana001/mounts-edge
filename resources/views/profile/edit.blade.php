<x-admin-layout>
    <div class="min-h-screen bg-[#FAF9F6] py-10">
        <div class="w-full px-5 sm:px-8 lg:px-10 xl:px-12">
            <header class="mb-8">
                <span class="text-[10px] font-bold uppercase tracking-[0.25em] text-[#E67E22]">Account Settings</span>
                <h1 class="mt-2 font-serif text-3xl text-[#1a2e2a]">My Profile</h1>
                <p class="mt-2 text-sm text-gray-500">Manage your personal details and secure your administrator account.</p>
            </header>

            <div class="grid gap-8 lg:grid-cols-2 lg:items-start">
                @include('profile.partials.update-profile-information-form')
                @include('profile.partials.update-password-form')
            </div>
        </div>
    </div>
</x-admin-layout>
