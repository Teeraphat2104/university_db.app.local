<dialog id="participant-search-dialog" class="modal">
    <div class="dialog-header">
        <div style="display:flex;align-items:center;gap:.625rem">
            <div style="width:32px;height:32px;border-radius:var(--radius-md);background:#EEF2FF;color:#6366F1;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
            </div>
            <div>
                <h3 style="margin:0;font-size:1rem">ตรวจสอบการเข้าร่วมกิจกรรม</h3>
                <p style="margin:0;font-size:.78rem;color:var(--color-gray-400)">ค้นหาด้วย Student ID หรือ ชื่อ-นามสกุล</p>
            </div>
        </div>
        <button id="participant-search-dialog-close" type="button" class="btn btn-ghost btn-sm"
            style="width:32px;height:32px;padding:0;border-radius:var(--radius-md)">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
        </button>
    </div>

    <div class="dialog-body" style="display:grid;gap:1.25rem">
        {{-- Search input --}}
        <div style="display:flex;gap:.5rem">
            <div style="flex:1;position:relative">
                <svg style="position:absolute;left:.75rem;top:50%;transform:translateY(-50%);color:var(--color-gray-400);pointer-events:none"
                    width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input id="participant-search-input" type="text"
                    placeholder="กรอก Student ID (เช่น 6601234567) หรือ ชื่อ..."
                    style="width:100%;padding-left:2.25rem;box-sizing:border-box">
            </div>
            <button id="participant-search-btn" type="button" class="btn btn-primary btn-sm" style="white-space:nowrap">ค้นหา</button>
        </div>

        {{-- Type hint pills --}}
        <div style="display:flex;gap:.5rem;flex-wrap:wrap">
            <span style="font-size:.75rem;color:var(--color-gray-500)">ตัวอย่าง:</span>
            <button type="button" class="pill" id="ps-hint-id"
                style="cursor:pointer;font-size:.73rem;padding:.2rem .6rem;background:#EEF2FF;color:#4338CA;border:none">
                🔢 6601234567 (Student ID)
            </button>
            <button type="button" class="pill" id="ps-hint-name"
                style="cursor:pointer;font-size:.73rem;padding:.2rem .6rem;background:#F0FDF4;color:#059669;border:none">
                👤 สมชาย (ชื่อ)
            </button>
        </div>

        {{-- Results area --}}
        <div id="participant-search-results">
            <p style="color:var(--color-gray-400);font-size:.875rem;text-align:center;padding:1.5rem 0">
                กรอกข้อมูลแล้วกด "ค้นหา"
            </p>
        </div>
    </div>
</dialog>
