<dialog id="confirm-dialog" class="modal-sm">
    <div style="background:#fff;border-radius:var(--radius-2xl)">
        <div class="dialog-body">
            <div style="display:flex;align-items:flex-start;gap:1rem;margin-bottom:1.5rem">
                <span style="width:42px;height:42px;border-radius:var(--radius-full);background:var(--color-danger-bg);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--color-danger)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                        <line x1="12" y1="9" x2="12" y2="13"/>
                        <line x1="12" y1="17" x2="12.01" y2="17"/>
                    </svg>
                </span>
                <div>
                    <h3 id="confirm-title" style="margin:0 0 .375rem;font-size:1rem;font-weight:700;color:var(--color-gray-900)">ยืนยันการดำเนินการ</h3>
                    <p id="confirm-message" style="margin:0;font-size:.85rem;color:var(--color-gray-500);line-height:1.6"></p>
                </div>
            </div>
            <div style="display:flex;justify-content:flex-end;gap:.625rem">
                <button id="confirm-cancel" type="button" class="btn btn-muted btn-sm">ยกเลิก</button>
                <button id="confirm-ok" type="button" class="btn btn-danger btn-sm">ยืนยันลบ</button>
            </div>
        </div>
    </div>
</dialog>
