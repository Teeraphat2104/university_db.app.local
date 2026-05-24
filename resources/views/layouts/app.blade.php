<!doctype html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name', 'University Activities') . ' - Admin')</title>
    <meta name="description" content="ระบบจัดการกิจกรรมและเอกสารของมหาวิทยาลัย">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Noto+Sans+Thai:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" crossorigin="anonymous">
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <style>
        :root {
            --primary: #6366F1;
            --primary-dark: #4F46E5;
            --primary-light: #EEF2FF;
            --accent: #8B5CF6;
            --gray-50: #F8FAFC;
            --gray-100: #F1F5F9;
            --gray-200: #E2E8F0;
            --gray-300: #CBD5E1;
            --gray-400: #94A3B8;
            --gray-500: #64748B;
            --gray-600: #475569;
            --gray-700: #334155;
            --gray-800: #1E293B;
            --gray-900: #0F172A;
            --success: #10B981;
            --success-bg: #DCFCE7;
            --success-text: #166534;
            --danger: #EF4444;
            --danger-bg: #FEE2E2;
            --danger-text: #B91C1C;
            --warning: #F59E0B;
            --line: #E2E8F0;
            --surface: #fff;
            --text-primary: #1E293B;
            --text-muted: #64748B;
            --border: #E2E8F0;
            --radius-md: 8px;
            --radius-lg: 12px;
            --radius-xl: 16px;
            --radius-2xl: 20px;
            --radius-full: 9999px;
            --sidebar-width: 248px;
        }
        body { font-family: 'Manrope', 'Noto Sans Thai', sans-serif; background: var(--gray-50); color: var(--text-primary); font-size: 14px; line-height: 1.5; }
        *, *::before, *::after { box-sizing: border-box; }

        /* Admin Layout */
        .admin-layout { display: flex; min-height: 100vh; }
        .sidebar {
            width: var(--sidebar-width); background: #fff;
            border-right: 1px solid var(--border);
            position: fixed; top: 0; left: 0; bottom: 0;
            display: flex; flex-direction: column; z-index: 100;
        }
        .sidebar-header { padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: 0.75rem; }
        .sidebar-logo { width: 36px; height: 36px; background: linear-gradient(135deg, var(--primary), var(--accent)); border-radius: var(--radius-md); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 16px; }
        .sidebar-brand { font-weight: 700; font-size: 16px; color: var(--text-primary); }
        .sidebar-nav { flex: 1; padding: 1rem 0.75rem; overflow-y: auto; }
        .nav-section { margin-bottom: 1.5rem; }
        .nav-section-title { font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: var(--gray-400); padding: 0 0.75rem; margin-bottom: 0.5rem; }
        .nav-item { display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1rem; border-radius: var(--radius-md); color: var(--gray-500); text-decoration: none; font-weight: 500; transition: all 0.15s; margin-bottom: 2px; }
        .nav-item:hover { background: var(--gray-100); color: var(--text-primary); text-decoration: none; }
        .nav-item.active { background: var(--primary); color: white; }
        .nav-item i { width: 20px; text-align: center; flex-shrink: 0; font-size: 1rem; }
        .sidebar-footer { padding: 1rem 1.5rem; border-top: 1px solid var(--border); }
        .user-info { display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem; background: var(--gray-100); border-radius: var(--radius-md); }
        .user-avatar { width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, var(--primary), var(--accent)); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 14px; }
        .user-details { flex: 1; min-width: 0; }
        .user-name { font-weight: 600; font-size: 13px; color: var(--text-primary); margin: 0; }
        .user-role { font-size: 12px; color: var(--gray-400); margin: 0; }
        .main-content { flex: 1; margin-left: var(--sidebar-width); min-height: 100vh; display: flex; flex-direction: column; }
        .topbar { background: #fff; border-bottom: 1px solid var(--border); padding: 1rem 2rem; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 50; }
        .page-content { padding: 2rem; flex: 1; }

        /* Page Header */
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; }
        .page-title { font-size: 1.5rem; font-weight: 700; }
        .page-subtitle { color: var(--text-muted); font-size: .875rem; }

        /* Loading / Empty */
        .loading-cell { text-align: center; padding: 3rem; color: var(--text-muted); }
        .empty-state-icon { width: 80px; height: 80px; border-radius: 50%; background: linear-gradient(135deg,#EEF2FF,#E0E7FF); display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; }
        .empty-state-icon i { font-size: 2rem; color: var(--primary); }
        .empty-state h3 { font-size: 1.125rem; font-weight: 700; color: var(--text-primary); margin-bottom: .5rem; }
        .empty-state p { color: var(--text-muted); margin-bottom: 1.5rem; }

        /* Filter Bar */
        .filter-bar { display: flex; gap: 1rem; align-items: center; flex-wrap: wrap; }
        .filter-bar .filter-input { flex: 1; min-width: 200px; }

        /* Data Table */
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table th { text-align: left; padding: 0.75rem 1rem; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: var(--gray-400); background: var(--gray-100); border-bottom: 1px solid var(--border); }
        .data-table td { padding: 1rem; border-bottom: 1px solid var(--gray-100); vertical-align: middle; color: var(--gray-700); }
        .data-table tr:last-child td { border-bottom: none; }
        .data-table tr:hover td { background: var(--gray-50); }

        /* Badges */
        .badge { display: inline-flex; align-items: center; padding: 4px 10px; border-radius: 999px; font-size: 12px; font-weight: 600; }
        .badge-success { background: #DCFCE7; color: #16A34A; }
        .badge-warning { background: #FEF3C7; color: #B45309; }

        /* Dialogs */
        dialog { border: none; border-radius: var(--radius-2xl); padding: 0; margin: auto; box-shadow: 0 20px 40px rgba(0,0,0,.10); max-height: 90vh; overflow-y: auto; }
        dialog::backdrop { background: rgba(15,23,42,.6); backdrop-filter: blur(4px); }
        .dialog-header { display: flex; align-items: center; justify-content: space-between; padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--line); position: sticky; top: 0; background: #fff; z-index: 1; border-radius: var(--radius-2xl) var(--radius-2xl) 0 0; }
        .dialog-header h3 { margin: 0; font-size: 1.05rem; font-weight: 700; }
        .dialog-body { padding: 1.5rem; }
        .dialog-footer { display: flex; justify-content: flex-end; gap: .75rem; padding: 1rem 1.5rem; border-top: 1px solid var(--line); background: var(--gray-50); border-radius: 0 0 var(--radius-2xl) var(--radius-2xl); position: sticky; bottom: 0; }
        .modal-sm { width: min(440px, 92vw); }
        .modal-md { width: min(520px, 92vw); }
        .modal-lg { width: min(740px, 92vw); }

        /* Save Bar */
        .save-bar { position: sticky; bottom: 0; background: #fff; border-top: 1px solid var(--border); padding: 1rem 0; margin-top: 1.5rem; display: flex; justify-content: flex-end; }

        /* Stat Cards */
        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; margin-bottom: 2rem; }
        .stat-card { background: #fff; border-radius: var(--radius-lg); padding: 1.5rem; border: 1px solid var(--border); box-shadow: 0 1px 2px rgba(0,0,0,.05); transition: all 0.2s; }
        .stat-card:hover { box-shadow: 0 4px 6px rgba(0,0,0,.06); transform: translateY(-2px); }
        .stat-icon { width: 48px; height: 48px; border-radius: var(--radius-md); display: flex; align-items: center; justify-content: center; }
        .stat-icon.primary { background: #DBEAFE; color: var(--primary); }
        .stat-icon.success { background: #DCFCE7; color: var(--success); }
        .stat-icon.warning { background: #FEF3C7; color: var(--warning); }
        .stat-icon.danger { background: #FEE2E2; color: var(--danger); }
        .stat-icon i { font-size: 1.25rem; }
        .stat-value { font-size: 32px; font-weight: 800; color: var(--text-primary); line-height: 1; margin-bottom: 0.25rem; }
        .stat-label { font-size: 14px; color: var(--gray-500); }

        /* Card */
        .card { background: #fff; border-radius: var(--radius-lg) !important; border: 1px solid var(--border) !important; box-shadow: 0 1px 2px rgba(0,0,0,.05); }
        .card-body { padding: 1.5rem !important; }

        /* Buttons */
        .btn-primary { background: var(--primary) !important; border-color: var(--primary) !important; }
        .btn-primary:hover { background: var(--primary-dark) !important; border-color: var(--primary-dark) !important; }

        /* Responsive */
        @media (max-width: 1024px) { .stats-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 768px) { .sidebar { transform: translateX(-100%); } .main-content { margin-left: 0; } .stats-grid { grid-template-columns: 1fr; } .page-content { padding: 1rem; } }
    </style>
    @yield('style')
</head>
<body>
    <div class="admin-layout">
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-logo">U</div>
                <span class="sidebar-brand">University</span>
            </div>
            <nav class="sidebar-nav">
                <div class="nav-section">
                    <p class="nav-section-title">Main</p>
                    <a href="{{ route('admin.dashboard') }}" class="nav-item @if(request()->path() === 'admin') active @endif">
                        <i class="fa-solid fa-gauge-high"></i>
                        Dashboard
                    </a>
                    <a href="{{ route('admin.activities') }}" class="nav-item @if(str_starts_with(request()->path(), 'admin/activities')) active @endif">
                        <i class="fa-regular fa-calendar"></i>
                        กิจกรรม
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="nav-item @if(str_starts_with(request()->path(), 'admin/categories')) active @endif">
                        <i class="fa-regular fa-file"></i>
                        หมวดหมู่
                    </a>
                </div>
                <div class="nav-section">
                    <p class="nav-section-title">Reports</p>
                    <a href="/admin/reports" class="nav-item @if(str_starts_with(request()->path(), 'admin/reports')) active @endif">
                        <i class="fa-solid fa-chart-simple"></i>
                        รายงาน
                    </a>
                </div>
                <div class="nav-section">
                    <p class="nav-section-title">System</p>
                    <a href="/admin/settings" class="nav-item @if(str_starts_with(request()->path(), 'admin/settings')) active @endif">
                        <i class="fa-solid fa-gear"></i>
                        ตั้งค่า
                    </a>
                    <a href="#" onclick="logout();return false;" class="nav-item text-danger">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        ออกจากระบบ
                    </a>
                </div>
            </nav>
            <div class="sidebar-footer">
                <div class="user-info">
                    <div class="user-avatar">A</div>
                    <div class="user-details">
                        <p class="user-name">Admin User</p>
                        <p class="user-role">ผู้ดูแลระบบ</p>
                    </div>
                </div>
            </div>
        </aside>
        <main class="main-content">
            <div class="page-content">
                @yield('content')
            </div>
        </main>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" crossorigin="anonymous"></script>
    <script>
        function logout() {
            Swal.fire({
                title: 'ออกจากระบบ?',
                text: 'คุณต้องการออกจากระบบใช่หรือไม่',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#EF4444',
                cancelButtonColor: '#64748B',
                confirmButtonText: 'ใช่, ออกจากระบบ',
                cancelButtonText: 'ยกเลิก'
            }).then(function (result) {
                if (result.isConfirmed) {
                    localStorage.removeItem('admin_token');
                    window.location.href = '/login';
                }
            });
        }
    </script>
    @yield('script')
</body>
</html>
