<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', setting('site_name', 'University Activities'))</title>
    <meta name="description" content="{{ setting('site_description', 'ระบบจัดการกิจกรรมและเอกสารของมหาวิทยาลัย') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Noto+Sans+Thai:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('sneat-1.0.0/assets/vendor/fonts/boxicons.css') }}">
    <link rel="stylesheet" href="{{ asset('sneat-1.0.0/assets/vendor/css/core.css') }}">
    <link rel="stylesheet" href="{{ asset('sneat-1.0.0/assets/vendor/css/theme-default.css') }}">
    <link rel="stylesheet" href="{{ asset('sneat-1.0.0/assets/css/demo.css') }}">
    <link rel="stylesheet" href="{{ asset('sneat-1.0.0/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}">
    @php $favicon = setting('favicon'); @endphp
    @if ($favicon)
        <link rel="icon" type="image/png" href="{{ Storage::disk('public')->url($favicon) }}">
    @else
        <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    @endif
    <style>
        body { font-family: 'Public Sans', 'Noto Sans Thai', sans-serif; }
        :root { --primary-color: {{ setting('primary_color', '#696cff') }}; }
        .toast {
            position: fixed; bottom: 24px; right: 24px; max-width: 360px;
            padding: .875rem 1.125rem; border-radius: 12px; font-size: .875rem;
            font-weight: 500; z-index: 9999; box-shadow: 0 20px 40px rgba(0,0,0,.10);
            animation: toast-in .22s ease; display: flex; align-items: center;
            gap: .75rem; color: #fff;
        }
        .toast.info { background: #696cff; }
        .toast.success { background: #10B981; }
        .toast.error { background: #EF4444; }
        @keyframes toast-in {
            from { opacity: 0; transform: translateY(10px) scale(.96); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }
        .site-header {
            position: fixed; top: 0; left: 0; right: 0; z-index: 40;
            background: rgba(255,255,255,.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(0,0,0,.06);
        }
        .site-header-inner {
            max-width: 1200px; margin: 0 auto; padding: 0 1.25rem;
            display: flex; align-items: center; justify-content: space-between;
            height: 64px;
        }
        .site-logo {
            display: flex; align-items: center; gap: .75rem;
            text-decoration: none;
        }
        .site-logo-img { height: 36px; width: auto; }
        .site-logo-fallback {
            display: flex; align-items: center; justify-content: center;
            width: 36px; height: 36px; border-radius: 8px;
            background: linear-gradient(135deg,#696cff,#8b5cf6);
            color: #fff; font-weight: 700; font-size: 1rem;
            box-shadow: 0 2px 8px rgba(105,108,255,.25);
        }
        .site-logo-text { font-weight: 700; font-size: .875rem; color: #0f172a; line-height: 1.25; }
        .site-nav { display: flex; align-items: center; gap: .25rem; }
        .site-nav-link {
            display: inline-flex; align-items: center; gap: .375rem;
            padding: .5rem .875rem; font-size: .8125rem; font-weight: 600;
            color: #64748b; text-decoration: none; border-radius: 8px;
            transition: all .15s ease;
        }
        .site-nav-link:hover { color: #1e293b; background: #f1f5f9; }
        .site-nav-link i { font-size: 1rem; }
        .site-nav-btn {
            display: inline-flex; align-items: center; gap: .375rem;
            padding: .5rem 1rem; font-size: .8125rem; font-weight: 600;
            color: #fff; background: #696cff; border: none; border-radius: 50rem;
            text-decoration: none; transition: all .15s ease;
        }
        .site-nav-btn:hover { background: #5f5fdb; box-shadow: 0 4px 12px rgba(105,108,255,.35); }
        .public-hero {
            background: linear-gradient(145deg,#0f172a 0%,#1e1b4b 55%,#0f172a 100%);
            position: relative; overflow: hidden;
        }
        .public-hero::before {
            content: '';
            position: absolute; inset: 0;
            background-image:
                radial-gradient(ellipse at 15% 50%,rgba(105,108,255,.25) 0%,transparent 60%),
                radial-gradient(ellipse at 80% 50%,rgba(139,92,246,.15) 0%,transparent 55%);
            pointer-events: none;
        }
        .hero-orb {
            position: absolute; border-radius: 50%; filter: blur(80px);
            animation: hero-float 20s ease-in-out infinite; pointer-events: none;
        }
        .hero-orb-1 { width: 400px; height: 400px; background: radial-gradient(circle,rgba(105,108,255,.12) 0%,transparent 70%); top: -10%; left: -5%; }
        .hero-orb-2 { width: 300px; height: 300px; background: radial-gradient(circle,rgba(139,92,246,.10) 0%,transparent 70%); bottom: 0; right: -3%; animation-delay: -7s; }
        @keyframes hero-float {
            0%,100% { transform: translateY(0) scale(1); }
            33% { transform: translateY(-25px) scale(1.05); }
            66% { transform: translateY(15px) scale(.95); }
        }
        .fade-up { animation: fadeUp .6s ease-out backwards; }
        .fade-up-1 { animation: fadeUp .6s ease-out .1s backwards; }
        .fade-up-2 { animation: fadeUp .6s ease-out .2s backwards; }
        .fade-up-3 { animation: fadeUp .6s ease-out .3s backwards; }
        .fade-up-4 { animation: fadeUp .6s ease-out .4s backwards; }
        .fade-up-5 { animation: fadeUp .6s ease-out .5s backwards; }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .act-card {
            transition: all .2s ease; border: 1px solid #e5e7eb;
            border-radius: 1rem; background: #fff;
        }
        .act-card:hover {
            box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04);
            transform: translateY(-4px);
        }
        .detail-back-btn {
            display: inline-flex; align-items: center; gap: .375rem;
            padding: .375rem .875rem; font-size: .8125rem;
            color: #64748b; border: 1px solid #e2e8f0; border-radius: 8px;
            background: #fff; text-decoration: none; font-weight: 600;
            transition: all .15s ease;
        }
        .detail-back-btn:hover { color: #1e293b; border-color: #cbd5e1; background: #f8fafc; }
        .site-footer {
            background: #030712; color: #9ca3af; padding: 3rem 1.5rem;
        }
        .site-footer-inner { max-width: 72rem; margin: 0 auto; }
        .site-footer-top {
            display: flex; flex-wrap: wrap; justify-content: space-between; gap: 1rem;
            padding-bottom: 2rem; border-bottom: 1px solid rgba(255,255,255,.1);
            margin-bottom: 1.5rem;
        }
        .site-footer-brand {
            display: flex; align-items: center; gap: .75rem; margin-bottom: .75rem;
        }
        .site-footer-icon {
            display: flex; align-items: center; justify-content: center;
            width: 2.5rem; height: 2.5rem;
            background: linear-gradient(135deg,#696cff,#a855f7);
            border-radius: .75rem; color: #fff;
            box-shadow: 0 4px 16px rgba(99,102,241,.3);
        }
        .site-footer-name { font-weight: 700; color: #fff; font-size: 1.125rem; }
        .site-footer-desc { font-size: .875rem; max-width: 20rem; line-height: 1.625; }
        .site-footer-nav { display: flex; flex-direction: column; gap: .5rem; font-size: .875rem; }
        .site-footer-nav-title { font-weight: 600; color: #fff; margin-bottom: .25rem; }
        .site-footer-link {
            color: #9ca3af; text-decoration: none; transition: color .15s;
        }
        .site-footer-link:hover { color: #fff; }
        .site-footer-bottom {
            display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 1rem;
        }
        .site-footer-copy { font-size: .75rem; color: #6b7280; }
        .site-footer-heart { font-size: .75rem; color: #4b5563; }
    </style>
    @yield('style')
    <script src="{{ asset('sneat-1.0.0/assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('sneat-1.0.0/assets/js/config.js') }}"></script>
</head>
<body>
    @include('layouts.header')
    @yield('content')

    <script src="{{ asset('sneat-1.0.0/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('sneat-1.0.0/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('sneat-1.0.0/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('sneat-1.0.0/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('sneat-1.0.0/assets/vendor/js/menu.js') }}"></script>
    <script src="{{ asset('sneat-1.0.0/assets/js/main.js') }}"></script>
    @yield('script')
</body>
</html>
