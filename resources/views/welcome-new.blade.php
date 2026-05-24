@extends('layouts.master')

@section('title', setting('site_name', 'University Activities') . ' - ระบบจัดการกิจกรรมมหาวิทยาลัย')

@section('content')
    <div id="public-view">
        <section class="position-relative d-flex align-items-center justify-content-center overflow-hidden" style="min-height:75vh;padding-top:4rem;background:linear-gradient(135deg,#f8fafc,#ffffff,#eef2ff)">
            <div class="position-relative mx-auto px-4 text-center" style="max-width:896px;z-index:10;padding-top:4rem;padding-bottom:4rem">
                <div class="d-inline-flex align-items-center gap-2 px-4 py-2 small fw-medium rounded-pill text-decoration-none mb-5 fade-up-1" style="background:#eef2ff;border:1px solid rgba(99,102,241,.2);color:#4f46e5">
                    <i class="bx bx-graduation"></i>
                    <span>ยินดีต้อนรับสู่ระบบจัดการกิจกรรม</span>
                </div>

                <h1 class="fw-bolder mb-5 fade-up-2" style="color:#111827;line-height:1.2;font-size:clamp(1.875rem,5vw,2.25rem)">
                    กิจกรรมมหาวิทยาลัย<br>
                    <em class="fst-normal text-primary">ทุกที่ ทุกเวลา</em>
                </h1>

                <p class="text-muted mx-auto mb-5 fade-up-3" style="max-width:576px;font-size:1.125rem;line-height:1.6">
                    ค้นหาและติดตามกิจกรรมต่างๆ ของมหาวิทยาลัยได้อย่างง่ายดาย
                    รวมถึงตรวจสอบการเข้าร่วมและดาวน์โหลดเอกสารที่เกี่ยวข้อง
                </p>

                <div class="d-flex flex-wrap justify-content-center gap-3 mb-5 fade-up-4">
                    <a href="/activities" class="btn btn-primary btn-lg rounded-pill d-inline-flex align-items-center gap-2 px-5 py-3 fw-semibold">
                        <i class="bx bx-search"></i> ค้นหากิจกรรม
                    </a>
                    <a href="/login" class="btn btn-outline-primary btn-lg rounded-pill d-inline-flex align-items-center gap-2 px-5 py-3 fw-semibold">
                        <i class="bx bx-user-tie"></i> สำหรับผู้ดูแล
                    </a>
                </div>

                <div class="row row-cols-1 row-cols-sm-3 g-4 justify-content-center fade-up-5" style="max-width:672px;margin-left:auto;margin-right:auto">
                    <div class="col">
                        <a href="/activities" class="d-block text-center text-decoration-none p-4 border bg-white h-100 rounded-3 act-card">
                            <div class="d-flex align-items-center justify-content-center mx-auto mb-3" style="width:48px;height:48px;background:#eef2ff;border-radius:12px;font-size:1.25rem;color:#696cff">
                                <i class="bx bx-calendar"></i>
                            </div>
                            <h3 class="small fw-bold mb-1" style="color:#1f2937">ดูกิจกรรม</h3>
                            <p class="text-muted" style="font-size:.75rem">กิจกรรมทั้งหมดของมหาวิทยาลัย</p>
                        </a>
                    </div>
                    <div class="col">
                        <a href="/activities" class="d-block text-center text-decoration-none p-4 border bg-white h-100 rounded-3 act-card">
                            <div class="d-flex align-items-center justify-content-center mx-auto mb-3" style="width:48px;height:48px;background:#ecfdf5;border-radius:12px;font-size:1.25rem;color:#10b981">
                                <i class="bx bx-search"></i>
                            </div>
                            <h3 class="small fw-bold mb-1" style="color:#1f2937">ตรวจสอบการเข้าร่วม</h3>
                            <p class="text-muted" style="font-size:.75rem">ค้นหาชื่อในรายผู้เข้าร่วม</p>
                        </a>
                    </div>
                    <div class="col">
                        <a href="/login" class="d-block text-center text-decoration-none p-4 border bg-white h-100 rounded-3 act-card">
                            <div class="d-flex align-items-center justify-content-center mx-auto mb-3" style="width:48px;height:48px;background:#fffbeb;border-radius:12px;font-size:1.25rem;color:#f59e0b">
                                <i class="bx bx-user-tie"></i>
                            </div>
                            <h3 class="small fw-bold mb-1" style="color:#1f2937">ผู้ดูแลระบบ</h3>
                            <p class="text-muted" style="font-size:.75rem">เข้าสู่ระบบจัดการกิจกรรม</p>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-white border-top py-5">
            <div class="mx-auto px-4" style="max-width:896px">
                <div class="text-center mb-5">
                    <h2 class="fw-bold mb-2" style="color:#111827;font-size:clamp(1.25rem,3vw,1.5rem)">ระบบของเรา</h2>
                    <p class="text-muted small">สิ่งที่คุณสามารถทำได้</p>
                </div>
                <div class="row row-cols-1 row-cols-sm-3 g-4">
                    <div class="col text-center">
                        <div class="d-flex align-items-center justify-content-center mx-auto mb-4 rounded-3" style="width:56px;height:56px;background:#eef2ff;font-size:1.5rem;color:#696cff">
                            <i class="bx bx-calendar-check"></i>
                        </div>
                        <h3 class="small fw-bold mb-1" style="color:#1f2937">จัดการกิจกรรม</h3>
                        <p class="text-muted" style="font-size:.75rem">สร้างและติดตามกิจกรรมต่างๆ</p>
                    </div>
                    <div class="col text-center">
                        <div class="d-flex align-items-center justify-content-center mx-auto mb-4 rounded-3" style="width:56px;height:56px;background:#fef2f2;font-size:1.5rem;color:#ef4444">
                            <i class="bx bxs-file-pdf"></i>
                        </div>
                        <h3 class="small fw-bold mb-1" style="color:#1f2937">เอกสาร PDF</h3>
                        <p class="text-muted" style="font-size:.75rem">อัปโหลดและแชร์เอกสาร</p>
                    </div>
                    <div class="col text-center">
                        <div class="d-flex align-items-center justify-content-center mx-auto mb-4 rounded-3" style="width:56px;height:56px;background:#ecfdf5;font-size:1.5rem;color:#10b981">
                            <i class="bx bx-user"></i>
                        </div>
                        <h3 class="small fw-bold mb-1" style="color:#1f2937">ผู้เข้าร่วม</h3>
                        <p class="text-muted" style="font-size:.75rem">บริหารจัดการรายชื่อผู้เข้าร่วม</p>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
