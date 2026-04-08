@if ($activities && $activities->hasPages())
    <div class="pager">
        <span class="pager-link {{ $activities->onFirstPage() ? 'disabled' : '' }}">
            @if ($activities->onFirstPage())
                ย้อนกลับ
            @else
                <a href="{{ $activities->previousPageUrl() }}">ย้อนกลับ</a>
            @endif
        </span>

        <span class="muted">หน้า {{ $activities->currentPage() }} จาก {{ $activities->lastPage() }}</span>

        <span class="pager-link {{ $activities->hasMorePages() ? '' : 'disabled' }}">
            @if ($activities->hasMorePages())
                <a href="{{ $activities->nextPageUrl() }}">ถัดไป</a>
            @else
                ถัดไป
            @endif
        </span>
    </div>
@endif
