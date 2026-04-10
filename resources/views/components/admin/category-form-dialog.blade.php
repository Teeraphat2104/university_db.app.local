{{-- Admin: Category add/edit form dialog --}}
<dialog id="category-form-dialog" class="modal w-[480px]">
    <div class="bg-white p-5 rounded-2xl">
        {{-- Header --}}
        <div class="flex justify-between items-center mb-4">
            <h3 id="category-form-dialog-title" class="m-0 text-lg font-semibold">เพิ่มหมวดหมู่</h3>
            <button id="category-dialog-close-btn" type="button" class="btn btn-muted text-lg leading-none px-2.5 py-1.5">✕</button>
        </div>

        {{-- Form --}}
        <form id="admin-category-form" class="grid gap-3">
            <input type="hidden" id="category-id">

            <label class="grid gap-1.5" for="category-name">
                <span class="text-[13px] text-muted">ชื่อหมวดหมู่</span>
                <input id="category-name" type="text" required placeholder="เช่น กิจกรรมวิชาการ">
            </label>

            <label class="grid gap-1.5" for="category-cover">
                <span class="text-[13px] text-muted">รูปปกหมวดหมู่ (JPG/PNG/WEBP ≤ 5MB)</span>
                <input id="category-cover" name="cover_image" type="file" accept=".jpg,.jpeg,.png,.webp,image/*">
            </label>

            <div id="category-existing-cover" class="text-muted text-sm"></div>

            <label class="inline-flex items-center gap-2 text-muted text-[0.95rem]" for="category-status">
                <input id="category-status" type="checkbox" checked class="w-4 h-4 m-0 accent-primary">
                <span>เปิดใช้งาน</span>
            </label>

            <div class="flex justify-end gap-2 mt-2">
                <button id="category-cancel" type="button" class="btn btn-muted">ยกเลิก</button>
                <button id="category-submit" type="submit" class="btn btn-primary">เพิ่มหมวดหมู่</button>
            </div>
        </form>
    </div>
</dialog>
