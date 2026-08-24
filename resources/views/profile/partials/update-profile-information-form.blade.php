<section class="bg-white p-6 shadow-sm sm:p-8">
    <header class="border-b border-gray-100 pb-5">
        <span class="text-[9px] font-bold uppercase tracking-[0.22em] text-[#E67E22]">Personal Details</span>
        <h2 class="mt-2 font-serif text-2xl text-[#1a2e2a]">Profile Information</h2>
        <p class="mt-2 text-sm font-light text-gray-500">Update the name and email used for your admin account.</p>
    </header>

    <form method="POST" action="{{ route('profile.update') }}" class="mt-6 space-y-5" x-data="{ submitting: false, showPassword: false }" @submit="submitting = true">
        @csrf
        @method('PATCH')
        <div><label for="name" class="mb-2 block text-[10px] font-bold uppercase tracking-widest text-gray-500">Name</label><input id="name" name="name" value="{{ old('name', $user->name) }}" required autocomplete="name" class="w-full border-gray-200 text-sm focus:border-[#E67E22] focus:ring-[#E67E22]"><x-input-error class="mt-2" :messages="$errors->get('name')" /></div>
        <div><label for="email" class="mb-2 block text-[10px] font-bold uppercase tracking-widest text-gray-500">Email</label><input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="username" class="w-full border-gray-200 text-sm focus:border-[#E67E22] focus:ring-[#E67E22]"><x-input-error class="mt-2" :messages="$errors->get('email')" /></div>
        <div>
            <label for="profile_current_password" class="mb-2 block text-[10px] font-bold uppercase tracking-widest text-gray-500">Current Password <span class="font-normal normal-case tracking-normal text-gray-400">(required when changing email)</span></label>
            <div class="relative"><input id="profile_current_password" name="current_password" :type="showPassword ? 'text' : 'password'" autocomplete="current-password" class="w-full border-gray-200 pr-16 text-sm focus:border-[#E67E22] focus:ring-[#E67E22]"><button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 px-4 text-[9px] font-bold uppercase tracking-widest text-gray-400" x-text="showPassword ? 'Hide' : 'Show'">Show</button></div>
            <x-input-error class="mt-2" :messages="$errors->get('current_password')" />
        </div>
        <div class="flex items-center gap-4 pt-2"><button :disabled="submitting" class="bg-[#1a2e2a] px-6 py-3 text-[10px] font-bold uppercase tracking-widest text-white transition hover:bg-[#E67E22] disabled:opacity-60" x-text="submitting ? 'Saving...' : 'Save Changes'">Save Changes</button>@if(session('status') === 'profile-updated')<span class="text-sm text-green-700" x-data x-init="setTimeout(() => $el.remove(), 3000)">Profile saved.</span>@endif</div>
    </form>
</section>
