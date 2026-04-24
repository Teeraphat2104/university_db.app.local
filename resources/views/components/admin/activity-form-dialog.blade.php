<dialog id="activity-form-dialog" class="modal-lg">
    <div class="dialog-header">
        <h3 id="activity-form-dialog-title">เพิ่มกิจกรรม</h3>
        <button id="activity-dialog-close-btn" type="button" class="btn btn-ghost btn-sm" style="width:32px;height:32px;padding:0;border-radius:var(--radius-md)">
            <i class="fa-solid fa-xmark"></i>
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

            {{-- Excel import --}}
            <div style="display:grid;gap:.5rem">
                <span class="field-label">ไฟล์รายชื่อผู้เข้าร่วม (Excel .xlsx / .xls / .csv)</span>
                <div id="activity-participants-badge" class="hidden"
                    style="display:flex;align-items:center;gap:.5rem;padding:.375rem .625rem;background:#EEF2FF;border-radius:var(--radius-md);font-size:.8rem;color:#4338CA;width:fit-content">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                    <span id="activity-participants-count">0 คน</span>
                    <button type="button" id="activity-clear-participants" class="btn btn-danger btn-sm"
                        style="padding:.15rem .5rem;font-size:.73rem;height:auto">ล้างรายชื่อ</button>
                </div>
                <div style="display:flex;align-items:center;gap:.5rem">
                    <input id="activity-excel" type="file" accept=".xlsx,.xls,.csv" style="flex:1">
                    <button type="button" id="activity-import-excel-btn" class="btn btn-primary btn-sm" style="white-space:nowrap">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right:.25rem">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/>
                        </svg>
                        นำเข้า
                    </button>
                </div>
                <p style="font-size:.75rem;color:var(--color-gray-400)">
                    ต้องมีคอลัมน์ <code>student_id</code> และ <code>name</code> (คอลัมน์อื่นๆ เป็น optional)
                </p>
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
