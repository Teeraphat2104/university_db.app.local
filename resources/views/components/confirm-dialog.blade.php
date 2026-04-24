<dialog id="confirm-dialog" class="modal-sm">
    <div style="background:#fff;border-radius:var(--radius-2xl)">
        <div class="dialog-body">
            <div style="display:flex;align-items:flex-start;gap:1rem;margin-bottom:1.5rem">
                <span style="width:42px;height:42px;border-radius:var(--radius-full);background:var(--color-danger-bg);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                    <i class="fa-solid fa-triangle-exclamation" style="color:var(--color-danger)"></i>
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
