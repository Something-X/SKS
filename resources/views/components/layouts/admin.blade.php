<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>{{ $title ?? 'Admin Dashboard' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 text-gray-800 antialiased flex h-screen overflow-hidden">
    
    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-md hidden md:flex flex-col">
        <div class="p-6 border-b border-gray-100">
            <h1 class="text-2xl font-extrabold text-purple-600 tracking-tight">AdminPanel.</h1>
        </div>
        <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
            <a href="#" class="block px-4 py-3 rounded-xl hover:bg-purple-50 hover:text-purple-700 transition text-gray-600 font-medium">
                Dashboard
            </a>
            <a href="{{ route('admin.products.index') }}" class="block px-4 py-3 rounded-xl {{ request()->routeIs('admin.products.*') ? 'bg-purple-100 text-purple-700 font-semibold' : 'hover:bg-purple-50 hover:text-purple-700 transition text-gray-600 font-medium' }}">
                Products
            </a>
            <a href="{{ route('admin.promos.index') }}" class="block px-4 py-3 rounded-xl {{ request()->routeIs('admin.promos.*') ? 'bg-purple-100 text-purple-700 font-semibold' : 'hover:bg-purple-50 hover:text-purple-700 transition text-gray-600 font-medium' }}">
                Promos
            </a>
        </nav>
        <div class="p-4 border-t border-gray-100">
            <a href="{{ route('home') }}" class="block px-4 py-2 text-sm text-gray-500 hover:text-gray-800">
                &larr; Back to Shop
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col h-screen overflow-hidden">
        
        <!-- Top Header -->
        <header class="bg-white shadow-sm flex items-center justify-between px-6 py-4 md:px-8 border-b border-gray-100">
            <div class="flex items-center md:hidden">
                <h1 class="text-xl font-bold text-purple-600">AdminPanel.</h1>
            </div>
            <div class="flex items-center ml-auto">
                <button class="bg-gray-100 text-gray-600 px-4 py-2 rounded-xl text-sm font-semibold hover:bg-gray-200 transition">
                    Admin
                </button>
            </div>
        </header>

        <!-- Content Area -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6 md:p-8">
            {{ $slot }}
        </main>
    </div>

    @livewireScripts
</body>
</html>
