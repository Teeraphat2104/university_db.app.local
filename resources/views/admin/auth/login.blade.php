@extends('layouts.public')

@section('title', 'เข้าสู่ระบบผู้ดูแล')

@section('content')
    <section class="hero" style="max-width: 720px; margin: 0 auto;">
        <div class="stack">
            <span class="eyebrow">Admin Access</span>
            <h1>เข้าสู่ระบบผู้ดูแล</h1>
            <p>สำหรับผู้ดูแลระบบที่ต้องการจัดการกิจกรรมนักศึกษา หมวดหมู่ และเอกสารประกอบ</p>
        </div>
    </section>

    <section class="section panel" style="max-width: 720px; margin-left: auto; margin-right: auto;">
        <div id="login-feedback" class="flash" hidden></div>

        <form action="{{ route('admin.login.store') }}" method="POST" id="admin-login-form" class="form-grid" novalidate>
            @csrf

            <div class="field span-4">
                <label for="email">อีเมล</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="admin@example.com" required>
            </div>

            <div class="field span-4">
                <label for="password">รหัสผ่าน</label>
                <input type="password" id="password" name="password" placeholder="********" required>
            </div>

            <div class="field span-4">
                <label style="display: inline-flex; align-items: center; gap: 0.6rem; font-weight: 400;">
                    <input type="checkbox" name="remember" value="1" @checked(old('remember')) style="width: auto;">
                    จดจำการเข้าสู่ระบบ
                </label>
            </div>

            <div class="field span-4">
                <div class="actions" style="margin-top: 0;">
                    <button type="submit" id="login-submit-button">เข้าสู่ระบบ</button>
                    <a href="{{ route('home') }}" class="button secondary">กลับหน้าแรก</a>
                </div>
            </div>
        </form>
    </section>
@endsection

@push('scripts')
    <script>
        $(function () {
            const formSelector = '#admin-login-form';
            const $submitButton = $('#login-submit-button');

            $(formSelector).on('submit', function (event) {
                event.preventDefault();

                AppUi.clearFormErrors(formSelector);
                $submitButton.prop('disabled', true).text('กำลังเข้าสู่ระบบ...');

                $.ajax({
                    url: this.action,
                    method: 'POST',
                    data: $(this).serialize(),
                    headers: {
                        Accept: 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                }).done(function (payload) {
                    window.location.href = payload.data.redirect_url;
                }).fail(function (xhr) {
                    const payload = xhr.responseJSON || {};

                    if (xhr.status === 422) {
                        const messages = AppUi.applyFieldErrors(formSelector, payload.errors || {});
                        AppUi.showFeedback('#login-feedback', 'error', payload.message || 'ไม่สามารถเข้าสู่ระบบได้', messages);
                        return;
                    }

                    AppUi.showFeedback('#login-feedback', 'error', payload.message || 'ไม่สามารถเข้าสู่ระบบได้');
                }).always(function () {
                    $submitButton.prop('disabled', false).text('เข้าสู่ระบบ');
                });
            });
        });
    </script>
@endpush
