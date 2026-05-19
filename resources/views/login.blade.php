@extends('layouts.master')

@section('title', 'เข้าสู่ระบบ - ผู้ดูแลระบบ')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-950 p-6">
    <div class="w-full max-w-sm bg-white rounded-3xl shadow-2xl p-8">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-11 h-11 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-xl flex items-center justify-center flex-shrink-0"> <i class="fa-solid fa-user-tie text-white"></i> </div>
            <div>
                <div class="text-sm font-extrabold text-gray-900">ผู้ดูแลระบบ</div>
                <div class="text-[10px] font-semibold text-gray-400 tracking-widest uppercase">Login</div>
            </div>
        </div>
        <h2 class="text-xl font-extrabold text-gray-900 mb-1">เข้าสู่ระบบ</h2>
        <p class="text-sm text-gray-500 mb-6">กรุณาเข้าสู่ระบบด้วยบัญชีผู้ดูแลของคุณ</p>
        <form id="admin-login-form" class="space-y-4">
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1.5">อีเมล</label>
                <input type="email" id="admin-email" name="email" required class="w-full px-3.5 py-2.5 text-sm border border-gray-200 rounded-xl focus:border-indigo-400 focus:ring-3 focus:ring-indigo-100 outline-none transition-all">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1.5">รหัสผ่าน</label>
                <input type="password" id="admin-password" name="password" required class="w-full px-3.5 py-2.5 text-sm border border-gray-200 rounded-xl focus:border-indigo-400 focus:ring-3 focus:ring-indigo-100 outline-none transition-all">
            </div>
            <button type="submit" class="w-full py-2.5 text-sm font-bold text-white bg-gradient-to-r from-indigo-500 to-purple-500 rounded-xl shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all border-none cursor-pointer">เข้าสู่ระบบ</button>
        </form>
        <p class="text-xs text-gray-400 text-center mt-5">
            demo: <code class="text-gray-600 bg-gray-100 px-1.5 py-0.5 rounded text-xs">admin@example.com</code> / <code class="text-gray-600 bg-gray-100 px-1.5 py-0.5 rounded text-xs">password</code>
        </p>
        <a href="/" class="mt-4 w-full inline-flex items-center justify-center gap-2 text-xs text-gray-400 hover:text-gray-600 text-center no-underline">
            <i class="fa-solid fa-arrow-left mr-1"></i> กลับหน้าหลัก
        </a>
    </div>
</div>
@endsection

@section('script')
<script>
$('#admin-login-form').on('submit', function (e) {
    e.preventDefault();
    var btn = $(this).find('button[type=submit]');
    btn.prop('disabled', true).text('กำลังเข้า...');

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
                alert('เข้าสู่ระบบไม่สำเร็จ');
                btn.prop('disabled', false).text('เข้าสู่ระบบ');
            }
        },
        error: function (xhr) {
            var msg = 'เกิดข้อผิดพลาด';
            try {
                var json = JSON.parse(xhr.responseText);
                msg = json.message || msg;
            } catch (e) {}
            alert(msg);
            btn.prop('disabled', false).text('เข้าสู่ระบบ');
        }
    });
});
</script>
@endsection
