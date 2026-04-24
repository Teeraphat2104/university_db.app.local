<div class="login-card">
    {{-- Logo --}}
    <div class="login-card-brand">
        <span class="login-card-icon">
            <i class="fa-solid fa-book-open" style="font-size: 1.25rem;"></i>
        </span>
        <div>
            <strong class="login-card-app-name">Activities Portal</strong>
            <span class="login-card-app-sub">University Admin</span>
        </div>
    </div>

    <h2 class="login-card-title">เข้าสู่ระบบ</h2>
    <p class="login-card-desc">จัดการกิจกรรมและเอกสารของมหาวิทยาลัย</p>

    <form id="admin-login-form">
        <label class="login-field">
            <span class="field-label">อีเมล</span>
            <div class="login-input-wrap">
                <i class="login-input-icon fa-solid fa-envelope"></i>
                <input id="admin-email" name="email" type="email" required autocomplete="email"
                    placeholder="admin@example.com" value="admin@example.com" style="padding-left:2.25rem">
            </div>
        </label>

        <label class="login-field">
            <span class="field-label">รหัสผ่าน</span>
            <div class="login-input-wrap">
                <i class="login-input-icon fa-solid fa-lock"></i>
                <input id="admin-password" name="password" type="password" required autocomplete="current-password"
                    placeholder="••••••••" value="password" style="padding-left:2.25rem">
            </div>
        </label>

        <button type="submit" class="btn btn-primary btn-lg" style="width:100%;margin-top:.25rem">
            เข้าสู่ระบบ
        </button>
    </form>

    <p class="login-card-hint">
        Demo: <code>admin@example.com</code> / <code>password</code>
    </p>

    <div style="margin-top:1.25rem;text-align:center">
        <button type="button" class="btn btn-ghost btn-sm mode-btn" data-mode="public"
            style="color:var(--color-gray-400);font-size:.82rem">
            <i class="fa-solid fa-chevron-left"></i>
            กลับหน้าหลัก
        </button>
    </div>
</div>
