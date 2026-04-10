/**
 * Admin view module.
 * Handles authentication, category CRUD, and activity CRUD.
 * Edit/delete actions use popup dialogs instead of inline forms / window.confirm.
 */

import { state, defaultMeta, saveAdminSession, clearAdminSession } from './state';
import { api, buildQuery, resolveAssetUrl, errorToMessage } from './api';
import { el, showToast, showConfirmDialog, escapeHtml, escapeAttr, formatDate } from './ui';

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
    const profileText = profile
        ? `เข้าสู่ระบบเป็น ${profile.name} (${profile.email})`
        : 'เข้าสู่ระบบสำเร็จ';

    el.adminProfileText.textContent = profileText;
    el.adminAuthCard.classList.add('hidden');
    el.adminDashboard.classList.remove('hidden');
}

async function loginAdmin() {
    const email = el.adminEmail.value.trim();
    const password = el.adminPassword.value;

    try {
        const response = await api('/admin/login', {
            method: 'POST',
            body: { email, password },
        });

        state.admin.session = {
            token: response.data.token,
            admin: response.data.admin,
        };

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
    } catch {
        // Ignore network/auth errors and clear local session anyway.
    }

    clearAdminSession();
    renderAdminLoggedOut();
    showToast('ออกจากระบบแล้ว', 'info');
}

/* ── Admin data bootstrap ── */

async function loadAdminData() {
    await loadAdminCategories();
    await loadAdminActivities();
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
    if (!state.admin.categories.length) {
        el.categoryList.innerHTML = `
            <tr>
                <td colspan="4" class="text-center text-muted">ยังไม่มีหมวดหมู่</td>
            </tr>
        `;
        return;
    }

    el.categoryList.innerHTML = state.admin.categories
        .map((category) => {
            const status = Number(category.status) === 1;
            const thumb = category.cover_image_url
                ? `<img src="${escapeAttr(resolveAssetUrl(category.cover_image_url))}" alt="" class="w-10 h-10 rounded-lg object-cover">`
                : `<div class="w-10 h-10 rounded-lg bg-gradient-to-br from-teal-50 to-emerald-100 grid place-items-center text-primary font-display text-sm">${escapeHtml(category.name.slice(0, 1).toUpperCase())}</div>`;

            return `
                <tr>
                    <td class="w-[52px]">${thumb}</td>
                    <td>${escapeHtml(category.name)}</td>
                    <td><span class="pill ${status ? 'pill-on' : 'pill-off'}">${status ? 'เปิดใช้งาน' : 'ปิดใช้งาน'}</span></td>
                    <td class="whitespace-nowrap">
                        <button type="button" class="btn btn-muted btn-sm" data-action="edit" data-id="${category.id}">แก้ไข</button>
                        <button type="button" class="btn btn-danger btn-sm" data-action="delete" data-id="${category.id}">ลบ</button>
                    </td>
                </tr>
            `;
        })
        .join('');
}

function hydrateCategorySelects() {
    const allCategories = state.admin.categories || [];
    const activitySelected = el.activityCategory.value;
    const filterSelected = state.admin.filters.category_id || '';

    const activityOptions = allCategories
        .map((category) => `<option value="${category.id}">${escapeHtml(category.name)}</option>`)
        .join('');
    el.activityCategory.innerHTML = `<option value="">เลือกหมวดหมู่</option>${activityOptions}`;
    el.activityCategory.value = activitySelected || '';

    const filterOptions = allCategories
        .map((category) => `<option value="${category.id}">${escapeHtml(category.name)}</option>`)
        .join('');
    el.adminActivityFilterCategory.innerHTML = `<option value="">ทั้งหมด</option>${filterOptions}`;
    el.adminActivityFilterCategory.value = filterSelected;
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
    if (!category) {
        return;
    }

    el.categoryId.value = category.id;
    el.categoryName.value = category.name || '';
    el.categoryStatus.checked = Number(category.status) === 1;

    if (category.cover_image_url) {
        el.categoryExistingCover.innerHTML = `<a href="${escapeAttr(resolveAssetUrl(category.cover_image_url))}" target="_blank" rel="noopener">ดูรูปปกปัจจุบัน</a>`;
    } else {
        el.categoryExistingCover.innerHTML = '';
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
    el.categoryExistingCover.innerHTML = '';
}

async function saveCategory() {
    const id = el.categoryId.value;
    const formData = new FormData();
    formData.set('name', el.categoryName.value.trim());
    formData.set('status', el.categoryStatus.checked ? '1' : '0');

    if (!el.categoryName.value.trim()) {
        showToast('กรุณาระบุชื่อหมวดหมู่', 'error');
        return;
    }

    if (el.categoryCover.files.length) {
        formData.set('cover_image', el.categoryCover.files[0]);
    }

    try {
        if (id) {
            formData.append('_method', 'PUT');
            await api(`/admin/categories/${id}`, {
                method: 'POST',
                auth: true,
                body: formData,
            });
            showToast('อัปเดตหมวดหมู่แล้ว', 'success');
        } else {
            await api('/admin/categories', {
                method: 'POST',
                auth: true,
                body: formData,
            });
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
    const categoryName = category?.name || 'หมวดหมู่นี้';

    const confirmed = await showConfirmDialog(
        'ยืนยันการลบหมวดหมู่',
        `ต้องการลบ "${categoryName}" หรือไม่? การดำเนินการนี้ไม่สามารถย้อนกลับได้`
    );

    if (!confirmed) {
        return;
    }

    try {
        await api(`/admin/categories/${id}`, {
            method: 'DELETE',
            auth: true,
        });
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
    } catch (error) {
        showToast(errorToMessage(error), 'error');
    }
}

function renderAdminActivities() {
    const list = state.admin.activities;

    if (!list.length) {
        el.adminActivityList.innerHTML = `
            <tr>
                <td colspan="6" class="text-center text-muted">ยังไม่พบกิจกรรม</td>
            </tr>
        `;
    } else {
        el.adminActivityList.innerHTML = list
            .map((activity) => {
                const status = Number(activity.status) === 1;
                const files = [
                    activity.cover_image_url
                        ? `<a href="${escapeAttr(resolveAssetUrl(activity.cover_image_url))}" target="_blank" rel="noopener">รูปปก</a>`
                        : null,
                    activity.pdf_url
                        ? `<a href="${escapeAttr(resolveAssetUrl(activity.pdf_url))}" target="_blank" rel="noopener">PDF</a>`
                        : null,
                ]
                    .filter(Boolean)
                    .join(' • ');

                return `
                    <tr>
                        <td>
                            <strong>${escapeHtml(activity.title || '-')}</strong>
                            <p class="mt-1 text-muted text-xs m-0">${escapeHtml(activity.location || '')}</p>
                        </td>
                        <td>${escapeHtml(activity.category?.name || '-')}</td>
                        <td>${activity.activity_date ? formatDate(activity.activity_date) : '-'}</td>
                        <td><span class="pill ${status ? 'pill-on' : 'pill-off'}">${status ? 'แสดงผล' : 'ปิด'}</span></td>
                        <td>${files || '-'}</td>
                        <td class="whitespace-nowrap">
                            <button type="button" class="btn btn-muted btn-sm" data-action="edit" data-id="${activity.id}">แก้ไข</button>
                            <button type="button" class="btn btn-danger btn-sm" data-action="delete" data-id="${activity.id}">ลบ</button>
                        </td>
                    </tr>
                `;
            })
            .join('');
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

        el.activityId.value = activity.id;
        el.activityTitle.value = activity.title || '';
        el.activityCategory.value = activity.category_id || '';
        el.activityDate.value = activity.activity_date || '';
        el.activityLocation.value = activity.location || '';
        el.activityDescription.value = activity.description || '';
        el.activityStatus.checked = Number(activity.status) === 1;

        const links = [];
        if (activity.cover_image_url) {
            links.push(`<a href="${escapeAttr(resolveAssetUrl(activity.cover_image_url))}" target="_blank" rel="noopener">ดูรูปปกปัจจุบัน</a>`);
        }
        if (activity.pdf_url) {
            links.push(`<a href="${escapeAttr(resolveAssetUrl(activity.pdf_url))}" target="_blank" rel="noopener">ดู PDF ปัจจุบัน</a>`);
        }
        el.activityExistingAssets.innerHTML = links.join(' • ');

        el.activityFormDialogTitle.textContent = 'แก้ไขกิจกรรม';
        el.activitySubmit.textContent = 'บันทึกการแก้ไข';
        el.activityFormDialog.showModal();
    } catch (error) {
        showToast(errorToMessage(error), 'error');
    }
}

function resetActivityForm() {
    el.adminActivityForm.reset();
    el.activityId.value = '';
    el.activityStatus.checked = true;
    el.activityExistingAssets.innerHTML = '';
}

async function saveActivity() {
    const id = el.activityId.value;
    const formData = new FormData(el.adminActivityForm);
    formData.set('status', el.activityStatus.checked ? '1' : '0');

    if (!el.activityCover.files.length) {
        formData.delete('cover_image');
    }
    if (!el.activityPdf.files.length) {
        formData.delete('pdf_file');
    }

    try {
        if (id) {
            formData.append('_method', 'PUT');
            await api(`/admin/activities/${id}`, {
                method: 'POST',
                auth: true,
                body: formData,
            });
            showToast('อัปเดตกิจกรรมแล้ว', 'success');
        } else {
            await api('/admin/activities', {
                method: 'POST',
                auth: true,
                body: formData,
            });
            showToast('เพิ่มกิจกรรมแล้ว', 'success');
        }

        el.activityFormDialog.close();
        await loadAdminActivities();
    } catch (error) {
        showToast(errorToMessage(error), 'error');
    }
}

async function deleteActivity(id) {
    const target = state.admin.activities.find((item) => String(item.id) === String(id));
    const label = target?.title || 'กิจกรรมนี้';

    const confirmed = await showConfirmDialog(
        'ยืนยันการลบกิจกรรม',
        `ต้องการลบ "${label}" หรือไม่? การดำเนินการนี้ไม่สามารถย้อนกลับได้`
    );

    if (!confirmed) {
        return;
    }

    try {
        await api(`/admin/activities/${id}`, {
            method: 'DELETE',
            auth: true,
        });
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
    /* ── Auth ── */
    el.adminLoginForm.addEventListener('submit', (event) => {
        event.preventDefault();
        void loginAdmin();
    });

    el.adminLogout.addEventListener('click', () => {
        void logoutAdmin();
    });

    /* ── Category dialog ── */
    el.categoryAddBtn.addEventListener('click', () => {
        openCategoryDialog('add');
    });

    el.categoryDialogCloseBtn.addEventListener('click', () => {
        el.categoryFormDialog.close();
    });

    el.categoryCancel.addEventListener('click', () => {
        el.categoryFormDialog.close();
    });

    el.categoryFormDialog.addEventListener('close', () => {
        resetCategoryForm();
    });

    el.adminCategoryForm.addEventListener('submit', (event) => {
        event.preventDefault();
        void saveCategory();
    });

    el.categoryList.addEventListener('click', (event) => {
        const actionButton = event.target.closest('button[data-action]');
        if (!actionButton) {
            return;
        }
        const { action, id } = actionButton.dataset;
        if (action === 'edit') {
            editCategory(id);
        }
        if (action === 'delete') {
            void deleteCategory(id);
        }
    });

    /* ── Activity dialog ── */
    el.activityAddBtn.addEventListener('click', () => {
        openActivityDialog('add');
    });

    el.activityDialogCloseBtn.addEventListener('click', () => {
        el.activityFormDialog.close();
    });

    el.activityCancel.addEventListener('click', () => {
        el.activityFormDialog.close();
    });

    el.activityFormDialog.addEventListener('close', () => {
        resetActivityForm();
    });

    el.adminActivityForm.addEventListener('submit', (event) => {
        event.preventDefault();
        void saveActivity();
    });

    el.adminActivityList.addEventListener('click', (event) => {
        const actionButton = event.target.closest('button[data-action]');
        if (!actionButton) {
            return;
        }
        const { action, id } = actionButton.dataset;
        if (action === 'edit') {
            void editActivity(id);
        }
        if (action === 'delete') {
            void deleteActivity(id);
        }
    });

    /* ── Activity filters & pagination ── */
    el.adminActivitySearch.addEventListener('click', () => {
        state.admin.filters.keyword = el.adminActivityKeyword.value.trim();
        state.admin.filters.category_id = el.adminActivityFilterCategory.value;
        state.admin.filters.page = 1;
        void loadAdminActivities();
    });

    el.adminActivityReset.addEventListener('click', () => {
        el.adminActivityKeyword.value = '';
        el.adminActivityFilterCategory.value = '';
        state.admin.filters.keyword = '';
        state.admin.filters.category_id = '';
        state.admin.filters.page = 1;
        void loadAdminActivities();
    });

    el.adminActivityFilterCategory.addEventListener('change', () => {
        state.admin.filters.category_id = el.adminActivityFilterCategory.value;
        state.admin.filters.page = 1;
        void loadAdminActivities();
    });

    el.adminActivityKeyword.addEventListener('keydown', (event) => {
        if (event.key === 'Enter') {
            event.preventDefault();
            el.adminActivitySearch.click();
        }
    });

    el.adminActivityPrev.addEventListener('click', () => {
        if (state.admin.meta.current_page <= 1) {
            return;
        }
        state.admin.filters.page -= 1;
        void loadAdminActivities();
    });

    el.adminActivityNext.addEventListener('click', () => {
        if (state.admin.meta.current_page >= state.admin.meta.last_page) {
            return;
        }
        state.admin.filters.page += 1;
        void loadAdminActivities();
    });
}
