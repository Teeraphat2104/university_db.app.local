{{-- Reusable pagination component --}}
@props(['prevId', 'pageId', 'nextId'])

<div class="flex justify-end items-center gap-2 mt-4 max-md:justify-start">
    <button id="{{ $prevId }}" type="button" class="btn btn-muted">ก่อนหน้า</button>
    <span id="{{ $pageId }}" class="text-sm text-muted">หน้า 1 / 1</span>
    <button id="{{ $nextId }}" type="button" class="btn btn-muted">ถัดไป</button>
</div>
