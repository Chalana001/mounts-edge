@php
    $newEnquiryCount = \App\Models\Enquiry::where('status', \App\Models\Enquiry::STATUS_NEW)->count();
    $navigation = [
        ['label' => 'Dashboard', 'route' => 'dashboard', 'active' => 'dashboard', 'icon' => 'M3 12l9-9 9 9M5 10v10h14V10M9 20v-6h6v6'],
        ['label' => 'Rooms', 'route' => 'admin.rooms.index', 'active' => 'admin.rooms.*', 'icon' => 'M4 19v-8h16v8M4 15h16M7 11V7h10v4M7 19v2m10-2v2'],
        ['label' => 'Weddings', 'route' => 'admin.weddings.index', 'active' => 'admin.weddings.*', 'icon' => 'M12 21s-7-4.35-9.33-8.46C.5 8.7 2.42 5 6.1 5A5.2 5.2 0 0112 8.09 5.2 5.2 0 0117.9 5c3.68 0 5.6 3.7 3.43 7.54C19 16.65 12 21 12 21z'],
        ['label' => 'Gallery', 'route' => 'admin.gallery.index', 'active' => 'admin.gallery.*', 'icon' => 'M4 5h16v14H4zM4 16l4-4 3 3 3-4 6 6M8 9h.01'],
        ['label' => 'Enquiries', 'route' => 'admin.enquiries.index', 'active' => 'admin.enquiries.*', 'icon' => 'M4 5h16v12H7l-3 3V5zm3 4h10M7 13h6', 'badge' => $newEnquiryCount],
    ];
    $accountNavigation = [
        ['label' => 'Admin Accounts', 'route' => 'admin.users.index', 'active' => 'admin.users.*', 'icon' => 'M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2M9 11a4 4 0 100-8 4 4 0 000 8zm7-3a4 4 0 010 7.75M22 21v-2a4 4 0 00-3-3.87'],
        ['label' => 'My Profile', 'route' => 'profile.edit', 'active' => 'profile.*', 'icon' => 'M20 21a8 8 0 10-16 0m8-7a5 5 0 100-10 5 5 0 000 10z'],
        ['label' => 'Site Settings', 'route' => 'admin.settings.edit', 'active' => 'admin.settings.*', 'icon' => 'M12 15.5a3.5 3.5 0 100-7 3.5 3.5 0 000 7zm7.4-3.5a7.7 7.7 0 00-.1-1l2-1.5-2-3.5-2.4 1a8.7 8.7 0 00-1.7-1L15 3.5h-4L10.7 6a8.7 8.7 0 00-1.7 1L6.6 6l-2 3.5 2 1.5a7.7 7.7 0 000 2L4.6 14.5l2 3.5 2.4-1a8.7 8.7 0 001.7 1l.3 2.5h4l.3-2.5a8.7 8.7 0 001.7-1l2.4 1 2-3.5-2-1.5a7.7 7.7 0 00.1-1z'],
    ];
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Administration - Mounts Edge Regency</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#FAF9F6] font-sans text-gray-900 antialiased">
    <div x-data="{ menuOpen: false }" x-effect="document.body.style.overflow = menuOpen ? 'hidden' : ''" @keydown.escape.window="menuOpen = false" class="min-h-screen lg:pl-72">
        <aside class="fixed inset-y-0 left-0 z-40 hidden w-72 flex-col bg-[#1a2e2a] text-white lg:flex">
            <a href="{{ route('dashboard') }}" class="border-b border-white/10 px-8 py-8">
                <span class="block font-serif text-xl tracking-wide">Mounts Edge Regency</span>
                <span class="mt-2 block text-[9px] font-bold uppercase tracking-[0.32em] text-[#E67E22]">Administration</span>
            </a>

            <nav class="flex-1 space-y-1 overflow-y-auto px-4 py-7">
                @foreach ($navigation as $item)
                    <a href="{{ route($item['route']) }}" class="relative flex items-center gap-4 border-l-2 px-5 py-3 text-sm transition {{ request()->routeIs($item['active']) ? 'border-[#E67E22] bg-white/10 text-white' : 'border-transparent text-white/60 hover:bg-white/5 hover:text-white' }}">
                        <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $item['icon'] }}" /></svg>
                        <span>{{ $item['label'] }}</span>
                        @if (($item['badge'] ?? 0) > 0)
                            <span class="ml-auto min-w-6 rounded-full bg-[#E67E22] px-2 py-0.5 text-center text-[9px] font-bold text-white">{{ $item['badge'] > 99 ? '99+' : $item['badge'] }}</span>
                        @endif
                    </a>
                @endforeach

                <div class="my-6 border-t border-white/10"></div>

                @foreach ($accountNavigation as $item)
                    <a href="{{ route($item['route']) }}" class="flex items-center gap-4 border-l-2 px-5 py-3 text-sm transition {{ request()->routeIs($item['active']) ? 'border-[#E67E22] bg-white/10 text-white' : 'border-transparent text-white/60 hover:bg-white/5 hover:text-white' }}">
                        <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $item['icon'] }}" /></svg>
                        <span>{{ $item['label'] }}</span>
                    </a>
                @endforeach

                <a href="/" target="_blank" rel="noopener noreferrer" class="flex items-center gap-4 border-l-2 border-transparent px-5 py-3 text-sm text-white/60 transition hover:bg-white/5 hover:text-white">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14 3h7v7m0-7L10 14M5 7v14h14v-5" /></svg>
                    <span>View Live Site</span>
                </a>
            </nav>

            <div class="border-t border-white/10 p-6">
                <p class="truncate text-sm font-bold">{{ auth()->user()->name }}</p>
                <p class="mt-1 truncate text-xs text-white/70">{{ auth()->user()->email }}</p>
                <form method="POST" action="{{ route('logout') }}" class="mt-4">@csrf<button class="text-[10px] font-bold uppercase tracking-widest text-white/80 transition hover:text-[#E67E22]">Log out</button></form>
            </div>
        </aside>

        <header class="sticky top-0 z-30 flex h-16 items-center justify-between border-b border-[#1a2e2a]/10 bg-[#FAF9F6]/95 px-5 backdrop-blur lg:hidden">
            <button @click="menuOpen = true" class="p-2 text-[#1a2e2a]" aria-label="Open navigation"><svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16" /></svg></button>
            <a href="{{ route('dashboard') }}" class="font-serif text-lg text-[#1a2e2a]">Mounts Edge</a>
            <a href="{{ route('admin.enquiries.index') }}" class="relative p-2 text-[#1a2e2a]" aria-label="Enquiries"><svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 5h16v12H7l-3 3V5z" /></svg>@if($newEnquiryCount > 0)<span class="absolute right-0 top-0 min-w-5 rounded-full bg-[#E67E22] px-1 text-center text-[8px] font-bold text-white">{{ $newEnquiryCount > 99 ? '99+' : $newEnquiryCount }}</span>@endif</a>
        </header>

        <div x-cloak x-show="menuOpen" x-transition.opacity @click="menuOpen = false" class="fixed inset-0 z-40 bg-black/50 lg:hidden"></div>
        <aside x-cloak x-show="menuOpen" role="dialog" aria-modal="true" aria-label="Admin navigation" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" class="fixed inset-y-0 left-0 z-50 flex w-[85%] max-w-xs flex-col bg-[#1a2e2a] text-white lg:hidden">
            <div class="flex items-start justify-between border-b border-white/10 p-6"><a href="{{ route('dashboard') }}" @click="menuOpen = false"><span class="block font-serif text-lg">Mounts Edge Regency</span><span class="mt-1 block text-[8px] font-bold uppercase tracking-[0.3em] text-[#E67E22]">Administration</span></a><button @click="menuOpen = false" class="p-2" aria-label="Close navigation"><svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-width="1.5" d="M6 6l12 12M18 6L6 18" /></svg></button></div>
            <nav class="flex-1 space-y-1 overflow-y-auto p-4">
                @foreach (array_merge($navigation, $accountNavigation) as $item)
                    <a href="{{ route($item['route']) }}" @click="menuOpen = false" class="flex items-center gap-4 border-l-2 px-4 py-3 text-sm {{ request()->routeIs($item['active']) ? 'border-[#E67E22] bg-white/10 text-white' : 'border-transparent text-white/60' }}"><svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $item['icon'] }}" /></svg><span>{{ $item['label'] }}</span>@if (($item['badge'] ?? 0) > 0)<span class="ml-auto rounded-full bg-[#E67E22] px-2 py-0.5 text-[9px]">{{ $item['badge'] > 99 ? '99+' : $item['badge'] }}</span>@endif</a>
                @endforeach
                <a href="/" target="_blank" rel="noopener noreferrer" @click="menuOpen = false" class="flex items-center gap-4 border-l-2 border-transparent px-4 py-3 text-sm text-white/60"><svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14 3h7v7m0-7L10 14M5 7v14h14v-5" /></svg>View Live Site</a>
            </nav>
            <div class="border-t border-white/10 p-6"><p class="truncate text-sm font-bold">{{ auth()->user()->name }}</p><p class="mt-1 truncate text-xs text-white/70">{{ auth()->user()->email }}</p><form method="POST" action="{{ route('logout') }}" class="mt-4">@csrf<button class="text-[10px] font-bold uppercase tracking-widest text-[#E67E22]">Log out</button></form></div>
        </aside>

        <main class="min-h-screen">{{ $slot }}</main>
    </div>
</body>
</html>
