@php
    // Check if we're on the /activities page (no category selected)
    $initialView = request()->is('activities') ? 'activities' : 'categories';
@endphp
<div id="public-view-inner" data-initial-view="{{ $initialView }}">

    {{-- Categories view --}}
    <div id="public-categories-view">
        <div class="acts-toolbar">
            <div class="acts-toolbar-info">
                <h2>กิจกรรมทั้งหมด</h2>
                <p>เลือกหมวดหมู่เพื่อดูกิจกรรมที่สนใจ</p>
            </div>
        </div>
        <div id="public-category-grid" class="cat-grid">
            <p style="color:var(--color-gray-400);font-size:.875rem">กำลังโหลด...</p>
        </div>
    </div>

    {{-- Activities view --}}
    <div id="public-activities-view" class="hidden">
        <div class="acts-toolbar">
            <div class="acts-toolbar-info">
                <h2 id="public-activities-title"></h2>
                <p id="public-activities-subtitle"></p>
            </div>
            <div style="display:flex;align-items:center;gap:.75rem;flex-wrap:wrap">
                <div class="acts-search">
                    <input id="public-keyword" type="text" placeholder="ค้นหากิจกรรม..." style="width:200px">
                    <button id="public-search" type="button" class="btn btn-primary btn-sm">ค้นหา</button>
                    <button id="public-reset" type="button" class="btn btn-muted btn-sm">ล้าง</button>
                </div>

                {{-- View toggle --}}
                <div class="view-toggle">
                    <button id="view-card-btn" type="button" class="view-toggle-btn is-active" aria-label="Card view" title="มุมมองการ์ด">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
                            <rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
                        </svg>
                    </button>
                    <button id="view-table-btn" type="button" class="view-toggle-btn" aria-label="Table view" title="มุมมองตาราง">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/>
                            <line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/>
                        </svg>
                    </button>
                </div>

                <button id="public-back-to-categories" type="button" class="btn btn-muted btn-sm">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="15 18 9 12 15 6"/>
                    </svg>
                    กลับ
                </button>
            </div>
        </div>

        <p id="public-summary" style="font-size:.82rem;color:var(--color-gray-400);margin-bottom:1rem">กำลังโหลด...</p>

        {{-- Card view --}}
        <div id="public-activity-grid" class="act-grid"></div>

        {{-- Table view --}}
        <div id="public-activity-table-wrap" class="table-wrap hidden">
            <table>
                <thead>
                    <tr>
                        <th style="width:52px">รูป</th>
                        <th>ชื่อกิจกรรม</th>
                        <th>หมวดหมู่</th>
                        <th>วันที่</th>
                        <th>สถานที่</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="public-activity-table-body"></tbody>
            </table>
        </div>

        <div class="pagination">
            <button id="public-prev" type="button" class="btn btn-muted btn-sm">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                ก่อนหน้า
            </button>
            <span id="public-page" class="pagination-info">หน้า 1 / 1</span>
            <button id="public-next" type="button" class="btn btn-muted btn-sm">
                ถัดไป
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
            </button>
        </div>
    </div>

</div>
