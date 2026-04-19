<dialog id="category-form-dialog" class="modal-md">
    <div class="dialog-header">
        <h3 id="category-form-dialog-title">เพิ่มหมวดหมู่</h3>
        <button id="category-dialog-close-btn" type="button" class="btn btn-ghost btn-sm" style="width:32px;height:32px;padding:0;border-radius:var(--radius-md)">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
        </button>
    </div>

    <form id="admin-category-form" class="dialog-body" style="display:grid;gap:1rem">
        <input type="hidden" id="category-id">

        <label style="display:grid;gap:.375rem">
            <span class="field-label">ชื่อหมวดหมู่ <span style="color:var(--color-danger)">*</span></span>
            <input id="category-name" type="text" required placeholder="เช่น กิจกรรมวิชาการ">
        </label>

        <div style="display:grid;gap:.375rem">
            <span class="field-label">รูปปกหมวดหมู่ (JPG/PNG/WEBP ≤ 5MB)</span>
            <input id="category-cover" name="cover_image" type="file" accept=".jpg,.jpeg,.png,.webp,image/*">
            <div id="category-cover-preview" class="file-preview hidden"></div>
            <div id="category-existing-cover" class="file-existing hidden"></div>
        </div>

        <label style="display:inline-flex;align-items:center;gap:.625rem;cursor:pointer">
            <input id="category-status" type="checkbox" checked style="width:16px;height:16px;accent-color:var(--color-primary)">
            <span style="font-size:.875rem;color:var(--color-gray-700);font-weight:500">เปิดใช้งาน</span>
        </label>

        <div class="dialog-footer" style="margin:-1.5rem;margin-top:.5rem">
            <button id="category-cancel" type="button" class="btn btn-muted btn-sm">ยกเลิก</button>
            <button id="category-submit" type="submit" class="btn btn-primary btn-sm">เพิ่มหมวดหมู่</button>
        </div>
    </form>
</dialog>
