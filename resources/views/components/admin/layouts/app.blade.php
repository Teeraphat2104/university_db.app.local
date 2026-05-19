<!doctype html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'University Activities') }} - Admin</title>
    <meta name="description" content="ระบบจัดการกิจกรรมและเอกสารของมหาวิทยาลัย">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Noto+Sans+Thai:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --primary: #6366F1;
            --primary-light: #818CF8;
            --primary-dark: #4F46E5;
            --success: #10B981;
            --success-light: #34D399;
            --danger: #EF4444;
            --danger-light: #F87171;
            --warning: #F59E0B;
            --background: #F8FAFC;
            --surface: #FFFFFF;
            --surface-hover: #F1F5F9;
            --text-primary: #0F172A;
            --text-secondary: #64748B;
            --text-muted: #94A3B8;
            --border: #E2E8F0;
            --border-light: #F1F5F9;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            --radius-sm: 0.375rem;
            --radius: 0.5rem;
            --radius-lg: 0.75rem;
            --radius-xl: 1rem;
            --sidebar-width: 260px;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Manrope', 'Noto Sans Thai', sans-serif; background: var(--background); color: var(--text-primary); font-size: 14px; line-height: 1.5; }
        .admin-layout { display: flex; min-height: 100vh; }
        .sidebar { width: var(--sidebar-width); background: var(--surface); border-right: 1px solid var(--border); position: fixed; top: 0; left: 0; bottom: 0; display: flex; flex-direction: column; z-index: 100; }
        .sidebar-header { padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: 0.75rem; }
        .sidebar-logo { width: 36px; height: 36px; background: linear-gradient(135deg, var(--primary), var(--primary-light)); border-radius: var(--radius); display: flex; align-items: center; justify-content: center; color: white; font-size: 16px; }
        .sidebar-brand { font-weight: 700; font-size: 16px; color: var(--text-primary); }
        .sidebar-nav { flex: 1; padding: 1rem 0.75rem; overflow-y: auto; }
        .nav-section { margin-bottom: 1.5rem; }
        .nav-section-title { font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted); padding: 0 0.75rem; margin-bottom: 0.5rem; }
        .nav-item { display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1rem; border-radius: var(--radius); color: var(--text-secondary); text-decoration: none; font-weight: 500; transition: all 0.15s; margin-bottom: 2px; }
        .nav-item:hover { background: var(--surface-hover); color: var(--text-primary); }
        .nav-item.active { background: var(--primary); color: white; }
        .nav-item .fa-solid, .nav-item .fa-regular { width: 20px; font-size: 1rem; flex-shrink: 0; text-align: center; }
        .nav-item-badge { margin-left: auto; background: var(--danger); color: white; font-size: 11px; font-weight: 600; padding: 2px 6px; border-radius: 999px; }
        .sidebar-footer { padding: 1rem 1.5rem; border-top: 1px solid var(--border); }
        .user-info { display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem; background: var(--surface-hover); border-radius: var(--radius); }
        .user-avatar { width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, var(--primary), var(--primary-light)); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 14px; }
        .user-details { flex: 1; min-width: 0; }
        .user-name { font-weight: 600; font-size: 13px; color: var(--text-primary); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .user-role { font-size: 12px; color: var(--text-muted); }
        .main-content { flex: 1; margin-left: var(--sidebar-width); min-height: 100vh; }
        .topbar { background: var(--surface); border-bottom: 1px solid var(--border); padding: 1rem 2rem; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 50; }
        .topbar-left { display: flex; align-items: center; gap: 1rem; }
        .page-title { font-size: 20px; font-weight: 700; color: var(--text-primary); }
        .breadcrumb { font-size: 13px; color: var(--text-muted); }
        .breadcrumb a { color: var(--text-secondary); text-decoration: none; }
        .breadcrumb a:hover { color: var(--primary); }
        .topbar-right { display: flex; align-items: center; gap: 1rem; }
        .topbar-btn { width: 40px; height: 40px; border-radius: var(--radius); border: 1px solid var(--border); background: var(--surface); display: flex; align-items: center; justify-content: center; color: var(--text-secondary); cursor: pointer; transition: all 0.15s; }
        .topbar-btn:hover { background: var(--surface-hover); color: var(--text-primary); }
        .page-content { padding: 2rem; }
        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; margin-bottom: 2rem; }
        .stat-card { background: var(--surface); border-radius: var(--radius-lg); padding: 1.5rem; border: 1px solid var(--border); box-shadow: var(--shadow-sm); transition: all 0.2s; }
        .stat-card:hover { box-shadow: var(--shadow-md); transform: translateY(-2px); }
        .stat-header { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 1rem; }
        .stat-icon { width: 48px; height: 48px; border-radius: var(--radius); display: flex; align-items: center; justify-content: center; font-size: 1.25rem; }
        .stat-icon.primary { background: #EEF2FF; color: var(--primary); }
        .stat-icon.success { background: #DCFCE7; color: var(--success); }
        .stat-icon.warning { background: #FEF3C7; color: var(--warning); }
        .stat-icon.danger { background: #FEE2E2; color: var(--danger); }
        .stat-trend { font-size: 12px; font-weight: 600; padding: 4px 8px; border-radius: 999px; display: flex; align-items: center; gap: 4px; }
        .stat-trend.up { background: #DCFCE7; color: var(--success); }
        .stat-trend.down { background: #FEE2E2; color: var(--danger); }
        .stat-value { font-size: 32px; font-weight: 800; color: var(--text-primary); line-height: 1; margin-bottom: 0.25rem; }
        .stat-label { font-size: 14px; color: var(--text-secondary); }
        .card { background: var(--surface); border-radius: var(--radius-lg); border: 1px solid var(--border); box-shadow: var(--shadow-sm); }
        .card-header { padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; }
        .card-title { font-size: 16px; font-weight: 700; color: var(--text-primary); }
        .card-body { padding: 1.5rem; }
        .btn { display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem; padding: 0.625rem 1.25rem; border-radius: var(--radius); font-size: 14px; font-weight: 600; cursor: pointer; border: none; transition: all 0.15s; text-decoration: none; }
        .btn-primary { background: var(--primary); color: white; }
        .btn-primary:hover { background: var(--primary-dark); }
        .btn-secondary { background: var(--surface); color: var(--text-primary); border: 1px solid var(--border); }
        .btn-secondary:hover { background: var(--surface-hover); }
        .btn-sm { padding: 0.375rem 0.75rem; font-size: 13px; }
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table th { text-align: left; padding: 0.75rem 1rem; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted); background: var(--surface-hover); border-bottom: 1px solid var(--border); }
        .data-table td { padding: 1rem; border-bottom: 1px solid var(--border-light); }
        .data-table tr:last-child td { border-bottom: none; }
        .data-table tr:hover td { background: var(--surface-hover); }
        .badge { display: inline-flex; align-items: center; padding: 4px 10px; border-radius: 999px; font-size: 12px; font-weight: 600; }
        .badge-success { background: #DCFCE7; color: var(--success); }
        .badge-warning { background: #FEF3C7; color: #B45309; }
        .badge-danger { background: #FEE2E2; color: var(--danger); }
        .badge-primary { background: #EEF2FF; color: var(--primary); }
        .empty-state { text-align: center; padding: 3rem; color: var(--text-muted); }
        .empty-state svg { width: 64px; height: 64px; margin-bottom: 1rem; opacity: 0.5; }
        @media (max-width: 1024px) { .stats-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 768px) { .sidebar { transform: translateX(-100%); } .main-content { margin-left: 0; } .stats-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <div class="admin-layout">
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-logo"><i class="fa-solid fa-graduation-cap"></i></div>
                <span class="sidebar-brand">University</span>
            </div>
            <nav class="sidebar-nav">
                <div class="nav-section">
                    <p class="nav-section-title">Main</p>
                    <a href="/admin" class="nav-item @if(request()->is('admin') || request()->is('admin/')) active @endif">
                        <i class="fa-solid fa-border-all"></i>
                        Dashboard
                    </a>
                    <a href="/admin/activities" class="nav-item @if(request()->is('admin/activities') || request()->is('admin/activities/*')) active @endif">
                        <i class="fa-solid fa-calendar-days"></i>
                        กิจกรรม
                    </a>
                    <a href="/admin/students" class="nav-item @if(request()->is('admin/students') || request()->is('admin/students/*')) active @endif">
                        <i class="fa-solid fa-users"></i>
                        นักศึกษา
                    </a>
                    <a href="/admin/participants" class="nav-item @if(request()->is('admin/participants') || request()->is('admin/participants/*')) active @endif">
                        <i class="fa-solid fa-user-plus"></i>
                        ผู้เข้าร่วม
                        <span class="nav-item-badge">12</span>
                    </a>
                </div>
                <div class="nav-section">
                    <p class="nav-section-title">Reports</p>
                    <a href="/admin/reports" class="nav-item @if(request()->is('admin/reports') || request()->is('admin/reports/*')) active @endif">
                        <i class="fa-solid fa-chart-bar"></i>
                        รายงาน
                    </a>
                </div>
                <div class="nav-section">
                    <p class="nav-section-title">System</p>
                    <a href="/admin/settings" class="nav-item @if(request()->is('admin/settings') || request()->is('admin/settings/*')) active @endif">
                        <i class="fa-solid fa-gear"></i>
                        ตั้งค่า
                    </a>
                    <a href="/" class="nav-item">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        ออกจากระบบ
                    </a>
                </div>
            </nav>
            <div class="sidebar-footer">
                <div class="user-info">
                    <div class="user-avatar"><i class="fa-solid fa-user"></i></div>
                    <div class="user-details">
                        <p class="user-name">Admin User</p>
                        <p class="user-role">ผู้ดูแลระบบ</p>
                    </div>
                </div>
            </div>
        </aside>
        <main class="main-content">
            <header class="topbar">
                <div class="topbar-left">
                    <h1 class="page-title">Dashboard</h1>
                </div>
                <div class="topbar-right">
                    <button class="topbar-btn" aria-label="แจ้งเตือน">
                        <i class="fa-regular fa-bell"></i>
                    </button>
                    <button class="topbar-btn" aria-label="เวลา">
                        <i class="fa-regular fa-clock"></i>
                    </button>
                </div>
            </header>
            <div class="page-content">
                {{ $slot }}
            </div>
        </main>
    </div>
</body>
</html>
