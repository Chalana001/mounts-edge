<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Mounts Edge Regency</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#FAF9F6] font-sans antialiased text-gray-900">
    
    <nav class="bg-[#1a2e2a] text-white py-4 shadow-md">
        <div class="max-w-7xl mx-auto px-6 flex justify-between items-center">
            <a href="{{ route('admin.rooms.index') }}" class="font-serif text-xl tracking-widest uppercase">
                Mounts Edge <span class="text-[#E67E22]">Admin</span>
            </a>
            <a href="/" target="_blank" class="text-[10px] tracking-widest uppercase font-bold text-gray-300 hover:text-white transition-colors">
                View Live Site
            </a>
        </div>
    </nav>

    <main>
        {{ $slot }}
    </main>

</body>
</html>