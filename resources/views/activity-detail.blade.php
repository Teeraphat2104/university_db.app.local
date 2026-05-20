@extends('layouts.master')

@section('title', 'รายละเอียดกิจกรรม - University Activities')

@section('content')
<div class="bg-gray-50 border-b border-gray-100">
    <div class="max-w-6xl mx-auto px-6 py-4">
        <div class="flex items-center gap-2 text-sm text-gray-500">
            <a href="/" class="hover:text-indigo-600 transition-colors no-underline">หน้าหลัก</a>
            <i class="fa-solid fa-chevron-right text-xs text-gray-300"></i>
            <a href="/activities" class="hover:text-indigo-600 transition-colors no-underline">กิจกรรมทั้งหมด</a>
            <i class="fa-solid fa-chevron-right text-xs text-gray-300"></i>
            <span class="text-gray-800 font-medium" id="breadcrumb-title">โหลด...</span>
        </div>
    </div>
</div>

<section class="py-10 bg-white">
    <div class="max-w-6xl mx-auto px-6">
        <div id="loading" class="text-center py-20">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-indigo-50 rounded-full mb-4">
                <i class="fa-regular fa-circle-notch fa-spin text-2xl text-indigo-400"></i>
            </div>
            <p class="text-gray-500 font-medium">กำลังโหลดข้อมูล...</p>
        </div>

        <div id="activity-content" class="hidden">
            <div class="flex flex-col lg:flex-row gap-8">
                <div class="flex-1 min-w-0 space-y-6">
                    <div id="cover-wrap" class="rounded-2xl overflow-hidden bg-gray-100 aspect-video relative">
                        <img id="cover-img" src="" alt="" class="w-full h-full object-cover hidden">
                        <div id="cover-placeholder" class="w-full h-full flex items-center justify-center text-5xl text-gray-300"><i class="fa-regular fa-image"></i></div>
                    </div>

                    <div>
                        <h1 id="activity-title" class="text-2xl sm:text-3xl font-extrabold text-gray-900 mb-4"></h1>
                        <div id="activity-description" class="text-gray-600 text-base leading-relaxed"></div>
                    </div>

                    <div id="pdf-preview-wrap" class="hidden rounded-2xl overflow-hidden border border-gray-200">
                        <div class="bg-gray-50 px-4 py-3 border-b border-gray-200 flex items-center justify-between">
                            <span class="text-sm font-semibold text-gray-700"><i class="fa-regular fa-file-pdf text-red-500 mr-2"></i>เอกสาร PDF</span>
                            <a id="pdf-download-link" href="#" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-red-600 bg-red-50 rounded-lg hover:bg-red-100 transition-colors no-underline">
                                <i class="fa-solid fa-download"></i> ดาวน์โหลด
                            </a>
                        </div>
                        <iframe id="pdf-preview" src="" class="w-full h-[500px] bg-gray-100" frameborder="0"></iframe>
                    </div>
                </div>

                <div class="lg:w-80 flex-shrink-0">
                    <div class="sticky top-24 space-y-4">
                        <div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-2xl p-5 space-y-4 border border-indigo-100">
                            <div>
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">วันที่จัดกิจกรรม</p>
                                <p id="detail-date" class="text-sm font-bold text-gray-800 flex items-center gap-2"><i class="fa-regular fa-calendar text-indigo-500"></i></p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">สถานที่</p>
                                <p id="detail-location" class="text-sm font-bold text-gray-800 flex items-center gap-2"><i class="fa-solid fa-location-dot text-indigo-500"></i></p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">หมวดหมู่</p>
                                <p id="detail-category" class="text-sm font-bold text-gray-800 flex items-center gap-2"><i class="fa-regular fa-rectangle-list text-indigo-500"></i></p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">ผู้เข้าร่วม</p>
                                <p id="detail-participants" class="text-sm font-bold text-gray-800 flex items-center gap-2"><i class="fa-solid fa-users text-indigo-500"></i></p>
                            </div>
                        </div>

                        <div id="pdf-sidebar-wrap" class="hidden bg-white rounded-2xl p-5 border border-gray-200">
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">ดาวน์โหลด</p>
                            <a id="pdf-sidebar-link" href="#" target="_blank" class="flex items-center gap-3 px-4 py-3 bg-red-50 text-red-700 rounded-xl hover:bg-red-100 transition-colors no-underline">
                                <i class="fa-regular fa-file-pdf text-lg"></i>
                                <div>
                                    <p class="text-sm font-bold">ดาวน์โหลด PDF</p>
                                    <p class="text-xs text-red-500">เอกสารประกอบกิจกรรม</p>
                                </div>
                            </a>
                        </div>

                        <a href="/activities" class="flex items-center justify-center gap-2 w-full px-4 py-3 text-sm font-semibold text-gray-600 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors no-underline border border-gray-200">
                            <i class="fa-solid fa-arrow-left"></i>
                            กลับไปหน้ากิจกรรมทั้งหมด
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div id="not-found" class="hidden text-center py-20">
            <div class="inline-flex items-center justify-center w-24 h-24 bg-red-50 rounded-full mb-4">
                <i class="fa-regular fa-circle-exclamation text-3xl text-red-400"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">ไม่พบกิจกรรม</h3>
            <p class="text-gray-500 mb-6">กิจกรรมที่คุณกำลังค้นหาอาจถูกลบหรือย้ายไปแล้ว</p>
            <a href="/activities" class="inline-flex items-center gap-2 px-6 py-3 text-sm font-bold text-white bg-gradient-to-r from-indigo-500 to-purple-500 rounded-xl shadow-lg shadow-indigo-500/30 hover:shadow-xl hover:-translate-y-0.5 transition-all no-underline">
                <i class="fa-solid fa-arrow-left"></i> กลับไปหน้ากิจกรรมทั้งหมด
            </a>
        </div>
    </div>
</section>

<footer class="bg-gray-950 text-gray-400 py-12 px-6">
    <div class="max-w-6xl mx-auto">
        <div class="flex flex-wrap justify-between gap-8 pb-8 border-b border-white/10 mb-6">
            <div>
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-xl flex items-center justify-center text-white shadow-lg shadow-indigo-500/30"> <i class="fa-solid fa-graduation-cap"></i> </div>
                    <div class="text-white text-lg font-extrabold">University Activities</div>
                </div>
                <p class="text-sm text-gray-400 max-w-xs leading-relaxed">ระบบจัดการกิจกรรมและเอกสารสำหรับมหาวิทยาลัย</p>
            </div>
            <nav class="flex flex-col gap-3 text-sm">
                <p class="text-white font-semibold mb-1">เมนู</p>
                <a href="/activities" class="text-gray-400 hover:text-white transition-colors no-underline"><i class="fa-regular fa-calendar mr-2"></i>กิจกรรมทั้งหมด</a>
                <a href="/#about" class="text-gray-400 hover:text-white transition-colors no-underline"><i class="fa-regular fa-circle-info mr-2"></i>เกี่ยวกับระบบ</a>
                <a href="/login" class="text-gray-400 hover:text-white transition-colors no-underline"><i class="fa-solid fa-user-gear mr-2"></i>สำหรับผู้ดูแล</a>
            </nav>
        </div>
        <div class="flex flex-wrap justify-between items-center gap-4">
            <p class="text-xs text-gray-500">© {{ date('Y') }} University Activities. สงวนลิขสิทธิ์ทั้งหมด</p>
            <p class="text-xs text-gray-600">พัฒนาด้วย <i class="fa-solid fa-heart text-red-500 mx-1"></i> สำหรับมหาวิทยาลัย</p>
        </div>
    </div>
</footer>
@endsection

@section('script')
<script>
var activityId = window.location.pathname.split('/').pop();

$(function () {
    $.getJSON('/api/public/activities/' + activityId, function (json) {
        if (json.data) {
            renderActivity(json.data);
        } else {
            showNotFound();
        }
    }).fail(function () {
        showNotFound();
    });
});

function renderActivity(a) {
    $('#loading').addClass('hidden');
    $('#activity-content').removeClass('hidden');

    document.title = a.title + ' - University Activities';
    $('#breadcrumb-title').text(a.title);

    if (a.cover_image_url) {
        $('#cover-img').attr('src', a.cover_image_url).attr('alt', a.title).removeClass('hidden');
        $('#cover-placeholder').addClass('hidden');
    }

    $('#activity-title').text(a.title);
    $('#activity-description').text(a.description || '');

    var date = a.activity_date || '-';
    var months = ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'];
    if (a.activity_date) {
        var parts = a.activity_date.split('-');
        if (parts.length === 3) {
            date = parseInt(parts[2]) + ' ' + months[parseInt(parts[1]) - 1] + ' ' + (parseInt(parts[0]) + 543);
        }
    }
    $('#detail-date').append(date);
    $('#detail-location').append(a.location || 'ไม่มีสถานที่');

    if (a.category) {
        $('#detail-category').append(a.category.name);
    }

    $('#detail-participants').append((a.participants_count ?? 0) + ' คน');

    if (a.pdf_url) {
        $('#pdf-preview-wrap').removeClass('hidden');
        $('#pdf-preview').attr('src', a.pdf_url);
        $('#pdf-download-link').attr('href', a.pdf_url);
        $('#pdf-sidebar-wrap').removeClass('hidden');
        $('#pdf-sidebar-link').attr('href', a.pdf_url);
    }
}

function showNotFound() {
    $('#loading').addClass('hidden');
    $('#not-found').removeClass('hidden');
}
</script>
@endsection
