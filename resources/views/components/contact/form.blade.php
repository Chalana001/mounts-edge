@props([
    'roomTypes' => [],
    'weddingHalls' => [],
    'weddingPackages' => [],
    'preselectedType' => '',
    'preselectedRoomType' => '',
    'preselectedHall' => '',
])

@php
    $labelClass = 'text-[11px] font-bold uppercase tracking-widest text-brand-green';
    $fieldClass = 'w-full bg-brand-light border border-brand-green/30 p-4 text-sm font-light focus:border-brand-orange focus:ring-0 transition-all outline-none';
    $selectClass = $fieldClass.' appearance-none cursor-pointer';
    $today = now()->format('Y-m-d');
@endphp

<section class="pt-6 pb-12 md:pt-10 md:pb-20 bg-brand-light relative">
    <div class="container mx-auto px-6 max-w-4xl">

        <div class="text-center mb-8 md:mb-10">
            <span class="text-[11px] tracking-[0.4em] uppercase text-brand-green/70 mb-2 block font-bold">Send a Message</span>
            <h2 class="text-3xl md:text-4xl font-serif text-brand-green mb-3">Make an Inquiry</h2>
            <p class="text-brand-green/70 font-light italic text-sm">Tell us what you need and we'll get back to you as soon as possible.</p>
        </div>

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
                <div class="space-y-1.5">
                    <label for="name" class="{{ $labelClass }}">Full Name *</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" placeholder="Your full name" required autocomplete="name" class="{{ $fieldClass }}">
                    <x-input-error :messages="$errors->get('name')" />
                </div>
                <div class="space-y-1.5">
                    <label for="email" class="{{ $labelClass }}">Email Address *</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="your@email.com" required autocomplete="email" inputmode="email" class="{{ $fieldClass }}">
                    <x-input-error :messages="$errors->get('email')" />
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="space-y-1.5">
                    <label for="phone" class="{{ $labelClass }}">Phone Number *</label>
                    <input id="phone" type="tel" name="phone" value="{{ old('phone') }}" placeholder="+94 77 123 4567" required autocomplete="tel" inputmode="tel" class="{{ $fieldClass }}">
                    <x-input-error :messages="$errors->get('phone')" />
                </div>
                <div class="space-y-1.5">
                    <label for="type" class="{{ $labelClass }}">Inquiry Type *</label>
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
                    <div class="space-y-1.5">
                        <label for="check_in" class="{{ $labelClass }}">Check-in *</label>
                        <input id="check_in" type="date" name="details[check_in]" value="{{ old('details.check_in') }}" min="{{ $today }}" class="{{ $fieldClass }}">
                        <x-input-error :messages="$errors->get('details.check_in')" />
                    </div>
                    <div class="space-y-1.5">
                        <label for="check_out" class="{{ $labelClass }}">Check-out *</label>
                        <input id="check_out" type="date" name="details[check_out]" value="{{ old('details.check_out') }}" min="{{ $today }}" class="{{ $fieldClass }}">
                        <x-input-error :messages="$errors->get('details.check_out')" />
                    </div>
                    <div class="space-y-1.5">
                        <label for="guests" class="{{ $labelClass }}">Guests *</label>
                        <input id="guests" type="number" name="details[guests]" value="{{ old('details.guests') }}" min="1" max="50" placeholder="e.g. 2" class="{{ $fieldClass }}">
                        <x-input-error :messages="$errors->get('details.guests')" />
                    </div>
                    <div class="space-y-1.5">
                        <label for="rooms" class="{{ $labelClass }}">Rooms</label>
                        <input id="rooms" type="number" name="details[rooms]" value="{{ old('details.rooms') }}" min="1" max="20" placeholder="e.g. 1" class="{{ $fieldClass }}">
                        <x-input-error :messages="$errors->get('details.rooms')" />
                    </div>
                </div>
                <div class="space-y-1.5">
                    <label for="room_type" class="{{ $labelClass }}">Preferred Room Type</label>
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
                <div class="space-y-1.5">
                    <label for="event_date" class="{{ $labelClass }}">Event Date *</label>
                    <input id="event_date" type="date" name="details[event_date]" value="{{ old('details.event_date') }}" min="{{ $today }}" class="{{ $fieldClass }}">
                    <x-input-error :messages="$errors->get('details.event_date')" />
                </div>
                <div class="space-y-1.5">
                    <label for="event_guests" class="{{ $labelClass }}">Guests *</label>
                    <input id="event_guests" type="number" name="details[event_guests]" value="{{ old('details.event_guests') }}" min="1" max="2000" placeholder="e.g. 250" class="{{ $fieldClass }}">
                    <x-input-error :messages="$errors->get('details.event_guests')" />
                </div>
                <div class="space-y-1.5">
                    <label for="hall" class="{{ $labelClass }}">Preferred Hall</label>
                    <select id="hall" name="details[hall]" class="{{ $selectClass }}">
                        <option value="">No preference / not sure yet</option>
                        @foreach ($weddingHalls as $hall)
                            <option value="{{ $hall->name }}" @selected(old('details.hall', $preselectedHall) === $hall->name)>{{ $hall->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('details.hall')" />
                </div>
                <div class="space-y-1.5">
                    <label for="package" class="{{ $labelClass }}">Preferred Package</label>
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
                <div class="space-y-1.5">
                    <label for="dining_date" class="{{ $labelClass }}">Date *</label>
                    <input id="dining_date" type="date" name="details[dining_date]" value="{{ old('details.dining_date') }}" min="{{ $today }}" class="{{ $fieldClass }}">
                    <x-input-error :messages="$errors->get('details.dining_date')" />
                </div>
                <div class="space-y-1.5">
                    <label for="dining_time" class="{{ $labelClass }}">Time *</label>
                    <input id="dining_time" type="time" name="details[dining_time]" value="{{ old('details.dining_time') }}" class="{{ $fieldClass }}">
                    <x-input-error :messages="$errors->get('details.dining_time')" />
                </div>
                <div class="space-y-1.5">
                    <label for="party_size" class="{{ $labelClass }}">How Many People *</label>
                    <input id="party_size" type="number" name="details[party_size]" value="{{ old('details.party_size') }}" min="1" max="100" placeholder="e.g. 4" class="{{ $fieldClass }}">
                    <x-input-error :messages="$errors->get('details.party_size')" />
                </div>
            </div>

            <div class="space-y-1.5">
                <label for="message" class="{{ $labelClass }}">
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
