@php $logo = setting('logo'); $siteName = setting('site_name', 'University'); @endphp
<nav class="fixed top-0 left-0 right-0 z-50 bg-white/80 backdrop-blur-xl border-b border-gray-100">
    <div class="max-w-6xl mx-auto px-6 h-16 flex items-center justify-between">
        <a href="/" class="flex items-center gap-3 no-underline">
            @if ($logo)
                <img src="{{ Storage::disk('public')->url($logo) }}" alt="{{ $siteName }}" class="h-9 w-auto">
            @else
                <div class="w-9 h-9 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-lg flex items-center justify-center text-white font-bold shadow-md shadow-indigo-200">
                    U
                </div>
            @endif
            <div>
                <div class="text-sm font-extrabold text-gray-900 leading-tight">{{ $siteName }}</div>
                <div class="text-[10px] font-semibold text-gray-400 tracking-widest uppercase">Activities</div>
            </div>
        </a>
        <div class="flex items-center gap-2">
            <a href="/activities"
                class="items-center gap-2 px-4 py-2 text-sm font-semibold text-gray-600 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition-all no-underline">
                <i class="fa-regular fa-magnifying-glass"></i>
                ค้นหา
            </a>
            <a href="/activities"
                class="items-center gap-2 px-4 py-2 text-sm font-semibold text-gray-600 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition-all no-underline">
                <i class="fa-regular fa-calendar"></i>
                กิจกรรม
            </a>
            <a href="/login"
                class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-gray-600 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition-all no-underline">
                <i class="fa-solid fa-user-tie"></i>
                ผู้ดูแล
            </a>
        </div>
    </div>
</nav>
