{{-- Admin: Activity add/edit form dialog --}}
<dialog id="activity-form-dialog" class="modal" style="width: min(720px, 92vw)">
    <div class="bg-white p-5 rounded-2xl">
        {{-- Header --}}
        <div class="flex justify-between items-center mb-4">
            <h3 id="activity-form-dialog-title" class="m-0 text-lg font-semibold">เพิ่มกิจกรรม</h3>
            <button id="activity-dialog-close-btn" type="button" class="btn btn-muted text-lg leading-none px-2.5 py-1.5">✕</button>
        </div>

        {{-- Form --}}
        <form id="admin-activity-form" class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <input type="hidden" id="activity-id">

            <label class="grid gap-1.5 sm:col-span-2" for="activity-title">
                <span class="text-[13px] text-muted">ชื่อกิจกรรม</span>
                <input id="activity-title" name="title" type="text" required maxlength="255">
            </label>

            <label class="grid gap-1.5" for="activity-category">
                <span class="text-[13px] text-muted">หมวดหมู่</span>
                <select id="activity-category" name="category_id" required></select>
            </label>

            <label class="grid gap-1.5" for="activity-date">
                <span class="text-[13px] text-muted">วันที่กิจกรรม</span>
                <input id="activity-date" name="activity_date" type="date">
            </label>

            <label class="grid gap-1.5 sm:col-span-2" for="activity-location">
                <span class="text-[13px] text-muted">สถานที่</span>
                <input id="activity-location" name="location" type="text" maxlength="500" placeholder="เช่น อาคารเรียนรวม">
            </label>

            <label class="grid gap-1.5 sm:col-span-2" for="activity-description">
                <span class="text-[13px] text-muted">รายละเอียด</span>
                <textarea id="activity-description" name="description" rows="3" placeholder="รายละเอียดกิจกรรม..."></textarea>
            </label>

            <label class="grid gap-1.5" for="activity-cover">
                <span class="text-[13px] text-muted">รูปปก (JPG/PNG/WEBP ≤ 5MB)</span>
                <input id="activity-cover" name="cover_image" type="file" accept=".jpg,.jpeg,.png,.webp,image/*">
            </label>

            <label class="grid gap-1.5" for="activity-pdf">
                <span class="text-[13px] text-muted">ไฟล์ PDF (≤ 20MB)</span>
                <input id="activity-pdf" name="pdf_file" type="file" accept=".pdf,application/pdf">
            </label>

            <label class="inline-flex items-center gap-2 text-muted text-[0.95rem]" for="activity-status">
                <input id="activity-status" name="status" type="checkbox" checked class="w-4 h-4 m-0 accent-primary">
                <span>เปิดเผยกิจกรรม</span>
            </label>

            <div id="activity-existing-assets" class="text-muted text-sm sm:col-span-2"></div>

            <div class="flex justify-end gap-2 sm:col-span-2 mt-2">
                <button id="activity-cancel" type="button" class="btn btn-muted">ยกเลิก</button>
                <button id="activity-submit" type="submit" class="btn btn-primary">เพิ่มกิจกรรม</button>
            </div>
        </form>
    </div>
</dialog>
