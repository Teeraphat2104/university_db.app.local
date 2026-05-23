<!doctype html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', setting('site_name', 'University Activities'))</title>
    <meta name="description" content="{{ setting('site_description', 'ระบบจัดการกิจกรรมและเอกสารของมหาวิทยาลัย') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800;900&family=Noto+Sans+Thai:wght@400;500;600;700&display=swap" rel="stylesheet">
    @php $favicon = setting('favicon'); @endphp
    @if ($favicon)
        <link rel="icon" type="image/png" href="{{ Storage::disk('public')->url($favicon) }}">
    @else
        <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    @endif
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/air-datepicker@3/air-datepicker.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        :root { --primary-color: {{ setting('primary_color', '#6366F1') }}; }
        .toast { position:fixed; bottom:24px; right:24px; max-width:360px; padding:.875rem 1.125rem; border-radius:12px; font-size:.875rem; font-weight:500; z-index:9999; box-shadow:0 20px 40px rgba(0,0,0,.10); animation:toast-in .22s ease; display:flex; align-items:center; gap:.75rem; color:#fff; }
        .toast.info { background:var(--primary-color); }
        .toast.success { background:#10B981; }
        .toast.error { background:#EF4444; }
        @keyframes toast-in { from{opacity:0;transform:translateY(10px) scale(.96);} to{opacity:1;transform:translateY(0) scale(1);} }
    </style>
    @yield('style')
</head>
<body>
    @include('layouts.header')
    @include('layouts.nav')
    @yield('content')

    <script src="https://cdn.jsdelivr.net/npm/air-datepicker@3/air-datepicker.js"></script>
    @yield('script')
</body>
</html>
