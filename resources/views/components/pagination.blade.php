@props(['prevId', 'pageId', 'nextId'])

<div class="pagination">
    <button id="{{ $prevId }}" type="button" class="btn btn-muted btn-sm">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
        ก่อนหน้า
    </button>
    <span id="{{ $pageId }}" class="pagination-info">หน้า 1 / 1</span>
    <button id="{{ $nextId }}" type="button" class="btn btn-muted btn-sm">
        ถัดไป
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
    </button>
</div>
