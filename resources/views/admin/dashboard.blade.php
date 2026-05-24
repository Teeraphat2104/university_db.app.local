@extends('layouts.app')

@section('title', 'Dashboard - Admin')

@section('content')
<div class="page-header">
    <div>
        <h2 class="page-title">Dashboard</h2>
        <p class="page-subtitle">ภาพรวมของระบบ</p>
    </div>
    <span style="font-size:.875rem;color:var(--gray-400);"><i class="fa-regular fa-calendar me-1"></i><span id="current-date"></span></span>
</div>

<div class="row g-4 mb-4">
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon primary"><i class="fa-regular fa-calendar-check"></i></div>
            </div>
            <p class="stat-value">24</p>
            <p class="stat-label">กิจกรรมทั้งหมด</p>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon success"><i class="fa-solid fa-users"></i></div>
            </div>
            <p class="stat-value">1,234</p>
            <p class="stat-label">นักศึกษาทั้งหมด</p>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon warning"><i class="fa-solid fa-user-plus"></i></div>
            </div>
            <p class="stat-value">856</p>
            <p class="stat-label">ผู้เข้าร่วม</p>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon danger"><i class="fa-regular fa-calendar"></i></div>
            </div>
            <p class="stat-value">3</p>
            <p class="stat-label">กิจกรรมวันนี้</p>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-12 col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">กิจกรรมล่าสุด</h3>
                <a href="/admin/activities" class="btn btn-sm btn-secondary">ดูทั้งหมด</a>
            </div>
            <div class="card-body p-0">
                <table class="data-table">
                    <thead>
                        <tr><th>ชื่อกิจกรรม</th><th>วันที่</th><th>ผู้เข้าร่วม</th><th>สถานะ</th></tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><p class="fw-semibold">อบรมเทคโนโลยีสารสนเทศ</p><p style="font-size:.75rem;color:var(--gray-400)">หมวดหมู่: การศึกษา</p></td>
                            <td>13 พ.ค. 2569</td><td>45 คน</td>
                            <td><span class="badge badge-success">เสร็จสิ้น</span></td>
                        </tr>
                        <tr>
                            <td><p class="fw-semibold">กีฬาสีภาคต้น</p><p style="font-size:.75rem;color:var(--gray-400)">หมวดหมู่: กีฬา</p></td>
                            <td>14 พ.ค. 2569</td><td>120 คน</td>
                            <td><span class="badge badge-primary">กำลังดำเนิน</span></td>
                        </tr>
                        <tr>
                            <td><p class="fw-semibold">อาสาสมัครบริการชุมชน</p><p style="font-size:.75rem;color:var(--gray-400)">หมวดหมู่: อาสา</p></td>
                            <td>15 พ.ค. 2569</td><td>30 คน</td>
                            <td><span class="badge badge-warning">รอดำเนินการ</span></td>
                        </tr>
                        <tr>
                            <td><p class="fw-semibold">สัมมนาพัฒนาทักษะ</p><p style="font-size:.75rem;color:var(--gray-400)">หมวดหมู่: พัฒนาทักษะ</p></td>
                            <td>20 พ.ค. 2569</td><td>0 คน</td>
                            <td><span class="badge badge-warning">รอดำเนินการ</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-4">
        <div class="card">
            <div class="card-header"><h3 class="card-title">หมวดหมู่</h3></div>
            <div class="card-body d-flex flex-column" style="gap:.75rem">
                <div class="d-flex align-items-center justify-content-between px-3 py-2" style="border-radius:.5rem;background:#EEF2FF"><span class="fw-semibold" style="color:#4F46E5">การศึกษา</span><span class="fw-bold" style="color:#4F46E5">8</span></div>
                <div class="d-flex align-items-center justify-content-between px-3 py-2" style="border-radius:.5rem;background:#ECFDF5"><span class="fw-semibold" style="color:#059669">กีฬา</span><span class="fw-bold" style="color:#059669">5</span></div>
                <div class="d-flex align-items-center justify-content-between px-3 py-2" style="border-radius:.5rem;background:#FFFBEB"><span class="fw-semibold" style="color:#D97706">อาสา</span><span class="fw-bold" style="color:#D97706">4</span></div>
                <div class="d-flex align-items-center justify-content-between px-3 py-2" style="border-radius:.5rem;background:#FEF2F2"><span class="fw-semibold" style="color:#DC2626">พัฒนาทักษะ</span><span class="fw-bold" style="color:#DC2626">3</span></div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-12 col-lg-6">
        <div class="card">
            <div class="card-header"><h3 class="card-title">ผู้เข้าร่วมมากที่สุด (Top 5)</h3></div>
            <div class="card-body d-flex flex-column" style="gap:1rem">
                <div class="d-flex align-items-center" style="gap:.75rem">
                    <div class="d-flex align-items-center justify-content-center flex-shrink-0 rounded-pill text-white fw-bold" style="width:32px;height:32px;background:#4F46E5;font-size:.875rem">1</div>
                    <div class="flex-fill"><p class="fw-semibold mb-0">สมชาย ใจดี</p><p style="font-size:.75rem;color:var(--gray-400);margin:0">ภาควิชาวิทยาศาสตร์</p></div>
                    <span class="badge badge-success">12 กิจกรรม</span>
                </div>
                <div class="d-flex align-items-center" style="gap:.75rem">
                    <div class="d-flex align-items-center justify-content-center flex-shrink-0 rounded-pill text-white fw-bold" style="width:32px;height:32px;background:#4F46E5;font-size:.875rem">2</div>
                    <div class="flex-fill"><p class="fw-semibold mb-0">สมศักดิ์ รักเรียน</p><p style="font-size:.75rem;color:var(--gray-400);margin:0">ภาควิชาวิศวกรรม</p></div>
                    <span class="badge badge-success">10 กิจกรรม</span>
                </div>
                <div class="d-flex align-items-center" style="gap:.75rem">
                    <div class="d-flex align-items-center justify-content-center flex-shrink-0 rounded-pill text-white fw-bold" style="width:32px;height:32px;background:#4F46E5;font-size:.875rem">3</div>
                    <div class="flex-fill"><p class="fw-semibold mb-0">สมหญิง สุขใส</p><p style="font-size:.75rem;color:var(--gray-400);margin:0">ภาควิชาบริหาร</p></div>
                    <span class="badge badge-success">8 กิจกรรม</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6">
        <div class="card">
            <div class="card-header"><h3 class="card-title">การดำเนินการ</h3></div>
            <div class="card-body d-flex flex-column" style="gap:.75rem">
                <a href="/admin/activities/create" class="btn btn-primary" style="text-align:left"><i class="fa-solid fa-plus"></i> สร้างกิจกรรมใหม่</a>
                <a href="/admin/participants/import" class="btn btn-secondary" style="text-align:left"><i class="fa-solid fa-upload"></i> นำเข้าข้อมูลผู้เข้าร่วม</a>
                <a href="/admin/reports/export" class="btn btn-secondary" style="text-align:left"><i class="fa-solid fa-file-export"></i> ส่งออกรายงาน</a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
$(function() {
    var d = new Date();
    var months = ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'];
    var days = ['อาทิตย์','จันทร์','อังคาร','พุธ','พฤหัสบดี','ศุกร์','เสาร์'];
    $('#current-date').text(days[d.getDay()] + 'ที่ ' + d.getDate() + ' ' + months[d.getMonth()] + ' ' + (d.getFullYear()+543));
});
</script>
@endsection
