<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>ระบบจัดการเอกสาร - @yield('title', 'หน้าแรก')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        },
                        accent: {
                            50: '#fdf4ff',
                            100: '#fae8ff',
                            200: '#f5d0fe',
                            300: '#f0abfc',
                            400: '#e879f9',
                            500: '#d946ef',
                            600: '#c026d3',
                            700: '#a21caf',
                            800: '#86198f',
                            900: '#701a75',
                        }
                    },
                    fontFamily: {
                        thai: ['Prompt', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        * { scrollbar-width: thin; scrollbar-color: #0ea5e9 #f1f5f9; }
        *::-webkit-scrollbar { width: 8px; }
        *::-webkit-scrollbar-track { background: #f1f5f9; }
        *::-webkit-scrollbar-thumb { background: #0ea5e9; border-radius: 4px; }
        
        body {
            font-family: 'Prompt', sans-serif;
            background: #f8fafc;
        }

        .card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.08), 0 4px 6px -2px rgba(0, 0, 0, 0.04);
            transform: translateY(-2px);
        }

        .input-field {
            background: #f8fafc;
            border: 2px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .input-field:focus {
            border-color: #0ea5e9;
            background: white;
            box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.15);
            outline: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
            box-shadow: 0 4px 12px rgba(14, 165, 233, 0.4);
        }

        .btn-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            transition: all 0.3s ease;
        }

        .btn-success:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
        }

        .btn-warning {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            transition: all 0.3s ease;
        }

        .btn-warning:hover {
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.4);
        }

        .btn-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            transition: all 0.3s ease;
        }

        .btn-danger:hover {
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
        }

        .sidebar {
            background: white;
            box-shadow: 4px 0 6px -1px rgba(0, 0, 0, 0.05);
        }

        .sidebar-link {
            color: #64748b;
            transition: all 0.3s ease;
            border-radius: 12px;
        }

        .sidebar-link:hover, .sidebar-link.active {
            background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%);
            color: #0284c7;
        }

        .sidebar-link.active {
            background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
            color: white;
        }

        .table-header {
            background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%);
            color: #475569;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
        }

        .table-row {
            border-bottom: 1px solid #f1f5f9;
            transition: all 0.2s ease;
        }

        .table-row:hover {
            background: #f8fafc;
        }

        .badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .badge-primary {
            background: #e0f2fe;
            color: #0284c7;
        }

        .badge-success {
            background: #d1fae5;
            color: #059669;
        }

        .badge-warning {
            background: #fef3c7;
            color: #d97706;
        }

        .badge-danger {
            background: #fee2e2;
            color: #dc2626;
        }

        .pagination-btn {
            background: white;
            border: 2px solid #e2e8f0;
            color: #475569;
            transition: all 0.2s ease;
        }

        .pagination-btn:hover, .pagination-btn.active {
            background: #0ea5e9;
            border-color: #0ea5e9;
            color: white;
        }

        .modal-overlay {
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
        }

        .modal-content {
            background: white;
            border-radius: 20px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="font-thai antialiased">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="sidebar w-64 flex-shrink-0 hidden md:flex flex-col">
            <div class="p-6 border-b border-slate-100">
                <h1 class="text-xl font-bold flex items-center text-primary-600">
                    <i class="fas fa-folder-open mr-2"></i>
                    DMS <span class="text-accent-500">University</span>
                </h1>
            </div>
            <nav class="flex-1 px-4 py-4 space-y-2">
                <a href="{{ route('dashboard') }}" class="sidebar-link flex items-center px-4 py-3 {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-line w-6"></i>
                    <span>แดชบอร์ด</span>
                </a>
                <a href="{{ route('documents.index') }}" class="sidebar-link flex items-center px-4 py-3 {{ request()->routeIs('documents.*') ? 'active' : '' }}">
                    <i class="fas fa-file-alt w-6"></i>
                    <span>จัดการเอกสาร</span>
                </a>
                <a href="{{ route('categories.index') }}" class="sidebar-link flex items-center px-4 py-3 {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                    <i class="fas fa-folder w-6"></i>
                    <span>หมวดหมู่</span>
                </a>
            </nav>
            <div class="p-4 border-t border-slate-100">
                <div class="flex items-center px-4 py-3 rounded-xl" style="background: linear-gradient(135deg, #e0f2fe 0%, #f0f9ff 100%);">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white font-semibold">A</div>
                    <div class="ml-3">
                        <p class="text-sm font-semibold text-slate-700">Admin User</p>
                        <p class="text-xs text-slate-500">admin@university.ac.th</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden bg-slate-50">
            <!-- Topbar -->
            <header class="h-16 bg-white flex items-center justify-between px-8 shadow-sm">
                <div class="flex items-center">
                    <button class="md:hidden mr-4 text-slate-400">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h2 class="text-lg font-semibold text-slate-700">@yield('header', 'Dashboard')</h2>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="flex items-center space-x-2 px-3 py-1.5 rounded-full bg-emerald-50 border border-emerald-200">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span class="text-xs text-emerald-600 font-medium">พร้อมใช้งาน</span>
                    </div>
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
