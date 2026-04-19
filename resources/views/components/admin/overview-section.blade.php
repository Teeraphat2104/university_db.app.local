<div class="admin-section" id="admin-section-overview">

    {{-- Welcome Banner --}}
    <div class="admin-welcome-banner">
        <div>
            <h2 class="admin-welcome-title">ยินดีต้อนรับ, <span id="overview-admin-name">Admin</span></h2>
            <p class="admin-welcome-sub" id="overview-date">—</p>
        </div>
        <div style="display:flex;gap:.625rem;flex-wrap:wrap">
            <button type="button" class="btn btn-primary btn-sm" id="overview-add-activity-btn">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                เพิ่มกิจกรรม
            </button>
            <button type="button" class="btn btn-muted btn-sm" id="overview-add-category-btn">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                เพิ่มหมวดหมู่
            </button>
        </div>
    </div>

    {{-- Stat Cards --}}
    <div class="overview-stats-grid">

        <div class="stat-card">
            <div class="stat-card-icon indigo">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="18" rx="2"/>
                    <line x1="16" y1="2" x2="16" y2="6"/>
                    <line x1="8" y1="2" x2="8" y2="6"/>
                    <line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
            </div>
            <div class="stat-card-content">
                <p class="stat-card-value" id="overview-total-activities">—</p>
                <p class="stat-card-label">กิจกรรมทั้งหมด</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-card-icon green">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                    <polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
            </div>
            <div class="stat-card-content">
                <p class="stat-card-value" id="overview-active-activities">—</p>
                <p class="stat-card-label">กิจกรรมที่เปิดเผย</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-card-icon purple">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
                    <rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
                </svg>
            </div>
            <div class="stat-card-content">
                <p class="stat-card-value" id="overview-total-categories">—</p>
                <p class="stat-card-label">หมวดหมู่</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-card-icon amber">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                    <line x1="16" y1="13" x2="8" y2="13"/>
                    <line x1="16" y1="17" x2="8" y2="17"/>
                    <polyline points="10 9 9 9 8 9"/>
                </svg>
            </div>
            <div class="stat-card-content">
                <p class="stat-card-value" id="overview-total-documents">—</p>
                <p class="stat-card-label">เอกสาร PDF</p>
            </div>
        </div>

    </div>

    {{-- Recent Activities --}}
    <div class="panel">
        <div class="panel-header">
            <div>
                <h3 class="panel-title">กิจกรรมล่าสุด</h3>
                <p class="panel-desc">5 รายการล่าสุดในระบบ</p>
            </div>
            <button type="button" class="btn btn-muted btn-sm" data-section-goto="admin-section-activities">
                ดูทั้งหมด
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="9 18 15 12 9 6"/>
                </svg>
            </button>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>ชื่อกิจกรรม</th>
                        <th>หมวดหมู่</th>
                        <th>วันที่</th>
                        <th>สถานะ</th>
                        <th>จัดการ</th>
                    </tr>
                </thead>
                <tbody id="overview-recent-list">
                    <tr>
                        <td colspan="5" style="text-align:center;color:var(--color-gray-400);padding:2rem">กำลังโหลด...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>
