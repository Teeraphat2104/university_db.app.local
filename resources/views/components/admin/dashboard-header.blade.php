<aside class="admin-sidebar">
    {{-- Brand --}}
    <div class="sidebar-brand">
        <span class="sidebar-brand-icon">
            <i class="fa-solid fa-book-open"></i>
        </span>
        <div class="sidebar-brand-text">
            <strong>Activities</strong>
            <span>University Portal</span>
        </div>
    </div>

    {{-- Navigation --}}
    <nav class="sidebar-nav">
        <span class="sidebar-nav-label">เมนูหลัก</span>

        <button type="button" class="sidebar-nav-item is-active" data-section="admin-section-overview">
            <i class="fa-solid fa-grip"></i>
            ภาพรวม
        </button>

        <button type="button" class="sidebar-nav-item" data-section="admin-section-categories">
            <i class="fa-solid fa-border-all"></i>
            หมวดหมู่
        </button>

        <button type="button" class="sidebar-nav-item" data-section="admin-section-activities">
            <i class="fa-solid fa-calendar-days"></i>
            กิจกรรม
        </button>
    </nav>

    {{-- Profile & logout --}}
    <div class="sidebar-footer">
        <div class="sidebar-profile">
            <span class="sidebar-avatar"><i class="fa-solid fa-user"></i></span>
            <p id="admin-profile-text">กำลังโหลด...</p>
        </div>
        <button id="admin-logout" type="button">
            <i class="fa-solid fa-right-from-bracket"></i>
            ออกจากระบบ
        </button>
    </div>
</aside>
