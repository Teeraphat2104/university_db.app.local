<div class="panel admin-section hidden" id="admin-section-activities">
    <div class="panel-header">
        <div>
            <h3 class="panel-title">กิจกรรม</h3>
            <p class="panel-desc">เพิ่ม แก้ไข ลบกิจกรรม และอัปโหลดไฟล์แนบ</p>
        </div>
        <button id="activity-add-btn" type="button" class="btn btn-primary btn-sm">
            <i class="fa-solid fa-plus"></i>
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
            <i class="fa-solid fa-chevron-left"></i>
            ก่อนหน้า
        </button>
        <span id="admin-activity-page" style="font-size:.82rem;color:var(--color-gray-500)">หน้า 1 / 1</span>
        <button id="admin-activity-next" type="button" class="btn btn-muted btn-sm">
            ถัดไป
            <i class="fa-solid fa-chevron-right"></i>
        </button>
    </div>
</div>
