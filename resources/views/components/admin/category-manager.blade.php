<div class="panel admin-section hidden" id="admin-section-categories">
    <div class="panel-header">
        <div>
            <h3 class="panel-title">หมวดหมู่</h3>
            <p class="panel-desc">เพิ่ม แก้ไข และลบหมวดหมู่กิจกรรม</p>
        </div>
        <button id="category-add-btn" type="button" class="btn btn-primary btn-sm">
            <i class="fa-solid fa-plus"></i>
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
