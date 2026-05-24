@extends('layouts.master')

@section('title', 'University Activities - ระบบจัดการกิจกรรมมหาวิทยาลัย')

@section('style')
    <style>
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-up-1 { animation: fadeUp .6s ease-out .1s backwards; }
        .fade-up-2 { animation: fadeUp .6s ease-out .2s backwards; }
        .fade-up-3 { animation: fadeUp .6s ease-out .3s backwards; }
        .fade-up-4 { animation: fadeUp .6s ease-out .4s backwards; }
        .fade-up-5 { animation: fadeUp .6s ease-out .5s backwards; }
        .hero-gradient { background: radial-gradient(circle, rgba(99, 102, 241, 0.08) 0%, transparent 70%); }
        .hero-gradient-2 { background: radial-gradient(circle, rgba(139, 92, 246, 0.08) 0%, transparent 70%); }
        .quick-card { transition: all .2s ease; }
        .quick-card:hover { transform: translateY(-4px); }
        .quick-icon { transition: transform .2s ease; }
        .quick-card:hover .quick-icon { transform: scale(1.1); }
        .hover-lift { transition: all .2s ease; }
        .hover-lift:hover { transform: translateY(-1px); }
    </style>
@endsection

@section('content')
    <div id="public-view">
        <!-- Hero Section -->
        <section
            class="position-relative d-flex align-items-center justify-content-center overflow-hidden"
            style="min-height:75vh;padding-top:4rem;background:linear-gradient(135deg,#f8fafc,#ffffff,#eef2ff)">
            <!-- Decorative elements -->
            <div class="position-absolute top-0 start-0 w-100 h-100" style="pointer-events:none">
                <div class="position-absolute rounded-pill hero-gradient" style="width:600px;height:600px;top:-10rem;left:-10rem;opacity:.6"></div>
                <div class="position-absolute rounded-pill hero-gradient-2" style="width:500px;height:500px;bottom:-10rem;right:-10rem;opacity:.5"></div>
            </div>

            <div class="position-relative mx-auto px-4 text-center" style="max-width:896px;z-index:10;padding-top:4rem;padding-bottom:4rem">
                <!-- Welcome badge -->
                <div
                    class="d-inline-flex align-items-center gap-2 px-4 py-2 small fw-medium rounded-pill text-decoration-none mb-5 fade-up-1"
                    style="background-color:var(--primary-light);border:1px solid rgba(99,102,241,.2);color:var(--primary-dark)">
                    <i class="fa-solid fa-graduation-cap"></i>
                    <span>ยินดีต้อนรับสู่ระบบจัดการกิจกรรม</span>
                </div>

                <!-- Headline -->
                <h1 class="fw-bolder mb-5 fade-up-2" style="color:var(--gray-900);line-height:1.2;font-size:clamp(1.875rem,5vw,2.25rem)">
                    กิจกรรมมหาวิทยาลัย<br>
                    <em class="fst-normal" style="color:var(--primary-dark)">ทุกที่ ทุกเวลา</em>
                </h1>

                <!-- Subtitle -->
                <p class="text-secondary mx-auto mb-5 fade-up-3" style="max-width:576px;font-size:1.125rem;line-height:1.6">
                    ค้นหาและติดตามกิจกรรมต่างๆ ของมหาวิทยาลัยได้อย่างง่ายดาย
                    รวมถึงตรวจสอบการเข้าร่วมและดาวน์โหลดเอกสารที่เกี่ยวข้อง
                </p>

                <!-- Action buttons -->
                <div class="d-flex flex-wrap justify-content-center gap-3 mb-5 fade-up-4">
                    <a href="/activities"
                        class="d-inline-flex align-items-center gap-2 px-5 py-3 small fw-semibold text-white btn btn-primary rounded-pill text-decoration-none hover-lift">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        ค้นหากิจกรรม
                    </a>
                    <a href="/login"
                        class="d-inline-flex align-items-center gap-2 px-5 py-3 small fw-semibold text-decoration-none btn btn-outline-primary rounded-pill">
                        <i class="fa-solid fa-user-tie"></i>
                        สำหรับผู้ดูแล
                    </a>
                </div>

                <!-- Quick links cards -->
                <div class="row row-cols-1 row-cols-sm-3 g-4 justify-content-center fade-up-5" style="max-width:672px;margin-left:auto;margin-right:auto">
                    <div class="col">
                        <a href="/activities"
                            class="d-block text-center text-decoration-none p-4 border bg-white h-100 rounded-3 quick-card"
                            style="border-color:var(--gray-100)">
                            <div
                                class="d-flex align-items-center justify-content-center mx-auto mb-3 quick-icon"
                                style="width:48px;height:48px;background-color:var(--primary-light);border-radius:12px;font-size:1.25rem;color:var(--primary)">
                                <i class="fa-regular fa-calendar"></i>
                            </div>
                            <h3 class="small fw-bold mb-1" style="color:var(--gray-800)">ดูกิจกรรม</h3>
                            <p class="text-secondary" style="font-size:.75rem">กิจกรรมทั้งหมดของมหาวิทยาลัย</p>
                        </a>
                    </div>
                    <div class="col">
                        <a href="/activities"
                            class="d-block text-center text-decoration-none p-4 border bg-white h-100 rounded-3 quick-card"
                            style="border-color:var(--gray-100)">
                            <div
                                class="d-flex align-items-center justify-content-center mx-auto mb-3 quick-icon"
                                style="width:48px;height:48px;background-color:#ecfdf5;border-radius:12px;font-size:1.25rem;color:#10b981">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </div>
                            <h3 class="small fw-bold mb-1" style="color:var(--gray-800)">ตรวจสอบการเข้าร่วม</h3>
                            <p class="text-secondary" style="font-size:.75rem">ค้นหาชื่อในรายผู้เข้าร่วม</p>
                        </a>
                    </div>
                    <div class="col">
                        <a href="/login"
                            class="d-block text-center text-decoration-none p-4 border bg-white h-100 rounded-3 quick-card"
                            style="border-color:var(--gray-100)">
                            <div
                                class="d-flex align-items-center justify-content-center mx-auto mb-3 quick-icon"
                                style="width:48px;height:48px;background-color:#fffbeb;border-radius:12px;font-size:1.25rem;color:#f59e0b">
                                <i class="fa-solid fa-user-tie"></i>
                            </div>
                            <h3 class="small fw-bold mb-1" style="color:var(--gray-800)">ผู้ดูแลระบบ</h3>
                            <p class="text-secondary" style="font-size:.75rem">เข้าสู่ระบบจัดการกิจกรรม</p>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="bg-white border-top" style="border-color:var(--gray-100);padding-top:4rem;padding-bottom:4rem">
            <div class="mx-auto px-4" style="max-width:896px">
                <div class="text-center mb-5">
                    <h2 class="fw-bold mb-2" style="color:var(--gray-900);font-size:clamp(1.25rem,3vw,1.5rem)">ระบบของเรา</h2>
                    <p class="text-secondary small">สิ่งที่คุณสามารถทำได้</p>
                </div>
                <div class="row row-cols-1 row-cols-sm-3 g-4">
                    <div class="col text-center">
                        <div
                            class="d-flex align-items-center justify-content-center mx-auto mb-4 rounded-3"
                            style="width:56px;height:56px;background-color:var(--primary-light);font-size:1.5rem;color:var(--primary)">
                            <i class="fa-solid fa-calendar-check"></i>
                        </div>
                        <h3 class="small fw-bold mb-1" style="color:var(--gray-800)">จัดการกิจกรรม</h3>
                        <p class="text-secondary" style="font-size:.75rem">สร้างและติดตามกิจกรรมต่างๆ</p>
                    </div>
                    <div class="col text-center">
                        <div
                            class="d-flex align-items-center justify-content-center mx-auto mb-4 rounded-3"
                            style="width:56px;height:56px;background-color:#fef2f2;font-size:1.5rem;color:#ef4444">
                            <i class="fa-solid fa-file-pdf"></i>
                        </div>
                        <h3 class="small fw-bold mb-1" style="color:var(--gray-800)">เอกสาร PDF</h3>
                        <p class="text-secondary" style="font-size:.75rem">อัปโหลดและแชร์เอกสาร</p>
                    </div>
                    <div class="col text-center">
                        <div
                            class="d-flex align-items-center justify-content-center mx-auto mb-4 rounded-3"
                            style="width:56px;height:56px;background-color:#ecfdf5;font-size:1.5rem;color:#10b981">
                            <i class="fa-solid fa-users"></i>
                        </div>
                        <h3 class="small fw-bold mb-1" style="color:var(--gray-800)">ผู้เข้าร่วม</h3>
                        <p class="text-secondary" style="font-size:.75rem">บริหารจัดการรายชื่อผู้เข้าร่วม</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-light border-top px-4" style="border-color:var(--gray-100);padding-top:2rem;padding-bottom:2rem">
            <div class="mx-auto text-center" style="max-width:896px">
                <div class="d-flex align-items-center justify-content-center gap-2 mb-3">
                    <div
                        class="d-flex align-items-center justify-content-center text-white small fw-bold rounded-2"
                        style="width:32px;height:32px;background:linear-gradient(135deg,var(--primary),var(--accent,#8B5CF6))">
                        U
                    </div>
                    <span class="small fw-semibold" style="color:var(--gray-900)">University Activities</span>
                </div>
                <p class="text-secondary" style="font-size:.75rem">ระบบจัดการกิจกรรมและเอกสารสำหรับมหาวิทยาลัย</p>
            </div>
        </footer>
    </div>
@endsection
