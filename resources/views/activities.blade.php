@extends('layouts.master')

@section('title', 'กิจกรรมทั้งหมด - University Activities')

@section('content')
<div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-indigo-600 border-b border-white/10">
    <div class="max-w-6xl mx-auto px-6 py-8">
        <div class="flex items-center gap-2 text-sm text-white/70">
            <a href="/" class="hover:text-white transition-colors no-underline">หน้าหลัก</a>
            <i class="fa-solid fa-chevron-right text-xs text-white/40"></i>
            <span class="text-white font-medium">กิจกรรมทั้งหมด</span>
        </div>
    </div>
</div>

<section class="py-10 bg-white">
    <div class="max-w-6xl mx-auto px-6">
        <div class="flex flex-col sm:flex-row sm:items-center gap-4 mb-6">
            <h1 class="text-2xl font-extrabold text-gray-900 whitespace-nowrap">กิจกรรมทั้งหมด</h1>
            <div class="flex flex-wrap gap-2 flex-1">
                <div class="relative flex-1 max-w-xs">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                    <input type="text" id="search-input" placeholder="ค้นหากิจกรรม..." class="pl-10 pr-3.5 py-2.5 text-sm border border-gray-200 rounded-xl outline-none focus:border-indigo-400 w-full bg-gray-50 focus:bg-white transition-colors">
                </div>
                <select id="filter-category" class="px-3.5 py-2.5 text-sm border border-gray-200 rounded-xl bg-white text-gray-700 outline-none focus:border-indigo-400 min-w-[140px]">
                    <option value="">ทุกหมวดหมู่</option>
                </select>
                <select id="filter-year" class="px-3.5 py-2.5 text-sm border border-gray-200 rounded-xl bg-white text-gray-700 outline-none focus:border-indigo-400 min-w-[120px]">
                    <option value="">ทุกปี</option>
                    @for ($y = date('Y') + 543; $y >= date('Y') + 543 - 5; $y--)
                        <option value="{{ $y - 543 }}">{{ $y }}</option>
                    @endfor
                </select>
            </div>
        </div>
        <p class="text-sm text-gray-500 mb-8 flex items-center gap-2">
            <i class="fa-regular fa-lightbulb text-amber-500"></i>
            รวมกิจกรรมและเอกสารของมหาวิทยาลัย
        </p>
        <div id="activities-grid" class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
            <div class="col-span-full text-center py-20">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-indigo-50 rounded-full mb-4">
                    <i class="fa-regular fa-circle-notch fa-spin text-2xl text-indigo-400"></i>
                </div>
                <p class="text-gray-500 font-medium">กำลังโหลดข้อมูล...</p>
            </div>
        </div>
        <div id="pagination" class="flex items-center justify-between gap-4 mt-8 flex-wrap">
            <p id="pagination-info" class="text-sm text-gray-500"></p>
            <div id="pagination-btns" class="flex gap-2"></div>
        </div>
    </div>
</section>

@php $siteName = setting('site_name', 'University Activities'); $siteDesc = setting('site_description', 'ระบบจัดการกิจกรรมและเอกสารของมหาวิทยาลัย'); $footerText = setting('footer_text', '© ' . date('Y') . ' University Activities. สงวนลิขสิทธิ์ทั้งหมด'); $fbUrl = setting('facebook_url'); $lineUrl = setting('line_url'); $ytUrl = setting('youtube_url'); @endphp
<footer class="bg-gray-950 text-gray-400 py-12 px-6">
    <div class="max-w-6xl mx-auto">
        <div class="flex flex-wrap justify-between gap-8 pb-8 border-b border-white/10 mb-6">
            <div>
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-xl flex items-center justify-center text-white shadow-lg shadow-indigo-500/30"> <i class="fa-solid fa-graduation-cap"></i> </div>
                    <div class="text-white text-lg font-extrabold">{{ $siteName }}</div>
                </div>
                <p class="text-sm text-gray-400 max-w-xs leading-relaxed">{{ $siteDesc }}</p>
            </div>
            <nav class="flex flex-col gap-3 text-sm">
                <p class="text-white font-semibold mb-1">เมนู</p>
                <a href="/activities" class="text-gray-400 hover:text-white transition-colors no-underline"><i class="fa-regular fa-calendar mr-2"></i>กิจกรรมทั้งหมด</a>
                <a href="/#about" class="text-gray-400 hover:text-white transition-colors no-underline"><i class="fa-regular fa-circle-info mr-2"></i>เกี่ยวกับระบบ</a>
                <a href="/login" class="text-gray-400 hover:text-white transition-colors no-underline"><i class="fa-solid fa-user-gear mr-2"></i>สำหรับผู้ดูแล</a>
            </nav>
        </div>
        <div class="flex flex-wrap justify-between items-center gap-4">
            <p class="text-xs text-gray-500">{{ $footerText }}</p>
            <p class="text-xs text-gray-600">พัฒนาด้วย <i class="fa-solid fa-heart text-red-500 mx-1"></i> สำหรับมหาวิทยาลัย</p>
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
    $grid.html('<div class="col-span-full text-center py-16 text-gray-400"><i class="fa-regular fa-circle-notch fa-spin text-2xl"></i><p class="mt-3 text-sm">กำลังโหลด...</p></div>');

    var params = { per_page: 12, page: page };
    if (currentCategory) params.category_id = currentCategory;
    if (currentYear) params.year = currentYear;
    if (currentKeyword) params.keyword = currentKeyword;

    $.getJSON(API + '/activities', params, function (json) {
        var data = json.data || [];

        if (data.length === 0) {
            $grid.html('<div class="col-span-full text-center py-20">' +
                '<div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 rounded-full mb-4">' +
                '<i class="fa-regular fa-inbox text-3xl text-gray-400"></i></div>' +
                '<h3 class="text-lg font-bold text-gray-800 mb-2">ไม่พบกิจกรรม</h3>' +
                '<p class="text-gray-500 mb-4">ลองค้นหาด้วยคำอื่นหรือเปลี่ยนตัวกรอง</p>' +
                '<button onclick="$(\'#search-input\').val(\'\');$(\'#filter-category\').val(\'\');$(\'#filter-year\').val(\'\');loadActivities(1)" class="px-4 py-2 text-sm font-semibold text-indigo-600 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition-colors">' +
                '<i class="fa-solid fa-rotate-left mr-1"></i> ล้างตัวกรอง</button></div>');
        } else {
            $grid.html($.map(data, function (a) {
                var img = a.cover_image_url
                    ? '<img src="' + a.cover_image_url + '" alt="' + a.title + '" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">'
                    : '<div class="w-full h-full flex items-center justify-center text-3xl text-gray-300"><i class="fa-regular fa-image"></i></div>';
                var cat = a.category
                    ? '<span class="absolute top-2.5 left-2.5 bg-gray-900/60 backdrop-blur-sm text-white text-[10px] font-bold px-2 py-0.5 rounded-full">' + a.category.name + '</span>'
                    : '';
                return '<a href="/activities/' + a.id + '" class="block bg-white border border-gray-100 rounded-2xl overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all group no-underline">'
                    + '<div class="h-40 bg-gray-100 overflow-hidden relative">' + cat + img + '</div>'
                    + '<div class="p-4">'
                    + '<div class="flex items-center gap-2 text-xs text-gray-400 mb-2"><i class="fa-regular fa-calendar"></i>' + (a.activity_date || '') + '</div>'
                    + '<h3 class="text-sm font-bold text-gray-800 leading-snug mb-2">' + a.title + '</h3>'
                    + '<p class="text-xs text-gray-500 line-clamp-2 leading-relaxed">' + (a.description || '') + '</p>'
                    + '<div class="flex items-center gap-2 mt-3 text-xs text-gray-400">'
                    + '<span><i class="fa-regular fa-location-dot mr-1"></i>' + (a.location || 'ไม่มีสถานที่') + '</span>'
                    + '<span class="ml-auto">' + (a.participants_count ?? 0) + ' คน</span>'
                    + '</div>'
                    + '</div>'
                    + '</a>';
            }).join(''));
        }

        var meta = json.meta;
        if (meta) {
            currentPage = meta.current_page;
            $('#pagination-info').text('แสดง ' + ((meta.current_page - 1) * meta.per_page + 1) + '-' + Math.min(meta.current_page * meta.per_page, meta.total) + ' จาก ' + meta.total + ' รายการ');
            renderPagination(meta);
        }
    }).fail(function () {
        $grid.html('<div class="col-span-full text-center py-16 text-gray-400"><i class="fa-regular fa-circle-exclamation text-3xl"></i><p class="mt-3 text-sm">เกิดข้อผิดพลาดในการโหลดข้อมูล</p></div>');
    });
}

function renderPagination(meta) {
    var $btns = $('#pagination-btns').empty();
    if (meta.last_page <= 1) return;

    var prev = $('<button>').addClass('px-3 py-1.5 text-sm font-semibold rounded-xl border transition-all')
        .html('<i class="fa-solid fa-chevron-left"></i>')
        .prop('disabled', meta.current_page === 1)
        .toggleClass('text-gray-300 border-gray-100 cursor-not-allowed', meta.current_page === 1)
        .toggleClass('text-gray-600 border-gray-200 hover:bg-gray-50 hover:text-indigo-600 cursor-pointer', meta.current_page !== 1)
        .on('click', function () {
            if (meta.current_page > 1) loadActivities(meta.current_page - 1);
        });
    $btns.append(prev);

    for (var i = 1; i <= meta.last_page; i++) {
        (function (p) {
            var btn = $('<button>').text(p).addClass('px-3 py-1.5 text-sm font-semibold rounded-xl border transition-all')
                .toggleClass('bg-indigo-500 text-white border-indigo-500', p === meta.current_page)
                .toggleClass('text-gray-600 border-gray-200 hover:bg-gray-50 hover:text-indigo-600 cursor-pointer', p !== meta.current_page)
                .on('click', function () { loadActivities(p); });
            $btns.append(btn);
        })(i);
    }

    var next = $('<button>').addClass('px-3 py-1.5 text-sm font-semibold rounded-xl border transition-all')
        .html('<i class="fa-solid fa-chevron-right"></i>')
        .prop('disabled', meta.current_page === meta.last_page)
        .toggleClass('text-gray-300 border-gray-100 cursor-not-allowed', meta.current_page === meta.last_page)
        .toggleClass('text-gray-600 border-gray-200 hover:bg-gray-50 hover:text-indigo-600 cursor-pointer', meta.current_page !== meta.last_page)
        .on('click', function () {
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
