<div class="admin-section" id="admin-section-overview">

    {{-- Welcome Banner --}}
    <div class="admin-welcome-banner">
        <div>
            <h2 class="admin-welcome-title">ยินดีต้อนรับ, <span id="overview-admin-name">Admin</span></h2>
            <p class="admin-welcome-sub" id="overview-date">—</p>
        </div>
        <div style="display:flex;gap:.625rem;flex-wrap:wrap">
            <button type="button" class="btn btn-primary btn-sm" id="overview-add-activity-btn">
                <i class="fa-solid fa-plus"></i>
                เพิ่มกิจกรรม
            </button>
            <button type="button" class="btn btn-muted btn-sm" id="overview-add-category-btn">
                <i class="fa-solid fa-plus"></i>
                เพิ่มหมวดหมู่
            </button>
        </div>
    </div>

    {{-- Stat Cards --}}
    <div class="overview-stats-grid">

        <div class="stat-card">
            <div class="stat-card-icon indigo">
                <i class="fa-solid fa-calendar-days"></i>
            </div>
            <div class="stat-card-content">
                <p class="stat-card-value" id="overview-total-activities">—</p>
                <p class="stat-card-label">กิจกรรมทั้งหมด</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-card-icon green">
                <i class="fa-solid fa-check-circle"></i>
            </div>
            <div class="stat-card-content">
                <p class="stat-card-value" id="overview-active-activities">—</p>
                <p class="stat-card-label">กิจกรรมที่เปิดเผย</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-card-icon purple">
                <i class="fa-solid fa-border-all"></i>
            </div>
            <div class="stat-card-content">
                <p class="stat-card-value" id="overview-total-categories">—</p>
                <p class="stat-card-label">หมวดหมู่</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-card-icon amber">
                <i class="fa-solid fa-file-pdf"></i>
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
                <i class="fa-solid fa-chevron-right"></i>
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
