{{-- Admin: Category manager (table only — form is in dialog) --}}
<section class="bg-white border border-line/75 rounded-2xl shadow-card p-5 mb-3.5">
    <x-section-head
        title="จัดการหมวดหมู่"
        description="เพิ่ม แก้ไข และลบหมวดหมู่กิจกรรม"
        tag="h3"
    >
        <button id="category-add-btn" type="button" class="btn btn-primary shrink-0">+ เพิ่มหมวดหมู่</button>
    </x-section-head>

    {{-- Category table --}}
    <div class="w-full overflow-x-auto border border-line rounded-xl">
        <table>
            <thead>
                <tr>
                    <th class="w-[52px]">รูป</th>
                    <th>ชื่อหมวดหมู่</th>
                    <th>สถานะ</th>
                    <th>จัดการ</th>
                </tr>
            </thead>
            <tbody id="admin-category-list"></tbody>
        </table>
    </div>
</section>
