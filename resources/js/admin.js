/**
 * Admin view module.
 * Handles authentication, section switching, overview stats,
 * category/activity CRUD, and image/PDF preview.
 */

import { state, defaultMeta, saveAdminSession, clearAdminSession } from './state';
import { api, buildQuery, resolveAssetUrl, errorToMessage } from './api';
import { el, showToast, showConfirmDialog, escapeHtml, escapeAttr, formatDate } from './ui';

/* ── Section config ── */

const SECTION_META = {
    'admin-section-overview':   { title: 'ภาพรวม',  desc: 'สถิติและข้อมูลสรุปของระบบ' },
    'admin-section-categories': { title: 'หมวดหมู่', desc: 'จัดการหมวดหมู่กิจกรรม' },
    'admin-section-activities': { title: 'กิจกรรม',  desc: 'จัดการกิจกรรมและเอกสาร' },
};

let airDatepicker = null; // Air Datepicker instance

function switchAdminSection(sectionId) {
    document.querySelectorAll('.admin-section').forEach((s) => s.classList.add('hidden'));
    const target = document.getElementById(sectionId);
    if (target) target.classList.remove('hidden');

    document.querySelectorAll('.sidebar-nav-item[data-section]').forEach((btn) => {
        btn.classList.toggle('is-active', btn.dataset.section === sectionId);
    });

    const meta = SECTION_META[sectionId] || SECTION_META['admin-section-overview'];
    const topbarTitle = document.getElementById('admin-topbar-title');
    const topbarDesc  = document.getElementById('admin-topbar-desc');
    if (topbarTitle) topbarTitle.textContent = meta.title;
    if (topbarDesc)  topbarDesc.textContent  = meta.desc;
}

/* ══════════════════════════════════
   Media Preview
   ══════════════════════════════════ */

const IMG_ICON_SVG = `<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>`;
const PDF_ICON_SVG  = `<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>`;

function openMediaPreview(url, type = 'image') {
    const dialog      = document.getElementById('media-preview-dialog');
    const img         = document.getElementById('media-preview-img');
    const iframe      = document.getElementById('media-preview-pdf');
    const titleEl     = document.getElementById('media-preview-title');
    if (!dialog) return;

    if (type === 'image') {
        img.src = url;
        img.classList.remove('hidden');
        iframe.src = '';
        iframe.classList.add('hidden');
        dialog.classList.remove('is-pdf');
        if (titleEl) titleEl.innerHTML = `<span class="media-preview-title-icon img-icon">${IMG_ICON_SVG}</span>ดูตัวอย่างรูปภาพ`;
    } else {
        iframe.src = url;
        iframe.classList.remove('hidden');
        img.src = '';
        img.classList.add('hidden');
        dialog.classList.add('is-pdf');
        if (titleEl) titleEl.innerHTML = `<span class="media-preview-title-icon pdf-icon">${PDF_ICON_SVG}</span>ดูตัวอย่าง PDF`;
    }

    dialog.showModal();
}

function closeMediaPreview() {
    const dialog = document.getElementById('media-preview-dialog');
    if (!dialog) return;
    dialog.close();
    const img    = document.getElementById('media-preview-img');
    const iframe = document.getElementById('media-preview-pdf');
    if (img)    { img.src = '';    img.classList.add('hidden'); }
    if (iframe) { iframe.src = ''; iframe.classList.add('hidden'); }
    dialog.classList.remove('is-pdf');
}

/* ── Inline file preview (inside form dialogs) ── */

function bindFilePreview(inputEl, previewEl, type) {
    inputEl.addEventListener('change', () => {
        const file = inputEl.files[0];
        if (!file) {
            previewEl.innerHTML = '';
            previewEl.classList.add('hidden');
            return;
        }

        if (type === 'image') {
            const reader = new FileReader();
            reader.onload = (e) => {
                const dataUrl = e.target.result;
                previewEl.innerHTML = `
                    <div class="fp-img-wrap">
                        <img src="${escapeAttr(dataUrl)}" alt="Preview">
                        <button type="button" class="fp-img-expand" aria-label="ขยาย">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="15 3 21 3 21 9"/><polyline points="9 21 3 21 3 15"/>
                                <line x1="21" y1="3" x2="14" y2="10"/><line x1="3" y1="21" x2="10" y2="14"/>
                            </svg>
                        </button>
                    </div>
                `;
                previewEl.classList.remove('hidden');
                previewEl.querySelector('.fp-img-expand').addEventListener('click', () => {
                    openMediaPreview(dataUrl, 'image');
                });
            };
            reader.readAsDataURL(file);
        } else {
            const sizeMb = (file.size / 1048576).toFixed(2);
            previewEl.innerHTML = `
                <div class="fp-pdf-wrap">
                    <div class="fp-pdf-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                        </svg>
                    </div>
                    <div class="fp-pdf-info">
                        <p class="fp-pdf-name">${escapeHtml(file.name)}</p>
                        <p class="fp-pdf-size">${sizeMb} MB</p>
                    </div>
                    <button type="button" class="btn btn-muted btn-sm fp-pdf-preview-btn">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                        ดูตัวอย่าง
                    </button>
                </div>
            `;
            previewEl.classList.remove('hidden');

            let objectUrl = null;
            previewEl.querySelector('.fp-pdf-preview-btn').addEventListener('click', () => {
                if (!objectUrl) objectUrl = URL.createObjectURL(file);
                openMediaPreview(objectUrl, 'pdf');
            });
        }
    });
}

/* ── Existing-asset display (edit mode) ── */

function renderExistingImage(containerEl, url, label = 'รูปปกปัจจุบัน') {
    const resolvedUrl = resolveAssetUrl(url);
    containerEl.innerHTML = `
        <span class="fe-label">${escapeHtml(label)}</span>
        <div class="fe-img-thumb" data-preview-url="${escapeAttr(resolvedUrl)}" data-preview-type="image">
            <img src="${escapeAttr(resolvedUrl)}" alt="">
            <div class="fe-img-overlay">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                </svg>
            </div>
        </div>
    `;
    containerEl.classList.remove('hidden');
}

function renderExistingPdf(containerEl, url, existingImageUrl = null) {
    const resolvedUrl = resolveAssetUrl(url);
    const imgPart = existingImageUrl ? '' : '';
    containerEl.innerHTML = (imgPart) + `
        <span class="fe-label">PDF ปัจจุบัน</span>
        <div class="fe-pdf-chip" data-preview-url="${escapeAttr(resolvedUrl)}" data-preview-type="pdf">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                <polyline points="14 2 14 8 20 8"/>
            </svg>
            <span>ดูตัวอย่าง PDF</span>
        </div>
    `;
    containerEl.classList.remove('hidden');
}

/* ── Authentication ── */

export async function ensureAdminSession() {
    if (!state.admin.session?.token) {
        renderAdminLoggedOut();
        return;
    }

    try {
        const response = await api('/admin/profile', { auth: true });
        state.admin.session.admin = response.data;
        saveAdminSession(state.admin.session);
        renderAdminLoggedIn();

        if (!state.admin.bootstrapped) {
            await loadAdminData();
            state.admin.bootstrapped = true;
        }
    } catch {
        clearAdminSession();
        renderAdminLoggedOut();
        showToast('Session หมดอายุ กรุณาเข้าสู่ระบบใหม่', 'error');
    }
}

function renderAdminLoggedOut() {
    el.adminAuthCard.classList.remove('hidden');
    el.adminDashboard.classList.add('hidden');
    el.adminLoginForm.reset();
}

function renderAdminLoggedIn() {
    const profile = state.admin.session?.admin;
    el.adminProfileText.textContent = profile ? profile.name : 'Admin';

    const avatar = document.querySelector('.sidebar-avatar');
    if (avatar && profile?.name) avatar.textContent = profile.name.slice(0, 1).toUpperCase();

    const overviewName = document.getElementById('overview-admin-name');
    if (overviewName && profile?.name) overviewName.textContent = profile.name;

    const overviewDate = document.getElementById('overview-date');
    if (overviewDate) {
        overviewDate.textContent = new Intl.DateTimeFormat('th-TH', {
            weekday: 'long', year: 'numeric', month: 'long', day: 'numeric',
        }).format(new Date());
    }

    el.adminAuthCard.classList.add('hidden');
    el.adminDashboard.classList.remove('hidden');
    switchAdminSection('admin-section-overview');
}

async function loginAdmin() {
    const email    = el.adminEmail.value.trim();
    const password = el.adminPassword.value;

    try {
        const response = await api('/admin/login', { method: 'POST', body: { email, password } });
        state.admin.session = { token: response.data.token, admin: response.data.admin };
        saveAdminSession(state.admin.session);
        state.admin.bootstrapped = false;

        renderAdminLoggedIn();
        await loadAdminData();
        state.admin.bootstrapped = true;

        el.adminLoginForm.reset();
        showToast('เข้าสู่ระบบสำเร็จ', 'success');
    } catch (error) {
        showToast(errorToMessage(error), 'error');
    }
}

async function logoutAdmin() {
    try {
        await api('/admin/logout', { method: 'POST', auth: true });
    } catch { /* ignore */ }

    clearAdminSession();
    renderAdminLoggedOut();
    showToast('ออกจากระบบแล้ว', 'info');
}

/* ── Admin data bootstrap ── */

async function loadAdminData() {
    await loadAdminCategories();
    await loadAdminActivities();
    void loadOverviewStats();
}

/* ── Overview stats ── */

async function loadOverviewStats() {
    try {
        const response = await api('/public/home');
        const stats = response.data?.stats || {};
        const elActive = document.getElementById('overview-active-activities');
        const elDocs   = document.getElementById('overview-total-documents');
        const elPart   = document.getElementById('stat-registered');
        if (elActive) elActive.textContent = stats.total_activities ?? '—';
        if (elDocs)   elDocs.textContent   = stats.total_documents  ?? '—';
        if (elPart)   {
            const total = stats.total_participants || 0;
            animateStatNumber(elPart, total);
        }
    } catch { /* non-critical */ }
}

function animateStatNumber(element, target) {
    const duration = 800;
    const startTime = performance.now();
    function update(t) {
        const progress = Math.min((t - startTime) / duration, 1);
        const easeOut = 1 - Math.pow(1 - progress, 3);
        element.textContent = Math.floor(target * easeOut).toLocaleString('th-TH');
        if (progress < 1) requestAnimationFrame(update);
    }
    requestAnimationFrame(update);
}

function updateOverviewCounts() {
    const elTotal = document.getElementById('overview-total-activities');
    const elCats  = document.getElementById('overview-total-categories');
    if (elTotal) elTotal.textContent = state.admin.meta.total ?? 0;
    if (elCats)  elCats.textContent  = state.admin.categories.length;
    renderOverviewRecentActivities();
}

function renderOverviewRecentActivities() {
    const list = document.getElementById('overview-recent-list');
    if (!list) return;

    const recent = state.admin.activities.slice(0, 5);
    if (!recent.length) {
        list.innerHTML = `<tr><td colspan="5" style="text-align:center;color:var(--color-gray-400);padding:2rem">ยังไม่มีกิจกรรม</td></tr>`;
        return;
    }

    list.innerHTML = recent.map((activity) => {
        const status = Number(activity.status) === 1;
        const thumb  = activity.cover_image_url
            ? `<img class="table-thumb" src="${escapeAttr(resolveAssetUrl(activity.cover_image_url))}" alt="" data-preview-url="${escapeAttr(resolveAssetUrl(activity.cover_image_url))}" data-preview-type="image">`
            : `<div class="table-thumb-ph" style="background:#EEF2FF;color:#6366F1">${escapeHtml((activity.title || '?').slice(0, 1).toUpperCase())}</div>`;

        return `
            <tr>
                <td>
                    <div style="display:flex;align-items:center;gap:.75rem">
                        ${thumb}
                        <span style="font-weight:600;color:var(--color-gray-800)">${escapeHtml(activity.title || '-')}</span>
                    </div>
                </td>
                <td>${escapeHtml(activity.category?.name || '-')}</td>
                <td style="white-space:nowrap">${activity.activity_date ? formatDate(activity.activity_date) : '-'}</td>
                <td><span class="pill ${status ? 'pill-on' : 'pill-off'}">${status ? 'แสดงผล' : 'ปิด'}</span></td>
                <td><button type="button" class="btn btn-muted btn-sm" data-action="edit" data-id="${activity.id}">แก้ไข</button></td>
            </tr>
        `;
    }).join('');
}

/* ══════════════════════════════════
   Categories
   ══════════════════════════════════ */

async function loadAdminCategories() {
    try {
        const response = await api('/admin/categories', { auth: true });
        state.admin.categories = response.data || [];
        renderAdminCategories();
        hydrateCategorySelects();
    } catch (error) {
        showToast(errorToMessage(error), 'error');
    }
}

function renderAdminCategories() {
    const elCatCount = document.getElementById('overview-total-categories');
    if (elCatCount) elCatCount.textContent = state.admin.categories.length;

    if (!state.admin.categories.length) {
        el.categoryList.innerHTML = `<tr><td colspan="5" style="text-align:center;color:var(--color-gray-400);padding:2rem">ยังไม่มีหมวดหมู่</td></tr>`;
        return;
    }

    el.categoryList.innerHTML = state.admin.categories.map((category) => {
        const status = Number(category.status) === 1;
        const thumb  = category.cover_image_url
            ? `<img class="table-thumb" src="${escapeAttr(resolveAssetUrl(category.cover_image_url))}" alt="" data-preview-url="${escapeAttr(resolveAssetUrl(category.cover_image_url))}" data-preview-type="image">`
            : `<div class="table-thumb-ph" style="background:#EEF2FF;color:#6366F1">${escapeHtml(category.name.slice(0, 1).toUpperCase())}</div>`;

        return `
            <tr>
                <td style="width:52px">${thumb}</td>
                <td><span style="font-weight:600;color:var(--color-gray-800)">${escapeHtml(category.name)}</span></td>
                <td><span class="pill ${status ? 'pill-on' : 'pill-off'}">${status ? 'เปิดใช้งาน' : 'ปิดใช้งาน'}</span></td>
                <td style="font-size:.8rem;color:var(--color-gray-500)">${category.created_at ? formatDate(category.created_at) : '-'}</td>
                <td style="white-space:nowrap">
                    <button type="button" class="btn btn-muted btn-sm" data-action="edit"   data-id="${category.id}">แก้ไข</button>
                    <button type="button" class="btn btn-danger btn-sm" data-action="delete" data-id="${category.id}">ลบ</button>
                </td>
            </tr>
        `;
    }).join('');
}

function hydrateCategorySelects() {
    const all = state.admin.categories || [];
    const actSel    = el.activityCategory.value;
    const filterSel = state.admin.filters.category_id || '';

    el.activityCategory.innerHTML = `<option value="">เลือกหมวดหมู่</option>${all.map((c) => `<option value="${c.id}">${escapeHtml(c.name)}</option>`).join('')}`;
    el.activityCategory.value = actSel || '';

    el.adminActivityFilterCategory.innerHTML = `<option value="">ทั้งหมด</option>${all.map((c) => `<option value="${c.id}">${escapeHtml(c.name)}</option>`).join('')}`;
    el.adminActivityFilterCategory.value = filterSel;
}

/* ── Category dialog helpers ── */

function openCategoryDialog(mode = 'add') {
    if (mode === 'add') {
        resetCategoryForm();
        el.categoryFormDialogTitle.textContent = 'เพิ่มหมวดหมู่';
        el.categorySubmit.textContent = 'เพิ่มหมวดหมู่';
    }
    el.categoryFormDialog.showModal();
}

function editCategory(id) {
    const category = state.admin.categories.find((item) => String(item.id) === String(id));
    if (!category) return;

    el.categoryId.value = category.id;
    el.categoryName.value = category.name || '';
    el.categoryStatus.checked = Number(category.status) === 1;

    const previewEl   = document.getElementById('category-cover-preview');
    const existingEl  = document.getElementById('category-existing-cover');

    if (previewEl)  { previewEl.innerHTML = '';  previewEl.classList.add('hidden'); }

    if (existingEl) {
        if (category.cover_image_url) {
            renderExistingImage(existingEl, category.cover_image_url);
        } else {
            existingEl.innerHTML = '';
            existingEl.classList.add('hidden');
        }
    }

    el.categoryFormDialogTitle.textContent = 'แก้ไขหมวดหมู่';
    el.categorySubmit.textContent = 'บันทึกการแก้ไข';
    el.categoryFormDialog.showModal();
    el.categoryName.focus();
}

function resetCategoryForm() {
    el.adminCategoryForm.reset();
    el.categoryId.value = '';
    el.categoryStatus.checked = true;

    const previewEl  = document.getElementById('category-cover-preview');
    const existingEl = document.getElementById('category-existing-cover');
    if (previewEl)  { previewEl.innerHTML = '';  previewEl.classList.add('hidden'); }
    if (existingEl) { existingEl.innerHTML = ''; existingEl.classList.add('hidden'); }
}

async function saveCategory() {
    if (!el.categoryName.value.trim()) {
        showToast('กรุณาระบุชื่อหมวดหมู่', 'error');
        return;
    }

    const id = el.categoryId.value;
    const formData = new FormData();
    formData.set('name',   el.categoryName.value.trim());
    formData.set('status', el.categoryStatus.checked ? '1' : '0');
    if (el.categoryCover.files.length) formData.set('cover_image', el.categoryCover.files[0]);

    try {
        if (id) {
            formData.append('_method', 'PUT');
            await api(`/admin/categories/${id}`, { method: 'POST', auth: true, body: formData });
            showToast('อัปเดตหมวดหมู่แล้ว', 'success');
        } else {
            await api('/admin/categories', { method: 'POST', auth: true, body: formData });
            showToast('เพิ่มหมวดหมู่แล้ว', 'success');
        }
        el.categoryFormDialog.close();
        await loadAdminCategories();
    } catch (error) {
        showToast(errorToMessage(error), 'error');
    }
}

async function deleteCategory(id) {
    const category = state.admin.categories.find((item) => String(item.id) === String(id));
    const confirmed = await showConfirmDialog(
        'ยืนยันการลบหมวดหมู่',
        `ต้องการลบ "${category?.name || 'หมวดหมู่นี้'}" หรือไม่? การดำเนินการนี้ไม่สามารถย้อนกลับได้`
    );
    if (!confirmed) return;

    try {
        await api(`/admin/categories/${id}`, { method: 'DELETE', auth: true });
        await loadAdminCategories();
        showToast('ลบหมวดหมู่แล้ว', 'success');
    } catch (error) {
        showToast(errorToMessage(error), 'error');
    }
}

/* ══════════════════════════════════
   Activities
   ══════════════════════════════════ */

async function loadAdminActivities() {
    try {
        const query = buildQuery(state.admin.filters);
        const response = await api(`/admin/activities${query}`, { auth: true });
        state.admin.activities = response.data || [];
        state.admin.meta = response.meta || { ...defaultMeta, per_page: state.admin.filters.per_page };
        renderAdminActivities();
        updateOverviewCounts();
    } catch (error) {
        showToast(errorToMessage(error), 'error');
    }
}

function renderAdminActivities() {
    const list = state.admin.activities;

    if (!list.length) {
        el.adminActivityList.innerHTML = `<tr><td colspan="6" style="text-align:center;color:var(--color-gray-400);padding:2rem">ยังไม่พบกิจกรรม</td></tr>`;
    } else {
        el.adminActivityList.innerHTML = list.map((activity) => {
            const status = Number(activity.status) === 1;
            const thumb  = activity.cover_image_url
                ? `<img class="table-thumb" src="${escapeAttr(resolveAssetUrl(activity.cover_image_url))}" alt="" data-preview-url="${escapeAttr(resolveAssetUrl(activity.cover_image_url))}" data-preview-type="image">`
                : `<div class="table-thumb-ph" style="background:#EEF2FF;color:#6366F1">${escapeHtml((activity.title || '?').slice(0, 1).toUpperCase())}</div>`;

            const files = [
                activity.cover_image_url
                    ? `<span class="fe-label" style="cursor:pointer;color:var(--color-primary);font-size:.8rem" data-preview-url="${escapeAttr(resolveAssetUrl(activity.cover_image_url))}" data-preview-type="image">รูปปก</span>`
                    : null,
                activity.pdf_url
                    ? `<span class="fe-label" style="cursor:pointer;color:var(--color-danger);font-size:.8rem" data-preview-url="${escapeAttr(resolveAssetUrl(activity.pdf_url))}" data-preview-type="pdf">PDF</span>`
                    : null,
            ].filter(Boolean).join(' • ');

            return `
                <tr>
                    <td>
                        <div style="display:flex;align-items:center;gap:.75rem">
                            ${thumb}
                            <div>
                                <div style="font-weight:600;color:var(--color-gray-800)">${escapeHtml(activity.title || '-')}</div>
                                <div style="font-size:.75rem;color:var(--color-gray-400);margin-top:.15rem">${escapeHtml(activity.location || '')}</div>
                            </div>
                        </div>
                    </td>
                    <td>${escapeHtml(activity.category?.name || '-')}</td>
                    <td style="white-space:nowrap">${activity.activity_date ? formatDate(activity.activity_date) : '-'}</td>
                    <td><span class="pill ${status ? 'pill-on' : 'pill-off'}">${status ? 'แสดงผล' : 'ปิด'}</span></td>
                    <td>${files || '<span style="color:var(--color-gray-300)">—</span>'}</td>
                    <td style="white-space:nowrap">
                        <button type="button" class="btn btn-muted btn-sm" data-action="edit"   data-id="${activity.id}">แก้ไข</button>
                        <button type="button" class="btn btn-danger btn-sm" data-action="delete" data-id="${activity.id}">ลบ</button>
                    </td>
                </tr>
            `;
        }).join('');
    }

    el.adminActivityPage.textContent = `หน้า ${state.admin.meta.current_page ?? 1} / ${state.admin.meta.last_page ?? 1}`;
    el.adminActivityPrev.disabled = (state.admin.meta.current_page ?? 1) <= 1;
    el.adminActivityNext.disabled = (state.admin.meta.current_page ?? 1) >= (state.admin.meta.last_page ?? 1);
}

/* ── Activity dialog helpers ── */

function openActivityDialog(mode = 'add') {
    if (mode === 'add') {
        resetActivityForm();
        el.activityFormDialogTitle.textContent = 'เพิ่มกิจกรรม';
        el.activitySubmit.textContent = 'เพิ่มกิจกรรม';
    }
    el.activityFormDialog.showModal();
}

async function editActivity(id) {
    try {
        const response = await api(`/admin/activities/${id}`, { auth: true });
        const activity = response.data;

        el.activityId.value          = activity.id;
        el.activityTitle.value       = activity.title || '';
        el.activityCategory.value    = activity.category_id || '';
        if (airDatepicker && activity.activity_date) {
            const [y, m, d] = activity.activity_date.split('-').map(Number);
            airDatepicker.selectDate(new Date(y, m - 1, d));
        } else {
            el.activityDate.value = activity.activity_date || '';
        }
        el.activityLocation.value    = activity.location || '';
        el.activityDescription.value = activity.description || '';
        el.activityStatus.checked    = Number(activity.status) === 1;

        const coverPreviewEl = document.getElementById('activity-cover-preview');
        const pdfPreviewEl   = document.getElementById('activity-pdf-preview');
        const existingEl     = document.getElementById('activity-existing-assets');
        const excelInput     = document.getElementById('activity-excel');

        if (coverPreviewEl) { coverPreviewEl.innerHTML = ''; coverPreviewEl.classList.add('hidden'); }
        if (pdfPreviewEl)   { pdfPreviewEl.innerHTML   = ''; pdfPreviewEl.classList.add('hidden'); }
        if (excelInput)     { excelInput.value = ''; }

        if (existingEl) {
            existingEl.innerHTML = '';
            existingEl.classList.add('hidden');

            if (activity.cover_image_url) {
                renderExistingImage(existingEl, activity.cover_image_url);
            }
            if (activity.pdf_url) {
                renderExistingPdf(existingEl, activity.pdf_url);
            }
        }

        // Update participants badge
        updateParticipantsBadge(activity.participants_count || 0);

        el.activityFormDialogTitle.textContent = 'แก้ไขกิจกรรม';
        el.activitySubmit.textContent = 'บันทึกการแก้ไข';
        el.activityFormDialog.showModal();
    } catch (error) {
        showToast(errorToMessage(error), 'error');
    }
}

function updateParticipantsBadge(count) {
    const badge   = document.getElementById('activity-participants-badge');
    const countEl = document.getElementById('activity-participants-count');
    if (!badge || !countEl) return;
    if (count > 0) {
        countEl.textContent = `${count.toLocaleString('th-TH')} คน`;
        badge.classList.remove('hidden');
    } else {
        badge.classList.add('hidden');
    }
}

function resetActivityForm() {
    el.adminActivityForm.reset();
    el.activityId.value = '';
    el.activityStatus.checked = true;
    if (airDatepicker) {
        airDatepicker.clear();
    }
    el.activityDate.value = '';

    const coverPreviewEl = document.getElementById('activity-cover-preview');
    const pdfPreviewEl   = document.getElementById('activity-pdf-preview');
    const existingEl     = document.getElementById('activity-existing-assets');
    const excelInput     = document.getElementById('activity-excel');
    if (coverPreviewEl) { coverPreviewEl.innerHTML = ''; coverPreviewEl.classList.add('hidden'); }
    if (pdfPreviewEl)   { pdfPreviewEl.innerHTML   = ''; pdfPreviewEl.classList.add('hidden'); }
    if (existingEl)     { existingEl.innerHTML     = ''; existingEl.classList.add('hidden'); }
    if (excelInput)     { excelInput.value = ''; }
    const excelBadge   = document.getElementById('excel-ready-badge');
    const excelPreview = document.getElementById('excel-preview-wrap');
    if (excelBadge)   excelBadge.classList.add('hidden');
    if (excelPreview) excelPreview.classList.add('hidden');
    updateParticipantsBadge(0);
}

async function saveActivity() {
    const id = el.activityId.value;
    const excelInput = document.getElementById('activity-excel');
    const hasExcel = excelInput?.files.length > 0;

    const formData = new FormData(el.adminActivityForm);
    formData.set('status', el.activityStatus.checked ? '1' : '0');
    if (!el.activityCover.files.length) formData.delete('cover_image');
    if (!el.activityPdf.files.length)   formData.delete('pdf_file');

    try {
        let savedId = id;

        if (id) {
            formData.append('_method', 'PUT');
            await api(`/admin/activities/${id}`, { method: 'POST', auth: true, body: formData });
            showToast('อัปเดตกิจกรรมแล้ว', 'success');
        } else {
            const response = await api('/admin/activities', { method: 'POST', auth: true, body: formData });
            savedId = response.data?.id;
            showToast('เพิ่มกิจกรรมแล้ว', 'success');
        }

        // Auto-import Excel if file was attached
        if (hasExcel && savedId) {
            try {
                const xlFormData = new FormData();
                xlFormData.set('excel_file', excelInput.files[0]);
                const res = await api(`/admin/activities/${savedId}/import-excel`, { method: 'POST', auth: true, body: xlFormData });
                showToast(res.message || 'นำเข้ารายชื่อสำเร็จ', 'success');
            } catch (xlError) {
                showToast('บันทึกสำเร็จ แต่นำเข้า Excel ไม่สำเร็จ: ' + errorToMessage(xlError), 'error');
            }
        }

        el.activityFormDialog.close();
        await loadAdminActivities();
    } catch (error) {
        showToast(errorToMessage(error), 'error');
    }
}

/**
 * Saves a NEW activity silently (without closing the dialog) and returns its ID.
 * Used so Excel can be imported immediately after creating the activity.
 */
async function saveActivitySilent() {
    if (!el.activityTitle.value.trim()) {
        showToast('กรุณาระบุชื่อกิจกรรมก่อนนำเข้า Excel', 'error');
        return null;
    }
    if (!el.activityCategory.value) {
        showToast('กรุณาเลือกหมวดหมู่ก่อนนำเข้า Excel', 'error');
        return null;
    }

    const formData = new FormData(el.adminActivityForm);
    formData.set('status', el.activityStatus.checked ? '1' : '0');
    if (!el.activityCover.files.length) formData.delete('cover_image');
    if (!el.activityPdf.files.length)   formData.delete('pdf_file');

    try {
        const response = await api('/admin/activities', { method: 'POST', auth: true, body: formData });
        const newId = response.data?.id;
        if (newId) {
            el.activityId.value = String(newId);
            el.activityFormDialogTitle.textContent = 'แก้ไขกิจกรรม';
            el.activitySubmit.textContent = 'บันทึกการแก้ไข';
            await loadAdminActivities();
        }
        return newId || null;
    } catch (error) {
        showToast(errorToMessage(error), 'error');
        return null;
    }
}

async function deleteActivity(id) {
    const target = state.admin.activities.find((item) => String(item.id) === String(id));
    const confirmed = await showConfirmDialog(
        'ยืนยันการลบกิจกรรม',
        `ต้องการลบ "${target?.title || 'กิจกรรมนี้'}" หรือไม่? การดำเนินการนี้ไม่สามารถย้อนกลับได้`
    );
    if (!confirmed) return;

    try {
        await api(`/admin/activities/${id}`, { method: 'DELETE', auth: true });
        await loadAdminActivities();
        showToast('ลบกิจกรรมแล้ว', 'success');
    } catch (error) {
        showToast(errorToMessage(error), 'error');
    }
}

/* ══════════════════════════════════
   Event bindings
   ══════════════════════════════════ */

export function bindAdminEvents() {
    /* ── Air Datepicker Initialization ── */
    if (window.AirDatepicker && el.activityDateDisplay) {
        const thLocale = {
            days: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
            daysShort: ['อา', 'จ', 'อ', 'พ', 'พฤ', 'ศ', 'ส'],
            daysMin: ['อา', 'จ', 'อ', 'พ', 'พฤ', 'ศ', 'ส'],
            months: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน',
                     'กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
            monthsShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.',
                          'ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'],
            today: 'วันนี้',
            clear: 'ล้าง',
            dateFormat: 'dd/MM/yyyy',
            timeFormat: 'HH:mm',
            firstDay: 0,
        };

        airDatepicker = new AirDatepicker(el.activityDateDisplay, {
            locale: thLocale,
            container: '#activity-form-dialog',
            dateFormat(date) {
                const d = date.getDate();
                const m = thLocale.months[date.getMonth()];
                const y = date.getFullYear() + 543;
                return `${d} ${m} ${y}`;
            },
            navTitles: {
                days(dp) {
                    const m = thLocale.months[dp.viewDate.getMonth()];
                    const y = dp.viewDate.getFullYear() + 543;
                    return `${m} ${y}`;
                },
                months(dp) {
                    return dp.viewDate.getFullYear() + 543;
                },
            },
            onSelect({ date }) {
                if (date) {
                    const d = String(date.getDate()).padStart(2, '0');
                    const m = String(date.getMonth() + 1).padStart(2, '0');
                    el.activityDate.value = `${date.getFullYear()}-${m}-${d}`;
                } else {
                    el.activityDate.value = '';
                }
            },
        });
    }

    /* ── Auth ── */
    el.adminLoginForm.addEventListener('submit', (event) => {
        event.preventDefault();
        void loginAdmin();
    });
    el.adminLogout.addEventListener('click', async () => {
        const confirmed = await showConfirmDialog(
            'ออกจากระบบ',
            'ต้องการออกจากระบบหรือไม่?'
        );
        if (confirmed) void logoutAdmin();
    });

    /* ── Media preview dialog ── */
    document.getElementById('media-preview-close')?.addEventListener('click', closeMediaPreview);
    document.getElementById('media-preview-dialog')?.addEventListener('click', (event) => {
        if (event.target === event.currentTarget) closeMediaPreview();
    });

    /* ── Delegated preview trigger: data-preview-url on any element ── */
    document.addEventListener('click', (event) => {
        const el = event.target.closest('[data-preview-url]');
        if (el) {
            event.preventDefault();
            openMediaPreview(el.dataset.previewUrl, el.dataset.previewType || 'image');
        }
    });

    /* ── Sidebar section navigation ── */
    document.querySelectorAll('.sidebar-nav-item[data-section]').forEach((btn) => {
        btn.addEventListener('click', () => switchAdminSection(btn.dataset.section));
    });

    /* ── data-section-goto buttons (e.g. "ดูทั้งหมด") ── */
    document.addEventListener('click', (event) => {
        const btn = event.target.closest('[data-section-goto]');
        if (btn) switchAdminSection(btn.dataset.sectionGoto);
    });

    /* ── Overview quick-action buttons ── */
    document.getElementById('overview-add-activity-btn')?.addEventListener('click', () => {
        switchAdminSection('admin-section-activities');
        openActivityDialog('add');
    });
    document.getElementById('overview-add-category-btn')?.addEventListener('click', () => {
        switchAdminSection('admin-section-categories');
        openCategoryDialog('add');
    });

    /* ── Overview recent list edit ── */
    document.getElementById('overview-recent-list')?.addEventListener('click', (event) => {
        const btn = event.target.closest('button[data-action="edit"]');
        if (btn) {
            switchAdminSection('admin-section-activities');
            void editActivity(btn.dataset.id);
        }
    });

    /* ── Category dialog ── */
    el.categoryAddBtn.addEventListener('click', () => openCategoryDialog('add'));
    el.categoryDialogCloseBtn.addEventListener('click', () => el.categoryFormDialog.close());
    el.categoryCancel.addEventListener('click', () => el.categoryFormDialog.close());
    el.categoryFormDialog.addEventListener('close', () => resetCategoryForm());
    el.adminCategoryForm.addEventListener('submit', (event) => { event.preventDefault(); void saveCategory(); });
    el.categoryList.addEventListener('click', (event) => {
        const btn = event.target.closest('button[data-action]');
        if (!btn) return;
        if (btn.dataset.action === 'edit')   editCategory(btn.dataset.id);
        if (btn.dataset.action === 'delete') void deleteCategory(btn.dataset.id);
    });

    /* ── File preview bindings (category form) ── */
    const catCoverPreview = document.getElementById('category-cover-preview');
    if (catCoverPreview) bindFilePreview(el.categoryCover, catCoverPreview, 'image');

    /* ── Activity dialog ── */
    el.activityAddBtn.addEventListener('click', () => openActivityDialog('add'));
    el.activityDialogCloseBtn.addEventListener('click', () => el.activityFormDialog.close());
    el.activityCancel.addEventListener('click', () => el.activityFormDialog.close());
    el.activityFormDialog.addEventListener('close', () => resetActivityForm());
    el.adminActivityForm.addEventListener('submit', (event) => { event.preventDefault(); void saveActivity(); });
    el.adminActivityList.addEventListener('click', (event) => {
        const btn = event.target.closest('button[data-action]');
        if (!btn) return;
        if (btn.dataset.action === 'edit')   void editActivity(btn.dataset.id);
        if (btn.dataset.action === 'delete') void deleteActivity(btn.dataset.id);
    });

    /* ── File preview bindings (activity form) ── */
    const actCoverPreview = document.getElementById('activity-cover-preview');
    const actPdfPreview   = document.getElementById('activity-pdf-preview');
    if (actCoverPreview) bindFilePreview(el.activityCover, actCoverPreview, 'image');
    if (actPdfPreview)   bindFilePreview(el.activityPdf,   actPdfPreview,   'pdf');



    /* ── Clear participants ── */
    document.getElementById('activity-clear-participants')?.addEventListener('click', async () => {
        const id = el.activityId.value;
        if (!id) return;
        const confirmed = await showConfirmDialog('ล้างรายชื่อ', 'ต้องการล้างรายชื่อผู้เข้าร่วมทั้งหมดหรือไม่?');
        if (!confirmed) return;
        try {
            await api(`/admin/activities/${id}/participants`, { method: 'DELETE', auth: true });
            showToast('ล้างรายชื่อแล้ว', 'success');
            updateParticipantsBadge(0);
            await loadAdminActivities();
        } catch (error) {
            showToast(errorToMessage(error), 'error');
        }
    });

    /* ── Activity filters & pagination ── */
    el.adminActivitySearch.addEventListener('click', () => {
        state.admin.filters.keyword     = el.adminActivityKeyword.value.trim();
        state.admin.filters.category_id = el.adminActivityFilterCategory.value;
        state.admin.filters.page        = 1;
        void loadAdminActivities();
    });
    el.adminActivityReset.addEventListener('click', () => {
        el.adminActivityKeyword.value        = '';
        el.adminActivityFilterCategory.value = '';
        state.admin.filters.keyword     = '';
        state.admin.filters.category_id = '';
        state.admin.filters.page        = 1;
        void loadAdminActivities();
    });
    el.adminActivityFilterCategory.addEventListener('change', () => {
        state.admin.filters.category_id = el.adminActivityFilterCategory.value;
        state.admin.filters.page        = 1;
        void loadAdminActivities();
    });
    el.adminActivityKeyword.addEventListener('keydown', (event) => {
        if (event.key === 'Enter') { event.preventDefault(); el.adminActivitySearch.click(); }
    });
    el.adminActivityPrev.addEventListener('click', () => {
        if (state.admin.meta.current_page <= 1) return;
        state.admin.filters.page -= 1;
        void loadAdminActivities();
    });
    el.adminActivityNext.addEventListener('click', () => {
        if (state.admin.meta.current_page >= state.admin.meta.last_page) return;
        state.admin.filters.page += 1;
        void loadAdminActivities();
    });
}
