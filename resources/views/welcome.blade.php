<x-layouts.app>

    {{-- ════════════════════════════════
         PUBLIC VIEW
    ════════════════════════════════ --}}
    <div id="public-view">

        <x-topbar />

        {{-- Hero --}}
        <section class="hero">
            <div class="hero-shapes">
                <div class="hero-shape hero-shape-1"></div>
                <div class="hero-shape hero-shape-2"></div>
                <div class="hero-shape hero-shape-3"></div>
                <div class="hero-shape hero-shape-4"></div>
                <div class="hero-glow"></div>
            </div>
            <div class="hero-inner">
                <div class="hero-badge">ระบบจัดการกิจกรรมและเอกสาร</div>
                <h2 class="hero-title">
                    จัดการ<em>กิจกรรม</em><br>มหาวิทยาลัย<br>ให้ง่ายยิ่งขึ้น
                </h2>
                <p class="hero-desc">
                    ระบบครบวงจรสำหรับจัดการกิจกรรม อัปโหลดเอกสาร และติดตามข้อมูลอย่างมีประสิทธิภาพ
                </p>
                <div class="hero-actions">
                    <a href="#activities" class="hero-cta">
                        <i class="fa-solid fa-house"></i>
                        ดูกิจกรรมทั้งหมด
                    </a>
                    <button type="button" id="open-participant-search" class="hero-cta-outline">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                        </svg>
                        ตรวจสอบการเข้าร่วม
                    </button>
                    <button type="button" class="hero-cta-outline mode-btn" data-mode="admin">
                        <i class="fa-solid fa-user-gear"></i>
                        สำหรับผู้ดูแล
                    </button>
                </div>

                {{-- Stats --}}
                <div class="hero-stats">
                    <div class="hero-stat">
                        <p class="hero-stat-num" id="stat-activities">0</p>
                        <p class="hero-stat-label">กิจกรรม</p>
                    </div>
                    <div class="hero-stat">
                        <p class="hero-stat-num" id="stat-categories">0</p>
                        <p class="hero-stat-label">หมวดหมู่</p>
                    </div>
                    <div class="hero-stat">
                        <p class="hero-stat-num" id="stat-documents">0</p>
                        <p class="hero-stat-label">เอกสาร</p>
                    </div>
                    <div class="hero-stat" style="cursor:pointer" id="stat-registered-wrap">
                        <p class="hero-stat-num" id="stat-registered">0</p>
                        <p class="hero-stat-label">ผู้เข้าร่วม</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- Features --}}
        <section id="about" class="section" style="background:#fff; border-bottom:1px solid var(--color-line)">
            <div class="section-inner">
                <p class="section-eyebrow">ฟีเจอร์</p>
                <h3 class="section-title">ครบทุกความต้องการ</h3>
                <p class="section-subtitle">ระบบออกแบบมาเพื่อมหาวิทยาลัยโดยเฉพาะ</p>
                <div class="features-grid">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fa-solid fa-calendar-days"></i>
                        </div>
                        <h4 class="feature-title">จัดการกิจกรรม</h4>
                        <p class="feature-desc">สร้าง แก้ไข และติดตามกิจกรรมต่างๆ ได้อย่างมีระบบ</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fa-solid fa-file-pdf"></i>
                        </div>
                        <h4 class="feature-title">จัดการเอกสาร PDF</h4>
                        <p class="feature-desc">อัปโหลดและแชร์เอกสาร PDF ประกอบกิจกรรมได้ทันที</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fa-solid fa-users"></i>
                        </div>
                        <h4 class="feature-title">รองรับผู้เข้าร่วม</h4>
                        <p class="feature-desc">บริหารจัดการรายชื่อผู้เข้าร่วมกิจกรรมได้ง่าย</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fa-solid fa-chart-bar"></i>
                        </div>
                        <h4 class="feature-title">สถิติและรายงาน</h4>
                        <p class="feature-desc">ดูภาพรวมและสร้างรายงานได้อย่างรวดเร็ว</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- Activities Section --}}
        <section id="activities" class="section">
            <div class="section-inner">
                <x-public.activity-section />
            </div>
        </section>

        {{-- Footer --}}
        <footer class="footer">
            <div class="footer-inner">
                <div class="footer-top">
                    <div class="footer-brand">
                        <strong>University Activities</strong>
                        <p>ระบบจัดการกิจกรรมและเอกสารสำหรับมหาวิทยาลัย</p>
                    </div>
                    <nav class="footer-nav">
                        <a href="#activities">กิจกรรม</a>
                        <a href="#about">เกี่ยวกับ</a>
                        <a href="#" class="mode-btn" data-mode="admin">ผู้ดูแลระบบ</a>
                    </nav>
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
