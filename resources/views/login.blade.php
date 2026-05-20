@extends('layouts.master')

@section('title', 'เข้าสู่ระบบ - ผู้ดูแลระบบ')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-950 via-indigo-950 to-gray-950 p-6">
    <div class="w-full max-w-sm bg-white rounded-3xl shadow-2xl p-8 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-indigo-500/20 to-purple-500/20 rounded-full -translate-y-1/2 translate-x-1/2"></div>
        <div class="absolute bottom-0 left-0 w-24 h-24 bg-gradient-to-br from-purple-500/10 to-indigo-500/10 rounded-full translate-y-1/2 -translate-x-1/2"></div>

        <div class="relative">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg shadow-indigo-500/30"> <i class="fa-solid fa-user-tie text-white text-lg"></i> </div>
                <div>
                    <div class="text-sm font-extrabold text-gray-900">ผู้ดูแลระบบ</div>
                    <div class="text-[10px] font-semibold text-gray-400 tracking-widest uppercase">เข้าสู่ระบบ</div>
                </div>
            </div>
            <h2 class="text-xl font-extrabold text-gray-900 mb-1">ยินดีต้อนรับ</h2>
            <p class="text-sm text-gray-500 mb-6">เข้าสู่ระบบเพื่อจัดการกิจกรรม</p>

            <div id="login-error" class="hidden mb-4 p-3 bg-red-50 border border-red-200 rounded-xl">
                <p class="text-sm text-red-600 flex items-center gap-2"><i class="fa-solid fa-circle-exclamation"></i> <span id="error-message"></span></p>
            </div>

            <form id="admin-login-form" class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1.5">อีเมล</label>
                    <div class="relative">
                        <i class="fa-regular fa-envelope absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                        <input type="email" id="admin-email" name="email" required placeholder="admin@example.com" class="w-full pl-10 pr-3.5 py-2.5 text-sm border border-gray-200 rounded-xl focus:border-indigo-400 focus:ring-3 focus:ring-indigo-100 outline-none transition-all">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1.5">รหัสผ่าน</label>
                    <div class="relative">
                        <i class="fa-solid fa-lock absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                        <input type="password" id="admin-password" name="password" required placeholder="••••••••" class="w-full pl-10 pr-3.5 py-2.5 text-sm border border-gray-200 rounded-xl focus:border-indigo-400 focus:ring-3 focus:ring-indigo-100 outline-none transition-all">
                    </div>
                </div>
                <button type="submit" class="w-full py-3 text-sm font-bold text-white bg-gradient-to-r from-indigo-500 to-purple-500 rounded-xl shadow-lg shadow-indigo-500/30 hover:shadow-xl hover:shadow-indigo-500/40 hover:-translate-y-0.5 transition-all border-none cursor-pointer flex items-center justify-center gap-2">
                    <span id="btn-text">เข้าสู่ระบบ</span>
                    <div id="btn-loader" class="hidden"><i class="fa-solid fa-circle-notch fa-spin"></i></div>
                </button>
            </form>
            <div class="mt-6 p-4 bg-gray-50 rounded-xl border border-gray-100">
                <p class="text-xs text-gray-500 text-center mb-2">ข้อมูลสำหรับทดสอบ</p>
                <div class="flex items-center justify-center gap-3 text-xs">
                    <code class="text-gray-600 bg-white px-2 py-1 rounded border">admin@example.com</code>
                    <i class="fa-solid fa-arrow-right text-gray-400"></i>
                    <code class="text-gray-600 bg-white px-2 py-1 rounded border">password</code>
                </div>
            </div>
            <a href="/" class="mt-5 w-full inline-flex items-center justify-center gap-2 text-sm text-gray-500 hover:text-indigo-600 transition-colors text-center no-underline">
                <i class="fa-solid fa-arrow-left"></i> กลับหน้าหลัก
            </a>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
$('#admin-login-form').on('submit', function (e) {
    e.preventDefault();
    var btn = $(this).find('button[type=submit]');
    var btnText = $('#btn-text');
    var btnLoader = $('#btn-loader');
    var errorDiv = $('#login-error');
    var errorMsg = $('#error-message');

    btn.prop('disabled', true);
    btnText.addClass('hidden');
    btnLoader.removeClass('hidden');
    errorDiv.addClass('hidden');

    $.ajax({
        url: '/api/admin/login',
        method: 'POST',
        data: {
            email: $('#admin-email').val(),
            password: $('#admin-password').val()
        },
        success: function (json) {
            if (json.data?.token) {
                localStorage.setItem('admin_token', json.data.token);
                window.location.href = '/admin';
            } else {
                showError('เข้าสู่ระบบไม่สำเร็จ');
            }
        },
        error: function (xhr) {
            var msg = 'เกิดข้อผิดพลาด';
            try {
                var json = JSON.parse(xhr.responseText);
                msg = json.message || msg;
            } catch (e) {}
            showError(msg);
        }
    });

    function showError(msg) {
        errorMsg.text(msg);
        errorDiv.removeClass('hidden');
        btn.prop('disabled', false);
        btnText.removeClass('hidden');
        btnLoader.addClass('hidden');
    }
});
</script>
@endsection
