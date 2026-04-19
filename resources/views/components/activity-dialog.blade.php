<dialog id="activity-dialog" class="activity-dialog">
    <article style="background:#fff;border-radius:var(--radius-2xl)">
        <div class="dialog-header">
            <h3 id="dialog-title" style="padding-right:.5rem;line-height:1.35"></h3>
            <button id="dialog-close" type="button" class="btn btn-ghost btn-sm" style="width:32px;height:32px;padding:0;flex-shrink:0;border-radius:var(--radius-md)">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
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
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                </svg>
                เปิด PDF
            </a>
            <a id="dialog-download-pdf" class="btn btn-primary btn-sm hidden" target="_blank" rel="noopener" download>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                    <polyline points="7 10 12 15 17 10"/>
                    <line x1="12" y1="15" x2="12" y2="3"/>
                </svg>
                ดาวน์โหลด PDF
            </a>
        </div>
    </article>
</dialog>
