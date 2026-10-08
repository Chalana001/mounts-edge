@props([
    'roomTypes' => [],
    'weddingHalls' => [],
    'weddingPackages' => [],
    'preselectedType' => '',
    'preselectedRoomType' => '',
    'preselectedHall' => '',
])

@php
    $fieldClass = 'w-full bg-brand-light border border-brand-green/30 p-4 text-sm font-light focus:border-brand-orange focus:ring-0 transition-all outline-none';
    $selectClass = $fieldClass.' appearance-none cursor-pointer';
    $today = now()->format('Y-m-d');
@endphp

<section class="pt-6 pb-12 md:pt-10 md:pb-20 bg-brand-light relative">
    <div class="container mx-auto px-6 max-w-4xl">

        <x-section-heading
            eyebrow="Send a Message"
            title="Make an Inquiry"
            intro="Tell us what you need and we'll get back to you as soon as possible." />

        @if(session('success'))
            <div class="bg-brand-green text-brand-light px-4 py-4 rounded mb-6 text-sm text-center tracking-widest font-bold shadow-md">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 border-l-4 border-red-600 bg-red-50 px-4 py-3 text-sm text-red-700">Please check the highlighted fields and try again.</div>
        @endif

        <form action="{{ route('enquiry.send') }}" method="POST" class="space-y-5"
              x-data="{ type: @js(old('type', $preselectedType)), submitting: false }"
              @submit="submitting = true">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <x-form-field label="Full Name" name="name" type="text" :value="old('name')" placeholder="Your full name" required autocomplete="name" :error="$errors->get('name')" />
                <x-form-field label="Email Address" name="email" type="email" :value="old('email')" placeholder="your@email.com" required autocomplete="email" inputmode="email" :error="$errors->get('email')" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <x-form-field label="Phone Number" name="phone" type="tel" :value="old('phone')" placeholder="+94 77 123 4567" required autocomplete="tel" inputmode="tel" :error="$errors->get('phone')" />
                <div class="space-y-1.5">
                    <label for="type" class="text-[11px] font-bold uppercase tracking-widest text-brand-green">Inquiry Type *</label>
                    <select id="type" name="type" x-model="type" required class="{{ $selectClass }}">
                        <option value="">Select inquiry type</option>
                        @foreach (\App\Models\Enquiry::TYPES as $enquiryType)
                            <option value="{{ $enquiryType }}">{{ $enquiryType }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('type')" />
                </div>
            </div>

            {{-- Room Booking --}}
            <div x-show="type === @js(\App\Models\Enquiry::TYPE_ROOM)" x-cloak class="space-y-5">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-5">
                    <x-form-field label="Check-in" name="details[check_in]" type="date" :value="old('details.check_in')" :min="$today" :error="$errors->get('details.check_in')" />
                    <x-form-field label="Check-out" name="details[check_out]" type="date" :value="old('details.check_out')" :min="$today" :error="$errors->get('details.check_out')" />
                    <x-form-field label="Guests" name="details[guests]" type="number" :value="old('details.guests')" min="1" max="50" placeholder="e.g. 2" :error="$errors->get('details.guests')" />
                    <x-form-field label="Rooms" name="details[rooms]" type="number" :value="old('details.rooms')" min="1" max="20" placeholder="e.g. 1" :error="$errors->get('details.rooms')" />
                </div>
                <div class="space-y-1.5">
                    <label for="room_type" class="text-[11px] font-bold uppercase tracking-widest text-brand-green">Preferred Room Type</label>
                    <select id="room_type" name="details[room_type]" class="{{ $selectClass }}">
                        <option value="">No preference / not sure yet</option>
                        @foreach ($roomTypes as $roomType)
                            <option value="{{ $roomType->name }}" @selected(old('details.room_type', $preselectedRoomType) === $roomType->name)>{{ $roomType->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('details.room_type')" />
                </div>
            </div>

            {{-- Wedding Inquiry --}}
            <div x-show="type === @js(\App\Models\Enquiry::TYPE_WEDDING)" x-cloak class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-5">
                <x-form-field label="Event Date" name="details[event_date]" type="date" :value="old('details.event_date')" :min="$today" :error="$errors->get('details.event_date')" />
                <x-form-field label="Guests" name="details[event_guests]" type="number" :value="old('details.event_guests')" min="1" max="2000" placeholder="e.g. 250" :error="$errors->get('details.event_guests')" />
                <div class="space-y-1.5">
                    <label for="hall" class="text-[11px] font-bold uppercase tracking-widest text-brand-green">Preferred Hall</label>
                    <select id="hall" name="details[hall]" class="{{ $selectClass }}">
                        <option value="">No preference / not sure yet</option>
                        @foreach ($weddingHalls as $hall)
                            <option value="{{ $hall->name }}" @selected(old('details.hall', $preselectedHall) === $hall->name)>{{ $hall->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('details.hall')" />
                </div>
                <div class="space-y-1.5">
                    <label for="package" class="text-[11px] font-bold uppercase tracking-widest text-brand-green">Preferred Package</label>
                    <select id="package" name="details[package]" class="{{ $selectClass }}">
                        <option value="">No preference / not sure yet</option>
                        @foreach ($weddingPackages as $package)
                            <option value="{{ $package->name }}" @selected(old('details.package') === $package->name)>{{ $package->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('details.package')" />
                </div>
            </div>

            {{-- Dining Reservation --}}
            <div x-show="type === @js(\App\Models\Enquiry::TYPE_DINING)" x-cloak class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <x-form-field label="Date" name="details[dining_date]" type="date" :value="old('details.dining_date')" :min="$today" :error="$errors->get('details.dining_date')" />
                <x-form-field label="Time" name="details[dining_time]" type="time" :value="old('details.dining_time')" :error="$errors->get('details.dining_time')" />
                <x-form-field label="How Many People" name="details[party_size]" type="number" :value="old('details.party_size')" min="1" max="100" placeholder="e.g. 4" :error="$errors->get('details.party_size')" />
            </div>

            <div class="space-y-1.5">
                <label for="message" class="text-[11px] font-bold uppercase tracking-widest text-brand-green">
                    <span x-show="type === @js(\App\Models\Enquiry::TYPE_GENERAL) || type === ''">Message *</span>
                    <span x-show="type !== @js(\App\Models\Enquiry::TYPE_GENERAL) && type !== ''" x-cloak>Additional Notes</span>
                </label>
                <textarea id="message" name="message"
                          :rows="type === @js(\App\Models\Enquiry::TYPE_GENERAL) || type === '' ? 5 : 3"
                          placeholder="Anything else we should know?" class="{{ $fieldClass }} resize-none">{{ old('message') }}</textarea>
                <x-input-error :messages="$errors->get('message')" />
            </div>

            <div class="text-center pt-2">
                <button type="submit" :disabled="submitting" class="w-full md:w-auto bg-brand-green text-brand-light hover:bg-brand-hover disabled:cursor-wait disabled:opacity-60 px-16 py-4 text-[11px] tracking-[0.2em] uppercase font-bold transition-all duration-500 shadow-xl">
                    <span x-text="submitting ? 'Sending...' : 'Send Message'">Send Message</span>
                </button>
            </div>
        </form>
    </div>

</section>
