{{-- Admin: Login card --}}
<div id="admin-auth-card" class="bg-white border border-line/75 rounded-2xl shadow-card p-5 max-w-[520px]">
    <x-section-head
        title="เข้าสู่ระบบแอดมิน"
        description="จัดการหมวดหมู่และกิจกรรม พร้อมอัปโหลดรูปปกและไฟล์ PDF"
    />

    <form id="admin-login-form" class="grid gap-3">
        <label class="grid gap-1.5" for="admin-email">
            <span class="text-[13px] text-muted">อีเมล</span>
            <input id="admin-email" name="email" type="email" required autocomplete="email" placeholder="admin@example.com">
        </label>
        <label class="grid gap-1.5" for="admin-password">
            <span class="text-[13px] text-muted">รหัสผ่าน</span>
            <input id="admin-password" name="password" type="password" required autocomplete="current-password" placeholder="••••••••">
        </label>
        <button type="submit" class="btn btn-primary">เข้าสู่ระบบ</button>
    </form>

    <p class="mt-3 text-muted text-[0.84rem]">บัญชีตัวอย่างจาก seeder: <code class="text-gray-800 text-[0.84rem]">admin@example.com / password</code></p>
</div>
