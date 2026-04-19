<aside class="admin-sidebar">
    {{-- Brand --}}
    <div class="sidebar-brand">
        <span class="sidebar-brand-icon">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
            </svg>
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
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="3" width="7" height="9"/><rect x="14" y="3" width="7" height="5"/>
                <rect x="14" y="12" width="7" height="9"/><rect x="3" y="16" width="7" height="5"/>
            </svg>
            ภาพรวม
        </button>

        <button type="button" class="sidebar-nav-item" data-section="admin-section-categories">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
                <rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
            </svg>
            หมวดหมู่
        </button>

        <button type="button" class="sidebar-nav-item" data-section="admin-section-activities">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="4" width="18" height="18" rx="2"/>
                <line x1="16" y1="2" x2="16" y2="6"/>
                <line x1="8" y1="2" x2="8" y2="6"/>
                <line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
            กิจกรรม
        </button>
    </nav>

    {{-- Profile & logout --}}
    <div class="sidebar-footer">
        <div class="sidebar-profile">
            <span class="sidebar-avatar">A</span>
            <p id="admin-profile-text">กำลังโหลด...</p>
        </div>
        <button id="admin-logout" type="button">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                <polyline points="16 17 21 12 16 7"/>
                <line x1="21" y1="12" x2="9" y2="12"/>
            </svg>
            ออกจากระบบ
        </button>
    </div>
</aside>
