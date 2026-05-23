<!doctype html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name', 'University Activities') . ' - Admin')</title>
    <meta name="description" content="ระบบจัดการกิจกรรมและเอกสารของมหาวิทยาลัย">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Noto+Sans+Thai:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" crossorigin="anonymous">
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <style>
        /* ── Page Header ── */
        .page-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem; }
        .page-title { font-size:1.5rem; font-weight:700; margin-bottom:.15rem; }
        .page-subtitle { color:var(--text-muted); font-size:.875rem; }

        /* ── Loading / Empty ── */
        .loading-cell { text-align:center; padding:3rem; color:var(--text-muted); }
        .empty-state-icon { width:80px; height:80px; border-radius:50%; background:linear-gradient(135deg,#EEF2FF,#E0E7FF); display:flex; align-items:center; justify-content:center; margin:0 auto 1rem; }
        .empty-state-icon i { font-size:2rem; color:var(--primary); }
        .empty-state h3 { font-size:1.125rem; font-weight:700; color:var(--text-primary); margin-bottom:.5rem; }
        .empty-state p { color:var(--text-muted); margin-bottom:1.5rem; }

        /* ── Filter Bar ── */
        .filter-bar { display:flex; gap:1rem; align-items:center; flex-wrap:wrap; }
        .filter-bar .filter-input { flex:1; min-width:200px; }

        /* ── Form Grid ── */
        .form-grid { display:grid; grid-template-columns:1fr 1fr; gap:1rem; }
        .form-full { grid-column:1/-1; }

        /* ── Table Avatar ── */
        .table-avatar { width:44px; height:44px; border-radius:var(--radius); background:linear-gradient(135deg,#667eea,#764ba2); display:flex; align-items:center; justify-content:center; color:#fff; font-weight:700; flex-shrink:0; }

        /* ── Pagination ── */
        .pag-bar { display:flex; justify-content:space-between; align-items:center; margin-top:1.5rem; }
        .pag-info { color:var(--text-muted); font-size:.875rem; }
        .pag-btns { display:flex; gap:.5rem; }

        /* ── Detail Grid ── */
        .detail-grid { display:grid; grid-template-columns:1fr 1fr; gap:1.5rem; }
        .detail-cover { width:100%; border-radius:var(--radius-lg); max-height:300px; object-fit:cover; }

        /* ── Save Bar ── */
        .save-bar { position:sticky; bottom:0; background:var(--surface); border-top:1px solid var(--border); padding:1rem 0; margin-top:1.5rem; display:flex; justify-content:flex-end; }
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
                    <a href="#" onclick="logout();return false;" class="nav-item text-red-500">
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