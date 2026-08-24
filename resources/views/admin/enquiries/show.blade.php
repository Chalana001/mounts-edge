<x-admin-layout>
    @php
        $whatsappPhone = preg_replace('/\D+/', '', $enquiry->phone);
        $whatsappMessage = rawurlencode("Hello {$enquiry->name}, we are following up on your {$enquiry->type} enquiry to Mounts Edge Regency.");
    @endphp
    <div class="min-h-screen bg-[#FAF9F6] py-10">
        <div class="w-full px-5 sm:px-8 lg:px-10 xl:px-12">
            <a href="{{ route('admin.enquiries.index') }}" class="text-[10px] font-bold uppercase tracking-widest text-gray-500 hover:text-[#E67E22]">Back to Inbox</a>
            <article class="mt-6 max-w-5xl bg-white p-6 shadow-sm sm:p-10">
                <div class="flex flex-col justify-between gap-5 border-b border-gray-100 pb-7 sm:flex-row sm:items-start">
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#E67E22]">{{ $enquiry->type }}</span>
                        <h1 class="mt-2 font-serif text-3xl text-[#1a2e2a]">{{ $enquiry->name }}</h1>
                        <p class="mt-2 text-xs text-gray-400">Received {{ $enquiry->created_at->format('M j, Y \a\t g:i A') }}</p>
                    </div>
                    <form method="POST" action="{{ route('admin.enquiries.status', $enquiry) }}">
                        @csrf
                        @method('PATCH')
                        <select name="status" onchange="this.form.submit()" class="border-gray-200 text-sm focus:border-[#E67E22] focus:ring-[#E67E22]">
                            @foreach (\App\Models\Enquiry::STATUSES as $status)
                                <option value="{{ $status }}" @selected($enquiry->status === $status)>{{ ucfirst($status) }}</option>
                            @endforeach
                        </select>
                    </form>
                </div>

                @if ($enquiry->email_notification_failed)
                    <div class="mt-6 border-l-4 border-red-600 bg-red-50 px-4 py-3 text-sm text-red-700">Email notification failed</div>
                @endif

                <div class="mt-8 grid gap-5 sm:grid-cols-2">
                    <div><span class="block text-[9px] font-bold uppercase tracking-widest text-gray-400">Email</span><a href="mailto:{{ $enquiry->email }}" class="mt-2 block text-sm text-[#1a2e2a] hover:text-[#E67E22]">{{ $enquiry->email }}</a></div>
                    <div><span class="block text-[9px] font-bold uppercase tracking-widest text-gray-400">Phone</span><a href="tel:{{ $enquiry->phone }}" class="mt-2 block text-sm text-[#1a2e2a] hover:text-[#E67E22]">{{ $enquiry->phone }}</a></div>
                </div>

                @if (! empty($enquiry->formatted_details))
                    <div class="mt-8 border-t border-gray-100 pt-8">
                        <span class="block text-[9px] font-bold uppercase tracking-widest text-[#E67E22]">Enquiry Details</span>
                        <div class="mt-4 grid gap-5 sm:grid-cols-2">
                            @foreach ($enquiry->formatted_details as $label => $value)
                                <div>
                                    <span class="block text-[9px] font-bold uppercase tracking-widest text-gray-400">{{ $label }}</span>
                                    <span class="mt-2 block text-sm text-[#1a2e2a]">{{ $value }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if (filled($enquiry->message))
                    <div class="mt-8">
                        <span class="block text-[9px] font-bold uppercase tracking-widest text-gray-400">Message</span>
                        <p class="mt-3 whitespace-pre-line text-sm font-light leading-7 text-gray-700">{{ $enquiry->message }}</p>
                    </div>
                @endif

                <div class="mt-10 flex flex-wrap gap-3 border-t border-gray-100 pt-6">
                    <a href="mailto:{{ $enquiry->email }}" class="bg-[#1a2e2a] px-5 py-3 text-[10px] font-bold uppercase tracking-widest text-white hover:bg-[#E67E22]">Email</a>
                    <a href="tel:{{ $enquiry->phone }}" class="border border-[#1a2e2a] px-5 py-3 text-[10px] font-bold uppercase tracking-widest text-[#1a2e2a] hover:border-[#E67E22] hover:text-[#E67E22]">Call</a>
                    <a href="https://wa.me/{{ $whatsappPhone }}?text={{ $whatsappMessage }}" target="_blank" rel="noopener noreferrer" class="border border-[#1a2e2a] px-5 py-3 text-[10px] font-bold uppercase tracking-widest text-[#1a2e2a] hover:border-[#25D366] hover:text-[#25D366]">WhatsApp</a>
                    <form method="POST" action="{{ route('admin.enquiries.destroy', $enquiry) }}" class="sm:ml-auto" onsubmit="return confirm('Move this enquiry to Trash?')">
                        @csrf
                        @method('DELETE')
                        <button class="px-5 py-3 text-[10px] font-bold uppercase tracking-widest text-red-600 hover:text-red-800">Move to Trash</button>
                    </form>
                </div>
            </article>
        </div>
    </div>
</x-admin-layout>
