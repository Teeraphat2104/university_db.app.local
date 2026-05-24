@extends('layouts.master')

@section('title', 'University Activities - ระบบจัดการกิจกรรมมหาวิทยาลัย')

@section('style')
    <style>
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(20px);
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
            background: radial-gradient(circle, rgba(99, 102, 241, 0.08) 0%, transparent 70%);
        }

        .hero-gradient-2 {
            background: radial-gradient(circle, rgba(139, 92, 246, 0.08) 0%, transparent 70%);
        }

    </style>
@endsection

@section('content')
    <div id="public-view">
        <!-- Hero Section -->
        <section
            class="relative min-h-[75vh] flex items-center justify-center overflow-hidden bg-gradient-to-br from-slate-50 via-white to-indigo-50 pt-16">
            <!-- Decorative elements -->
            <div class="absolute inset-0 pointer-events-none">
                <div class="absolute w-[600px] h-[600px] -top-40 -left-40 rounded-full opacity-60 hero-gradient"></div>
                <div class="absolute w-[500px] h-[500px] -bottom-40 -right-40 rounded-full opacity-50 hero-gradient-2"></div>
            </div>

            <div class="relative z-10 max-w-4xl mx-auto px-6 py-16 text-center">
                <!-- Welcome badge -->
                <div
                    class="inline-flex items-center gap-2 bg-indigo-50 border border-indigo-100 rounded-full px-4 py-2 text-indigo-600 text-sm font-medium mb-8 fade-up-1">
                    <i class="fa-solid fa-graduation-cap"></i>
                    <span>ยินดีต้อนรับสู่ระบบจัดการกิจกรรม</span>
                </div>

                <!-- Headline -->
                <h1 class="text-gray-900 font-black leading-tight mb-6 fade-up-2 text-3xl sm:text-4xl">
                    กิจกรรมมหาวิทยาลัย<br>
                    <em class="not-italic text-indigo-600">ทุกที่ ทุกเวลา</em>
                </h1>

                <!-- Subtitle -->
                <p class="text-gray-500 text-lg max-w-xl mx-auto leading-relaxed mb-10 fade-up-3">
                    ค้นหาและติดตามกิจกรรมต่างๆ ของมหาวิทยาลัยได้อย่างง่ายดาย
                    รวมถึงตรวจสอบการเข้าร่วมและดาวน์โหลดเอกสารที่เกี่ยวข้อง
                </p>

                <!-- Action buttons -->
                <div class="flex flex-wrap justify-center gap-4 mb-12 fade-up-4">
                    <a href="/activities"
                        class="inline-flex items-center gap-2 px-6 py-3 text-sm font-semibold text-white bg-indigo-600 rounded-full shadow-lg shadow-indigo-200 hover:shadow-xl hover:shadow-indigo-300 hover:-translate-y-0.5 transition-all no-underline">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        ค้นหากิจกรรม
                    </a>
                    <a href="/login"
                        class="inline-flex items-center gap-2 px-6 py-3 text-sm font-semibold text-indigo-600 bg-white border-2 border-indigo-100 rounded-full hover:border-indigo-200 hover:bg-indigo-50 transition-all no-underline">
                        <i class="fa-solid fa-user-tie"></i>
                        สำหรับผู้ดูแล
                    </a>
                </div>

                <!-- Quick links cards -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 max-w-2xl mx-auto fade-up-5">
                    <a href="/activities"
                        class="group bg-white border border-gray-100 rounded-2xl p-5 text-center hover:border-indigo-200 hover:shadow-lg hover:-translate-y-1 transition-all no-underline">
                        <div
                            class="w-12 h-12 bg-indigo-50 text-indigo-500 rounded-xl flex items-center justify-center text-xl mb-3 group-hover:scale-110 transition-transform">
                            <i class="fa-regular fa-calendar"></i>
                        </div>
                        <h3 class="text-sm font-bold text-gray-800 mb-1">ดูกิจกรรม</h3>
                        <p class="text-xs text-gray-400">กิจกรรมทั้งหมดของมหาวิทยาลัย</p>
                    </a>
                    <a href="/activities"
                        class="group bg-white border border-gray-100 rounded-2xl p-5 text-center hover:border-emerald-200 hover:shadow-lg hover:-translate-y-1 transition-all no-underline">
                        <div
                            class="w-12 h-12 bg-emerald-50 text-emerald-500 rounded-xl flex items-center justify-center text-xl mb-3 group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </div>
                        <h3 class="text-sm font-bold text-gray-800 mb-1">ตรวจสอบการเข้าร่วม</h3>
                        <p class="text-xs text-gray-400">ค้นหาชื่อในรายผู้เข้าร่วม</p>
                    </a>
                    <a href="/login"
                        class="group bg-white border border-gray-100 rounded-2xl p-5 text-center hover:border-amber-200 hover:shadow-lg hover:-translate-y-1 transition-all no-underline">
                        <div
                            class="w-12 h-12 bg-amber-50 text-amber-500 rounded-xl flex items-center justify-center text-xl mb-3 group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-user-tie"></i>
                        </div>
                        <h3 class="text-sm font-bold text-gray-800 mb-1">ผู้ดูแลระบบ</h3>
                        <p class="text-xs text-gray-400">เข้าสู่ระบบจัดการกิจกรรม</p>
                    </a>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="py-16 bg-white border-t border-gray-100">
            <div class="max-w-4xl mx-auto px-6">
                <div class="text-center mb-10">
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-2">ระบบของเรา</h2>
                    <p class="text-gray-500 text-sm">สิ่งที่คุณสามารถทำได้</p>
                </div>
                <div class="grid sm:grid-cols-3 gap-6">
                    <div class="text-center">
                        <div
                            class="w-14 h-14 bg-indigo-50 text-indigo-500 rounded-2xl flex items-center justify-center text-2xl mx-auto mb-4">
                            <i class="fa-solid fa-calendar-check"></i>
                        </div>
                        <h3 class="text-sm font-bold text-gray-800 mb-1">จัดการกิจกรรม</h3>
                        <p class="text-xs text-gray-500">สร้างและติดตามกิจกรรมต่างๆ</p>
                    </div>
                    <div class="text-center">
                        <div
                            class="w-14 h-14 bg-red-50 text-red-500 rounded-2xl flex items-center justify-center text-2xl mx-auto mb-4">
                            <i class="fa-solid fa-file-pdf"></i>
                        </div>
                        <h3 class="text-sm font-bold text-gray-800 mb-1">เอกสาร PDF</h3>
                        <p class="text-xs text-gray-500">อัปโหลดและแชร์เอกสาร</p>
                    </div>
                    <div class="text-center">
                        <div
                            class="w-14 h-14 bg-emerald-50 text-emerald-500 rounded-2xl flex items-center justify-center text-2xl mx-auto mb-4">
                            <i class="fa-solid fa-users"></i>
                        </div>
                        <h3 class="text-sm font-bold text-gray-800 mb-1">ผู้เข้าร่วม</h3>
                        <p class="text-xs text-gray-500">บริหารจัดการรายชื่อผู้เข้าร่วม</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-gray-50 border-t border-gray-100 py-8 px-6">
            <div class="max-w-4xl mx-auto text-center">
                <div class="flex items-center justify-center gap-2 mb-3">
                    <div
                        class="w-8 h-8 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-lg flex items-center justify-center text-white text-sm font-bold">
                        U
                    </div>
                    <span class="text-gray-900 text-sm font-semibold">University Activities</span>
                </div>
                <p class="text-gray-400 text-xs">ระบบจัดการกิจกรรมและเอกสารสำหรับมหาวิทยาลัย</p>
            </div>
        </footer>
    </div>
@endsection
