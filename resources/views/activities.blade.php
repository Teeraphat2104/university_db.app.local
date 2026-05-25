@extends('layouts.master')

@section('title', 'กิจกรรมทั้งหมด - University Activities')

@section('style')
<style>
.site-back-btn {
    display: inline-flex; align-items: center; gap: .375rem;
    padding: .375rem .875rem; font-size: .8125rem; font-weight: 600;
    color: #64748b; border: 1px solid #e2e8f0; border-radius: 8px;
    background: #fff; text-decoration: none;
    transition: all .15s ease;
}
.site-back-btn:hover { color: #1e293b; border-color: #cbd5e1; background: #f8fafc; }
</style>
@endsection

@section('content')
@php $siteName = setting('site_name', 'University Activities'); $siteDesc = setting('site_description', 'ระบบจัดการกิจกรรมและเอกสารของมหาวิทยาลัย'); $footerText = setting('footer_text', '© ' . date('Y') . ' University Activities. สงวนลิขสิทธิ์ทั้งหมด'); @endphp

<div style="background:#f8fafc;border-bottom:1px solid #f1f5f9">
    <div class="mx-auto px-4 py-2" style="max-width:72rem">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="/" class="text-decoration-none">หน้าหลัก</a></li>
                <li class="breadcrumb-item active" aria-current="page">กิจกรรมทั้งหมด</li>
            </ol>
        </nav>
    </div>
</div>

<div class="bg-white py-5">
    <div class="mx-auto px-4" style="max-width:72rem">
        <a href="javascript:history.back()" class="site-back-btn mb-3"><i class="bx bx-arrow-back"></i> ย้อนกลับ</a>
        <div class="d-flex flex-column flex-sm-row align-items-sm-center gap-4 mb-4">
            <h1 class="h4 fw-bold flex-shrink-0 mb-0">กิจกรรมทั้งหมด</h1>
            <div class="d-flex flex-column flex-sm-row gap-2 flex-grow-1">
                <div class="position-relative flex-grow-1">
                    <i class="bx bx-search position-absolute top-50" style="left:.75rem;transform:translateY(-50%);color:#9ca3af;font-size:.875rem;pointer-events:none"></i>
                    <input type="text" id="search-input" class="form-control" placeholder="ค้นหากิจกรรม..." style="padding-left:2.25rem">
                </div>
                <select id="filter-category" class="form-select" style="min-width:140px">
                    <option value="">ทุกหมวดหมู่</option>
                </select>
                <select id="filter-year" class="form-select" style="min-width:120px">
                    <option value="">ทุกปี</option>
                    @for ($y = date('Y') + 543; $y >= date('Y') + 543 - 5; $y--)
                        <option value="{{ $y - 543 }}">{{ $y }}</option>
                    @endfor
                </select>
            </div>
        </div>
        <p class="d-flex align-items-center gap-2 text-muted small mb-4">
            <i class="bx bx-bulb" style="color:#f59e0b"></i> รวมกิจกรรมและเอกสารของมหาวิทยาลัย
        </p>
        <div id="activities-grid" class="row g-4">
            <div class="col-12 text-center py-5 text-muted">
                <div class="spinner-border spinner-border-sm mb-3" role="status"></div>
                <p>กำลังโหลดข้อมูล...</p>
            </div>
        </div>
        <div id="pagination" class="d-flex align-items-center justify-content-between gap-4 mt-4 flex-wrap">
            <p id="pagination-info" class="text-muted small mb-0"></p>
            <div id="pagination-btns" class="d-flex gap-1"></div>
        </div>
    </div>
</div>

<footer style="background:#111827;color:#9ca3af;padding:3rem 1.5rem">
    <div class="mx-auto" style="max-width:72rem">
        <div class="d-flex flex-wrap justify-content-between gap-4" style="padding-bottom:2rem;border-bottom:1px solid rgba(255,255,255,.1);margin-bottom:1.5rem">
            <div>
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="d-flex align-items-center justify-content-center" style="width:2.5rem;height:2.5rem;background:linear-gradient(135deg,#696cff,#a855f7);border-radius:.75rem;color:#fff;box-shadow:0 4px 16px rgba(99,102,241,.3)"><i class="bx bx-graduation"></i></div>
                    <div class="fw-bolder text-white" style="font-size:1.125rem">{{ $siteName }}</div>
                </div>
                <p style="font-size:.875rem;max-width:20rem;line-height:1.625">{{ $siteDesc }}</p>
            </div>
            <nav class="d-flex flex-column gap-2" style="font-size:.875rem">
                <p class="fw-semibold text-white mb-1">เมนู</p>
                <a href="/activities" class="text-decoration-none" style="color:#9ca3af;transition:color .15s" onmouseover="this.style.color='white'" onmouseout="this.style.color='#9ca3af'"><i class="bx bx-calendar me-2"></i>กิจกรรมทั้งหมด</a>
                <a href="/login" class="text-decoration-none" style="color:#9ca3af;transition:color .15s" onmouseover="this.style.color='white'" onmouseout="this.style.color='#9ca3af'"><i class="bx bx-user-tie me-2"></i>สำหรับผู้ดูแล</a>
            </nav>
        </div>
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-4">
            <p style="font-size:.75rem;color:#6b7280">{{ $footerText }}</p>
            <p style="font-size:.75rem;color:#4b5563">พัฒนาด้วย <i class="bx bxs-heart text-danger mx-1"></i> สำหรับมหาวิทยาลัย</p>
        </div>
    </div>
</footer>
@endsection

@section('script')
<script>
var LIST_API = '/api/public/activities';
var CAT_API = '/api/public/categories';
var currentPage = 1;
var currentCategory = '';
var currentYear = '';
var currentKeyword = '';

function loadActivities(page) {
    page = page || 1;
    var $grid = $('#activities-grid');
    $grid.html('<div class="col-12 text-center py-5 text-muted"><div class="spinner-border spinner-border-sm mb-3" role="status"></div><p>กำลังโหลด...</p></div>');

    var params = { per_page: 12, page: page };
    if (currentCategory) params.category_id = currentCategory;
    if (currentYear) params.year = currentYear;
    if (currentKeyword) params.keyword = currentKeyword;

    $.ajax({ url: LIST_API, method: 'POST', data: params, success: function (json) {
        var data = json.data || [];
        if (data.length === 0) {
            $grid.html('<div class="col-12 text-center py-5"><div class="mb-3 text-muted" style="font-size:3rem"><i class="bx bx-inbox"></i></div><h5 class="fw-bold" style="color:#1f2937">ไม่พบกิจกรรม</h5><p class="text-muted mb-3">ลองค้นหาด้วยคำอื่นหรือเปลี่ยนตัวกรอง</p><button class="btn btn-outline-primary btn-sm" onclick="$(\'#search-input\').val(\'\');$(\'#filter-category\').val(\'\');$(\'#filter-year\').val(\'\');loadActivities(1)"><i class="bx bx-undo me-1"></i>ล้างตัวกรอง</button></div>');
        } else {
            $grid.html($.map(data, function (a) {
                var img = a.cover_image_url
                    ? '<img src="' + a.cover_image_url + '" alt="' + a.title + '" class="w-100 h-100" style="object-fit:cover">'
                    : '<div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted" style="font-size:2rem"><i class="bx bx-image"></i></div>';
                var cat = a.category
                    ? '<span class="badge bg-dark position-absolute" style="top:.625rem;left:.625rem;font-size:10px">' + a.category.name + '</span>'
                    : '';
                return '<div class="col-sm-6 col-lg-4"><a href="/activities/' + a.id + '" class="d-block bg-white border text-decoration-none overflow-hidden act-card" style="border-color:#f3f4f6">'
                    + '<div class="position-relative" style="height:10rem;background:#f9fafb;overflow:hidden">' + cat + img + '</div>'
                    + '<div class="p-3">'
                    + '<div class="d-flex align-items-center gap-2 text-muted small mb-2"><i class="bx bx-calendar"></i>' + (a.activity_date || '') + '</div>'
                    + '<h3 class="fw-bold small" style="color:#1f2937;line-height:1.375;margin-bottom:.5rem">' + a.title + '</h3>'
                    + '<p class="text-muted small" style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden">' + (a.description || '') + '</p>'
                    + '<div class="d-flex align-items-center gap-2 text-muted small mt-2">'
                    + '<span><i class="bx bx-map-pin me-1"></i>' + (a.location || 'ไม่มีสถานที่') + '</span>'
                    + '<span class="ms-auto">' + (a.participants_count ?? 0) + ' คน</span>'
                    + '</div></div></a></div>';
            }).join(''));
        }
        var meta = json.meta;
        if (meta) {
            currentPage = meta.current_page;
            $('#pagination-info').text('แสดง ' + ((meta.current_page - 1) * meta.per_page + 1) + '-' + Math.min(meta.current_page * meta.per_page, meta.total) + ' จาก ' + meta.total + ' รายการ');
            renderPagination(meta);
        }
    }, error: function () {
        $grid.html('<div class="col-12 text-center py-5 text-danger"><i class="bx bx-error-circle" style="font-size:2rem"></i><p class="mt-2">เกิดข้อผิดพลาดในการโหลดข้อมูล</p></div>');
    }});
}

function renderPagination(meta) {
    var $btns = $('#pagination-btns').empty();
    if (meta.last_page <= 1) return;
    var prev = $('<button class="btn btn-sm btn-outline-secondary">').html('<i class="bx bx-chevron-left"></i>').prop('disabled', meta.current_page === 1);
    prev.on('click', function () { if (meta.current_page > 1) loadActivities(meta.current_page - 1); });
    $btns.append(prev);
    for (var i = 1; i <= meta.last_page; i++) {
        (function (p) {
            var btn = $('<button class="btn btn-sm ' + (p === meta.current_page ? 'btn-primary' : 'btn-outline-secondary') + '">').text(p);
            btn.on('click', function () { loadActivities(p); });
            $btns.append(btn);
        })(i);
    }
    var next = $('<button class="btn btn-sm btn-outline-secondary">').html('<i class="bx bx-chevron-right"></i>').prop('disabled', meta.current_page === meta.last_page);
    next.on('click', function () { if (meta.current_page < meta.last_page) loadActivities(meta.current_page + 1); });
    $btns.append(next);
}

$(function () {
    loadActivities(1);
    loadCategories();
    $('#filter-category, #filter-year').on('change', function () {
        currentCategory = $('#filter-category').val();
        currentYear = $('#filter-year').val();
        loadActivities(1);
    });
    var debounce;
    $('#search-input').on('input', function () {
        clearTimeout(debounce);
        var val = $(this).val();
        debounce = setTimeout(function () { currentKeyword = val; loadActivities(1); }, 300);
    });
});

function loadCategories() {
    $.ajax({ url: CAT_API, method: 'POST', success: function (json) {
        var $sel = $('#filter-category');
        $.each(json.data || [], function (_, c) { $sel.append($('<option>').val(c.id).text(c.name)); });
    }});
}
</script>
@endsection
