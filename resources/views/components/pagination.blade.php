@props(['prevId', 'pageId', 'nextId'])

<div class="pagination">
    <button id="{{ $prevId }}" type="button" class="btn btn-muted btn-sm">
        <i class="fa-solid fa-chevron-left"></i>
        ก่อนหน้า
    </button>
    <span id="{{ $pageId }}" class="pagination-info">หน้า 1 / 1</span>
    <button id="{{ $nextId }}" type="button" class="btn btn-muted btn-sm">
        ถัดไป
        <i class="fa-solid fa-chevron-right"></i>
    </button>
</div>
