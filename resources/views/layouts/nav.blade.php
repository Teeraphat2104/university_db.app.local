@php $logo = setting('logo'); $siteName = setting('site_name', 'University'); @endphp
<nav class="position-fixed top-0 start-0 end-0 z-3" style="background:rgba(255,255,255,.8);backdrop-filter:blur(20px);-webkit-backdrop-filter:blur(20px);border-bottom:1px solid #e5e7eb;">
    <div class="mx-auto px-4 d-flex align-items-center justify-content-between" style="max-width:1200px;height:64px;">
        <a href="/" class="d-flex align-items-center gap-3 text-decoration-none">
            @if ($logo)
                <img src="{{ Storage::disk('public')->url($logo) }}" alt="{{ $siteName }}" style="height:36px;width:auto;">
            @else
                <div class="d-flex align-items-center justify-content-center text-white fw-bold shadow-sm" style="width:36px;height:36px;background:linear-gradient(135deg,#6366F1,#8B5CF6);border-radius:8px;">
                    U
                </div>
            @endif
            <div>
                <div class="text-dark fw-bolder small" style="line-height:1.25;">{{ $siteName }}</div>
                <div class="fw-semibold text-uppercase" style="font-size:10px;letter-spacing:.1em;color:#9ca3af;">Activities</div>
            </div>
        </a>
        <div class="d-flex align-items-center gap-2">
            <a href="/activities"
                class="text-decoration-none px-3 py-2 d-inline-flex align-items-center gap-2 small fw-semibold"
                style="color:#4b5563;border-radius:12px;transition:all .15s;"
                onmouseover="this.style.color='#6366F1';this.style.background='rgba(99,102,241,.06)'"
                onmouseout="this.style.color='#4b5563';this.style.background='transparent'">
                <i class="fa-regular fa-magnifying-glass"></i>
                ค้นหา
            </a>
            <a href="/activities"
                class="text-decoration-none px-3 py-2 d-inline-flex align-items-center gap-2 small fw-semibold"
                style="color:#4b5563;border-radius:12px;transition:all .15s;"
                onmouseover="this.style.color='#6366F1';this.style.background='rgba(99,102,241,.06)'"
                onmouseout="this.style.color='#4b5563';this.style.background='transparent'">
                <i class="fa-regular fa-calendar"></i>
                กิจกรรม
            </a>
            <a href="/login"
                class="text-decoration-none px-3 py-2 d-inline-flex align-items-center gap-2 small fw-semibold"
                style="color:#4b5563;border-radius:12px;transition:all .15s;"
                onmouseover="this.style.color='#6366F1';this.style.background='rgba(99,102,241,.06)'"
                onmouseout="this.style.color='#4b5563';this.style.background='transparent'">
                <i class="fa-solid fa-user-tie"></i>
                ผู้ดูแล
            </a>
        </div>
    </div>
</nav>
