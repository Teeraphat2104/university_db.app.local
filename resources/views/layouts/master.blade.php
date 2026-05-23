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
    <style>:root { --primary-color: {{ setting('primary_color', '#6366F1') }}; }</style>
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
