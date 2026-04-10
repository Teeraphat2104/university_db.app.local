{{-- Confirmation dialog (replaces window.confirm) --}}
<dialog id="confirm-dialog" class="modal w-[420px]">
    <div class="bg-white p-6 rounded-2xl">
        <div class="flex items-start gap-3.5 mb-5">
            {{-- Warning icon --}}
            <div class="shrink-0 w-10 h-10 rounded-full bg-danger-bg flex items-center justify-center">
                <svg class="w-5 h-5 text-danger" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                </svg>
            </div>
            <div>
                <h3 id="confirm-title" class="m-0 text-lg font-semibold">ยืนยันการดำเนินการ</h3>
                <p id="confirm-message" class="m-0 mt-1.5 text-muted text-sm leading-relaxed"></p>
            </div>
        </div>
        <div class="flex justify-end gap-2">
            <button id="confirm-cancel" type="button" class="btn btn-muted">ยกเลิก</button>
            <button id="confirm-ok" type="button" class="btn btn-danger">ยืนยันลบ</button>
        </div>
    </div>
</dialog>
