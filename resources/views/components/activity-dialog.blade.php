{{-- Activity detail dialog (managed by JS) --}}
<dialog id="activity-dialog" class="activity-dialog">
    <article class="bg-white p-5 rounded-2xl">
        {{-- Header: Title + Close Button --}}
        <div class="flex justify-between items-start gap-4 mb-2">
            <h3 id="dialog-title" class="m-0 text-lg font-semibold mt-1"></h3>
            <button id="dialog-close" type="button" class="btn btn-muted px-3 py-1.5 flex-shrink-0">✕</button>
        </div>
        
        <p id="dialog-meta" class="text-muted mb-3 text-sm"></p>
        <img id="dialog-image" class="w-full rounded-xl mt-2 mb-3.5 max-h-72 object-cover hidden" alt="">
        <p id="dialog-description" class="m-0 leading-relaxed"></p>

        <div class="inline-flex flex-wrap items-center gap-2 mt-4">
            <a id="dialog-open-pdf" class="btn btn-primary hidden" target="_blank" rel="noopener">เปิด PDF</a>
            <a id="dialog-download-pdf" class="btn btn-muted hidden" target="_blank" rel="noopener" download>ดาวน์โหลด PDF</a>
        </div>
    </article>
</dialog>
