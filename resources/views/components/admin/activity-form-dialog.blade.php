<dialog id="activity-form-dialog" class="modal-lg">
    <div class="dialog-header">
        <h3 id="activity-form-dialog-title">เพิ่มกิจกรรม</h3>
        <button id="activity-dialog-close-btn" type="button" class="btn btn-ghost btn-sm" style="width:32px;height:32px;padding:0;border-radius:var(--radius-md)">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
        </button>
    </div>

    <form id="admin-activity-form" class="dialog-body">
        <input type="hidden" id="activity-id">

        <div style="display:grid;gap:1rem">
            <label style="display:grid;gap:.375rem">
                <span class="field-label">ชื่อกิจกรรม <span style="color:var(--color-danger)">*</span></span>
                <input id="activity-title" name="title" type="text" required maxlength="255" placeholder="ชื่อกิจกรรม">
            </label>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
                <label style="display:grid;gap:.375rem">
                    <span class="field-label">หมวดหมู่ <span style="color:var(--color-danger)">*</span></span>
                    <select id="activity-category" name="category_id" required></select>
                </label>
                <label style="display:grid;gap:.375rem">
                    <span class="field-label">วันที่กิจกรรม</span>
                    <input id="activity-date" name="activity_date" type="date">
                </label>
            </div>

            <label style="display:grid;gap:.375rem">
                <span class="field-label">สถานที่</span>
                <input id="activity-location" name="location" type="text" maxlength="500" placeholder="เช่น อาคารเรียนรวม ชั้น 3">
            </label>

            <label style="display:grid;gap:.375rem">
                <span class="field-label">รายละเอียด</span>
                <textarea id="activity-description" name="description" rows="3" placeholder="รายละเอียดกิจกรรม..."></textarea>
            </label>

            {{-- File uploads --}}
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
                <div style="display:grid;gap:.375rem">
                    <span class="field-label">รูปปก (JPG/PNG/WEBP ≤ 5MB)</span>
                    <input id="activity-cover" name="cover_image" type="file" accept=".jpg,.jpeg,.png,.webp,image/*">
                    <div id="activity-cover-preview" class="file-preview hidden"></div>
                </div>
                <div style="display:grid;gap:.375rem">
                    <span class="field-label">ไฟล์ PDF (≤ 20MB)</span>
                    <input id="activity-pdf" name="pdf_file" type="file" accept=".pdf,application/pdf">
                    <div id="activity-pdf-preview" class="file-preview hidden"></div>
                </div>
            </div>

            <div id="activity-existing-assets" class="file-existing hidden"></div>

            <label style="display:inline-flex;align-items:center;gap:.625rem;cursor:pointer">
                <input id="activity-status" name="status" type="checkbox" checked style="width:16px;height:16px;accent-color:var(--color-primary)">
                <span style="font-size:.875rem;color:var(--color-gray-700);font-weight:500">เปิดเผยกิจกรรมสู่สาธารณะ</span>
            </label>
        </div>

        <div class="dialog-footer" style="margin:-1.5rem;margin-top:1.25rem">
            <button id="activity-cancel" type="button" class="btn btn-muted btn-sm">ยกเลิก</button>
            <button id="activity-submit" type="submit" class="btn btn-primary btn-sm">เพิ่มกิจกรรม</button>
        </div>
    </form>
</dialog>
