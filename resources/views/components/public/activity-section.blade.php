{{-- Public: Category browsing + Activity list section --}}
<section id="public-view" class="bg-white border border-line/75 rounded-2xl shadow-card p-5 md:p-6">

    {{-- ═══ Category browsing view ═══ --}}
    <div id="public-categories-view">
        <x-section-head
            title="หมวดหมู่กิจกรรม"
            description="เลือกหมวดหมู่เพื่อดูกิจกรรมที่สนใจ"
        />

        <div id="public-category-grid" class="grid grid-cols-[repeat(auto-fill,minmax(240px,1fr))] gap-4">
            <p class="text-muted text-sm col-span-full">กำลังโหลดหมวดหมู่...</p>
        </div>
    </div>

    {{-- ═══ Activity list view (shown after clicking a category) ═══ --}}
    <div id="public-activities-view" class="hidden">
        {{-- Title + Back button --}}
        <div class="flex items-start md:items-center justify-between gap-4 mb-4">
            <div>
                <h2 id="public-activities-title" class="m-0 font-display text-[clamp(1.1rem,1.9vw,1.3rem)] font-bold"></h2>
                <p id="public-activities-subtitle" class="m-0 text-muted text-[0.94rem]"></p>
            </div>
            <button id="public-back-to-categories" type="button" class="btn btn-muted text-sm whitespace-nowrap">
                กลับหมวดหมู่
            </button>
        </div>

        {{-- Filters --}}
        <div class="grid gap-2.5 md:flex md:flex-wrap md:items-end md:gap-3 mb-4">
            <label class="grid gap-1.5 min-w-0 md:min-w-[180px] md:flex-1 md:basis-[280px]" for="public-keyword">
                <span class="text-[13px] text-muted">ค้นหาชื่อกิจกรรม</span>
                <input id="public-keyword" type="text" placeholder="พิมพ์คำค้นหา...">
            </label>
            <div class="flex flex-wrap items-center gap-2 w-full md:w-auto md:inline-flex">
                <button id="public-search" type="button" class="btn btn-primary flex-1 md:flex-none">ค้นหา</button>
                <button id="public-reset" type="button" class="btn btn-muted flex-1 md:flex-none">ล้างตัวกรอง</button>
            </div>
        </div>

        {{-- Summary --}}
        <p id="public-summary" class="my-1 mb-4 text-muted text-sm">กำลังโหลดรายการกิจกรรม...</p>

        {{-- Activity grid (rendered by JS) --}}
        <div id="public-activity-grid" class="grid grid-cols-[repeat(auto-fill,minmax(258px,1fr))] gap-3.5"></div>

        {{-- Pagination --}}
        <x-pagination prevId="public-prev" pageId="public-page" nextId="public-next" />
    </div>
</section>
