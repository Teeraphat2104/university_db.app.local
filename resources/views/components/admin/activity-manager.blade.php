{{-- Admin: Activity manager (filter + table + pagination — form is in dialog) --}}
<section class="bg-white border border-line/75 rounded-2xl shadow-card p-5 mb-3.5">
    <x-section-head
        title="จัดการกิจกรรม"
        description="เพิ่ม แก้ไข ลบกิจกรรม และอัปโหลดไฟล์แนบ"
        tag="h3"
    >
        <button id="activity-add-btn" type="button" class="btn btn-primary shrink-0">+ เพิ่มกิจกรรม</button>
    </x-section-head>

    {{-- Filters --}}
    <div class="grid gap-2.5 md:flex md:flex-wrap md:items-end md:gap-3 mb-4">
        <label class="grid gap-1.5 min-w-0 md:min-w-[180px] md:flex-1 md:basis-[280px]" for="admin-activity-keyword">
            <span class="text-[13px] text-muted">ค้นหากิจกรรม</span>
            <input id="admin-activity-keyword" type="text" placeholder="ค้นหาจากชื่อกิจกรรม">
        </label>
        <label class="grid gap-1.5 min-w-0 md:min-w-[180px]" for="admin-activity-filter-category">
            <span class="text-[13px] text-muted">กรองหมวดหมู่</span>
            <select id="admin-activity-filter-category">
                <option value="">ทั้งหมด</option>
            </select>
        </label>
        <div class="flex flex-wrap items-center gap-2 w-full md:w-auto md:inline-flex">
            <button id="admin-activity-search" type="button" class="btn btn-primary flex-1 md:flex-none">ค้นหา</button>
            <button id="admin-activity-reset" type="button" class="btn btn-muted flex-1 md:flex-none">ล้างตัวกรอง</button>
        </div>
    </div>

    {{-- Activity table --}}
    <div class="w-full overflow-x-auto border border-line rounded-xl">
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
            <tbody id="admin-activity-list"></tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <x-pagination prevId="admin-activity-prev" pageId="admin-activity-page" nextId="admin-activity-next" />
</section>
