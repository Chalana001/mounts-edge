<section class="bg-white p-6 shadow-sm sm:p-8">
    <header class="border-b border-gray-100 pb-5"><span class="text-[9px] font-bold uppercase tracking-[0.22em] text-[#E67E22]">Security</span><h2 class="mt-2 font-serif text-2xl text-[#1a2e2a]">Update Password</h2><p class="mt-2 text-sm font-light text-gray-500">Use a strong password that is unique to this account.</p></header>
    <form method="POST" action="{{ route('password.update') }}" class="mt-6 space-y-5" x-data="{ submitting: false, current: false, next: false, confirm: false }" @submit="submitting = true">
        @csrf
        @method('PUT')
        @foreach ([['current_password', 'Current Password', 'current'], ['password', 'New Password', 'next'], ['password_confirmation', 'Confirm New Password', 'confirm']] as [$name, $label, $visibility])
            <div><label for="{{ $name }}" class="mb-2 block text-[10px] font-bold uppercase tracking-widest text-gray-500">{{ $label }}</label><div class="relative"><input id="{{ $name }}" name="{{ $name }}" :type="{{ $visibility }} ? 'text' : 'password'" required autocomplete="{{ $name === 'current_password' ? 'current-password' : 'new-password' }}" class="w-full border-gray-200 pr-16 text-sm focus:border-[#E67E22] focus:ring-[#E67E22]"><button type="button" @click="{{ $visibility }} = !{{ $visibility }}" class="absolute inset-y-0 right-0 px-4 text-[9px] font-bold uppercase tracking-widest text-gray-400" x-text="{{ $visibility }} ? 'Hide' : 'Show'">Show</button></div><x-input-error :messages="$errors->updatePassword->get($name)" class="mt-2" /></div>
        @endforeach
        <div class="flex items-center gap-4 pt-2"><button :disabled="submitting" class="bg-[#1a2e2a] px-6 py-3 text-[10px] font-bold uppercase tracking-widest text-white transition hover:bg-[#E67E22] disabled:opacity-60" x-text="submitting ? 'Updating...' : 'Update Password'">Update Password</button>@if(session('status') === 'password-updated')<span class="text-sm text-green-700" x-data x-init="setTimeout(() => $el.remove(), 3000)">Password updated.</span>@endif</div>
    </form>
</section>
