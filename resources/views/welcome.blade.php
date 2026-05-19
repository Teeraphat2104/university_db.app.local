<x-layouts.app>

    {{-- ════════════════════════════════
         PUBLIC VIEW
    ════════════════════════════════ --}}
    <div id="public-view">

        <x-topbar />

        {{-- ════════════ Hero ════════════ --}}
        <section class="hero">
            <div class="hero-orb"></div>
            <div class="hero-orb hero-orb-2"></div>
            <div class="hero-orb hero-orb-3"></div>
            <div class="hero-inner">
                <div class="hero-badge">
                    <i class="fa-solid fa-layer-group"></i>
                    ระบบจัดการกิจกรรมมหาวิทยาลัย
                </div>
                <h1 class="hero-title">
                    จัดการกิจกรรม<em>มหาวิทยาลัย</em><br>ให้ง่ายยิ่งขึ้น
                </h1>
                <p class="hero-desc">
                    ระบบครบวงจรสำหรับจัดการกิจกรรม อัปโหลดเอกสาร และติดตามข้อมูลอย่างมีประสิทธิภาพ
                </p>
                <div class="hero-actions">
                    <a href="/activities" class="hero-cta">
                        <i class="fa-solid fa-calendar-check"></i>
                        ดูกิจกรรมทั้งหมด
                    </a>
                    <button type="button" id="open-participant-search" class="hero-cta-outline">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        ตรวจสอบการเข้าร่วม
                    </button>
                    <button type="button" class="hero-cta-outline mode-btn" data-mode="admin">
                        <i class="fa-solid fa-user-tie"></i>
                        สำหรับผู้ดูแล
                    </button>
                </div>

                {{-- Stats --}}
                <div class="hero-stats">
                    <div class="hero-stat">
                        <i class="fa-regular fa-calendar hero-stat-icon"></i>
                        <p class="hero-stat-num" id="stat-activities">0</p>
                        <p class="hero-stat-label">กิจกรรม</p>
                    </div>
                    <div class="hero-stat">
                        <i class="fa-regular fa-rectangle-list hero-stat-icon"></i>
                        <p class="hero-stat-num" id="stat-categories">0</p>
                        <p class="hero-stat-label">หมวดหมู่</p>
                    </div>
                    <div class="hero-stat">
                        <i class="fa-regular fa-file-lines hero-stat-icon"></i>
                        <p class="hero-stat-num" id="stat-documents">0</p>
                        <p class="hero-stat-label">เอกสาร</p>
                    </div>
                    <div class="hero-stat" style="cursor:pointer" id="stat-registered-wrap">
                        <i class="fa-regular fa-user hero-stat-icon"></i>
                        <p class="hero-stat-num" id="stat-registered">0</p>
                        <p class="hero-stat-label">ผู้เข้าร่วม</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- ════════════ Features ════════════ --}}
        <section id="about" class="section-alt">
            <div class="section-inner">
                <div class="section-header">
                    <span class="section-badge">ฟีเจอร์</span>
                    <h2 class="section-title">ครบทุกความต้องการ</h2>
                    <p class="section-desc">ระบบออกแบบมาเพื่อมหาวิทยาลัยโดยเฉพาะ</p>
                </div>
                <div class="features-grid">
                    <div class="feature-card">
                        <div class="feature-icon" style="--icon-color:#6366F1">
                            <i class="fa-solid fa-calendar-days"></i>
                        </div>
                        <h3 class="feature-title">จัดการกิจกรรม</h3>
                        <p class="feature-desc">สร้าง แก้ไข และติดตามกิจกรรมต่างๆ ได้อย่างมีระบบ</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon" style="--icon-color:#EF4444">
                            <i class="fa-solid fa-file-pdf"></i>
                        </div>
                        <h3 class="feature-title">จัดการเอกสาร PDF</h3>
                        <p class="feature-desc">อัปโหลดและแชร์เอกสาร PDF ประกอบกิจกรรมได้ทันที</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon" style="--icon-color:#10B981">
                            <i class="fa-solid fa-users"></i>
                        </div>
                        <h3 class="feature-title">รองรับผู้เข้าร่วม</h3>
                        <p class="feature-desc">บริหารจัดการรายชื่อผู้เข้าร่วมกิจกรรมได้ง่าย</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon" style="--icon-color:#F59E0B">
                            <i class="fa-solid fa-chart-bar"></i>
                        </div>
                        <h3 class="feature-title">สถิติและรายงาน</h3>
                        <p class="feature-desc">ดูภาพรวมและสร้างรายงานได้อย่างรวดเร็ว</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- ════════════ Highlights ════════════ --}}
        <section class="section-highlights">
            <div class="section-inner">
                <div class="section-header">
                    <span class="section-badge">ไฮไลท์</span>
                    <h2 class="section-title">ทำไมต้องเลือกระบบของเรา?</h2>
                    <p class="section-desc">ประสบการณ์การใช้งานที่ได้รับการพัฒนาอย่างต่อเนื่อง</p>
                </div>
                <div class="highlights-grid">
                    <div class="highlight-card">
                        <div class="highlight-icon">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                        <h3 class="highlight-title">ความปลอดภัยสูง</h3>
                        <p class="highlight-desc">ข้อมูลของคุณได้รับการปกป้องด้วยมาตรฐานการรักษาความปลอดภัยระดับสากล</p>
                    </div>
                    <div class="highlight-card">
                        <div class="highlight-icon">
                            <i class="fa-solid fa-moon"></i>
                        </div>
                        <h3 class="highlight-title">ใช้งานง่าย</h3>
                        <p class="highlight-desc">อินเตอร์เฟซที่เป็นมิตรกับผู้ใช้ ช่วยให้คุณเริ่มต้นได้ภายในไม่กี่นาที</p>
                    </div>
                    <div class="highlight-card">
                        <div class="highlight-icon">
                            <i class="fa-solid fa-globe"></i>
                        </div>
                        <h3 class="highlight-title">รองรับทุกแพลตฟอร์ม</h3>
                        <p class="highlight-desc">ใช้งานได้ทั้งบนคอมพิวเตอร์ แท็บเล็ต และสมาร์ทโฟน</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- ════════════ Activities ════════════ --}}
        <section id="activities" class="section-activities">
            <div class="section-inner">
                <x-public.activity-section />
            </div>
        </section>

        {{-- ════════════ Footer ════════════ --}}
        <footer class="footer">
            <div class="footer-inner">
                <div class="footer-top">
                    <div class="footer-brand">
                        <div class="footer-logo">
                            <i class="fa-solid fa-graduation-cap"></i>
                        </div>
                        <strong>University Activities</strong>
                        <p>ระบบจัดการกิจกรรมและเอกสารสำหรับมหาวิทยาลัย</p>
                    </div>
                    <nav class="footer-nav">
                        <a href="/activities"><i class="fa-regular fa-calendar"></i> กิจกรรม</a>
                        <a href="#about"><i class="fa-regular fa-circle-info"></i> เกี่ยวกับ</a>
                        <a href="#" class="mode-btn" data-mode="admin"><i class="fa-regular fa-user"></i> ผู้ดูแลระบบ</a>
                    </nav>
                    <div class="footer-social">
                        <a href="#" aria-label="Facebook"><i class="fa-brands fa-facebook"></i></a>
                        <a href="#" aria-label="Line"><i class="fa-brands fa-line"></i></a>
                        <a href="#" aria-label="YouTube"><i class="fa-brands fa-youtube"></i></a>
                    </div>
                </div>
                <p class="footer-bottom">© {{ date('Y') }} University Activities. สงวนลิขสิทธิ์</p>
            </div>
        </footer>

    </div>{{-- end #public-view --}}

    {{-- ════════════════════════════════
         ADMIN VIEW
    ════════════════════════════════ --}}
    <section id="admin-view" class="hidden">

        {{-- Login screen --}}
        <div class="admin-login-screen" id="admin-auth-card">
            <x-admin.login-card />
        </div>

        {{-- Dashboard --}}
        <div id="admin-dashboard" class="hidden admin-layout">
            <x-admin.dashboard-header />
            <div class="admin-main">
                <header class="admin-topbar">
                    <div style="display:flex;align-items:center;gap:.875rem">
                        <div>
                            <h1 id="admin-topbar-title">ภาพรวม</h1>
                            <p id="admin-topbar-desc">สถิติและข้อมูลสรุปของระบบ</p>
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm mode-btn" data-mode="public"
                        style="background:var(--color-gray-100);color:var(--color-gray-600);border:1px solid var(--color-gray-200)">
                        <i class="fa-solid fa-house"></i>
                        กลับหน้าหลัก
                    </button>
                </header>
                <div class="admin-page-body">
                    <x-admin.overview-section />
                    <x-admin.category-manager />
                    <x-admin.activity-manager />
                </div>
            </div>
        </div>

    </section>{{-- end #admin-view --}}

    {{-- Dialogs --}}
    <x-activity-dialog />
    <x-confirm-dialog />
    <x-admin.category-form-dialog />
    <x-admin.activity-form-dialog />
    <x-admin.media-preview-dialog />
    <x-participant-search-dialog />
    <x-toast />

</x-layouts.app>
