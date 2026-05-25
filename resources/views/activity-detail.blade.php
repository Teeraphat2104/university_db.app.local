@extends('layouts.master')

@section('title', 'รายละเอียดกิจกรรม - University Activities')

@section('style')
<style>
.detail-cover {
    aspect-ratio: 16/9; border-radius: 1rem; overflow: hidden;
    background: #f1f5f9;
}
.detail-cover-img { width: 100%; height: 100%; object-fit: cover; }
.detail-cover-fallback {
    display: flex; align-items: center; justify-content: center;
    width: 100%; height: 100%;
    background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
    color: #94a3b8; font-size: 3rem;
}

.detail-cover-title {
    font-size: 1.75rem; font-weight: 700; color: #0f172a;
    line-height: 1.3;
}

.detail-body { max-width: 72rem; margin: 0 auto; padding: 2.5rem 1.25rem; }

.detail-description {
    font-size: 1rem; line-height: 1.75; color: #334155;
}

.detail-card {
    position: sticky; top: 6rem;
    background: #fff; border: 1px solid #e2e8f0; border-radius: 1rem;
    box-shadow: 0 4px 24px rgba(0,0,0,.04); overflow: hidden;
}
.detail-card-body { padding: 1.25rem; display: flex; flex-direction: column; gap: 1.25rem; }
.detail-card-item { display: flex; align-items: flex-start; gap: .75rem; }
.detail-card-icon {
    display: flex; align-items: center; justify-content: center;
    width: 2.25rem; height: 2.25rem; border-radius: 10px;
    background: #f0f0ff; color: #696cff; font-size: 1.125rem;
    flex-shrink: 0;
}
.detail-card-label {
    display: block; font-size: .6875rem; font-weight: 600;
    text-transform: uppercase; letter-spacing: .05em; color: #94a3b8;
    margin-bottom: .125rem;
}
.detail-card-value { font-weight: 600; color: #1e293b; font-size: .875rem; }
.detail-card-divider { height: 1px; background: #f1f5f9; margin: 0; border: none; }

.detail-pdf-wrap {
    border: 1px solid #e2e8f0; border-radius: 1rem; overflow: hidden;
}
.detail-pdf-header {
    display: flex; align-items: center; justify-content: space-between;
    padding: .75rem 1rem; background: #f8fafc;
    font-size: .8125rem; font-weight: 600;
}
.detail-pdf-btn {
    display: inline-flex; align-items: center; gap: .375rem;
    padding: .375rem .875rem; font-size: .8125rem; font-weight: 600;
    color: #dc2626; border: 1px solid #fecaca; border-radius: 8px;
    background: #fff; text-decoration: none;
    transition: all .15s ease;
}
.detail-pdf-btn:hover { background: #fef2f2; border-color: #fca5a5; }

.detail-notfound { text-align: center; padding: 5rem 1.25rem; }
.detail-notfound-icon { font-size: 4rem; color: #cbd5e1; margin-bottom: 1rem; }
.detail-notfound-title { font-size: 1.5rem; font-weight: 700; color: #1e293b; margin-bottom: .5rem; }
.detail-notfound-text { color: #64748b; margin-bottom: 1.5rem; }
</style>
@endsection

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

<a href="javascript:history.back()" class="detail-back-btn" style="margin:1rem auto 0;max-width:72rem;display:inline-flex;margin-left:1.25rem"><i class="bx bx-arrow-back"></i> ย้อนกลับ</a>

<div id="loading" class="text-center py-5" style="margin-top:2rem">
    <div class="spinner-border text-primary mb-3" style="width:3rem;height:3rem" role="status"></div>
    <p class="text-muted">กำลังโหลดข้อมูล...</p>
</div>

<div id="activity-content" class="d-none">
    <div class="detail-body">
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="detail-cover mb-4">
                    <img id="cover-img" src="" alt="" class="detail-cover-img d-none">
                    <div id="cover-placeholder" class="detail-cover-fallback">
                        <i class="bx bx-image"></i>
                    </div>
                </div>

                <h1 id="activity-title" class="detail-cover-title mb-3"></h1>

                <div id="activity-description" class="detail-description mb-4"></div>

                <div id="pdf-preview-wrap" class="detail-pdf-wrap d-none">
                    <div class="detail-pdf-header">
                        <span><i class="bx bxs-file-pdf" style="color:#dc2626"></i> เอกสาร PDF</span>
                        <a id="pdf-download-link" href="#" target="_blank" class="detail-pdf-btn"><i class="bx bx-download"></i> ดาวน์โหลด</a>
                    </div>
                    <iframe id="pdf-preview" src="" style="width:100%;height:500px;border:none"></iframe>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="detail-card">
                    <div class="detail-card-body">
                        <div class="detail-card-item">
                            <div class="detail-card-icon"><i class="bx bx-calendar"></i></div>
                            <div>
                                <span class="detail-card-label">วันที่จัดกิจกรรม</span>
                                <span class="detail-card-value" id="detail-date"></span>
                            </div>
                        </div>
                        <hr class="detail-card-divider">
                        <div class="detail-card-item">
                            <div class="detail-card-icon"><i class="bx bx-map-pin"></i></div>
                            <div>
                                <span class="detail-card-label">สถานที่</span>
                                <span class="detail-card-value" id="detail-location"></span>
                            </div>
                        </div>
                        <hr class="detail-card-divider">
                        <div class="detail-card-item">
                            <div class="detail-card-icon"><i class="bx bx-receipt"></i></div>
                            <div>
                                <span class="detail-card-label">หมวดหมู่</span>
                                <span class="detail-card-value" id="detail-category"></span>
                            </div>
                        </div>
                        <hr class="detail-card-divider">
                        <div class="detail-card-item">
                            <div class="detail-card-icon"><i class="bx bx-user"></i></div>
                            <div>
                                <span class="detail-card-label">ผู้เข้าร่วม</span>
                                <span class="detail-card-value" id="detail-participants"></span>
                            </div>
                        </div>
                    </div>
                    <div id="pdf-sidebar-wrap" class="d-none">
                        <hr class="detail-card-divider">
                        <div class="detail-card-body">
                            <span class="detail-card-label">ดาวน์โหลด</span>
                            <a id="pdf-sidebar-link" href="#" target="_blank" class="detail-pdf-btn w-100 justify-content-center"><i class="bx bxs-file-pdf"></i> ดาวน์โหลด PDF</a>
                        </div>
                    </div>
                </div>
                <a href="/activities" class="detail-back-btn w-100 justify-content-center mt-3"><i class="bx bx-arrow-back"></i> กลับไปหน้ากิจกรรมทั้งหมด</a>
            </div>
        </div>
    </div>
</div>

<div id="not-found" class="detail-notfound d-none">
    <div class="detail-notfound-icon"><i class="bx bx-error-circle"></i></div>
    <h2 class="detail-notfound-title">ไม่พบกิจกรรม</h2>
    <p class="detail-notfound-text">กิจกรรมที่คุณกำลังค้นหาอาจถูกลบหรือย้ายไปแล้ว</p>
    <a href="/activities" class="detail-back-btn"><i class="bx bx-arrow-back"></i> กลับไปหน้ากิจกรรมทั้งหมด</a>
</div>

@include('layouts.footer')
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

            var months = ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'];
            var date = '-';
            if (a.activity_date) {
                var parts = a.activity_date.split('-');
                if (parts.length === 3) date = parseInt(parts[2]) + ' ' + months[parseInt(parts[1]) - 1] + ' ' + (parseInt(parts[0]) + 543);
            }

            if (a.cover_image_url) {
                $('#cover-img').attr('src', a.cover_image_url).attr('alt', a.title).removeClass('d-none');
                $('#cover-placeholder').addClass('d-none');
            }
            $('#activity-title').text(a.title);
            $('#activity-description').text(a.description || '');
            $('#detail-date').text(date);
            $('#detail-location').text(a.location || 'ไม่มีสถานที่');
            if (a.category) $('#detail-category').text(a.category.name);
            $('#detail-participants').text((a.participants_count ?? 0) + ' คน');

            if (a.pdf_url) {
                $('#pdf-preview-wrap').removeClass('d-none');
                $('#pdf-preview').attr('src', a.pdf_url);
                $('#pdf-download-link').attr('href', a.pdf_url).off('click').on('click', function() { track('download'); });
                $('#pdf-sidebar-wrap').removeClass('d-none');
                $('#pdf-sidebar-link').attr('href', a.pdf_url).off('click').on('click', function() { track('download'); });
                track('download');
            }
        }

        function showNotFound() {
            $('#loading').addClass('d-none');
            $('#not-found').removeClass('d-none');
        }
    </script>
@endsection
