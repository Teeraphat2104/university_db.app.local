<dialog id="media-preview-dialog">
    <div class="media-preview-header">
        <p class="media-preview-title" id="media-preview-title">
            {{-- icon + text injected by JS --}}
        </p>
        <button id="media-preview-close" type="button" class="media-preview-close" aria-label="ปิด">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
        </button>
    </div>
    <div class="media-preview-body">
        <img id="media-preview-img" class="hidden" src="" alt="Preview">
        <iframe id="media-preview-pdf" class="hidden" src="" title="PDF Preview" allowfullscreen></iframe>
    </div>
</dialog>
