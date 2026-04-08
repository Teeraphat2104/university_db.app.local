<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>ระบบจัดการเอกสาร - @yield('title', 'หน้าแรก')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts and Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-slate-900 text-white flex-shrink-0 flex flex-col hidden md:flex">
            <div class="p-6">
                <h1 class="text-xl font-bold flex items-center">
                    <i class="fas fa-file-invoice text-blue-400 mr-2"></i>
                    DMS University
                </h1>
            </div>
            <nav class="flex-1 px-4 py-4 space-y-2">
                <a href="{{ route('home') }}" class="flex items-center px-4 py-3 rounded-lg bg-blue-600 text-white">
                    <i class="fas fa-home w-6"></i>
                    <span>จัดการเอกสาร</span>
                </a>
            </nav>
            <div class="p-4 border-t border-slate-800">
                <div class="flex items-center px-4 py-2">
                    <div class="w-8 h-8 rounded-full bg-slate-700 flex items-center justify-center mr-3 text-xs">AD</div>
                    <div class="flex-1 overflow-hidden">
                        <p class="text-sm font-medium truncate">Admin User</p>
                        <p class="text-xs text-slate-400 truncate">admin@example.com</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Topbar -->
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-8">
                <div class="flex items-center">
                    <button class="md:hidden mr-4 text-gray-500">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h2 class="text-lg font-semibold text-gray-800">@yield('header', 'Dashboard')</h2>
                </div>
                <div class="flex items-center space-y-4">
                    <!-- Notifications, Search, Profile could go here -->
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-8">
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
