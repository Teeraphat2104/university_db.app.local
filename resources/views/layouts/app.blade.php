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