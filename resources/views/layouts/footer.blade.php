<footer class="site-footer">
    <div class="site-footer-inner">
        <div class="site-footer-top">
            <div>
                <div class="site-footer-brand">
                    <div class="site-footer-icon"><i class="bx bx-graduation"></i></div>
                    <span class="site-footer-name">{{ $siteName }}</span>
                </div>
                <p class="site-footer-desc">{{ $siteDesc }}</p>
            </div>
            <nav class="site-footer-nav">
                <span class="site-footer-nav-title">เมนู</span>
                <a href="/activities" class="site-footer-link"><i class="bx bx-calendar me-2"></i>กิจกรรมทั้งหมด</a>
                <a href="/login" class="site-footer-link"><i class="bx bx-user-tie me-2"></i>สำหรับผู้ดูแล</a>
            </nav>
        </div>
        <div class="site-footer-bottom">
            <span class="site-footer-copy">{{ $footerText }}</span>
            <span class="site-footer-heart">พัฒนาด้วย <i class="bx bxs-heart text-danger mx-1"></i> สำหรับมหาวิทยาลัย</span>
        </div>
    </div>
</footer>
