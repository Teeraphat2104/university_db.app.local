@extends('layouts.app')

@section('title', 'Dashboard - Admin')

@section('content')
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem">
        <div>
            <h2 style="font-size:24px;font-weight:700;margin-bottom:0.25rem">Dashboard</h2>
            <p style="color:var(--text-muted)">ภาพรวมของระบบ</p>
        </div>
        <div style="display:flex;gap:0.75rem">
            <span id="current-date" style="font-size:14px;color:var(--text-muted);display:flex;align-items:center;gap:0.5rem">
                <i class="bi bi-calendar"></i>
            </span>
        </div>
    </div>
    <div class="stats-grid" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:1.5rem">
        <div class="stat-card" style="background:linear-gradient(135deg,#6366F1,#8B5CF6);border:none">
            <div class="stat-header">
                <div class="stat-icon" style="background:rgba(255,255,255,0.2)">
                    <i class="bi bi-calendar-event"></i>
                </div>
            </div>
            <p class="stat-value" style="color:white">24</p>
            <p class="stat-label" style="color:rgba(255,255,255,0.8)">กิจกรรมทั้งหมด</p>
            <div style="margin-top:0.75rem;display:flex;align-items:center;gap:0.5rem;font-size:12px;color:rgba(255,255,255,0.7)">
                <i class="bi bi-arrow-up" style="font-size:10px"></i>
                <span>12% จากเดือนก่อน</span>
            </div>
        </div>
        <div class="stat-card" style="background:linear-gradient(135deg,#10B981,#34D399);border:none">
            <div class="stat-header">
                <div class="stat-icon" style="background:rgba(255,255,255,0.2)">
                    <i class="bi bi-people"></i>
                </div>
            </div>
            <p class="stat-value" style="color:white">1,234</p>
            <p class="stat-label" style="color:rgba(255,255,255,0.8)">นักศึกษาทั้งหมด</p>
            <div style="margin-top:0.75rem;display:flex;align-items:center;gap:0.5rem;font-size:12px;color:rgba(255,255,255,0.7)">
                <i class="bi bi-arrow-up" style="font-size:10px"></i>
                <span>8% จากเดือนก่อน</span>
            </div>
        </div>
        <div class="stat-card" style="background:linear-gradient(135deg,#F59E0B,#FBBF24);border:none">
            <div class="stat-header">
                <div class="stat-icon" style="background:rgba(255,255,255,0.2)">
                    <i class="bi bi-person-plus"></i>
                </div>
            </div>
            <p class="stat-value" style="color:white">856</p>
            <p class="stat-label" style="color:rgba(255,255,255,0.8)">ผู้เข้าร่วม</p>
            <div style="margin-top:0.75rem;font-size:12px;color:rgba(255,255,255,0.7)">
                รออนุมัติ: <strong style="color:white">12</strong>
            </div>
        </div>
        <div class="stat-card" style="background:linear-gradient(135deg,#EF4444,#F87171);border:none">
            <div class="stat-header">
                <div class="stat-icon" style="background:rgba(255,255,255,0.2)">
                    <i class="bi bi-calendar-date"></i>
                </div>
            </div>
            <p class="stat-value" style="color:white">3</p>
            <p class="stat-label" style="color:rgba(255,255,255,0.8)">กิจกรรมวันนี้</p>
            <div style="margin-top:0.75rem;font-size:12px;color:rgba(255,255,255,0.7)">
                กำลังดำเนิน: <strong style="color:white">1</strong>
            </div>
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
                        <tr>
                            <td>
                                <p style="font-weight: 600;">อบรมเทคโนโลยีสารสนเทศ</p>
                                <p style="font-size: 12px; color: var(--text-muted);">หมวดหมู่: การศึกษา</p>
                            </td>
                            <td>13 พ.ค. 2569</td>
                            <td>45 คน</td>
                            <td><span class="badge badge-success">เสร็จสิ้น</span></td>
                        </tr>
                        <tr>
                            <td>
                                <p style="font-weight: 600;">กีฬาสีภาคต้น</p>
                                <p style="font-size: 12px; color: var(--text-muted);">หมวดหมู่: กีฬา</p>
                            </td>
                            <td>14 พ.ค. 2569</td>
                            <td>120 คน</td>
                            <td><span class="badge badge-primary">กำลังดำเนิน</span></td>
                        </tr>
                        <tr>
                            <td>
                                <p style="font-weight: 600;">อาสาสมัครบริการชุมชน</p>
                                <p style="font-size: 12px; color: var(--text-muted);">หมวดหมู่: อาสา</p>
                            </td>
                            <td>15 พ.ค. 2569</td>
                            <td>30 คน</td>
                            <td><span class="badge badge-warning">รอดำเนินการ</span></td>
                        </tr>
                        <tr>
                            <td>
                                <p style="font-weight: 600;">สัมมนาพัฒนาทักษะ</p>
                                <p style="font-size: 12px; color: var(--text-muted);">หมวดหมู่: พัฒนาทักษะ</p>
                            </td>
                            <td>20 พ.ค. 2569</td>
                            <td>0 คน</td>
                            <td><span class="badge badge-warning">รอดำเนินการ</span></td>
                        </tr>
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
                    <div
                        style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem; background: #EEF2FF; border-radius: var(--radius);">
                        <span style="font-weight: 600; color: var(--primary);">การศึกษา</span><span
                            style="font-weight: 700; color: var(--primary);">8</span>
                    </div>
                    <div
                        style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem; background: #DCFCE7; border-radius: var(--radius);">
                        <span style="font-weight: 600; color: var(--success);">กีฬา</span><span
                            style="font-weight: 700; color: var(--success);">5</span>
                    </div>
                    <div
                        style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem; background: #FEF3C7; border-radius: var(--radius);">
                        <span style="font-weight: 600; color: #B45309;">อาสา</span><span
                            style="font-weight: 700; color: #B45309;">4</span>
                    </div>
                    <div
                        style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem; background: #FEE2E2; border-radius: var(--radius);">
                        <span style="font-weight: 600; color: var(--danger);">พัฒนาทักษะ</span><span
                            style="font-weight: 700; color: var(--danger);">3</span>
                    </div>
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
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div
                            style="width: 32px; height: 32px; border-radius: 50%; background: var(--primary); color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 14px;">
                            1</div>
                        <div style="flex: 1;">
                            <p style="font-weight: 600;">สมชาย ใจดี</p>
                            <p style="font-size: 12px; color: var(--text-muted);">ภาควิชาวิทยาศาสตร์</p>
                        </div><span class="badge badge-success">12 กิจกรรม</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div
                            style="width: 32px; height: 32px; border-radius: 50%; background: var(--primary); color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 14px;">
                            2</div>
                        <div style="flex: 1;">
                            <p style="font-weight: 600;">สมศักดิ์ รักเรียน</p>
                            <p style="font-size: 12px; color: var(--text-muted);">ภาควิชาวิศวกรรม</p>
                        </div><span class="badge badge-success">10 กิจกรรม</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div
                            style="width: 32px; height: 32px; border-radius: 50%; background: var(--primary); color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 14px;">
                            3</div>
                        <div style="flex: 1;">
                            <p style="font-weight: 600;">สมหญิง สุขใส</p>
                            <p style="font-size: 12px; color: var(--text-muted);">ภาควิชาบริหาร</p>
                        </div><span class="badge badge-success">8 กิจกรรม</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">การดำเนินการ</h3>
            </div>
            <div class="card-body">
                <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                    <a href="/admin/activities/create" class="btn btn-primary" style="justify-content: flex-start;"><i
                            class="bi bi-plus"></i> สร้างกิจกรรมใหม่</a>
                    <a href="/admin/participants/import" class="btn btn-secondary"
                        style="justify-content: flex-start;"><i class="bi bi-upload"></i>
                        นำเข้าข้อมูลผู้เข้าร่วม</a>
                    <a href="/admin/reports/export" class="btn btn-secondary" style="justify-content: flex-start;"><i
                            class="bi bi-file-earmark-arrow-up"></i> ส่งออกรายงาน</a>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
@endsection
