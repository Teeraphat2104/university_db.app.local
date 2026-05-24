@extends('layouts.app')

@section('title', 'Dashboard - Admin')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 class="fw-bold py-3 mb-0">Dashboard</h4>
        <p class="text-muted mb-0">ภาพรวมของระบบ</p>
    </div>
    <span class="text-muted small"><i class="bx bx-calendar me-1"></i><span id="current-date"></span></span>
</div>

<div class="row g-4 mb-4">
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-start justify-content-between">
                    <div>
                        <span class="fw-semibold d-block mb-1 text-muted">กิจกรรมทั้งหมด</span>
                        <h3 class="card-title mb-0">24</h3>
                    </div>
                    <div class="avatar avatar-sm flex-shrink-0">
                        <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-calendar-check"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-start justify-content-between">
                    <div>
                        <span class="fw-semibold d-block mb-1 text-muted">นักศึกษาทั้งหมด</span>
                        <h3 class="card-title mb-0">1,234</h3>
                    </div>
                    <div class="avatar avatar-sm flex-shrink-0">
                        <span class="avatar-initial rounded bg-label-success"><i class="bx bx-user"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-start justify-content-between">
                    <div>
                        <span class="fw-semibold d-block mb-1 text-muted">ผู้เข้าร่วม</span>
                        <h3 class="card-title mb-0">856</h3>
                    </div>
                    <div class="avatar avatar-sm flex-shrink-0">
                        <span class="avatar-initial rounded bg-label-warning"><i class="bx bx-user-plus"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-start justify-content-between">
                    <div>
                        <span class="fw-semibold d-block mb-1 text-muted">กิจกรรมวันนี้</span>
                        <h3 class="card-title mb-0">3</h3>
                    </div>
                    <div class="avatar avatar-sm flex-shrink-0">
                        <span class="avatar-initial rounded bg-label-danger"><i class="bx bx-calendar-event"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-12 col-lg-8">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0">กิจกรรมล่าสุด</h5>
                <a href="/admin/activities" class="btn btn-outline-secondary btn-sm">ดูทั้งหมด</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr><th>ชื่อกิจกรรม</th><th>วันที่</th><th>ผู้เข้าร่วม</th><th>สถานะ</th></tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><div class="fw-semibold">อบรมเทคโนโลยีสารสนเทศ</div><small class="text-muted">หมวดหมู่: การศึกษา</small></td>
                            <td>13 พ.ค. 2569</td><td>45 คน</td>
                            <td><span class="badge bg-label-success">เสร็จสิ้น</span></td>
                        </tr>
                        <tr>
                            <td><div class="fw-semibold">กีฬาสีภาคต้น</div><small class="text-muted">หมวดหมู่: กีฬา</small></td>
                            <td>14 พ.ค. 2569</td><td>120 คน</td>
                            <td><span class="badge bg-label-primary">กำลังดำเนิน</span></td>
                        </tr>
                        <tr>
                            <td><div class="fw-semibold">อาสาสมัครบริการชุมชน</div><small class="text-muted">หมวดหมู่: อาสา</small></td>
                            <td>15 พ.ค. 2569</td><td>30 คน</td>
                            <td><span class="badge bg-label-warning">รอดำเนินการ</span></td>
                        </tr>
                        <tr>
                            <td><div class="fw-semibold">สัมมนาพัฒนาทักษะ</div><small class="text-muted">หมวดหมู่: พัฒนาทักษะ</small></td>
                            <td>20 พ.ค. 2569</td><td>0 คน</td>
                            <td><span class="badge bg-label-warning">รอดำเนินการ</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-4">
        <div class="card">
            <div class="card-header"><h5 class="card-title mb-0">หมวดหมู่</h5></div>
            <div class="card-body d-flex flex-column gap-2">
                <div class="d-flex align-items-center justify-content-between px-3 py-2 rounded bg-lighter"><span class="fw-semibold text-primary">การศึกษา</span><span class="fw-bold text-primary">8</span></div>
                <div class="d-flex align-items-center justify-content-between px-3 py-2 rounded bg-lighter"><span class="fw-semibold text-success">กีฬา</span><span class="fw-bold text-success">5</span></div>
                <div class="d-flex align-items-center justify-content-between px-3 py-2 rounded bg-lighter"><span class="fw-semibold text-warning">อาสา</span><span class="fw-bold text-warning">4</span></div>
                <div class="d-flex align-items-center justify-content-between px-3 py-2 rounded bg-lighter"><span class="fw-semibold text-danger">พัฒนาทักษะ</span><span class="fw-bold text-danger">3</span></div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-12 col-lg-6">
        <div class="card">
            <div class="card-header"><h5 class="card-title mb-0">ผู้เข้าร่วมมากที่สุด (Top 5)</h5></div>
            <div class="card-body d-flex flex-column gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="d-flex align-items-center justify-content-center rounded-pill text-white fw-bold flex-shrink-0 bg-primary" style="width:32px;height:32px;font-size:.875rem">1</div>
                    <div class="flex-fill"><div class="fw-semibold">สมชาย ใจดี</div><small class="text-muted">ภาควิชาวิทยาศาสตร์</small></div>
                    <span class="badge bg-label-success">12 กิจกรรม</span>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="d-flex align-items-center justify-content-center rounded-pill text-white fw-bold flex-shrink-0 bg-primary" style="width:32px;height:32px;font-size:.875rem">2</div>
                    <div class="flex-fill"><div class="fw-semibold">สมศักดิ์ รักเรียน</div><small class="text-muted">ภาควิชาวิศวกรรม</small></div>
                    <span class="badge bg-label-success">10 กิจกรรม</span>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="d-flex align-items-center justify-content-center rounded-pill text-white fw-bold flex-shrink-0 bg-primary" style="width:32px;height:32px;font-size:.875rem">3</div>
                    <div class="flex-fill"><div class="fw-semibold">สมหญิง สุขใส</div><small class="text-muted">ภาควิชาบริหาร</small></div>
                    <span class="badge bg-label-success">8 กิจกรรม</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6">
        <div class="card">
            <div class="card-header"><h5 class="card-title mb-0">การดำเนินการ</h5></div>
            <div class="card-body d-flex flex-column gap-2">
                <a href="/admin/activities/create" class="btn btn-primary d-flex align-items-center"><i class="bx bx-plus me-2"></i> สร้างกิจกรรมใหม่</a>
                <a href="/admin/participants/import" class="btn btn-outline-secondary d-flex align-items-center"><i class="bx bx-upload me-2"></i> นำเข้าข้อมูลผู้เข้าร่วม</a>
                <a href="/admin/reports/export" class="btn btn-outline-secondary d-flex align-items-center"><i class="bx bx-export me-2"></i> ส่งออกรายงาน</a>
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
