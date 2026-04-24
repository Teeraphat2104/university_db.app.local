<div class="panel admin-section hidden" id="admin-section-activities">
    <div class="panel-header">
        <div>
            <h3 class="panel-title">กิจกรรม</h3>
            <p class="panel-desc">เพิ่ม แก้ไข ลบกิจกรรม และอัปโหลดไฟล์แนบ</p>
        </div>
        <button id="activity-add-btn" type="button" class="btn btn-primary btn-sm">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
            เพิ่มกิจกรรม
        </button>
    </div>

    {{-- Filters --}}
    <div class="panel-toolbar">
        <label style="display:grid;gap:.3rem;flex:1;min-width:180px;max-width:280px">
            <span class="tf-label">ค้นหากิจกรรม</span>
            <input id="admin-activity-keyword" type="text" placeholder="ชื่อกิจกรรม...">
        </label>
        <label style="display:grid;gap:.3rem;min-width:160px">
            <span class="tf-label">หมวดหมู่</span>
            <select id="admin-activity-filter-category">
                <option value="">ทั้งหมด</option>
            </select>
        </label>
        <div style="display:flex;gap:.5rem;align-items:flex-end">
            <button id="admin-activity-search" type="button" class="btn btn-primary btn-sm">ค้นหา</button>
            <button id="admin-activity-reset" type="button" class="btn btn-muted btn-sm">ล้าง</button>
        </div>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>กิจกรรม</th>
                    <th>หมวดหมู่</th>
                    <th>วันที่</th>
                    <th>สถานะ</th>
                    <th>ไฟล์</th>
                    <th>จัดการ</th>
                </tr>
            </thead>
            <tbody id="admin-activity-list">
                <tr><td colspan="6" style="text-align:center;color:var(--color-gray-400);padding:2rem">กำลังโหลด...</td></tr>
            </tbody>
        </table>
    </div>

    <div style="padding:.875rem 1.5rem;border-top:1px solid var(--color-gray-100);display:flex;justify-content:flex-end;align-items:center;gap:.75rem">
        <button id="admin-activity-prev" type="button" class="btn btn-muted btn-sm">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
            ก่อนหน้า
        </button>
        <span id="admin-activity-page" style="font-size:.82rem;color:var(--color-gray-500)">หน้า 1 / 1</span>
        <button id="admin-activity-next" type="button" class="btn btn-muted btn-sm">
            ถัดไป
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
        </button>
    </div>
</div>
