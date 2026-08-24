<x-admin-layout>
    <div class="min-h-screen bg-[#FAF9F6] py-10">
        <div class="w-full px-5 sm:px-8 lg:px-10 xl:px-12">
            <header class="mb-8">
                <span class="text-[10px] font-bold uppercase tracking-[0.25em] text-[#E67E22]">Website Configuration</span>
                <h1 class="mt-2 font-serif text-3xl text-[#1a2e2a]">Site Settings</h1>
                <p class="mt-2 text-sm text-gray-500">Update contact details shown throughout the public website.</p>
            </header>

            @if (session('success'))<div class="mb-6 border-l-4 border-green-600 bg-green-50 px-4 py-3 text-sm text-green-800">{{ session('success') }}</div>@endif
            @if ($errors->any())<div class="mb-6 border-l-4 border-red-600 bg-red-50 px-4 py-3 text-sm text-red-800">Please correct the highlighted fields.</div>@endif

            <form method="POST" action="{{ route('admin.settings.update') }}" class="max-w-5xl bg-white p-6 shadow-sm sm:p-8" x-data="{ submitting: false }" @submit="submitting = true">
                @csrf
                @method('PUT')
                <div class="grid gap-6 sm:grid-cols-2">
                    @foreach ([
                        ['phone_display', 'Phone Display', '055 2 256 500', 'How the phone number appears on the site'],
                        ['phone_link', 'Phone Link', '+94552256500', 'International format starting with + and country code'],
                        ['whatsapp_number', 'WhatsApp Number', '94704589764', 'Digits only, including country code'],
                        ['public_email', 'Public Email', 'contact@example.com', 'Displayed to website visitors'],
                        ['notification_email', 'Notification Email', 'inbox@example.com', 'Receives enquiries and WhatsApp alerts'],
                    ] as [$name, $label, $placeholder, $hint])
                        <div class="{{ $name === 'notification_email' ? 'sm:col-span-2' : '' }}">
                            <label for="{{ $name }}" class="mb-2 block text-[10px] font-bold uppercase tracking-widest text-gray-500">{{ $label }}</label>
                            <input id="{{ $name }}" name="{{ $name }}" type="{{ str_contains($name, 'email') ? 'email' : 'text' }}" value="{{ old($name, $settings->$name) }}" placeholder="{{ $placeholder }}" required class="w-full border-gray-200 text-sm focus:border-[#E67E22] focus:ring-[#E67E22]">
                            <p class="mt-1 text-xs text-gray-400">{{ $hint }}</p><x-input-error class="mt-2" :messages="$errors->get($name)" />
                        </div>
                    @endforeach
                    <div class="sm:col-span-2"><label for="address" class="mb-2 block text-[10px] font-bold uppercase tracking-widest text-gray-500">Hotel Address</label><textarea id="address" name="address" rows="3" required class="w-full border-gray-200 text-sm focus:border-[#E67E22] focus:ring-[#E67E22]">{{ old('address', $settings->address) }}</textarea><x-input-error class="mt-2" :messages="$errors->get('address')" /></div>
                    <div class="sm:col-span-2"><label for="map_url" class="mb-2 block text-[10px] font-bold uppercase tracking-widest text-gray-500">Google Maps Link</label><input id="map_url" name="map_url" type="url" value="{{ old('map_url', $settings->map_url) }}" required class="w-full border-gray-200 text-sm focus:border-[#E67E22] focus:ring-[#E67E22]"><x-input-error class="mt-2" :messages="$errors->get('map_url')" /></div>
                </div>
                <div class="mt-8 border-t border-gray-100 pt-6"><button :disabled="submitting" class="bg-[#1a2e2a] px-7 py-3 text-[10px] font-bold uppercase tracking-widest text-white transition hover:bg-[#E67E22] disabled:opacity-60" x-text="submitting ? 'Saving...' : 'Save Settings'">Save Settings</button></div>
            </form>
        </div>
    </div>
</x-admin-layout>
