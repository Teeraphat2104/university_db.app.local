@extends('layouts.app')

@section('title', 'Dashboard - Admin')

@section('style')
    .dash-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; }
    .dash-title { font-size: 24px; font-weight: 700; margin-bottom: 0.25rem; }
    .dash-subtitle { color: var(--text-muted); }
    .dash-header-right { display: flex; gap: 0.75rem; }
    .dash-date { font-size: 14px; color: var(--text-muted); display: flex; align-items: center; gap: 0.5rem; }
    .stat-card-colored { border: none !important; }
    .stat-card-colored .stat-header .stat-icon { background: rgba(255,255,255,0.2) !important; }
    .stat-card-colored .stat-value { color: white; }
    .stat-card-colored .stat-label { color: rgba(255,255,255,0.8); }
    .stat-trend-colored { margin-top: 0.75rem; display: flex; align-items: center; gap: 0.5rem; font-size: 12px; color: rgba(255,255,255,0.7); }
    .stat-card-purple { background: linear-gradient(135deg,#6366F1,#8B5CF6); }
    .stat-card-green { background: linear-gradient(135deg,#10B981,#34D399); }
    .stat-card-amber { background: linear-gradient(135deg,#F59E0B,#FBBF24); }
    .stat-card-red { background: linear-gradient(135deg,#EF4444,#F87171); }
    .dash-grid-2 { display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem; }
    .card-body-no-pad { padding: 0; }
    .category-item { display: flex; justify-content: space-between; align-items: center; padding: 0.75rem; border-radius: var(--radius); }
    .category-item-blue { background: #EEF2FF; }
    .category-item-blue span { font-weight: 600; color: var(--primary); }
    .category-item-green { background: #DCFCE7; }
    .category-item-green span { font-weight: 600; color: var(--success); }
    .category-item-amber { background: #FEF3C7; }
    .category-item-amber span { font-weight: 600; color: #B45309; }
    .category-item-red { background: #FEE2E2; }
    .category-item-red span { font-weight: 600; color: var(--danger); }
    .cat-val { font-weight: 700; }
    .cat-val-blue { color: var(--primary); }
    .cat-val-green { color: var(--success); }
    .cat-val-amber { color: #B45309; }
    .cat-val-red { color: var(--danger); }
    .dash-grid-half { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; }
    .rank-num { width: 32px; height: 32px; border-radius: 50%; background: var(--primary); color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 14px; flex-shrink: 0; }
    .student-name { font-weight: 600; }
    .student-dept { font-size: 12px; color: var(--text-muted); }
    .action-list { display: flex; flex-direction: column; gap: 0.75rem; }
    .action-list .btn { justify-content: flex-start; }
    .activity-name { font-weight: 600; }
    .activity-cat { font-size: 12px; color: var(--text-muted); }
    .cat-wrap { display: flex; flex-direction: column; gap: 0.75rem; }
    .cat-row { display: flex; justify-content: space-between; align-items: center; }
    .top-student-row { display: flex; align-items: center; gap: 1rem; }
    .top-student-info { flex: 1; }
    .dash-charts { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; }
@endsection

@section('content')
    <div class="dash-header">
        <div>
            <h2 class="dash-title">Dashboard</h2>
            <p class="dash-subtitle">ภาพรวมของระบบ</p>
        </div>
        <div class="dash-header-right">
            <span id="current-date" class="dash-date">
                <i class="bi bi-calendar"></i>
            </span>
        </div>
    </div>
    <div class="stats-grid" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:1.5rem">
        <div class="stat-card stat-card-colored stat-card-purple">
            <div class="stat-header">
                <div class="stat-icon">
                    <i class="bi bi-calendar-event"></i>
                </div>
            </div>
            <p class="stat-value">24</p>
            <p class="stat-label">กิจกรรมทั้งหมด</p>
            <div class="stat-trend-colored">
                <i class="bi bi-arrow-up" style="font-size:10px"></i>
                <span>12% จากเดือนก่อน</span>
            </div>
        </div>
        <div class="stat-card stat-card-colored stat-card-green">
            <div class="stat-header">
                <div class="stat-icon">
                    <i class="bi bi-people"></i>
                </div>
            </div>
            <p class="stat-value">1,234</p>
            <p class="stat-label">นักศึกษาทั้งหมด</p>
            <div class="stat-trend-colored">
                <i class="bi bi-arrow-up" style="font-size:10px"></i>
                <span>8% จากเดือนก่อน</span>
            </div>
        </div>
        <div class="stat-card stat-card-colored stat-card-amber">
            <div class="stat-header">
                <div class="stat-icon">
                    <i class="bi bi-person-plus"></i>
                </div>
            </div>
            <p class="stat-value">856</p>
            <p class="stat-label">ผู้เข้าร่วม</p>
            <div class="stat-trend-colored">
                รออนุมัติ: <strong style="color:white">12</strong>
            </div>
        </div>
        <div class="stat-card stat-card-colored stat-card-red">
            <div class="stat-header">
                <div class="stat-icon">
                    <i class="bi bi-calendar-date"></i>
                </div>
            </div>
            <p class="stat-value">3</p>
            <p class="stat-label">กิจกรรมวันนี้</p>
            <div class="stat-trend-colored">
                กำลังดำเนิน: <strong style="color:white">1</strong>
            </div>
        </div>
    </div>

    <div class="dash-grid-2">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">กิจกรรมล่าสุด</h3>
                <a href="/admin/activities" class="btn btn-sm btn-secondary">ดูทั้งหมด</a>
            </div>
            <div class="card-body card-body-no-pad">
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
                                <p class="activity-name">อบรมเทคโนโลยีสารสนเทศ</p>
                                <p class="activity-cat">หมวดหมู่: การศึกษา</p>
                            </td>
                            <td>13 พ.ค. 2569</td>
                            <td>45 คน</td>
                            <td><span class="badge badge-success">เสร็จสิ้น</span></td>
                        </tr>
                        <tr>
                            <td>
                                <p class="activity-name">กีฬาสีภาคต้น</p>
                                <p class="activity-cat">หมวดหมู่: กีฬา</p>
                            </td>
                            <td>14 พ.ค. 2569</td>
                            <td>120 คน</td>
                            <td><span class="badge badge-primary">กำลังดำเนิน</span></td>
                        </tr>
                        <tr>
                            <td>
                                <p class="activity-name">อาสาสมัครบริการชุมชน</p>
                                <p class="activity-cat">หมวดหมู่: อาสา</p>
                            </td>
                            <td>15 พ.ค. 2569</td>
                            <td>30 คน</td>
                            <td><span class="badge badge-warning">รอดำเนินการ</span></td>
                        </tr>
                        <tr>
                            <td>
                                <p class="activity-name">สัมมนาพัฒนาทักษะ</p>
                                <p class="activity-cat">หมวดหมู่: พัฒนาทักษะ</p>
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
                <div class="cat-wrap">
                    <div class="category-item category-item-blue">
                        <span>การศึกษา</span><span class="cat-val cat-val-blue">8</span>
                    </div>
                    <div class="category-item category-item-green">
                        <span>กีฬา</span><span class="cat-val cat-val-green">5</span>
                    </div>
                    <div class="category-item category-item-amber">
                        <span>อาสา</span><span class="cat-val cat-val-amber">4</span>
                    </div>
                    <div class="category-item category-item-red">
                        <span>พัฒนาทักษะ</span><span class="cat-val cat-val-red">3</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="dash-charts">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">ผู้เข้าร่วมมากที่สุด (Top 5)</h3>
            </div>
            <div class="card-body">
                <div class="cat-wrap">
                    <div class="top-student-row">
                        <div class="rank-num">1</div>
                        <div class="top-student-info">
                            <p class="student-name">สมชาย ใจดี</p>
                            <p class="student-dept">ภาควิชาวิทยาศาสตร์</p>
                        </div><span class="badge badge-success">12 กิจกรรม</span>
                    </div>
                    <div class="top-student-row">
                        <div class="rank-num">2</div>
                        <div class="top-student-info">
                            <p class="student-name">สมศักดิ์ รักเรียน</p>
                            <p class="student-dept">ภาควิชาวิศวกรรม</p>
                        </div><span class="badge badge-success">10 กิจกรรม</span>
                    </div>
                    <div class="top-student-row">
                        <div class="rank-num">3</div>
                        <div class="top-student-info">
                            <p class="student-name">สมหญิง สุขใส</p>
                            <p class="student-dept">ภาควิชาบริหาร</p>
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
                <div class="action-list">
                    <a href="/admin/activities/create" class="btn btn-primary"><i class="bi bi-plus"></i> สร้างกิจกรรมใหม่</a>
                    <a href="/admin/participants/import" class="btn btn-secondary"><i class="bi bi-upload"></i> นำเข้าข้อมูลผู้เข้าร่วม</a>
                    <a href="/admin/reports/export" class="btn btn-secondary"><i class="bi bi-file-earmark-arrow-up"></i> ส่งออกรายงาน</a>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
@endsection
