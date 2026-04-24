<dialog id="media-preview-dialog">
    <div class="media-preview-header">
        <p class="media-preview-title" id="media-preview-title">
            {{-- icon + text injected by JS --}}
        </p>
        <button id="media-preview-close" type="button" class="media-preview-close" aria-label="ปิด">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    <div class="media-preview-body">
        <img id="media-preview-img" class="hidden" src="" alt="Preview">
        <iframe id="media-preview-pdf" class="hidden" src="" title="PDF Preview" allowfullscreen></iframe>
    </div>
</dialog>
