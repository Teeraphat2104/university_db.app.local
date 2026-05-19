<x-layouts.app>

    {{-- ════════════════════════════════
         ACTIVITIES PAGE
    ════════════════════════════════ --}}
    <div id="public-view">

        <x-topbar />

        {{-- Breadcrumb --}}
        <div class="breadcrumb-wrap">
            <div class="breadcrumb-inner">
                <a href="/">หน้าหลัก</a>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                <span>กิจกรรมทั้งหมด</span>
            </div>
        </div>

        {{-- Activities Section --}}
        <section class="section" style="padding-top:1rem">
            <div class="section-inner">
                <x-public.activity-section :initialCategory="null" />
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
                        <a href="/activities">กิจกรรม</a>
                        <a href="/#about">เกี่ยวกับ</a>
                        <a href="#" class="mode-btn" data-mode="admin">ผู้ดูแลระบบ</a>
                    </nav>
                </div>
                <p class="footer-bottom">© {{ date('Y') }} University Activities. สงวนลิขสิทธิ์</p>
            </div>
        </footer>

    </div>

    {{-- Dialogs --}}
    <x-activity-dialog />
    <x-confirm-dialog />
    <x-toast />

</x-layouts.app>