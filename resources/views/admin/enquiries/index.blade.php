<x-admin-layout>
    <div class="min-h-screen bg-[#FAF9F6] py-10">
        <div class="w-full px-5 sm:px-8 lg:px-10 xl:px-12">
            <div class="mb-8 flex items-end justify-between gap-5">
                <div>
                    <span class="text-[10px] font-bold uppercase tracking-[0.25em] text-[#E67E22]">Guest Relations</span>
                    <h1 class="mt-2 font-serif text-3xl text-[#1a2e2a]">Enquiry Inbox</h1>
                </div>
                <a href="{{ route('admin.enquiries.trash') }}" class="text-[10px] font-bold uppercase tracking-widest text-gray-500 hover:text-[#E67E22]">View Trash</a>
            </div>

            @if (session('success'))
                <div class="mb-6 border-l-4 border-green-600 bg-green-50 px-4 py-3 text-sm text-green-800">{{ session('success') }}</div>
            @endif

            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                @forelse ($enquiries as $enquiry)
                    <article class="border-t-4 {{ $enquiry->status === 'new' ? 'border-[#E67E22]' : 'border-[#1a2e2a]/20' }} bg-white p-5 shadow-sm">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <span class="text-[9px] font-bold uppercase tracking-widest text-gray-400">{{ $enquiry->type }}</span>
                                <h2 class="mt-2 font-serif text-xl text-[#1a2e2a]">{{ $enquiry->name }}</h2>
                            </div>
                            <span class="rounded-full px-3 py-1 text-[9px] font-bold uppercase tracking-widest {{ $enquiry->status === 'new' ? 'bg-orange-50 text-[#E67E22]' : 'bg-gray-100 text-gray-600' }}">{{ $enquiry->status }}</span>
                        </div>
                        @if ($enquiry->detail_summary)
                            <p class="mt-3 text-xs font-bold text-[#1a2e2a]">{{ $enquiry->detail_summary }}</p>
                        @endif
                        <p class="mt-4 text-xs text-gray-400">Received {{ $enquiry->created_at->diffForHumans() }}</p>
                        @if ($enquiry->email_notification_failed)
                            <p class="mt-3 text-xs font-bold text-red-600">Email notification failed</p>
                        @endif
                        <div class="mt-5 flex items-center justify-between border-t border-gray-100 pt-4">
                            <form method="POST" action="{{ route('admin.enquiries.status', $enquiry) }}">
                                @csrf
                                @method('PATCH')
                                <select name="status" onchange="this.form.submit()" class="border-gray-200 py-1 text-xs focus:border-[#E67E22] focus:ring-[#E67E22]">
                                    @foreach (\App\Models\Enquiry::STATUSES as $status)
                                        <option value="{{ $status }}" @selected($enquiry->status === $status)>{{ ucfirst($status) }}</option>
                                    @endforeach
                                </select>
                            </form>
                            <a href="{{ route('admin.enquiries.show', $enquiry) }}" class="text-[10px] font-bold uppercase tracking-widest text-[#1a2e2a] hover:text-[#E67E22]">View Details</a>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full bg-white px-6 py-16 text-center text-sm text-gray-500">No enquiries yet.</div>
                @endforelse
            </div>

            <div class="mt-8">{{ $enquiries->links() }}</div>
        </div>
    </div>
</x-admin-layout>
