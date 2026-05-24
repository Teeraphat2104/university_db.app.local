@php $logo = setting('logo'); $siteName = setting('site_name', 'University Activities'); @endphp
<header class="public-nav position-fixed top-0 start-0 end-0" style="z-index:40">
    <div class="mx-auto px-4 d-flex align-items-center justify-content-between" style="max-width:1200px;height:64px;">
        <a href="/" class="d-flex align-items-center gap-3 text-decoration-none">
            @if ($logo)
                <img src="{{ Storage::disk('public')->url($logo) }}" alt="{{ $siteName }}" style="height:36px;width:auto;">
            @else
                <div class="d-flex align-items-center justify-content-center text-white fw-bold shadow-sm" style="width:36px;height:36px;background:linear-gradient(135deg,#696cff,#8B5CF6);border-radius:8px;">
                    U
                </div>
            @endif
            <div>
                <div class="text-dark fw-bolder small" style="line-height:1.25;">{{ $siteName }}</div>
                <div class="fw-semibold text-uppercase" style="font-size:10px;letter-spacing:.1em;color:#9ca3af;">Activities</div>
            </div>
        </a>
        <nav class="d-flex align-items-center gap-2">
            <a href="/activities" class="nav-link px-3 py-2 small fw-semibold text-decoration-none rounded" style="color:#4b5563;">
                <i class="bx bx-search me-1"></i>ค้นหา
            </a>
            <a href="/activities" class="nav-link px-3 py-2 small fw-semibold text-decoration-none rounded" style="color:#4b5563;">
                <i class="bx bx-calendar me-1"></i>กิจกรรม
            </a>
            <a href="/login" class="btn btn-primary btn-sm d-inline-flex align-items-center gap-1" style="padding:.5rem 1rem;">
                <i class="bx bx-user-tie"></i>ผู้ดูแล
            </a>
        </nav>
    </div>
</header>
