<div class="login-card">
    {{-- Logo --}}
    <div class="login-card-brand">
        <span class="login-card-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
            </svg>
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
                <svg class="login-input-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                    <polyline points="22,6 12,13 2,6"/>
                </svg>
                <input id="admin-email" name="email" type="email" required autocomplete="email"
                    placeholder="admin@example.com" value="admin@example.com" style="padding-left:2.25rem">
            </div>
        </label>

        <label class="login-field">
            <span class="field-label">รหัสผ่าน</span>
            <div class="login-input-wrap">
                <svg class="login-input-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                </svg>
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
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="15 18 9 12 15 6"/>
            </svg>
            กลับหน้าหลัก
        </button>
    </div>
</div>
