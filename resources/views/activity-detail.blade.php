@extends('layouts.master')

@section('title', 'รายละเอียดกิจกรรม - University Activities')

@section('content')
@php $siteName = setting('site_name', 'University Activities'); $siteDesc = setting('site_description', 'ระบบจัดการกิจกรรมและเอกสารของมหาวิทยาลัย'); $footerText = setting('footer_text', '© ' . date('Y') . ' University Activities. สงวนลิขสิทธิ์ทั้งหมด'); @endphp

<div style="background:#f8fafc;border-bottom:1px solid #f1f5f9">
    <div class="mx-auto px-4 py-2" style="max-width:72rem">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="/" class="text-decoration-none">หน้าหลัก</a></li>
                <li class="breadcrumb-item"><a href="/activities" class="text-decoration-none">กิจกรรมทั้งหมด</a></li>
                <li class="breadcrumb-item active" aria-current="page" id="breadcrumb-title">โหลด...</li>
            </ol>
        </nav>
    </div>
</div>

<section class="bg-white py-5">
    <div class="mx-auto px-4" style="max-width:72rem">
        <div id="loading" class="text-center py-5">
            <div class="spinner-border text-primary mb-3" style="width:3rem;height:3rem" role="status"></div>
            <p class="text-muted">กำลังโหลดข้อมูล...</p>
        </div>

        <div id="activity-content" class="d-none">
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="overflow-hidden rounded-3 bg-light mb-4" style="aspect-ratio:16/9">
                        <img id="cover-img" src="" alt="" class="d-none w-100 h-100" style="object-fit:cover">
                        <div id="cover-placeholder" class="d-flex align-items-center justify-content-center w-100 h-100 text-muted" style="font-size:3rem"><i class="bx bx-image"></i></div>
                    </div>

                    <h1 id="activity-title" class="fw-bold mb-3" style="font-size:1.75rem;color:#111827"></h1>
                    <div id="activity-description" class="text-muted mb-4" style="font-size:1rem;line-height:1.625"></div>

                    <div id="pdf-preview-wrap" class="d-none card">
                        <div class="card-header d-flex align-items-center justify-content-between bg-light">
                            <span class="fw-semibold small"><i class="bx bxs-file-pdf text-danger me-1"></i>เอกสาร PDF</span>
                            <a id="pdf-download-link" href="#" target="_blank" class="btn btn-sm btn-outline-danger"><i class="bx bx-download me-1"></i>ดาวน์โหลด</a>
                        </div>
                        <iframe id="pdf-preview" src="" style="width:100%;height:500px;border:none"></iframe>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card" style="position:sticky;top:6rem">
                        <div class="card-body d-flex flex-column gap-3">
                            <div>
                                <small class="text-muted text-uppercase fw-semibold d-block mb-1">วันที่จัดกิจกรรม</small>
                                <p id="detail-date" class="fw-bold mb-0 d-flex align-items-center gap-2"><i class="bx bx-calendar text-primary"></i></p>
                            </div>
                            <div>
                                <small class="text-muted text-uppercase fw-semibold d-block mb-1">สถานที่</small>
                                <p id="detail-location" class="fw-bold mb-0 d-flex align-items-center gap-2"><i class="bx bx-map-pin text-primary"></i></p>
                            </div>
                            <div>
                                <small class="text-muted text-uppercase fw-semibold d-block mb-1">หมวดหมู่</small>
                                <p id="detail-category" class="fw-bold mb-0 d-flex align-items-center gap-2"><i class="bx bx-receipt text-primary"></i></p>
                            </div>
                            <div>
                                <small class="text-muted text-uppercase fw-semibold d-block mb-1">ผู้เข้าร่วม</small>
                                <p id="detail-participants" class="fw-bold mb-0 d-flex align-items-center gap-2"><i class="bx bx-user text-primary"></i></p>
                            </div>
                        </div>
                        <div id="pdf-sidebar-wrap" class="d-none">
                            <hr class="my-0">
                            <div class="card-body">
                                <p class="fw-semibold text-uppercase small text-muted mb-2">ดาวน์โหลด</p>
                                <a id="pdf-sidebar-link" href="#" target="_blank" class="btn btn-outline-danger w-100 d-flex align-items-center gap-2"><i class="bx bxs-file-pdf"></i> ดาวน์โหลด PDF</a>
                            </div>
                        </div>
                    </div>
                    <a href="/activities" class="btn btn-outline-secondary w-100 mt-3 d-flex align-items-center justify-content-center gap-2"><i class="bx bx-arrow-back"></i>กลับไปหน้ากิจกรรมทั้งหมด</a>
                </div>
            </div>
        </div>

        <div id="not-found" class="d-none text-center py-5">
            <div class="mb-3 text-muted" style="font-size:4rem"><i class="bx bx-error-circle"></i></div>
            <h4 class="fw-bold mb-2">ไม่พบกิจกรรม</h4>
            <p class="text-muted mb-4">กิจกรรมที่คุณกำลังค้นหาอาจถูกลบหรือย้ายไปแล้ว</p>
            <a href="/activities" class="btn btn-primary btn-lg d-inline-flex align-items-center gap-2"><i class="bx bx-arrow-back"></i>กลับไปหน้ากิจกรรมทั้งหมด</a>
        </div>
    </div>
</section>

<footer style="background:#030712;color:#9ca3af;padding:3rem 1.5rem">
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
        var activityId = window.location.pathname.split('/').pop();
        var trackedView = false;
        var trackedDownload = false;

        function track(type) {
            if (type === 'view' && trackedView) return;
            if (type === 'download' && trackedDownload) return;
            if (type === 'view') trackedView = true;
            if (type === 'download') trackedDownload = true;
            $.post('/api/public/activities/' + activityId + '/track', { type: type });
        }

        $(function() {
            $.post('/api/public/activities/detail/' + activityId, function(json) {
                if (json.data) renderActivity(json.data);
                else showNotFound();
            }).fail(function() { showNotFound(); });
        });

        function renderActivity(a) {
            $('#loading').addClass('d-none');
            $('#activity-content').removeClass('d-none');
            document.title = a.title + ' - University Activities';
            $('#breadcrumb-title').text(a.title);
            track('view');

            if (a.cover_image_url) {
                $('#cover-img').attr('src', a.cover_image_url).attr('alt', a.title).removeClass('d-none');
                $('#cover-placeholder').addClass('d-none');
            }
            $('#activity-title').text(a.title);
            $('#activity-description').text(a.description || '');
            var date = a.activity_date || '-';
            var months = ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'];
            if (a.activity_date) {
                var parts = a.activity_date.split('-');
                if (parts.length === 3) date = parseInt(parts[2]) + ' ' + months[parseInt(parts[1]) - 1] + ' ' + (parseInt(parts[0]) + 543);
            }
            $('#detail-date').append(date);
            $('#detail-location').append(a.location || 'ไม่มีสถานที่');
            if (a.category) $('#detail-category').append(a.category.name);
            $('#detail-participants').append((a.participants_count ?? 0) + ' คน');
            if (a.pdf_url) {
                $('#pdf-preview-wrap').removeClass('d-none');
                $('#pdf-preview').attr('src', a.pdf_url);
                track('download');
                $('#pdf-download-link').attr('href', a.pdf_url).on('click', function() { track('download'); });
                $('#pdf-sidebar-wrap').removeClass('d-none');
                $('#pdf-sidebar-link').attr('href', a.pdf_url).on('click', function() { track('download'); });
            }
        }

        function showNotFound() {
            $('#loading').addClass('d-none');
            $('#not-found').removeClass('d-none');
        }
    </script>
@endsection
