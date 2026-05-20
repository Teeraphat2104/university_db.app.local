@php $logo = setting('logo'); $siteName = setting('site_name', 'University Activities'); @endphp
<header class="nav-bar">
    <div class="nav-inner">
        <a href="/" class="nav-brand">
            <span class="nav-brand-icon">
                @if ($logo)
                    <img src="{{ Storage::disk('public')->url($logo) }}" alt="{{ $siteName }}" class="w-6 h-6 object-contain">
                @else
                    <i class="fa-solid fa-book"></i>
                @endif
            </span>
            <div class="nav-brand-text">
                <strong>{{ $siteName }}</strong>
                <span>University Activities</span>
            </div>
        </a>

        <nav class="nav-links">
            <a href="/activities" class="nav-link">กิจกรรม</a>
            <a href="/#about" class="nav-link">เกี่ยวกับ</a>
            <a href="/login" class="btn btn-primary btn-sm">
                <i class="fa-solid fa-user-tie"></i>
                สำหรับแอดมิน
            </a>
        </nav>
    </div>
</header>
