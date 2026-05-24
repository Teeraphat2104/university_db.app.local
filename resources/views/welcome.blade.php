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
            class="relative min-h-[600px] flex items-center overflow-hidden bg-gradient-to-br from-gray-950 via-indigo-950 to-gray-950 pt-16">
            <div class="absolute inset-0 pointer-events-none">
                <div class="absolute w-[500px] h-[500px] -top-20 -left-20 rounded-full hero-gradient"></div>
                <div class="absolute w-[400px] h-[400px] -bottom-20 -right-20 rounded-full hero-gradient-2"></div>
            </div>
            <div class="relative z-10 max-w-6xl mx-auto px-6 py-20 w-full">
                <div
                    class="inline-flex items-center gap-2 bg-indigo-500/10 border border-indigo-500/30 rounded-full px-4 py-1.5 text-indigo-300 text-xs font-semibold mb-6 backdrop-blur fade-up-1">
                    <i class="fa-solid fa-layer-group text-[10px]"></i>
                    {{ $siteDesc }}
                </div>
                <h1 class="text-white font-black leading-tight mb-5 fade-up-2 text-3xl sm:text-4xl lg:text-5xl">
                    {{ $heroTitle }}
                </h1>
                <p class="text-gray-400 text-base sm:text-lg max-w-lg leading-relaxed mb-8 fade-up-3">
                    {{ $heroSub }}
                </p>
                <div class="flex flex-wrap gap-3 mb-12 fade-up-4">
                    <a href="/activities"
                        class="inline-flex items-center gap-2 px-6 py-3 text-sm font-bold text-white bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full shadow-lg shadow-indigo-500/30 hover:shadow-xl hover:shadow-indigo-500/40 hover:-translate-y-0.5 transition-all no-underline">
                        <i class="fa-solid fa-calendar-check"></i>
                        ดูกิจกรรมทั้งหมด
                    </a>
                    <button type="button" id="open-participant-search-hero"
                        class="inline-flex items-center gap-2 px-6 py-3 text-sm font-semibold text-white/80 bg-white/10 border border-white/15 rounded-full hover:bg-white/20 hover:text-white transition-all cursor-pointer no-underline">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        ตรวจสอบการเข้าร่วม
                    </button>
                    <a href="/login"
                        class="inline-flex items-center gap-2 px-6 py-3 text-sm font-semibold text-white/80 bg-white/10 border border-white/15 rounded-full hover:bg-white/20 hover:text-white transition-all no-underline">
                        <i class="fa-solid fa-user-tie"></i>
                        สำหรับผู้ดูแล
                    </a>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 max-w-lg fade-up-5">
                    <div
                        class="bg-white/5 border border-white/10 rounded-2xl p-4 text-center hover:-translate-y-1 hover:shadow-lg transition-all">
                        <i class="fa-regular fa-calendar text-indigo-400 text-lg mb-2 block"></i>
                        <p class="text-white text-2xl font-extrabold font-display leading-none mb-1" id="stat-activities">0
                        </p>
                        <p class="text-gray-500 text-xs font-medium">กิจกรรม</p>
                    </div>
                    <div
                        class="bg-white/5 border border-white/10 rounded-2xl p-4 text-center hover:-translate-y-1 hover:shadow-lg transition-all">
                        <i class="fa-regular fa-rectangle-list text-indigo-400 text-lg mb-2 block"></i>
                        <p class="text-white text-2xl font-extrabold font-display leading-none mb-1" id="stat-categories">0
                        </p>
                        <p class="text-gray-500 text-xs font-medium">หมวดหมู่</p>
                    </div>
                    <div
                        class="bg-white/5 border border-white/10 rounded-2xl p-4 text-center hover:-translate-y-1 hover:shadow-lg transition-all">
                        <i class="fa-regular fa-file-lines text-indigo-400 text-lg mb-2 block"></i>
                        <p class="text-white text-2xl font-extrabold font-display leading-none mb-1" id="stat-documents">0
                        </p>
                        <p class="text-gray-500 text-xs font-medium">เอกสาร</p>
                    </div>
                    <div class="bg-white/5 border border-white/10 rounded-2xl p-4 text-center hover:-translate-y-1 hover:shadow-lg transition-all cursor-pointer"
                        id="stat-registered-wrap">
                        <i class="fa-regular fa-user text-indigo-400 text-lg mb-2 block"></i>
                        <p class="text-white text-2xl font-extrabold font-display leading-none mb-1" id="stat-registered">0
                        </p>
                        <p class="text-gray-500 text-xs font-medium">ผู้เข้าร่วม</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="about" class="py-16 sm:py-20 bg-white border-b border-gray-100">
            <div class="max-w-6xl mx-auto px-6">
                <div class="text-center max-w-lg mx-auto mb-12">
                    <span
                        class="inline-flex items-center gap-1.5 bg-indigo-50 text-indigo-600 text-xs font-bold rounded-full px-3.5 py-1 mb-4 border border-indigo-100">ฟีเจอร์</span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 mb-3">ครบทุกความต้องการ</h2>
                    <p class="text-gray-500 text-sm leading-relaxed">ระบบออกแบบมาเพื่อมหาวิทยาลัยโดยเฉพาะ</p>
                </div>
                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
                    <div
                        class="bg-white border border-gray-100 rounded-2xl p-6 hover:border-indigo-200 hover:shadow-lg hover:shadow-indigo-500/5 hover:-translate-y-1.5 transition-all">
                        <div
                            class="w-11 h-11 bg-indigo-50 text-indigo-500 rounded-xl flex items-center justify-center text-lg mb-4">
                            <i class="fa-solid fa-calendar-days"></i> </div>
                        <h3 class="text-sm font-bold text-gray-800 mb-1.5">จัดการกิจกรรม</h3>
                        <p class="text-xs text-gray-500 leading-relaxed">สร้าง แก้ไข และติดตามกิจกรรมต่างๆ ได้อย่างมีระบบ
                        </p>
                    </div>
                    <div
                        class="bg-white border border-gray-100 rounded-2xl p-6 hover:border-red-200 hover:shadow-lg hover:shadow-red-500/5 hover:-translate-y-1.5 transition-all">
                        <div
                            class="w-11 h-11 bg-red-50 text-red-500 rounded-xl flex items-center justify-center text-lg mb-4">
                            <i class="fa-solid fa-file-pdf"></i> </div>
                        <h3 class="text-sm font-bold text-gray-800 mb-1.5">จัดการเอกสาร PDF</h3>
                        <p class="text-xs text-gray-500 leading-relaxed">อัปโหลดและแชร์เอกสาร PDF ประกอบกิจกรรมได้ทันที</p>
                    </div>
                    <div
                        class="bg-white border border-gray-100 rounded-2xl p-6 hover:border-emerald-200 hover:shadow-lg hover:shadow-emerald-500/5 hover:-translate-y-1.5 transition-all">
                        <div
                            class="w-11 h-11 bg-emerald-50 text-emerald-500 rounded-xl flex items-center justify-center text-lg mb-4">
                            <i class="fa-solid fa-users"></i> </div>
                        <h3 class="text-sm font-bold text-gray-800 mb-1.5">รองรับผู้เข้าร่วม</h3>
                        <p class="text-xs text-gray-500 leading-relaxed">บริหารจัดการรายชื่อผู้เข้าร่วมกิจกรรมได้ง่าย</p>
                    </div>
                    <div
                        class="bg-white border border-gray-100 rounded-2xl p-6 hover:border-amber-200 hover:shadow-lg hover:shadow-amber-500/5 hover:-translate-y-1.5 transition-all">
                        <div
                            class="w-11 h-11 bg-amber-50 text-amber-500 rounded-xl flex items-center justify-center text-lg mb-4">
                            <i class="fa-solid fa-chart-bar"></i> </div>
                        <h3 class="text-sm font-bold text-gray-800 mb-1.5">สถิติและรายงาน</h3>
                        <p class="text-xs text-gray-500 leading-relaxed">ดูภาพรวมและสร้างรายงานได้อย่างรวดเร็ว</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-16 sm:py-20 bg-gray-50">
            <div class="max-w-6xl mx-auto px-6">
                <div class="text-center max-w-lg mx-auto mb-12">
                    <span
                        class="inline-flex items-center gap-1.5 bg-indigo-50 text-indigo-600 text-xs font-bold rounded-full px-3.5 py-1 mb-4 border border-indigo-100">ไฮไลท์</span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 mb-3">ทำไมต้องเลือกระบบของเรา?</h2>
                    <p class="text-gray-500 text-sm leading-relaxed">ประสบการณ์การใช้งานที่ได้รับการพัฒนาอย่างต่อเนื่อง</p>
                </div>
                <div class="grid sm:grid-cols-3 gap-5">
                    <div
                        class="bg-white border border-gray-100 rounded-2xl p-8 text-center hover:shadow-xl hover:-translate-y-1 transition-all">
                        <div
                            class="w-14 h-14 bg-indigo-50 text-indigo-500 rounded-full flex items-center justify-center text-xl mx-auto mb-5">
                            <i class="fa-solid fa-shield-halved"></i> </div>
                        <h3 class="text-base font-bold text-gray-800 mb-2">ความปลอดภัยสูง</h3>
                        <p class="text-sm text-gray-500 leading-relaxed">
                            ข้อมูลของคุณได้รับการปกป้องด้วยมาตรฐานการรักษาความปลอดภัยระดับสากล</p>
                    </div>
                    <div
                        class="bg-white border border-gray-100 rounded-2xl p-8 text-center hover:shadow-xl hover:-translate-y-1 transition-all">
                        <div
                            class="w-14 h-14 bg-indigo-50 text-indigo-500 rounded-full flex items-center justify-center text-xl mx-auto mb-5">
                            <i class="fa-solid fa-moon"></i> </div>
                        <h3 class="text-base font-bold text-gray-800 mb-2">ใช้งานง่าย</h3>
                        <p class="text-sm text-gray-500 leading-relaxed">อินเตอร์เฟซที่เป็นมิตรกับผู้ใช้
                            ช่วยให้คุณเริ่มต้นได้ภายในไม่กี่นาที</p>
                    </div>
                    <div
                        class="bg-white border border-gray-100 rounded-2xl p-8 text-center hover:shadow-xl hover:-translate-y-1 transition-all">
                        <div
                            class="w-14 h-14 bg-indigo-50 text-indigo-500 rounded-full flex items-center justify-center text-xl mx-auto mb-5">
                            <i class="fa-solid fa-globe"></i> </div>
                        <h3 class="text-base font-bold text-gray-800 mb-2">รองรับทุกแพลตฟอร์ม</h3>
                        <p class="text-sm text-gray-500 leading-relaxed">ใช้งานได้ทั้งบนคอมพิวเตอร์ แท็บเล็ต และสมาร์ทโฟน
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section id="activities" class="py-16 sm:py-20 bg-white">
            <div class="max-w-6xl mx-auto px-6">
                <div class="text-center max-w-lg mx-auto mb-12">
                    <span
                        class="inline-flex items-center gap-1.5 bg-indigo-50 text-indigo-600 text-xs font-bold rounded-full px-3.5 py-1 mb-4 border border-indigo-100">กิจกรรม</span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 mb-3">กิจกรรมล่าสุด</h2>
                    <p class="text-gray-500 text-sm leading-relaxed">ดูข้อมูลกิจกรรมที่กำลังจะเกิดขึ้นและกิจกรรมยอดนิยม</p>
                </div>
                <div id="activities-grid" class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
                    <div class="col-span-full text-center py-16">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-indigo-50 rounded-full mb-4">
                            <i class="fa-solid fa-circle-notch fa-spin text-xl text-indigo-400"></i>
                        </div>
                        <p class="text-gray-500">กำลังโหลดกิจกรรม...</p>
                    </div>
                </div>
                <div class="text-center mt-8">
                    <a href="/activities"
                        class="inline-flex items-center gap-2 px-6 py-3 text-sm font-bold text-white bg-gradient-to-r from-indigo-500 to-purple-500 rounded-xl shadow-md shadow-indigo-200 hover:shadow-lg hover:shadow-indigo-300 hover:-translate-y-0.5 transition-all no-underline">
                        <i class="fa-solid fa-calendar-check"></i>
                        ดูทั้งหมด
                    </a>
                </div>
            </div>
        </section>

        <footer class="bg-gray-950 text-gray-400 py-12 px-6">
            <div class="max-w-6xl mx-auto">
                <div class="flex flex-wrap justify-between gap-8 pb-8 border-b border-white/10 mb-6">
                    <div>
                        <div class="flex items-center gap-3 mb-3">
                            <div
                                class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-xl flex items-center justify-center text-white shadow-lg shadow-indigo-500/30">
                                <i class="fa-solid fa-graduation-cap"></i> </div>
                            <div class="text-white text-lg font-extrabold">{{ $siteName }}</div>
                        </div>
                        <p class="text-sm text-gray-400 max-w-xs leading-relaxed mb-4">{{ $siteDesc }}</p>
                        @if ($fbUrl || $lineUrl || $ytUrl)
                            <div class="flex gap-2">
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
                    <nav class="flex flex-col gap-3 text-sm">
                        <p class="text-white font-semibold mb-1">เมนู</p>
                        <a href="/activities" class="text-gray-400 hover:text-white transition-colors no-underline"><i
                                class="fa-regular fa-calendar mr-2"></i>กิจกรรมทั้งหมด</a>
                        <a href="#about" class="text-gray-400 hover:text-white transition-colors no-underline"><i
                                class="fa-regular fa-circle-info mr-2"></i>เกี่ยวกับระบบ</a>
                        <a href="/login" class="text-gray-400 hover:text-white transition-colors no-underline"><i
                                class="fa-solid fa-user-gear mr-2"></i>สำหรับผู้ดูแล</a>
                    </nav>
                </div>
                <div class="flex flex-wrap justify-between items-center gap-4">
                    <p class="text-xs text-gray-500">{{ $footerText }}</p>
                    <p class="text-xs text-gray-600">พัฒนาด้วย <i class="fa-solid fa-heart text-red-500 mx-1"></i>
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
                            '" class="w-full h-full object-cover">' :
                            '<div class="w-full h-full flex items-center justify-center text-3xl text-gray-300"><i class="fa-regular fa-image"></i></div>';
                        var cat = a.category ?
                            '<span class="absolute top-2.5 left-2.5 bg-gray-900/60 backdrop-blur-sm text-white text-[10px] font-bold px-2 py-0.5 rounded-full">' +
                            a.category.name + '</span>' :
                            '';
                        var date = a.activity_date || '';
                        return '<div class="bg-white border border-gray-100 rounded-2xl overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all group">' +
                            '<div class="h-40 bg-gray-100 overflow-hidden relative">' + cat +
                            img + '</div>' +
                            '<div class="p-4">' +
                            '<div class="flex items-center gap-2 text-xs text-gray-400 mb-2"><i class="fa-regular fa-calendar"></i>' +
                            date + '</div>' +
                            '<h3 class="text-sm font-bold text-gray-800 leading-snug mb-2">' + a
                            .title + '</h3>' +
                            '<p class="text-xs text-gray-500 line-clamp-2 leading-relaxed">' + (
                                a.description || '') + '</p>' +
                            '</div>' +
                            '</div>';
                    }).join(''));
                }
            });

        });
    </script>
@endsection
