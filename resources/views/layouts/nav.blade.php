@php $logo = setting('logo'); $siteName = setting('site_name', 'University Activities'); @endphp
<header class="site-header">
    <div class="site-header-inner">
        <a href="/" class="site-logo">
            @if ($logo)
                <img src="{{ Storage::disk('public')->url($logo) }}" alt="{{ $siteName }}" class="site-logo-img">
            @else
                <div class="site-logo-fallback">U</div>
            @endif
            <span class="site-logo-text">{{ $siteName }}</span>
        </a>
        <nav class="site-nav">
            <a href="/activities" class="site-nav-link"><i class="bx bx-search"></i>ค้นหา</a>
            <a href="/activities" class="site-nav-link"><i class="bx bx-calendar"></i>กิจกรรม</a>
            <a href="/login" class="site-nav-btn"><i class="bx bx-user-tie"></i>ผู้ดูแล</a>
        </nav>
    </div>
</header>
