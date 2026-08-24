<x-admin-layout>
    <div class="min-h-screen bg-[#FAF9F6] py-10">
        <div class="w-full px-5 sm:px-8 lg:px-10 xl:px-12">
            <div class="mb-8 flex flex-col justify-between gap-5 sm:flex-row sm:items-end">
                <div>
                    <a href="{{ route('admin.enquiries.index') }}" class="text-[10px] font-bold uppercase tracking-widest text-gray-500 hover:text-[#E67E22]">Back to Inbox</a>
                    <h1 class="mt-3 font-serif text-3xl text-[#1a2e2a]">Enquiry Trash</h1>
                </div>
                @if ($enquiries->isNotEmpty())
                    <form method="POST" action="{{ route('admin.enquiries.trash.empty') }}" class="flex gap-2" onsubmit="return confirm('Permanently delete every enquiry in Trash?')">
                        @csrf
                        @method('DELETE')
                        <input name="password" type="password" required placeholder="Current password" class="w-44 border-gray-200 text-sm focus:border-red-600 focus:ring-red-600">
                        <button class="bg-red-700 px-4 py-2 text-[10px] font-bold uppercase tracking-widest text-white">Empty Trash</button>
                    </form>
                @endif
            </div>

            @if ($errors->has('password'))<p class="mb-5 text-sm text-red-600">{{ $errors->first('password') }}</p>@endif
            @if (session('success'))<p class="mb-5 text-sm text-green-700">{{ session('success') }}</p>@endif

            <div class="space-y-3">
                @forelse ($enquiries as $enquiry)
                    <article class="flex flex-col justify-between gap-4 bg-white p-5 shadow-sm sm:flex-row sm:items-center">
                        <div>
                            <h2 class="font-serif text-lg text-[#1a2e2a]">{{ $enquiry->name }}</h2>
                            <p class="mt-1 text-xs text-gray-400">Deleted {{ $enquiry->deleted_at->diffForHumans() }}</p>
                        </div>
                        <div class="flex gap-4">
                            <form method="POST" action="{{ route('admin.enquiries.restore', $enquiry->id) }}">@csrf<button class="text-[10px] font-bold uppercase tracking-widest text-green-700">Restore</button></form>
                            <form method="POST" action="{{ route('admin.enquiries.force-destroy', $enquiry->id) }}" onsubmit="return confirm('Permanently delete this enquiry?')">@csrf @method('DELETE')<button class="text-[10px] font-bold uppercase tracking-widest text-red-600">Delete Forever</button></form>
                        </div>
                    </article>
                @empty
                    <div class="bg-white px-6 py-16 text-center text-sm text-gray-500">Trash is empty.</div>
                @endforelse
            </div>
            <div class="mt-8">{{ $enquiries->links() }}</div>
        </div>
    </div>
</x-admin-layout>
