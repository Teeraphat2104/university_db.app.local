{{-- Topbar: Brand identity + mode switch --}}
<header class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 p-5 bg-white border border-line/75 rounded-2xl shadow-card mb-4">
    {{-- Brand --}}
    <div class="flex items-center gap-3.5">
        <span class="w-3.5 h-3.5 rounded-full bg-gradient-to-b from-primary to-[#14998f] shadow-[0_0_0_8px_rgba(15,118,110,0.12)]" aria-hidden="true"></span>
        <div>
            <p class="m-0 text-[13px] uppercase tracking-[0.08em] text-muted font-display">University Activities</p>
            <h1 class="mt-1 m-0 text-[clamp(1.05rem,1.8vw,1.35rem)] font-bold">ระบบกิจกรรมและเอกสาร</h1>
        </div>
    </div>

    {{-- Mode switch --}}
    <nav class="inline-flex gap-2 p-1.5 rounded-full border border-line bg-[#f7f9fc] w-full md:w-auto" aria-label="โหมดการใช้งาน">
        <button type="button" class="mode-btn is-active flex-1 md:flex-none border-0 rounded-full bg-transparent text-muted py-2 px-3.5 font-sans text-sm cursor-pointer text-center transition-colors" data-mode="public">ผู้ใช้ทั่วไป</button>
        <button type="button" class="mode-btn flex-1 md:flex-none border-0 rounded-full bg-transparent text-muted py-2 px-3.5 font-sans text-sm cursor-pointer text-center transition-colors" data-mode="admin">แอดมิน</button>
    </nav>
</header>
