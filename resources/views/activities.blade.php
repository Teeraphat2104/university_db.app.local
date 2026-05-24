@extends('layouts.master')

@section('title', 'กิจกรรมทั้งหมด - University Activities')

@section('content')
<div style="background: var(--gray-50); border-bottom: 1px solid var(--gray-100);">
    <div class="px-4 py-3" style="max-width: 72rem; margin: 0 auto;">
        <div class="d-flex align-items-center gap-2" style="font-size: 0.875rem; color: var(--gray-500);">
            <a href="/" class="text-decoration-none" style="color: var(--gray-500);" onmouseover="this.style.color='#4F46E5'" onmouseout="this.style.color='var(--gray-500)'">หน้าหลัก</a>
            <i class="fa-solid fa-chevron-right" style="font-size: 0.75rem; color: var(--gray-300);"></i>
            <span class="fw-medium" style="color: var(--gray-800);">กิจกรรมทั้งหมด</span>
        </div>
    </div>
</div>

<div class="bg-white" style="padding-top: 2.5rem; padding-bottom: 2.5rem;">
    <div class="px-4" style="max-width: 72rem; margin: 0 auto;">
        <div class="d-flex flex-column flex-sm-row align-items-sm-center gap-4 mb-4">
            <h1 class="fs-4 fw-bolder text-nowrap" style="color: var(--gray-900);">กิจกรรมทั้งหมด</h1>
            <div class="d-flex flex-column flex-sm-row gap-2 flex-grow-1">
                <div class="position-relative flex-grow-1">
                    <i class="fa-solid fa-magnifying-glass position-absolute top-50" style="left: 0.75rem; transform: translateY(-50%); color: var(--gray-400); font-size: 0.875rem;"></i>
                    <input type="text" id="search-input" placeholder="ค้นหากิจกรรม..." class="border w-100" style="padding: 0.625rem 0.875rem 0.625rem 2.5rem; font-size: 0.875rem; border-color: var(--gray-200); border-radius: 0.75rem; outline: none; background: var(--gray-50);" onfocus="this.style.borderColor='#818CF8'; this.style.background='white'" onblur="this.style.borderColor='var(--gray-200)'; this.style.background='var(--gray-50)'">
                </div>
                <select id="filter-category" class="border" style="padding: 0.625rem 0.875rem; font-size: 0.875rem; border-color: var(--gray-200); border-radius: 0.75rem; background: white; color: var(--gray-700); outline: none; min-width: 140px;" onfocus="this.style.borderColor='#818CF8'" onblur="this.style.borderColor='var(--gray-200)'">
                    <option value="">ทุกหมวดหมู่</option>
                </select>
                <select id="filter-year" class="border" style="padding: 0.625rem 0.875rem; font-size: 0.875rem; border-color: var(--gray-200); border-radius: 0.75rem; background: white; color: var(--gray-700); outline: none; min-width: 120px;" onfocus="this.style.borderColor='#818CF8'" onblur="this.style.borderColor='var(--gray-200)'">
                    <option value="">ทุกปี</option>
                    @for ($y = date('Y') + 543; $y >= date('Y') + 543 - 5; $y--)
                        <option value="{{ $y - 543 }}">{{ $y }}</option>
                    @endfor
                </select>
            </div>
        </div>
        <p class="d-flex align-items-center gap-2" style="font-size: 0.875rem; color: var(--gray-500); margin-bottom: 2rem;">
            <i class="fa-regular fa-lightbulb" style="color: #F59E0B;"></i>
            รวมกิจกรรมและเอกสารของมหาวิทยาลัย
        </p>
        <div id="activities-grid" class="row g-4">
            <div class="col-12 text-center" style="padding: 5rem 0;">
                <div class="d-inline-flex align-items-center justify-content-center" style="width: 5rem; height: 5rem; background: #EEF2FF; border-radius: 50%; margin-bottom: 1rem;">
                    <i class="fa-solid fa-circle-notch fa-spin fs-4" style="color: #818CF8;"></i>
                </div>
                <p class="fw-medium" style="color: var(--gray-500);">กำลังโหลดข้อมูล...</p>
            </div>
        </div>
        <div id="pagination" class="d-flex align-items-center justify-content-between gap-4 mt-4 flex-wrap">
            <p id="pagination-info" style="font-size: 0.875rem; color: var(--gray-500);"></p>
            <div id="pagination-btns" class="d-flex gap-2"></div>
        </div>
    </div>
</div>

@php $siteName = setting('site_name', 'University Activities'); $siteDesc = setting('site_description', 'ระบบจัดการกิจกรรมและเอกสารของมหาวิทยาลัย'); $footerText = setting('footer_text', '© ' . date('Y') . ' University Activities. สงวนลิขสิทธิ์ทั้งหมด'); $fbUrl = setting('facebook_url'); $lineUrl = setting('line_url'); $ytUrl = setting('youtube_url'); @endphp
<footer style="background: #111827; color: var(--gray-400); padding: 3rem 1.5rem;">
    <div style="max-width: 72rem; margin: 0 auto;">
        <div class="d-flex flex-wrap justify-content-between gap-4" style="padding-bottom: 2rem; border-bottom: 1px solid rgba(255,255,255,0.1); margin-bottom: 1.5rem;">
            <div>
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="d-flex align-items-center justify-content-center" style="width: 2.5rem; height: 2.5rem; background: linear-gradient(135deg, #6366F1, #A855F7); border-radius: 0.75rem; color: white; box-shadow: 0 0.25rem 1rem rgba(99,102,241,0.3);"> <i class="fa-solid fa-graduation-cap"></i> </div>
                    <div class="fw-bolder text-white" style="font-size: 1.125rem;">{{ $siteName }}</div>
                </div>
                <p style="font-size: 0.875rem; color: var(--gray-400); max-width: 20rem; line-height: 1.625;">{{ $siteDesc }}</p>
            </div>
            <nav class="d-flex flex-column gap-3" style="font-size: 0.875rem;">
                <p class="fw-semibold text-white mb-1">เมนู</p>
                <a href="/activities" class="text-decoration-none" style="color: var(--gray-400);" onmouseover="this.style.color='white'" onmouseout="this.style.color='var(--gray-400)'"><i class="fa-regular fa-calendar me-2"></i>กิจกรรมทั้งหมด</a>
                <a href="/#about" class="text-decoration-none" style="color: var(--gray-400);" onmouseover="this.style.color='white'" onmouseout="this.style.color='var(--gray-400)'"><i class="fa-regular fa-circle-info me-2"></i>เกี่ยวกับระบบ</a>
                <a href="/login" class="text-decoration-none" style="color: var(--gray-400);" onmouseover="this.style.color='white'" onmouseout="this.style.color='var(--gray-400)'"><i class="fa-solid fa-user-gear me-2"></i>สำหรับผู้ดูแล</a>
            </nav>
        </div>
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-4">
            <p style="font-size: 0.75rem; color: var(--gray-500);">{{ $footerText }}</p>
            <p style="font-size: 0.75rem; color: var(--gray-600);">พัฒนาด้วย <i class="fa-solid fa-heart text-danger mx-1"></i> สำหรับมหาวิทยาลัย</p>
        </div>
    </div>
</footer>
@endsection

@section('script')
<script>
var API = '/api/public';
var currentPage = 1;
var currentCategory = '';
var currentYear = '';
var currentKeyword = '';

function loadActivities(page) {
    page = page || 1;
    var $grid = $('#activities-grid');
    $grid.html('<div class="col-12 text-center" style="padding: 4rem 0; color: var(--gray-400);"><i class="fa-solid fa-circle-notch fa-spin fs-4"></i><p class="mt-3" style="font-size: 0.875rem;">กำลังโหลด...</p></div>');

    var params = { per_page: 12, page: page };
    if (currentCategory) params.category_id = currentCategory;
    if (currentYear) params.year = currentYear;
    if (currentKeyword) params.keyword = currentKeyword;

    $.getJSON(API + '/activities', params, function (json) {
        var data = json.data || [];

        if (data.length === 0) {
            $grid.html('<div class="col-12 text-center" style="padding: 5rem 0;">' +
                '<div class="d-inline-flex align-items-center justify-content-center" style="width: 5rem; height: 5rem; background: var(--gray-100); border-radius: 50%; margin-bottom: 1rem;">' +
                '<i class="fa-regular fa-inbox" style="font-size: 1.875rem; color: var(--gray-400);"></i></div>' +
                '<h3 class="fw-bold" style="font-size: 1.125rem; color: var(--gray-800); margin-bottom: 0.5rem;">ไม่พบกิจกรรม</h3>' +
                '<p style="color: var(--gray-500); margin-bottom: 1rem;">ลองค้นหาด้วยคำอื่นหรือเปลี่ยนตัวกรอง</p>' +
                '<button onclick="$(\'#search-input\').val(\'\');$(\'#filter-category\').val(\'\');$(\'#filter-year\').val(\'\');loadActivities(1)" style="padding: 0.5rem 1rem; font-size: 0.875rem; font-weight: 600; color: #4F46E5; background: #EEF2FF; border-radius: 0.5rem; border: none;" onmouseover="this.style.background=\'#E0E7FF\'" onmouseout="this.style.background=\'#EEF2FF\'">' +
                '<i class="fa-solid fa-rotate-left me-1"></i> ล้างตัวกรอง</button></div>');
        } else {
            $grid.html($.map(data, function (a) {
                var img = a.cover_image_url
                    ? '<img src="' + a.cover_image_url + '" alt="' + a.title + '" class="w-100 h-100" style="object-fit: cover;">'
                    : '<div class="w-100 h-100 d-flex align-items-center justify-content-center" style="font-size: 1.875rem; color: var(--gray-300);"><i class="fa-regular fa-image"></i></div>';
                var cat = a.category
                    ? '<span class="position-absolute" style="top: 0.625rem; left: 0.625rem; background: rgba(17,24,39,0.6); backdrop-filter: blur(4px); color: white; font-size: 10px; font-weight: 700; padding: 0.125rem 0.5rem; border-radius: 50rem;">' + a.category.name + '</span>'
                    : '';
                return '<div class="col-sm-6 col-lg-4"><a href="/activities/' + a.id + '" class="d-block bg-white border text-decoration-none overflow-hidden" style="border-color: var(--gray-100); border-radius: 1rem;" onmouseover="this.style.boxShadow=\'0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04)\'; this.style.transform=\'translateY(-0.25rem)\'" onmouseout="this.style.boxShadow=\'none\'; this.style.transform=\'none\'">'
                    + '<div class="position-relative" style="height: 10rem; background: var(--gray-100); overflow: hidden;">' + cat + img + '</div>'
                    + '<div class="p-3">'
                    + '<div class="d-flex align-items-center gap-2" style="font-size: 0.75rem; color: var(--gray-400); margin-bottom: 0.5rem;"><i class="fa-regular fa-calendar"></i>' + (a.activity_date || '') + '</div>'
                    + '<h3 class="fw-bold" style="font-size: 0.875rem; color: var(--gray-800); line-height: 1.375; margin-bottom: 0.5rem;">' + a.title + '</h3>'
                    + '<p style="font-size: 0.75rem; color: var(--gray-500); display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.625;">' + (a.description || '') + '</p>'
                    + '<div class="d-flex align-items-center gap-2 mt-3" style="font-size: 0.75rem; color: var(--gray-400);">'
                    + '<span><i class="fa-regular fa-location-dot me-1"></i>' + (a.location || 'ไม่มีสถานที่') + '</span>'
                    + '<span class="ms-auto">' + (a.participants_count ?? 0) + ' คน</span>'
                    + '</div>'
                    + '</div>'
                    + '</a></div>';
            }).join(''));
        }

        var meta = json.meta;
        if (meta) {
            currentPage = meta.current_page;
            $('#pagination-info').text('แสดง ' + ((meta.current_page - 1) * meta.per_page + 1) + '-' + Math.min(meta.current_page * meta.per_page, meta.total) + ' จาก ' + meta.total + ' รายการ');
            renderPagination(meta);
        }
    }).fail(function () {
        $grid.html('<div class="col-12 text-center" style="padding: 4rem 0; color: var(--gray-400);"><i class="fa-regular fa-circle-exclamation" style="font-size: 1.875rem;"></i><p class="mt-3" style="font-size: 0.875rem;">เกิดข้อผิดพลาดในการโหลดข้อมูล</p></div>');
    });
}

function renderPagination(meta) {
    var $btns = $('#pagination-btns').empty();
    if (meta.last_page <= 1) return;

    var prev = $('<button>').addClass('border rounded-2 fw-semibold')
        .css({ padding: '0.375rem 0.75rem', fontSize: '0.875rem' })
        .html('<i class="fa-solid fa-chevron-left"></i>')
        .prop('disabled', meta.current_page === 1);

    if (meta.current_page === 1) {
        prev.css({ color: 'var(--gray-300)', borderColor: 'var(--gray-100)', cursor: 'not-allowed' });
    } else {
        prev.css({ color: 'var(--gray-600)', borderColor: 'var(--gray-200)', cursor: 'pointer' });
    }
    prev.on('click', function () {
        if (meta.current_page > 1) loadActivities(meta.current_page - 1);
    });
    $btns.append(prev);

    for (var i = 1; i <= meta.last_page; i++) {
        (function (p) {
            var btn = $('<button>').text(p).addClass('border rounded-2 fw-semibold')
                .css({ padding: '0.375rem 0.75rem', fontSize: '0.875rem' })
                .on('click', function () { loadActivities(p); });

            if (p === meta.current_page) {
                btn.css({ background: '#6366F1', color: 'white', borderColor: '#6366F1' });
            } else {
                btn.css({ color: 'var(--gray-600)', borderColor: 'var(--gray-200)', cursor: 'pointer' });
            }
            $btns.append(btn);
        })(i);
    }

    var next = $('<button>').addClass('border rounded-2 fw-semibold')
        .css({ padding: '0.375rem 0.75rem', fontSize: '0.875rem' })
        .html('<i class="fa-solid fa-chevron-right"></i>')
        .prop('disabled', meta.current_page === meta.last_page);

    if (meta.current_page === meta.last_page) {
        next.css({ color: 'var(--gray-300)', borderColor: 'var(--gray-100)', cursor: 'not-allowed' });
    } else {
        next.css({ color: 'var(--gray-600)', borderColor: 'var(--gray-200)', cursor: 'pointer' });
    }
    next.on('click', function () {
        if (meta.current_page < meta.last_page) loadActivities(meta.current_page + 1);
    });
    $btns.append(next);
}

$(function () {
    loadActivities(1);
    loadCategories();

    $('#filter-category').on('change', function () {
        currentCategory = $(this).val();
        loadActivities(1);
    });

    $('#filter-year').on('change', function () {
        currentYear = $(this).val();
        loadActivities(1);
    });

    var debounce;
    $('#search-input').on('input', function () {
        clearTimeout(debounce);
        var val = $(this).val();
        debounce = setTimeout(function () {
            currentKeyword = val;
            loadActivities(1);
        }, 300);
    });
});

function loadCategories() {
    $.getJSON(API + '/categories', function (json) {
        var $sel = $('#filter-category');
        $.each(json.data || [], function (_, c) {
            $sel.append($('<option>').val(c.id).text(c.name));
        });
    });
}
</script>
@endsection
