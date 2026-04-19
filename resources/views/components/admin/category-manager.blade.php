<div class="panel admin-section hidden" id="admin-section-categories">
    <div class="panel-header">
        <div>
            <h3 class="panel-title">หมวดหมู่</h3>
            <p class="panel-desc">เพิ่ม แก้ไข และลบหมวดหมู่กิจกรรม</p>
        </div>
        <button id="category-add-btn" type="button" class="btn btn-primary btn-sm">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
            เพิ่มหมวดหมู่
        </button>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th style="width:52px">รูป</th>
                    <th>ชื่อหมวดหมู่</th>
                    <th>สถานะ</th>
                    <th>วันที่สร้าง</th>
                    <th>จัดการ</th>
                </tr>
            </thead>
            <tbody id="admin-category-list">
                <tr><td colspan="5" style="text-align:center;color:var(--color-gray-400);padding:2rem">กำลังโหลด...</td></tr>
            </tbody>
        </table>
    </div>
</div>
