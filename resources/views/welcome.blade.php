@extends('layouts.master')

@section('title', setting('site_name', 'University Activities') . ' - ' . setting('site_description',
    'ระบบจัดการกิจกรรมมหาวิทยาลัย'))

@section('style')
    <style>
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(24px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-up-1 {
            animation: fadeUp .6s ease-out .1s backwards;
        }

        .fade-up-2 {
            animation: fadeUp .6s ease-out .2s backwards;
        }

        .fade-up-3 {
            animation: fadeUp .6s ease-out .3s backwards;
        }

        .fade-up-4 {
            animation: fadeUp .6s ease-out .4s backwards;
        }

        .fade-up-5 {
            animation: fadeUp .6s ease-out .5s backwards;
        }

        .hero-gradient {
            background: radial-gradient(circle, rgba(99, 102, 241, 0.12) 0%, transparent 70%);
        }

        .hero-gradient-2 {
            background: radial-gradient(circle, rgba(139, 92, 246, 0.10) 0%, transparent 70%);
        }

        .social-link {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.06);
            color: var(--color-gray-400);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            font-size: 1rem;
        }

        .social-link:hover {
            background: var(--primary-color, #6366F1);
            color: #fff;
            transform: translateY(-2px);
            text-decoration: none;
        }

        .hero-gradient-bg {
            background: linear-gradient(135deg, #030712, #1e1b4b, #030712);
        }

        .hero-title {
            font-size: 1.875rem;
            font-weight: 900;
            line-height: 1.25;
        }
        @media (min-width: 576px) {
            .hero-title { font-size: 2.25rem; }
        }
        @media (min-width: 992px) {
            .hero-title { font-size: 3rem; }
        }

        .hero-subtitle {
            font-size: 1rem;
            line-height: 1.625;
        }
        @media (min-width: 576px) {
            .hero-subtitle { font-size: 1.125rem; }
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 900;
        }
        @media (min-width: 576px) {
            .section-title { font-size: 1.875rem; }
        }

        .py-section {
            padding-top: 4rem;
            padding-bottom: 4rem;
        }
        @media (min-width: 576px) {
            .py-section { padding-top: 5rem; padding-bottom: 5rem; }
        }

        .btn-gradient {
            background: linear-gradient(to right, #6366F1, #a855f7);
            border: none;
            transition: all .2s ease;
        }
        .btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(99, 102, 241, 0.4);
            color: #fff;
        }

        .hero-btn {
            transition: all .2s ease;
        }
        .hero-btn:hover {
            background: rgba(255, 255, 255, 0.2) !important;
            color: #fff !important;
        }

        .stat-card {
            transition: all .2s ease;
            cursor: pointer;
        }
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.15), 0 4px 6px -4px rgba(0, 0, 0, 0.1);
        }

        .feature-card {
            transition: all .2s ease;
            border-color: var(--gray-100, #f3f4f6);
        }
        .feature-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 25px -5px rgba(99, 102, 241, 0.06), 0 8px 10px -6px rgba(99, 102, 241, 0.04);
            border-color: #c7d2fe !important;
        }
        .feature-card-red:hover {
            border-color: #fecaca !important;
            box-shadow: 0 20px 25px -5px rgba(239, 68, 68, 0.06), 0 8px 10px -6px rgba(239, 68, 68, 0.04);
        }
        .feature-card-emerald:hover {
            border-color: #a7f3d0 !important;
            box-shadow: 0 20px 25px -5px rgba(16, 185, 129, 0.06), 0 8px 10px -6px rgba(16, 185, 129, 0.04);
        }
        .feature-card-amber:hover {
            border-color: #fde68a !important;
            box-shadow: 0 20px 25px -5px rgba(245, 158, 11, 0.06), 0 8px 10px -6px rgba(245, 158, 11, 0.04);
        }

        .why-card {
            transition: all .2s ease;
        }
        .why-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.08);
        }

        .activity-card {
            transition: all .2s ease;
        }
        .activity-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.08);
        }

        .nav-link-footer {
            transition: color .2s ease;
            text-decoration: none;
        }
        .nav-link-footer:hover {
            color: #fff !important;
        }

        .backdrop-blur {
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
        }

        .object-cover {
            object-fit: cover;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
@endsection

@section('content')
    @php
        $heroTitle = setting('hero_title', 'จัดการกิจกรรมมหาวิทยาลัย ให้ง่ายยิ่งขึ้น');
        $heroSub = setting('hero_subtitle', 'ระบบครบวงจรสำหรับจัดการกิจกรรม อัปโหลดเอกสาร และติดตามข้อมูลอย่างมีประสิทธิภาพ');
        $siteName = setting('site_name', 'University Activities');
        $siteDesc = setting('site_description', 'ระบบจัดการกิจกรรมและเอกสารของมหาวิทยาลัย');
        $footerText = setting('footer_text', '© ' . date('Y') . ' University Activities. สงวนลิขสิทธิ์ทั้งหมด');
        $fbUrl = setting('facebook_url');
        $lineUrl = setting('line_url');
        $ytUrl = setting('youtube_url');
    @endphp
    <div id="public-view">
        <section
            class="position-relative d-flex align-items-center overflow-hidden hero-gradient-bg" style="min-height:600px;padding-top:4rem;">
            <div class="position-absolute" style="top:0;right:0;bottom:0;left:0;pointer-events:none;">
                <div class="position-absolute hero-gradient rounded-circle" style="width:500px;height:500px;top:-80px;left:-80px;"></div>
                <div class="position-absolute hero-gradient-2 rounded-circle" style="width:400px;height:400px;bottom:-80px;right:-80px;"></div>
            </div>
            <div class="position-relative mx-auto w-100" style="max-width:1200px;padding:5rem 1.5rem;z-index:10;">
                <div
                    class="d-inline-flex align-items-center gap-2 rounded-pill fw-semibold mb-5 backdrop-blur" style="padding:0.375rem 1rem;background:rgba(99,102,241,0.1);border:1px solid rgba(99,102,241,0.3);color:rgb(165,180,252);font-size:0.75rem;">
                    <i class="fa-solid fa-layer-group" style="font-size:10px;"></i>
                    {{ $siteDesc }}
                </div>
                <h1 class="text-white hero-title mb-4 fade-up-2">
                    {{ $heroTitle }}
                </h1>
                <p class="hero-subtitle fade-up-3" style="color:var(--gray-400);max-width:512px;margin-bottom:2rem;">
                    {{ $heroSub }}
                </p>
                <div class="d-flex flex-wrap gap-3 mb-5 fade-up-4">
                    <a href="/activities"
                        class="d-inline-flex align-items-center gap-2 text-decoration-none btn-gradient rounded-pill text-white" style="padding:0.75rem 1.5rem;font-size:0.875rem;font-weight:700;box-shadow:0 10px 15px -3px rgba(99,102,241,0.3);">
                        <i class="fa-solid fa-calendar-check"></i>
                        ดูกิจกรรมทั้งหมด
                    </a>
                    <button type="button" id="open-participant-search-hero"
                        class="d-inline-flex align-items-center gap-2 hero-btn rounded-pill" style="padding:0.75rem 1.5rem;font-size:0.875rem;font-weight:600;color:rgba(255,255,255,0.8);background:rgba(255,255,255,0.1);border:1px solid rgba(255,255,255,0.15);cursor:pointer;">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        ตรวจสอบการเข้าร่วม
                    </button>
                    <a href="/login"
                        class="d-inline-flex align-items-center gap-2 hero-btn rounded-pill text-decoration-none" style="padding:0.75rem 1.5rem;font-size:0.875rem;font-weight:600;color:rgba(255,255,255,0.8);background:rgba(255,255,255,0.1);border:1px solid rgba(255,255,255,0.15);">
                        <i class="fa-solid fa-user-tie"></i>
                        สำหรับผู้ดูแล
                    </a>
                </div>
                <div class="row row-cols-2 row-cols-sm-4 g-3 fade-up-5" style="max-width:512px;">
                    <div class="col">
                        <div class="stat-card text-center d-block" style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);border-radius:1rem;padding:1.5rem 1rem;">
                            <i class="fa-regular fa-calendar d-block mb-2" style="color:#818cf8;font-size:1.125rem;"></i>
                            <p class="text-white mb-1" style="font-size:1.5rem;font-weight:900;line-height:1;" id="stat-activities">0</p>
                            <p class="fw-medium" style="color:var(--gray-500);font-size:0.75rem;">กิจกรรม</p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="stat-card text-center d-block" style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);border-radius:1rem;padding:1.5rem 1rem;">
                            <i class="fa-regular fa-rectangle-list d-block mb-2" style="color:#818cf8;font-size:1.125rem;"></i>
                            <p class="text-white mb-1" style="font-size:1.5rem;font-weight:900;line-height:1;" id="stat-categories">0</p>
                            <p class="fw-medium" style="color:var(--gray-500);font-size:0.75rem;">หมวดหมู่</p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="stat-card text-center d-block" style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);border-radius:1rem;padding:1.5rem 1rem;">
                            <i class="fa-regular fa-file-lines d-block mb-2" style="color:#818cf8;font-size:1.125rem;"></i>
                            <p class="text-white mb-1" style="font-size:1.5rem;font-weight:900;line-height:1;" id="stat-documents">0</p>
                            <p class="fw-medium" style="color:var(--gray-500);font-size:0.75rem;">เอกสาร</p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="stat-card text-center d-block" id="stat-registered-wrap" style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);border-radius:1rem;padding:1.5rem 1rem;">
                            <i class="fa-regular fa-user d-block mb-2" style="color:#818cf8;font-size:1.125rem;"></i>
                            <p class="text-white mb-1" style="font-size:1.5rem;font-weight:900;line-height:1;" id="stat-registered">0</p>
                            <p class="fw-medium" style="color:var(--gray-500);font-size:0.75rem;">ผู้เข้าร่วม</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="about" class="py-section" style="background:#fff;border-bottom:1px solid var(--gray-100);">
            <div class="mx-auto" style="max-width:1200px;padding-left:1.5rem;padding-right:1.5rem;">
                <div class="text-center mx-auto mb-5" style="max-width:512px;">
                    <span
                        class="d-inline-flex align-items-center gap-1 rounded-pill fw-bold" style="padding:0.25rem 0.875rem;font-size:0.75rem;background:var(--gray-50, #f9fafb);color:#4f46e5;margin-bottom:1rem;border:1px solid #e0e7ff;">ฟีเจอร์</span>
                    <h2 class="section-title mb-3" style="color:var(--gray-900);">ครบทุกความต้องการ</h2>
                    <p class="fw-medium" style="color:var(--gray-500);font-size:0.875rem;line-height:1.625;">ระบบออกแบบมาเพื่อมหาวิทยาลัยโดยเฉพาะ</p>
                </div>
                <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-5">
                    <div class="col">
                        <div class="feature-card" style="background:#fff;border:1px solid var(--gray-100, #f3f4f6);border-radius:1rem;padding:1.5rem;">
                            <div
                                class="d-flex align-items-center justify-content-center mb-4" style="width:2.75rem;height:2.75rem;background:var(--gray-50, #f9fafb);color:#6366F1;border-radius:0.75rem;font-size:1.125rem;">
                                <i class="fa-solid fa-calendar-days"></i> </div>
                            <h3 class="fw-bold mb-1" style="font-size:0.875rem;color:var(--gray-800);">จัดการกิจกรรม</h3>
                            <p class="fw-medium" style="font-size:0.75rem;color:var(--gray-500);line-height:1.625;">สร้าง แก้ไข และติดตามกิจกรรมต่างๆ ได้อย่างมีระบบ</p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="feature-card feature-card-red" style="background:#fff;border:1px solid var(--gray-100, #f3f4f6);border-radius:1rem;padding:1.5rem;">
                            <div
                                class="d-flex align-items-center justify-content-center mb-4" style="width:2.75rem;height:2.75rem;background:#fef2f2;color:#ef4444;border-radius:0.75rem;font-size:1.125rem;">
                                <i class="fa-solid fa-file-pdf"></i> </div>
                            <h3 class="fw-bold mb-1" style="font-size:0.875rem;color:var(--gray-800);">จัดการเอกสาร PDF</h3>
                            <p class="fw-medium" style="font-size:0.75rem;color:var(--gray-500);line-height:1.625;">อัปโหลดและแชร์เอกสาร PDF ประกอบกิจกรรมได้ทันที</p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="feature-card feature-card-emerald" style="background:#fff;border:1px solid var(--gray-100, #f3f4f6);border-radius:1rem;padding:1.5rem;">
                            <div
                                class="d-flex align-items-center justify-content-center mb-4" style="width:2.75rem;height:2.75rem;background:#ecfdf5;color:#10b981;border-radius:0.75rem;font-size:1.125rem;">
                                <i class="fa-solid fa-users"></i> </div>
                            <h3 class="fw-bold mb-1" style="font-size:0.875rem;color:var(--gray-800);">รองรับผู้เข้าร่วม</h3>
                            <p class="fw-medium" style="font-size:0.75rem;color:var(--gray-500);line-height:1.625;">บริหารจัดการรายชื่อผู้เข้าร่วมกิจกรรมได้ง่าย</p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="feature-card feature-card-amber" style="background:#fff;border:1px solid var(--gray-100, #f3f4f6);border-radius:1rem;padding:1.5rem;">
                            <div
                                class="d-flex align-items-center justify-content-center mb-4" style="width:2.75rem;height:2.75rem;background:#fffbeb;color:#f59e0b;border-radius:0.75rem;font-size:1.125rem;">
                                <i class="fa-solid fa-chart-bar"></i> </div>
                            <h3 class="fw-bold mb-1" style="font-size:0.875rem;color:var(--gray-800);">สถิติและรายงาน</h3>
                            <p class="fw-medium" style="font-size:0.75rem;color:var(--gray-500);line-height:1.625;">ดูภาพรวมและสร้างรายงานได้อย่างรวดเร็ว</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-section" style="background:var(--gray-50);">
            <div class="mx-auto" style="max-width:1200px;padding-left:1.5rem;padding-right:1.5rem;">
                <div class="text-center mx-auto mb-5" style="max-width:512px;">
                    <span
                        class="d-inline-flex align-items-center gap-1 rounded-pill fw-bold" style="padding:0.25rem 0.875rem;font-size:0.75rem;background:var(--gray-50, #f9fafb);color:#4f46e5;margin-bottom:1rem;border:1px solid #e0e7ff;">ไฮไลท์</span>
                    <h2 class="section-title mb-3" style="color:var(--gray-900);">ทำไมต้องเลือกระบบของเรา?</h2>
                    <p class="fw-medium" style="color:var(--gray-500);font-size:0.875rem;line-height:1.625;">ประสบการณ์การใช้งานที่ได้รับการพัฒนาอย่างต่อเนื่อง</p>
                </div>
                <div class="row row-cols-1 row-cols-sm-3 g-5">
                    <div class="col">
                        <div class="why-card text-center" style="background:#fff;border:1px solid var(--gray-100, #f3f4f6);border-radius:1rem;padding:2rem;">
                            <div
                                class="d-flex align-items-center justify-content-center mx-auto mb-5 rounded-circle" style="width:3.5rem;height:3.5rem;background:var(--gray-50, #f9fafb);color:#6366F1;font-size:1.25rem;">
                                <i class="fa-solid fa-shield-halved"></i> </div>
                            <h3 class="fw-bold mb-2" style="font-size:1rem;color:var(--gray-800);">ความปลอดภัยสูง</h3>
                            <p class="fw-medium" style="font-size:0.875rem;color:var(--gray-500);line-height:1.625;">ข้อมูลของคุณได้รับการปกป้องด้วยมาตรฐานการรักษาความปลอดภัยระดับสากล</p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="why-card text-center" style="background:#fff;border:1px solid var(--gray-100, #f3f4f6);border-radius:1rem;padding:2rem;">
                            <div
                                class="d-flex align-items-center justify-content-center mx-auto mb-5 rounded-circle" style="width:3.5rem;height:3.5rem;background:var(--gray-50, #f9fafb);color:#6366F1;font-size:1.25rem;">
                                <i class="fa-solid fa-moon"></i> </div>
                            <h3 class="fw-bold mb-2" style="font-size:1rem;color:var(--gray-800);">ใช้งานง่าย</h3>
                            <p class="fw-medium" style="font-size:0.875rem;color:var(--gray-500);line-height:1.625;">อินเตอร์เฟซที่เป็นมิตรกับผู้ใช้ ช่วยให้คุณเริ่มต้นได้ภายในไม่กี่นาที</p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="why-card text-center" style="background:#fff;border:1px solid var(--gray-100, #f3f4f6);border-radius:1rem;padding:2rem;">
                            <div
                                class="d-flex align-items-center justify-content-center mx-auto mb-5 rounded-circle" style="width:3.5rem;height:3.5rem;background:var(--gray-50, #f9fafb);color:#6366F1;font-size:1.25rem;">
                                <i class="fa-solid fa-globe"></i> </div>
                            <h3 class="fw-bold mb-2" style="font-size:1rem;color:var(--gray-800);">รองรับทุกแพลตฟอร์ม</h3>
                            <p class="fw-medium" style="font-size:0.875rem;color:var(--gray-500);line-height:1.625;">ใช้งานได้ทั้งบนคอมพิวเตอร์ แท็บเล็ต และสมาร์ทโฟน</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="activities" class="py-section" style="background:#fff;">
            <div class="mx-auto" style="max-width:1200px;padding-left:1.5rem;padding-right:1.5rem;">
                <div class="text-center mx-auto mb-5" style="max-width:512px;">
                    <span
                        class="d-inline-flex align-items-center gap-1 rounded-pill fw-bold" style="padding:0.25rem 0.875rem;font-size:0.75rem;background:var(--gray-50, #f9fafb);color:#4f46e5;margin-bottom:1rem;border:1px solid #e0e7ff;">กิจกรรม</span>
                    <h2 class="section-title mb-3" style="color:var(--gray-900);">กิจกรรมล่าสุด</h2>
                    <p class="fw-medium" style="color:var(--gray-500);font-size:0.875rem;line-height:1.625;">ดูข้อมูลกิจกรรมที่กำลังจะเกิดขึ้นและกิจกรรมยอดนิยม</p>
                </div>
                <div id="activities-grid" class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-5">
                    <div class="col">
                        <div class="text-center" style="padding-top:4rem;padding-bottom:4rem;">
                            <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-4" style="width:4rem;height:4rem;background:var(--gray-50, #f9fafb);">
                                <i class="fa-solid fa-circle-notch fa-spin" style="font-size:1.25rem;color:#818cf8;"></i>
                            </div>
                            <p class="fw-medium" style="color:var(--gray-500);">กำลังโหลดกิจกรรม...</p>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-5">
                    <a href="/activities"
                        class="d-inline-flex align-items-center gap-2 text-decoration-none btn-gradient" style="padding:0.75rem 1.5rem;font-size:0.875rem;font-weight:700;color:#fff;border-radius:0.75rem;box-shadow:0 4px 6px -1px rgba(99,102,241,0.2);">
                        <i class="fa-solid fa-calendar-check"></i>
                        ดูทั้งหมด
                    </a>
                </div>
            </div>
        </section>

        <footer class="text-nowrap" style="background:#030712;color:var(--gray-400);padding:3rem 1.5rem;">
            <div class="mx-auto" style="max-width:1200px;">
                <div class="d-flex flex-wrap justify-content-between" style="gap:2rem;padding-bottom:2rem;border-bottom:1px solid rgba(255,255,255,0.1);margin-bottom:1.5rem;">
                    <div>
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div
                                class="d-flex align-items-center justify-content-center" style="width:2.5rem;height:2.5rem;border-radius:0.75rem;background:linear-gradient(135deg, #6366F1, #a855f7);color:#fff;box-shadow:0 10px 15px -3px rgba(99,102,241,0.3);">
                                <i class="fa-solid fa-graduation-cap"></i> </div>
                            <div class="text-white fw-bolder" style="font-size:1.125rem;">{{ $siteName }}</div>
                        </div>
                        <p class="fw-medium" style="font-size:0.875rem;color:var(--gray-400);max-width:320px;line-height:1.625;margin-bottom:1rem;">{{ $siteDesc }}</p>
                        @if ($fbUrl || $lineUrl || $ytUrl)
                            <div class="d-flex gap-2">
                                @if ($fbUrl)
                                    <a href="{{ $fbUrl }}" class="social-link" target="_blank"><i
                                            class="fa-brands fa-facebook text-sm"></i></a>
                                @endif
                                @if ($lineUrl)
                                    <a href="{{ $lineUrl }}" class="social-link" target="_blank"><i
                                            class="fa-brands fa-line text-sm"></i></a>
                                @endif
                                @if ($ytUrl)
                                    <a href="{{ $ytUrl }}" class="social-link" target="_blank"><i
                                            class="fa-brands fa-youtube text-sm"></i></a>
                                @endif
                            </div>
                        @endif
                    </div>
                    <nav class="d-flex flex-column gap-3" style="font-size:0.875rem;">
                        <p class="text-white fw-semibold mb-1">เมนู</p>
                        <a href="/activities" class="nav-link-footer" style="color:var(--gray-400);"><i
                                class="fa-regular fa-calendar me-2"></i>กิจกรรมทั้งหมด</a>
                        <a href="#about" class="nav-link-footer" style="color:var(--gray-400);"><i
                                class="fa-regular fa-circle-info me-2"></i>เกี่ยวกับระบบ</a>
                        <a href="/login" class="nav-link-footer" style="color:var(--gray-400);"><i
                                class="fa-solid fa-user-gear me-2"></i>สำหรับผู้ดูแล</a>
                    </nav>
                </div>
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-4">
                    <p style="font-size:0.75rem;color:var(--gray-500);">{{ $footerText }}</p>
                    <p style="font-size:0.75rem;color:var(--gray-600);">พัฒนาด้วย <i class="fa-solid fa-heart mx-1" style="color:#ef4444;"></i>
                        สำหรับมหาวิทยาลัย</p>
                </div>
            </div>
        </footer>
    </div>
@endsection

@section('script')
    <script>
        const API_BASE = '/api/public';

        $(function() {
            $.getJSON(API_BASE + '/home', function(json) {
                if (json.data) {
                    $('#stat-activities').text(json.data.stats?.total_activities ?? 0);
                    $('#stat-categories').text(json.data.stats?.total_categories ?? 0);
                    $('#stat-documents').text(json.data.stats?.total_documents ?? 0);
                    $('#stat-registered').text(json.data.stats?.total_participants ?? 0);
                }
            });

            $.getJSON(API_BASE + '/activities', {
                per_page: 6
            }, function(json) {
                var $grid = $('#activities-grid');
                if (json.data && $grid.length) {
                    $grid.html($.map(json.data, function(a) {
                        var img = a.cover_image_url ?
                            '<img src="' + a.cover_image_url + '" alt="' + a.title +
                            '" class="w-100 h-100 object-cover">' :
                            '<div class="w-100 h-100 d-flex align-items-center justify-content-center" style="font-size:1.875rem;color:var(--gray-300);"><i class="fa-regular fa-image"></i></div>';
                        var cat = a.category ?
                            '<span class="position-absolute fw-bold rounded-pill backdrop-blur" style="top:10px;left:10px;background:rgba(17,24,39,0.6);color:#fff;font-size:10px;padding:0.125rem 0.5rem;">' +
                            a.category.name + '</span>' :
                            '';
                        var date = a.activity_date || '';
                        return '<div class="col"><div class="activity-card" style="background:#fff;border:1px solid var(--gray-100, #f3f4f6);border-radius:1rem;overflow:hidden;">' +
                            '<div class="position-relative overflow-hidden" style="height:10rem;background:var(--gray-100);">' + cat +
                            img + '</div>' +
                            '<div style="padding:1rem;">' +
                            '<div class="d-flex align-items-center gap-2 mb-2" style="font-size:0.75rem;color:var(--gray-400);"><i class="fa-regular fa-calendar"></i>' +
                            date + '</div>' +
                            '<h3 class="fw-bold mb-2" style="font-size:0.875rem;color:var(--gray-800);line-height:1.4;">' + a
                            .title + '</h3>' +
                            '<p class="fw-medium line-clamp-2" style="font-size:0.75rem;color:var(--gray-500);line-height:1.625;">' + (
                                a.description || '') + '</p>' +
                            '</div>' +
                            '</div></div>';
                    }).join(''));
                }
            });

        });
    </script>
@endsection
