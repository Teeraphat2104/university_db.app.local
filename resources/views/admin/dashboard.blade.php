@extends('layouts.master')

@section('title', 'Dashboard - Admin')

@section('style')
    @include('partials._admin-styles')
@endsection

@section('content')
    <div class="admin-layout">
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-logo">U</div>
                <span class="sidebar-brand">University</span>
            </div>
            <nav class="sidebar-nav">
                <div class="nav-section">
                    <p class="nav-section-title">Main</p>
                    <a href="/admin" class="nav-item active">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                        Dashboard
                    </a>
                    <a href="/admin/activities" class="nav-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        กิจกรรม
                    </a>
                    <a href="/admin/students" class="nav-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        นักศึกษา
                    </a>
                    <a href="/admin/participants" class="nav-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-1a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v1"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
                        ผู้เข้าร่วม
                        <span class="nav-item-badge">12</span>
                    </a>
                </div>
                <div class="nav-section">
                    <p class="nav-section-title">Reports</p>
                    <a href="/admin/reports" class="nav-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                        รายงาน
                    </a>
                </div>
                <div class="nav-section">
                    <p class="nav-section-title">System</p>
                    <a href="/admin/settings" class="nav-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                        ตั้งค่า
                    </a>
                    <a href="/" class="nav-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
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
            <header class="topbar">
                <div class="topbar-left">
                    <h1 class="page-title">Dashboard</h1>
                </div>
                <div class="topbar-right">
                    <button class="topbar-btn">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                    </button>
                    <button class="topbar-btn">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                    </button>
                </div>
            </header>
            <div class="page-content">
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon primary">
                                <i class="fa-solid fa-calendar-days"></i>
                            </div>
                            <span class="stat-trend up">
                                <i class="fa-solid fa-arrow-up"></i>
                                12%
                            </span>
                        </div>
                        <p class="stat-value">24</p>
                        <p class="stat-label">กิจกรรมทั้งหมด</p>
                    </div>
                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon success">
                                <i class="fa-solid fa-users"></i>
                            </div>
                            <span class="stat-trend up">
                                <i class="fa-solid fa-arrow-up"></i>
                                8%
                            </span>
                        </div>
                        <p class="stat-value">1,234</p>
                        <p class="stat-label">นักศึกษาทั้งหมด</p>
                    </div>
                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon warning">
                                <i class="fa-solid fa-user-plus"></i>
                            </div>
                        </div>
                        <p class="stat-value">856</p>
                        <p class="stat-label">ผู้เข้าร่วม</p>
                    </div>
                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon danger">
                                <i class="fa-solid fa-calendar-day"></i>
                            </div>
                            <span class="stat-trend down">
                                <i class="fa-solid fa-arrow-down"></i>
                                2%
                            </span>
                        </div>
                        <p class="stat-value">3</p>
                        <p class="stat-label">กิจกรรมวันนี้</p>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">กิจกรรมล่าสุด</h3>
                            <a href="/admin/activities" class="btn btn-sm btn-secondary">ดูทั้งหมด</a>
                        </div>
                        <div class="card-body" style="padding: 0;">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>ชื่อกิจกรรม</th>
                                        <th>วันที่</th>
                                        <th>ผู้เข้าร่วม</th>
                                        <th>สถานะ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><td><p style="font-weight: 600;">อบรมเทคโนโลยีสารสนเทศ</p><p style="font-size: 12px; color: var(--text-muted);">หมวดหมู่: การศึกษา</p></td><td>13 พ.ค. 2569</td><td>45 คน</td><td><span class="badge badge-success">เสร็จสิ้น</span></td></tr>
                                    <tr><td><p style="font-weight: 600;">กีฬาสีภาคต้น</p><p style="font-size: 12px; color: var(--text-muted);">หมวดหมู่: กีฬา</p></td><td>14 พ.ค. 2569</td><td>120 คน</td><td><span class="badge badge-primary">กำลังดำเนิน</span></td></tr>
                                    <tr><td><p style="font-weight: 600;">อาสาสมัครบริการชุมชน</p><p style="font-size: 12px; color: var(--text-muted);">หมวดหมู่: อาสา</p></td><td>15 พ.ค. 2569</td><td>30 คน</td><td><span class="badge badge-warning">รอดำเนินการ</span></td></tr>
                                    <tr><td><p style="font-weight: 600;">สัมมนาพัฒนาทักษะ</p><p style="font-size: 12px; color: var(--text-muted);">หมวดหมู่: พัฒนาทักษะ</p></td><td>20 พ.ค. 2569</td><td>0 คน</td><td><span class="badge badge-warning">รอดำเนินการ</span></td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">หมวดหมู่</h3>
                        </div>
                        <div class="card-body">
                            <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                                <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem; background: #EEF2FF; border-radius: var(--radius);"><span style="font-weight: 600; color: var(--primary);">การศึกษา</span><span style="font-weight: 700; color: var(--primary);">8</span></div>
                                <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem; background: #DCFCE7; border-radius: var(--radius);"><span style="font-weight: 600; color: var(--success);">กีฬา</span><span style="font-weight: 700; color: var(--success);">5</span></div>
                                <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem; background: #FEF3C7; border-radius: var(--radius);"><span style="font-weight: 600; color: #B45309;">อาสา</span><span style="font-weight: 700; color: #B45309;">4</span></div>
                                <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem; background: #FEE2E2; border-radius: var(--radius);"><span style="font-weight: 600; color: var(--danger);">พัฒนาทักษะ</span><span style="font-weight: 700; color: var(--danger);">3</span></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">ผู้เข้าร่วมมากที่สุด (Top 5)</h3>
                        </div>
                        <div class="card-body">
                            <div style="display: flex; flex-direction: column; gap: 1rem;">
                                <div style="display: flex; align-items: center; gap: 1rem;"><div style="width: 32px; height: 32px; border-radius: 50%; background: var(--primary); color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 14px;">1</div><div style="flex: 1;"><p style="font-weight: 600;">สมชาย ใจดี</p><p style="font-size: 12px; color: var(--text-muted);">ภาควิชาวิทยาศาสตร์</p></div><span class="badge badge-success">12 กิจกรรม</span></div>
                                <div style="display: flex; align-items: center; gap: 1rem;"><div style="width: 32px; height: 32px; border-radius: 50%; background: var(--primary); color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 14px;">2</div><div style="flex: 1;"><p style="font-weight: 600;">สมศักดิ์ รักเรียน</p><p style="font-size: 12px; color: var(--text-muted);">ภาควิชาวิศวกรรม</p></div><span class="badge badge-success">10 กิจกรรม</span></div>
                                <div style="display: flex; align-items: center; gap: 1rem;"><div style="width: 32px; height: 32px; border-radius: 50%; background: var(--primary); color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 14px;">3</div><div style="flex: 1;"><p style="font-weight: 600;">สมหญิง สุขใส</p><p style="font-size: 12px; color: var(--text-muted);">ภาควิชาบริหาร</p></div><span class="badge badge-success">8 กิจกรรม</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">การดำเนินการ</h3>
                        </div>
                        <div class="card-body">
                            <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                                <a href="/admin/activities/create" class="btn btn-primary" style="justify-content: flex-start;"><i class="fa-solid fa-plus"></i> สร้างกิจกรรมใหม่</a>
                                <a href="/admin/participants/import" class="btn btn-secondary" style="justify-content: flex-start;"><i class="fa-solid fa-upload"></i> นำเข้าข้อมูลผู้เข้าร่วม</a>
                                <a href="/admin/reports/export" class="btn btn-secondary" style="justify-content: flex-start;"><i class="fa-solid fa-file-export"></i> ส่งออกรายงาน</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
@endsection

@section('script')
@endsection
