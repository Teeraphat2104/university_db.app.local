@extends('layouts.master')

@section('title', 'รายละเอียดกิจกรรม - University Activities')

@section('content')
<style>
.hover-indigo-600:hover{color:#4f46e5!important}
.hover-bg-red-100:hover{background-color:#fee2e2!important}
.hover-bg-gray-100:hover{background-color:#f3f4f6!important}
.hover-text-white:hover{color:#fff!important}
.not-found-btn:hover{box-shadow:0 10px 15px -3px rgba(99,102,241,0.3)!important;transform:translateY(-0.125rem)!important}
.hover-indigo-600,.hover-bg-red-100,.hover-bg-gray-100,.hover-text-white{transition:color .15s ease-in-out,background-color .15s ease-in-out}
.not-found-btn{transition:all .15s ease-in-out}
</style>
    <div style="background-color:#f9fafb;border-bottom:1px solid #f3f4f6">
        <div class="mx-auto" style="max-width:72rem;padding:1rem 1.5rem">
            <div class="d-flex align-items-center" style="gap:0.5rem;font-size:0.875rem;color:#6b7280">
                <a href="/" class="text-decoration-none hover-indigo-600" style="color:#6b7280">หน้าหลัก</a>
                <i class="fa-solid fa-chevron-right" style="font-size:0.75rem;color:#d1d5db"></i>
                <a href="/activities" class="text-decoration-none hover-indigo-600" style="color:#6b7280">กิจกรรมทั้งหมด</a>
                <i class="fa-solid fa-chevron-right" style="font-size:0.75rem;color:#d1d5db"></i>
                <span class="fw-medium" style="color:#1f2937" id="breadcrumb-title">โหลด...</span>
            </div>
        </div>
    </div>

    <section class="bg-white" style="padding:2.5rem 0">
        <div class="mx-auto" style="max-width:72rem;padding:0 1.5rem">
            <div id="loading" class="text-center" style="padding:5rem 0">
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle" style="width:5rem;height:5rem;background-color:#eef2ff;margin-bottom:1rem">
                    <i class="fa-solid fa-circle-notch fa-spin" style="font-size:1.5rem;color:#818cf8"></i>
                </div>
                <p class="fw-medium" style="color:#6b7280">กำลังโหลดข้อมูล...</p>
            </div>

            <div id="activity-content" class="d-none">
                <div class="d-flex flex-column flex-lg-row" style="gap:2rem">
                    <div class="flex-fill d-flex flex-column" style="min-width:0;gap:1.5rem">
                        <div id="cover-wrap" class="overflow-hidden position-relative" style="border-radius:1rem;background-color:#f3f4f6;aspect-ratio:16/9">
                            <img id="cover-img" src="" alt="" class="d-none" style="width:100%;height:100%;object-fit:cover">
                            <div id="cover-placeholder" class="d-flex align-items-center justify-content-center" style="width:100%;height:100%;font-size:3rem;color:#d1d5db"><i class="fa-regular fa-image"></i></div>
                        </div>

                        <div>
                            <h1 id="activity-title" class="fw-bolder" style="font-size:1.875rem;color:#111827;margin-bottom:1.5rem"></h1>
                            <div id="activity-description" style="color:#4b5563;font-size:1rem;line-height:1.625"></div>
                        </div>

                        <div id="pdf-preview-wrap" class="d-none overflow-hidden" style="border-radius:1rem;border:1px solid #e5e7eb">
                            <div class="d-flex align-items-center justify-content-between" style="background-color:#f9fafb;padding:0.75rem 1rem;border-bottom:1px solid #e5e7eb">
                                <span class="fw-semibold" style="font-size:0.875rem;color:#374151"><i class="fa-solid fa-file-pdf" style="color:#ef4444;margin-right:0.5rem"></i>เอกสาร PDF</span>
                                <a id="pdf-download-link" href="#" target="_blank" class="d-inline-flex align-items-center text-decoration-none hover-bg-red-100" style="gap:0.375rem;padding:0.375rem 0.75rem;font-size:0.75rem;font-weight:600;color:#dc2626;background-color:#fef2f2;border-radius:0.5rem">
                                    <i class="fa-solid fa-download"></i> ดาวน์โหลด
                                </a>
                            </div>
                            <iframe id="pdf-preview" src="" style="width:100%;height:500px;background-color:#f3f4f6" frameborder="0"></iframe>
                        </div>
                    </div>

                    <div class="flex-shrink-0" style="flex:0 0 auto;width:20rem">
                        <div class="d-flex flex-column" style="position:sticky;top:6rem;gap:1rem">
                            <div class="d-flex flex-column" style="background:linear-gradient(135deg,#eef2ff,#faf5ff);border-radius:1rem;padding:1.25rem;gap:1rem;border:1px solid #e0e7ff">
                                <div>
                                    <p class="fw-semibold text-uppercase" style="font-size:0.75rem;color:#9ca3af;letter-spacing:0.05em;margin-bottom:0.25rem">วันที่จัดกิจกรรม</p>
                                    <p id="detail-date" class="fw-bold d-flex align-items-center" style="font-size:0.875rem;color:#1f2937;gap:0.5rem"><i class="fa-regular fa-calendar" style="color:#6366f1"></i></p>
                                </div>
                                <div>
                                    <p class="fw-semibold text-uppercase" style="font-size:0.75rem;color:#9ca3af;letter-spacing:0.05em;margin-bottom:0.25rem">สถานที่</p>
                                    <p id="detail-location" class="fw-bold d-flex align-items-center" style="font-size:0.875rem;color:#1f2937;gap:0.5rem"><i class="fa-solid fa-location-dot" style="color:#6366f1"></i></p>
                                </div>
                                <div>
                                    <p class="fw-semibold text-uppercase" style="font-size:0.75rem;color:#9ca3af;letter-spacing:0.05em;margin-bottom:0.25rem">หมวดหมู่</p>
                                    <p id="detail-category" class="fw-bold d-flex align-items-center" style="font-size:0.875rem;color:#1f2937;gap:0.5rem"><i class="fa-regular fa-rectangle-list" style="color:#6366f1"></i></p>
                                </div>
                                <div>
                                    <p class="fw-semibold text-uppercase" style="font-size:0.75rem;color:#9ca3af;letter-spacing:0.05em;margin-bottom:0.25rem">ผู้เข้าร่วม</p>
                                    <p id="detail-participants" class="fw-bold d-flex align-items-center" style="font-size:0.875rem;color:#1f2937;gap:0.5rem"><i class="fa-solid fa-users" style="color:#6366f1"></i></p>
                                </div>
                            </div>

                            <div id="pdf-sidebar-wrap" class="d-none bg-white" style="border-radius:1rem;padding:1.25rem;border:1px solid #e5e7eb">
                                <p class="fw-semibold text-uppercase" style="font-size:0.75rem;color:#9ca3af;letter-spacing:0.05em;margin-bottom:0.75rem">ดาวน์โหลด</p>
                                <a id="pdf-sidebar-link" href="#" target="_blank" class="d-flex align-items-center text-decoration-none hover-bg-red-100" style="gap:0.75rem;padding:0.75rem 1rem;background-color:#fef2f2;color:#b91c1c;border-radius:0.75rem">
                                    <i class="fa-solid fa-file-pdf" style="font-size:1.125rem"></i>
                                    <div>
                                        <p class="fw-bold" style="font-size:0.875rem">ดาวน์โหลด PDF</p>
                                        <p style="font-size:0.75rem;color:#ef4444">เอกสารประกอบกิจกรรม</p>
                                    </div>
                                </a>
                            </div>

                            <a href="/activities" class="d-flex align-items-center justify-content-center w-100 text-decoration-none hover-bg-gray-100" style="gap:0.5rem;padding:0.75rem 1rem;font-size:0.875rem;font-weight:600;color:#4b5563;background-color:#f9fafb;border-radius:0.75rem;border:1px solid #e5e7eb">
                                <i class="fa-solid fa-arrow-left"></i>
                                กลับไปหน้ากิจกรรมทั้งหมด
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div id="not-found" class="d-none text-center" style="padding:5rem 0">
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle" style="width:6rem;height:6rem;background-color:#fef2f2;margin-bottom:1rem">
                    <i class="fa-regular fa-circle-exclamation" style="font-size:1.875rem;color:#f87171"></i>
                </div>
                <h3 class="fw-bold" style="font-size:1.25rem;color:#1f2937;margin-bottom:0.5rem">ไม่พบกิจกรรม</h3>
                <p style="color:#6b7280;margin-bottom:1.5rem">กิจกรรมที่คุณกำลังค้นหาอาจถูกลบหรือย้ายไปแล้ว</p>
                <a href="/activities" class="d-inline-flex align-items-center text-decoration-none not-found-btn" style="gap:0.5rem;padding:0.75rem 1.5rem;font-size:0.875rem;font-weight:700;color:#fff;background:linear-gradient(to right,#6366f1,#a855f7);border-radius:0.75rem;box-shadow:0 10px 15px -3px rgba(99,102,241,0.3)">
                    <i class="fa-solid fa-arrow-left"></i> กลับไปหน้ากิจกรรมทั้งหมด
                </a>
            </div>
        </div>
    </section>

    @php
        $siteName = setting('site_name', 'University Activities');
        $siteDesc = setting('site_description', 'ระบบจัดการกิจกรรมและเอกสารของมหาวิทยาลัย');
        $footerText = setting('footer_text', '© ' . date('Y') . ' University Activities. สงวนลิขสิทธิ์ทั้งหมด');
        $fbUrl = setting('facebook_url');
        $lineUrl = setting('line_url');
        $ytUrl = setting('youtube_url');
    @endphp
    <footer style="background-color:#030712;color:#9ca3af;padding:3rem 1.5rem">
        <div class="mx-auto" style="max-width:72rem">
            <div class="d-flex flex-wrap justify-content-between" style="gap:2rem;padding-bottom:2rem;border-bottom:1px solid rgba(255,255,255,0.1);margin-bottom:1.5rem">
                <div>
                    <div class="d-flex align-items-center" style="gap:0.75rem;margin-bottom:0.75rem">
                        <div class="d-flex align-items-center justify-content-center" style="width:2.5rem;height:2.5rem;background:linear-gradient(135deg,#6366f1,#a855f7);border-radius:0.75rem;color:#fff;box-shadow:0 10px 15px -3px rgba(99,102,241,0.3)">
                            <i class="fa-solid fa-graduation-cap"></i> </div>
                        <div class="fw-bolder" style="color:#fff;font-size:1.125rem">{{ $siteName }}</div>
                    </div>
                    <p style="font-size:0.875rem;color:#9ca3af;max-width:20rem;line-height:1.625">{{ $siteDesc }}</p>
                </div>
                <nav class="d-flex flex-column" style="gap:0.75rem;font-size:0.875rem">
                    <p class="fw-semibold" style="color:#fff;margin-bottom:0.25rem">เมนู</p>
                    <a href="/activities" class="text-decoration-none hover-text-white" style="color:#9ca3af"><i class="fa-regular fa-calendar me-2"></i>กิจกรรมทั้งหมด</a>
                    <a href="/#about" class="text-decoration-none hover-text-white" style="color:#9ca3af"><i class="fa-regular fa-circle-info me-2"></i>เกี่ยวกับระบบ</a>
                    <a href="/login" class="text-decoration-none hover-text-white" style="color:#9ca3af"><i class="fa-solid fa-user-gear me-2"></i>สำหรับผู้ดูแล</a>
                </nav>
            </div>
            <div class="d-flex flex-wrap justify-content-between align-items-center" style="gap:1rem">
                <p style="font-size:0.75rem;color:#6b7280">{{ $footerText }}</p>
                <p style="font-size:0.75rem;color:#4b5563">พัฒนาด้วย <i class="fa-solid fa-heart" style="color:#ef4444;margin:0 0.25rem"></i> สำหรับมหาวิทยาลัย</p>
            </div>
        </div>
    </footer>
@endsection

@section('script')
    <script>
        var activityId = window.location.pathname.split('/').pop();

        $(function() {
            $.getJSON('/api/public/activities/' + activityId, function(json) {
                if (json.data) {
                    renderActivity(json.data);
                } else {
                    showNotFound();
                }
            }).fail(function() {
                showNotFound();
            });
        });

        function renderActivity(a) {
            $('#loading').addClass('d-none');
            $('#activity-content').removeClass('d-none');

            document.title = a.title + ' - University Activities';
            $('#breadcrumb-title').text(a.title);

            if (a.cover_image_url) {
                $('#cover-img').attr('src', a.cover_image_url).attr('alt', a.title).removeClass('d-none');
                $('#cover-placeholder').addClass('d-none');
            }

            $('#activity-title').text(a.title);
            $('#activity-description').text(a.description || '');

            var date = a.activity_date || '-';
            var months = ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.',
            'ธ.ค.'];
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
                $('#pdf-preview-wrap').removeClass('d-none');
                $('#pdf-preview').attr('src', a.pdf_url);
                $('#pdf-download-link').attr('href', a.pdf_url);
                $('#pdf-sidebar-wrap').removeClass('d-none');
                $('#pdf-sidebar-link').attr('href', a.pdf_url);
            }
        }

        function showNotFound() {
            $('#loading').addClass('d-none');
            $('#not-found').removeClass('d-none');
        }
    </script>
@endsection
