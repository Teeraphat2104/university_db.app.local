@extends('layouts.public')

@section('title', 'Admin Login')

@section('content')
    <section class="hero-panel" style="grid-template-columns: minmax(0, 1fr); max-width: 720px; margin: 0 auto 1.5rem;">
        <div class="hero-copy">
            <span class="eyebrow">Admin Access</span>
            <h1>เข้าสู่ระบบผู้ดูแล</h1>
            <p>สำหรับผู้ดูแลระบบในการจัดการกิจกรรมนักศึกษา หมวดหมู่ และเอกสาร PDF</p>
        </div>
    </section>

    <section class="filter-panel" style="max-width: 720px; margin: 0 auto;">
        <form action="{{ route('admin.login.store') }}" method="POST" class="form-grid">
            @csrf
            <div class="field span-4">
                <label for="email">อีเมล</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="admin@example.com" required>
            </div>
            <div class="field span-4">
                <label for="password">รหัสผ่าน</label>
                <input type="password" id="password" name="password" placeholder="********" required>
            </div>
            <div class="field span-4" style="align-items:flex-start;">
                <label style="display:flex;align-items:center;gap:0.6rem;font-weight:600;">
                    <input type="checkbox" name="remember" value="1" @checked(old('remember')) style="width:auto;">
                    จดจำการเข้าสู่ระบบ
                </label>
            </div>
            <div class="field span-4" style="display:flex;justify-content:flex-end;">
                <button type="submit">เข้าสู่ระบบ</button>
            </div>
        </form>
    </section>
@endsection
