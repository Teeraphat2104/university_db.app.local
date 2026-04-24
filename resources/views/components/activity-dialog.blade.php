<dialog id="activity-dialog" class="activity-dialog">
    <article style="background:#fff;border-radius:var(--radius-2xl)">
        <div class="dialog-header">
            <h3 id="dialog-title" style="padding-right:.5rem;line-height:1.35"></h3>
            <button id="dialog-close" type="button" class="btn btn-ghost btn-sm" style="width:32px;height:32px;padding:0;flex-shrink:0;border-radius:var(--radius-md)">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="dialog-body">
            <p id="dialog-meta" style="font-size:.82rem;color:var(--color-gray-400);margin:0 0 1rem"></p>
            <img id="dialog-image" class="hidden" alt=""
                style="width:100%;border-radius:var(--radius-xl);max-height:260px;object-fit:cover;margin-bottom:1rem">
            <p id="dialog-description" style="margin:0;line-height:1.75;color:var(--color-gray-700);font-size:.9rem"></p>
        </div>

        <div class="dialog-footer">
            <a id="dialog-open-pdf" class="btn btn-muted btn-sm hidden" target="_blank" rel="noopener">
                <i class="fa-solid fa-eye"></i>
                เปิด PDF
            </a>
            <a id="dialog-download-pdf" class="btn btn-primary btn-sm hidden" target="_blank" rel="noopener" download>
                <i class="fa-solid fa-download"></i>
                ดาวน์โหลด PDF
            </a>
        </div>
    </article>
</dialog>
