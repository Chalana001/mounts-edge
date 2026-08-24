<x-admin-layout>
    <div class="min-h-screen bg-[#FAF9F6] py-10">
        <div class="w-full px-5 sm:px-8 lg:px-10 xl:px-12">
            <div class="mb-8">
                <span class="text-[10px] font-bold uppercase tracking-[0.25em] text-[#E67E22]">Access Control</span>
                <h1 class="mt-2 font-serif text-3xl text-[#1a2e2a]">Admin Accounts</h1>
                <p class="mt-2 text-sm text-gray-500">Create accounts, reset passwords and remove access.</p>
            </div>

            @if (session('success'))
                <div class="mb-6 border-l-4 border-green-600 bg-green-50 px-4 py-3 text-sm text-green-800">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="mb-6 border-l-4 border-red-600 bg-red-50 px-4 py-3 text-sm text-red-800">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <div class="grid gap-8 lg:grid-cols-[360px_1fr]">
                <section class="h-fit bg-white p-6 shadow-sm">
                    <h2 class="mb-6 font-serif text-xl text-[#1a2e2a]">Create New Admin</h2>
                    <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-5">
                        @csrf
                        <div>
                            <label for="name" class="mb-2 block text-[10px] font-bold uppercase tracking-widest text-gray-500">Name</label>
                            <input id="name" name="name" value="{{ old('name') }}" required class="w-full border-gray-200 text-sm focus:border-[#E67E22] focus:ring-[#E67E22]">
                        </div>
                        <div>
                            <label for="email" class="mb-2 block text-[10px] font-bold uppercase tracking-widest text-gray-500">Email</label>
                            <input id="email" name="email" type="email" value="{{ old('email') }}" required class="w-full border-gray-200 text-sm focus:border-[#E67E22] focus:ring-[#E67E22]">
                        </div>
                        <div>
                            <label for="password" class="mb-2 block text-[10px] font-bold uppercase tracking-widest text-gray-500">Password</label>
                            <input id="password" name="password" type="password" required autocomplete="new-password" class="w-full border-gray-200 text-sm focus:border-[#E67E22] focus:ring-[#E67E22]">
                        </div>
                        <div>
                            <label for="password_confirmation" class="mb-2 block text-[10px] font-bold uppercase tracking-widest text-gray-500">Confirm Password</label>
                            <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password" class="w-full border-gray-200 text-sm focus:border-[#E67E22] focus:ring-[#E67E22]">
                        </div>
                        <div><label for="create_current_password" class="mb-2 block text-[10px] font-bold uppercase tracking-widest text-gray-500">Your Current Password</label><input id="create_current_password" name="current_password" type="password" required autocomplete="current-password" class="w-full border-gray-200 text-sm focus:border-[#E67E22] focus:ring-[#E67E22]"></div>
                        <button class="w-full bg-[#1a2e2a] px-5 py-3 text-[10px] font-bold uppercase tracking-widest text-white transition hover:bg-[#E67E22]">Create Account</button>
                    </form>
                </section>

                <section class="space-y-4">
                    @foreach ($users as $user)
                        <article class="bg-white p-5 shadow-sm sm:p-6">
                            <div class="flex flex-col justify-between gap-5 sm:flex-row sm:items-center">
                                <div>
                                    <div class="flex items-center gap-3">
                                        <h2 class="font-serif text-xl text-[#1a2e2a]">{{ $user->name }}</h2>
                                        @if (auth()->user()->is($user))
                                            <span class="bg-[#1a2e2a]/5 px-2 py-1 text-[9px] font-bold uppercase tracking-widest text-[#1a2e2a]">You</span>
                                        @endif
                                    </div>
                                    <p class="mt-1 text-sm text-gray-500">{{ $user->email }}</p>
                                </div>

                                @php $isSelf = auth()->user()->is($user); @endphp
                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('{{ $isSelf ? 'This will permanently delete YOUR OWN account and log you out immediately. Continue?' : 'Remove this admin account?' }}')">
                                    @csrf
                                    @method('DELETE')
                                    <input name="current_password" type="password" required autocomplete="current-password" placeholder="Your password" aria-label="Your password to confirm deleting {{ $user->name }}" class="mr-3 w-36 border-gray-200 py-2 text-xs focus:border-red-600 focus:ring-red-600">
                                    <button class="text-[10px] font-bold uppercase tracking-widest text-red-600 transition hover:text-red-800">Delete Account</button>
                                </form>
                            </div>

                            <form method="POST" action="{{ route('admin.users.password.update', $user) }}" class="mt-5 grid gap-3 border-t border-gray-100 pt-5 sm:grid-cols-2 xl:grid-cols-[1fr_1fr_1fr_auto]">
                                @csrf
                                @method('PUT')
                                <input name="password" type="password" required autocomplete="new-password" placeholder="New password" aria-label="New password for {{ $user->name }}" class="border-gray-200 text-sm focus:border-[#E67E22] focus:ring-[#E67E22]">
                                <input name="password_confirmation" type="password" required autocomplete="new-password" placeholder="Confirm password" aria-label="Confirm new password for {{ $user->name }}" class="border-gray-200 text-sm focus:border-[#E67E22] focus:ring-[#E67E22]">
                                <input name="current_password" type="password" required autocomplete="current-password" placeholder="Your current password" aria-label="Your current password" class="border-gray-200 text-sm focus:border-[#E67E22] focus:ring-[#E67E22]">
                                <button class="bg-[#1a2e2a] px-5 py-3 text-[10px] font-bold uppercase tracking-widest text-white transition hover:bg-[#E67E22]">Change Password</button>
                            </form>
                        </article>
                    @endforeach

                    <div class="mt-6">{{ $users->links() }}</div>
                </section>
            </div>
        </div>
    </div>
</x-admin-layout>
