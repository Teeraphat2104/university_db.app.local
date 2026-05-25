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

<div id="dash-loading" class="text-center py-5 text-muted">
    <div class="spinner-border spinner-border-sm mb-2" role="status"></div><br>
    กำลังโหลด...
</div>

<div id="dash-content" class="d-none">
    <div class="row g-4 mb-4">
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <span class="fw-semibold d-block mb-1 text-muted">กิจกรรมทั้งหมด</span>
                            <h3 class="card-title mb-0" id="stat-activities">—</h3>
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
                            <span class="fw-semibold d-block mb-1 text-muted">หมวดหมู่ทั้งหมด</span>
                            <h3 class="card-title mb-0" id="stat-categories">—</h3>
                        </div>
                        <div class="avatar avatar-sm flex-shrink-0">
                            <span class="avatar-initial rounded bg-label-success"><i class="bx bx-category"></i></span>
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
                            <span class="fw-semibold d-block mb-1 text-muted">ผู้เข้าร่วมทั้งหมด</span>
                            <h3 class="card-title mb-0" id="stat-participants">—</h3>
                        </div>
                        <div class="avatar avatar-sm flex-shrink-0">
                            <span class="avatar-initial rounded bg-label-warning"><i class="bx bx-user"></i></span>
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
                            <span class="fw-semibold d-block mb-1 text-muted">เอกสาร PDF</span>
                            <h3 class="card-title mb-0" id="stat-documents">—</h3>
                        </div>
                        <div class="avatar avatar-sm flex-shrink-0">
                            <span class="avatar-initial rounded bg-label-info"><i class="bx bx-file"></i></span>
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
                            <span class="fw-semibold d-block mb-1 text-muted">ยอดเข้าชมรวม</span>
                            <h3 class="card-title mb-0" id="stat-views">—</h3>
                        </div>
                        <div class="avatar avatar-sm flex-shrink-0">
                            <span class="avatar-initial rounded bg-label-danger"><i class="bx bx-show"></i></span>
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
                            <span class="fw-semibold d-block mb-1 text-muted">ยอดดาวน์โหลดรวม</span>
                            <h3 class="card-title mb-0" id="stat-downloads">—</h3>
                        </div>
                        <div class="avatar avatar-sm flex-shrink-0">
                            <span class="avatar-initial rounded bg-label-secondary"><i class="bx bx-download"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex align-items-center gap-3 mb-4">
        <span class="badge bg-label-primary px-3 py-2 fs-6" id="today-badge">
            <i class="bx bx-calendar-event me-1"></i>กิจกรรมวันนี้: <span id="today-count">—</span>
        </span>
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
                        <tbody id="recent-tbody">
                            <tr><td colspan="4" class="text-center text-muted py-3">ไม่มีข้อมูล</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="card">
                <div class="card-header"><h5 class="card-title mb-0">หมวดหมู่</h5></div>
                <div class="card-body d-flex flex-column gap-2" id="category-list">
                    <div class="text-center text-muted small py-3">ไม่มีข้อมูล</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-12 col-lg-6">
            <div class="card h-100">
                <div class="card-header"><h5 class="card-title mb-0"><i class="bx bx-show text-primary me-1"></i>อ่านมากที่สุด</h5></div>
                <div class="card-body d-flex flex-column gap-3" id="most-viewed-list">
                    <div class="text-center text-muted small py-3">ไม่มีข้อมูล</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="card h-100">
                <div class="card-header"><h5 class="card-title mb-0"><i class="bx bx-download text-success me-1"></i>ดาวน์โหลดมากที่สุด</h5></div>
                <div class="card-body d-flex flex-column gap-3" id="most-downloaded-list">
                    <div class="text-center text-muted small py-3">ไม่มีข้อมูล</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-12 col-lg-6">
            <div class="card">
                <div class="card-header"><h5 class="card-title mb-0">การดำเนินการ</h5></div>
                <div class="card-body d-flex flex-column gap-2">
                    <a href="/admin/activities" class="btn btn-primary d-flex align-items-center" onclick="openCreateModal()"><i class="bx bx-plus me-2"></i> สร้างกิจกรรมใหม่</a>
                    <a href="/admin/participants/import" class="btn btn-outline-secondary d-flex align-items-center"><i class="bx bx-upload me-2"></i> นำเข้าข้อมูลผู้เข้าร่วม</a>
                    <a href="/admin/reports/export" class="btn btn-outline-secondary d-flex align-items-center"><i class="bx bx-export me-2"></i> ส่งออกรายงาน</a>
                </div>
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

    var token = localStorage.getItem('admin_token');
    if (!token) { $('#dash-loading').html('กรุณา <a href="/login" class="text-primary">เข้าสู่ระบบ</a>'); return; }

    $.ajax({
        url: '/api/admin/dashboard',
        method: 'POST',
        headers: { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' },
        success: function(json) {
            if (!json.data) return;
            var data = json.data;
            var s = data.stats;

            $('#stat-activities').text(s.total_activities);
            $('#stat-categories').text(s.total_categories);
            $('#stat-participants').text(s.total_participants);
            $('#stat-documents').text(s.total_documents);
            $('#stat-views').text(Number(s.total_views).toLocaleString());
            $('#stat-downloads').text(Number(s.total_downloads).toLocaleString());
            $('#today-count').text(data.today_activities);

            $('#dash-loading').addClass('d-none');
            $('#dash-content').removeClass('d-none');

            // Recent activities
            var $recent = $('#recent-tbody').empty();
            if (data.recent_activities && data.recent_activities.length) {
                $.each(data.recent_activities, function(i, a) {
                    var statusHtml = a.status ? '<span class="badge bg-label-success">เปิดใช้งาน</span>' : '<span class="badge bg-label-warning">ปิดใช้งาน</span>';
                    $recent.append('<tr><td><div class="fw-semibold">' + $('<span>').text(a.title).html() + '</div><small class="text-muted">หมวดหมู่: ' + $('<span>').text(a.category_name || '-').html() + '</small></td><td>' + (a.activity_date || '-') + '</td><td>' + a.participants_count + ' คน</td><td>' + statusHtml + '</td></tr>');
                });
            } else {
                $recent.html('<tr><td colspan="4" class="text-center text-muted py-3">ไม่มีข้อมูล</td></tr>');
            }

            // Category stats
            var $cats = $('#category-list').empty();
            if (data.category_stats && data.category_stats.length) {
                var colors = ['primary', 'success', 'warning', 'danger', 'info'];
                $.each(data.category_stats, function(i, c) {
                    var cls = colors[i % colors.length];
                    $cats.append('<div class="d-flex align-items-center justify-content-between px-3 py-2 rounded bg-lighter"><span class="fw-semibold text-' + cls + '">' + $('<span>').text(c.name).html() + '</span><span class="fw-bold text-' + cls + '">' + c.count + '</span></div>');
                });
            } else {
                $cats.html('<div class="text-center text-muted small py-3">ไม่มีข้อมูล</div>');
            }

            // Most viewed
            var $viewed = $('#most-viewed-list').empty();
            if (data.most_viewed && data.most_viewed.length) {
                $.each(data.most_viewed, function(i, a) {
                    var rank = i + 1;
                    $viewed.append('<div class="d-flex align-items-center gap-3"><div class="d-flex align-items-center justify-content-center rounded-pill text-white fw-bold flex-shrink-0 bg-primary" style="width:28px;height:28px;font-size:.75rem">' + rank + '</div><div class="flex-fill"><div class="fw-semibold small">' + $('<span>').text(a.title).html() + '</div></div><span class="badge bg-label-primary flex-shrink-0">' + Number(a.view_count).toLocaleString() + ' ครั้ง</span></div>');
                });
            } else {
                $viewed.html('<div class="text-center text-muted small py-3">ไม่มีข้อมูล</div>');
            }

            // Most downloaded
            var $downloaded = $('#most-downloaded-list').empty();
            if (data.most_downloaded && data.most_downloaded.length) {
                $.each(data.most_downloaded, function(i, a) {
                    var rank = i + 1;
                    $downloaded.append('<div class="d-flex align-items-center gap-3"><div class="d-flex align-items-center justify-content-center rounded-pill text-white fw-bold flex-shrink-0 bg-success" style="width:28px;height:28px;font-size:.75rem">' + rank + '</div><div class="flex-fill"><div class="fw-semibold small">' + $('<span>').text(a.title).html() + '</div></div><span class="badge bg-label-success flex-shrink-0">' + Number(a.download_count).toLocaleString() + ' ครั้ง</span></div>');
                });
            } else {
                $downloaded.html('<div class="text-center text-muted small py-3">ไม่มีข้อมูล</div>');
            }
        },
        error: function() {
            $('#dash-loading').html('เกิดข้อผิดพลาดในการโหลดข้อมูล');
        }
    });
});
</script>
@endsection
