@extends('layouts.master')

@section('title', 'กิจกรรมทั้งหมด - Admin')

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
                    <a href="/admin" class="nav-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                        Dashboard
                    </a>
                    <a href="/admin/activities" class="nav-item active">
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
                    <h1 class="page-title">กิจกรรมทั้งหมด</h1>
                </div>
                <div class="topbar-right">
                    <button class="topbar-btn">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                    </button>
                </div>
            </header>
            <div class="page-content">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                    <div>
                        <h2 style="font-size: 24px; font-weight: 700; margin-bottom: 0.25rem;">กิจกรรมทั้งหมด</h2>
                        <p style="color: var(--text-muted);">จัดการกิจกรรมของมหาวิทยาลัย</p>
                    </div>
                    <button class="btn btn-primary">
                        <i class="fa-solid fa-plus"></i>
                        สร้างกิจกรรมใหม่
                    </button>
                </div>

                <div class="card" style="margin-bottom: 1.5rem;">
                    <div class="card-body" style="display: flex; gap: 1rem; align-items: center; flex-wrap: wrap;">
                        <div style="flex: 1; min-width: 250px;">
                            <input type="text" placeholder="ค้นหากิจกรรม..." style="width: 100%; padding: 0.625rem 1rem; border: 1px solid var(--border); border-radius: var(--radius); font-size: 14px;">
                        </div>
                        <select style="padding: 0.625rem 1rem; border: 1px solid var(--border); border-radius: var(--radius); font-size: 14px; background: var(--surface);">
                            <option>ทุกหมวดหมู่</option>
                            <option>การศึกษา</option>
                            <option>กีฬา</option>
                            <option>อาสา</option>
                            <option>พัฒนาทักษะ</option>
                        </select>
                        <select style="padding: 0.625rem 1rem; border: 1px solid var(--border); border-radius: var(--radius); font-size: 14px; background: var(--surface);">
                            <option>ทุกสถานะ</option>
                            <option>รอดำเนินการ</option>
                            <option>กำลังดำเนิน</option>
                            <option>เสร็จสิ้น</option>
                        </select>
                        <button class="btn btn-secondary">
                            <i class="fa-solid fa-filter"></i>
                            กรอง
                        </button>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body" style="padding: 0;">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th style="width: 40px;"><input type="checkbox" style="width: 18px; height: 18px; cursor: pointer;"></th>
                                    <th>ชื่อกิจกรรม</th>
                                    <th>หมวดหมู่</th>
                                    <th>วันที่</th>
                                    <th>สถานที่</th>
                                    <th>ผู้เข้าร่วม</th>
                                    <th>สถานะ</th>
                                    <th style="width: 100px;">การดำเนินการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="checkbox" style="width: 18px; height: 18px; cursor: pointer;"></td>
                                    <td>
                                        <div style="display: flex; align-items: center; gap: 1rem;">
                                            <div style="width: 48px; height: 48px; border-radius: var(--radius); background: linear-gradient(135deg, #667eea, #764ba2); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700;">อ</div>
                                            <div><p style="font-weight: 600; margin-bottom: 2px;">อบรมเทคโนโลยีสารสนเทศ</p><p style="font-size: 12px; color: var(--text-muted);">สร้างเมื่อ 10 พ.ค. 2569</p></div>
                                        </div>
                                    </td>
                                    <td><span class="badge badge-primary">การศึกษา</span></td>
                                    <td>13 พ.ค. 2569</td>
                                    <td>ห้องปฏิบัติการคอมพิวเตอร์</td>
                                    <td><span style="font-weight: 600;">45</span> / 50</td>
                                    <td><span class="badge badge-success">เสร็จสิ้น</span></td>
                                    <td>
                                        <div style="display: flex; gap: 0.5rem;">
                                            <button class="btn btn-sm btn-secondary" style="padding: 0.375rem;"><i class="fa-regular fa-eye"></i></button>
                                            <button class="btn btn-sm btn-secondary" style="padding: 0.375rem;"><i class="fa-regular fa-pen-to-square"></i></button>
                                            <button class="btn btn-sm btn-secondary" style="padding: 0.375rem; color: var(--danger);"><i class="fa-regular fa-trash-can"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" style="width: 18px; height: 18px; cursor: pointer;"></td>
                                    <td>
                                        <div style="display: flex; align-items: center; gap: 1rem;">
                                            <div style="width: 48px; height: 48px; border-radius: var(--radius); background: linear-gradient(135deg, #f093fb, #f5576c); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700;">ก</div>
                                            <div><p style="font-weight: 600; margin-bottom: 2px;">กีฬาสีภาคต้น</p><p style="font-size: 12px; color: var(--text-muted);">สร้างเมื่อ 8 พ.ค. 2569</p></div>
                                        </div>
                                    </td>
                                    <td><span class="badge badge-success">กีฬา</span></td>
                                    <td>14 พ.ค. 2569</td>
                                    <td>สนามกีฬากลาง</td>
                                    <td><span style="font-weight: 600;">120</span> / 200</td>
                                    <td><span class="badge badge-primary">กำลังดำเนิน</span></td>
                                    <td>
                                        <div style="display: flex; gap: 0.5rem;">
                                            <button class="btn btn-sm btn-secondary" style="padding: 0.375rem;"><i class="fa-regular fa-eye"></i></button>
                                            <button class="btn btn-sm btn-secondary" style="padding: 0.375rem;"><i class="fa-regular fa-pen-to-square"></i></button>
                                            <button class="btn btn-sm btn-secondary" style="padding: 0.375rem; color: var(--danger);"><i class="fa-regular fa-trash-can"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" style="width: 18px; height: 18px; cursor: pointer;"></td>
                                    <td>
                                        <div style="display: flex; align-items: center; gap: 1rem;">
                                            <div style="width: 48px; height: 48px; border-radius: var(--radius); background: linear-gradient(135deg, #4facfe, #00f2fe); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700;">อ</div>
                                            <div><p style="font-weight: 600; margin-bottom: 2px;">อาสาสมัครบริการชุมชน</p><p style="font-size: 12px; color: var(--text-muted);">สร้างเมื่อ 5 พ.ค. 2569</p></div>
                                        </div>
                                    </td>
                                    <td><span class="badge badge-warning">อาสา</span></td>
                                    <td>15 พ.ค. 2569</td>
                                    <td>ชุมชนวัดสว่าง</td>
                                    <td><span style="font-weight: 600;">30</span> / 40</td>
                                    <td><span class="badge badge-warning">รอดำเนินการ</span></td>
                                    <td>
                                        <div style="display: flex; gap: 0.5rem;">
                                            <button class="btn btn-sm btn-secondary" style="padding: 0.375rem;"><i class="fa-regular fa-eye"></i></button>
                                            <button class="btn btn-sm btn-secondary" style="padding: 0.375rem;"><i class="fa-regular fa-pen-to-square"></i></button>
                                            <button class="btn btn-sm btn-secondary" style="padding: 0.375rem; color: var(--danger);"><i class="fa-regular fa-trash-can"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" style="width: 18px; height: 18px; cursor: pointer;"></td>
                                    <td>
                                        <div style="display: flex; align-items: center; gap: 1rem;">
                                            <div style="width: 48px; height: 48px; border-radius: var(--radius); background: linear-gradient(135deg, #fa709a, #fee140); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700;">ส</div>
                                            <div><p style="font-weight: 600; margin-bottom: 2px;">สัมมนาพัฒนาทักษะ</p><p style="font-size: 12px; color: var(--text-muted);">สร้างเมื่อ 1 พ.ค. 2569</p></div>
                                        </div>
                                    </td>
                                    <td><span class="badge badge-danger">พัฒนาทักษะ</span></td>
                                    <td>20 พ.ค. 2569</td>
                                    <td>ห้องประชุมใหญ่</td>
                                    <td><span style="font-weight: 600;">0</span> / 100</td>
                                    <td><span class="badge badge-warning">รอดำเนินการ</span></td>
                                    <td>
                                        <div style="display: flex; gap: 0.5rem;">
                                            <button class="btn btn-sm btn-secondary" style="padding: 0.375rem;"><i class="fa-regular fa-eye"></i></button>
                                            <button class="btn btn-sm btn-secondary" style="padding: 0.375rem;"><i class="fa-regular fa-pen-to-square"></i></button>
                                            <button class="btn btn-sm btn-secondary" style="padding: 0.375rem; color: var(--danger);"><i class="fa-regular fa-trash-can"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" style="width: 18px; height: 18px; cursor: pointer;"></td>
                                    <td>
                                        <div style="display: flex; align-items: center; gap: 1rem;">
                                            <div style="width: 48px; height: 48px; border-radius: var(--radius); background: linear-gradient(135deg, #a8edea, #fed6e3); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; color: #333;">ว</div>
                                            <div><p style="font-weight: 600; margin-bottom: 2px;">วิทยาศาสตร์สำหรับเด็ก</p><p style="font-size: 12px; color: var(--text-muted);">สร้างเมื่อ 28 เม.ย. 2569</p></div>
                                        </div>
                                    </td>
                                    <td><span class="badge badge-primary">การศึกษา</span></td>
                                    <td>25 เม.ย. 2569</td>
                                    <td>พิพิธภัณฑ์วิทยา</td>
                                    <td><span style="font-weight: 600;">60</span> / 60</td>
                                    <td><span class="badge badge-success">เสร็จสิ้น</span></td>
                                    <td>
                                        <div style="display: flex; gap: 0.5rem;">
                                            <button class="btn btn-sm btn-secondary" style="padding: 0.375rem;"><i class="fa-regular fa-eye"></i></button>
                                            <button class="btn btn-sm btn-secondary" style="padding: 0.375rem;"><i class="fa-regular fa-pen-to-square"></i></button>
                                            <button class="btn btn-sm btn-secondary" style="padding: 0.375rem; color: var(--danger);"><i class="fa-regular fa-trash-can"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1.5rem;">
                    <p style="color: var(--text-muted); font-size: 14px;">แสดง 1-5 จาก 24 รายการ</p>
                    <div style="display: flex; gap: 0.5rem;">
                        <button class="btn btn-sm btn-secondary" disabled>ก่อนหน้า</button>
                        <button class="btn btn-sm btn-primary">1</button>
                        <button class="btn btn-sm btn-secondary">2</button>
                        <button class="btn btn-sm btn-secondary">3</button>
                        <button class="btn btn-sm btn-secondary">4</button>
                        <button class="btn btn-sm btn-secondary">5</button>
                        <button class="btn btn-sm btn-secondary">ถัดไป</button>
                    </div>
                </div>
            </div>
        </main>
    </div>
@endsection

@section('script')
@endsection
