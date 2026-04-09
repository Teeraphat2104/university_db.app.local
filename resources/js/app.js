import './bootstrap';

const API_PREFIX = '/api';
const ADMIN_SESSION_KEY = 'university-admin-session-v1';

const defaultMeta = {
    current_page: 1,
    last_page: 1,
    total: 0,
    per_page: 10,
};

const state = {
    mode: 'public',
    public: {
        filters: {
            keyword: '',
            category_id: '',
            page: 1,
            per_page: 9,
        },
        categories: [],
        activities: [],
        meta: { ...defaultMeta, per_page: 9 },
    },
    admin: {
        session: loadAdminSession(),
        bootstrapped: false,
        filters: {
            keyword: '',
            category_id: '',
            page: 1,
            per_page: 8,
        },
        categories: [],
        activities: [],
        meta: { ...defaultMeta, per_page: 8 },
    },
};

const el = {};

document.addEventListener('DOMContentLoaded', async () => {
    cacheElements();
    bindEvents();

    const initialMode = window.location.pathname.startsWith('/admin') ? 'admin' : 'public';
    setMode(initialMode, false);

    try {
        await Promise.all([loadPublicCategories(), loadPublicActivities()]);
        await ensureAdminSession();
    } catch (error) {
        showToast(errorToMessage(error), 'error');
    }
});

function cacheElements() {
    el.modeButtons = document.querySelectorAll('.mode-btn');
    el.publicView = document.getElementById('public-view');
    el.adminView = document.getElementById('admin-view');

    el.publicKeyword = document.getElementById('public-keyword');
    el.publicCategory = document.getElementById('public-category');
    el.publicSearch = document.getElementById('public-search');
    el.publicReset = document.getElementById('public-reset');
    el.publicSummary = document.getElementById('public-summary');
    el.publicGrid = document.getElementById('public-activity-grid');
    el.publicPrev = document.getElementById('public-prev');
    el.publicNext = document.getElementById('public-next');
    el.publicPage = document.getElementById('public-page');

    el.dialog = document.getElementById('activity-dialog');
    el.dialogClose = document.getElementById('dialog-close');
    el.dialogImage = document.getElementById('dialog-image');
    el.dialogTitle = document.getElementById('dialog-title');
    el.dialogMeta = document.getElementById('dialog-meta');
    el.dialogDescription = document.getElementById('dialog-description');
    el.dialogOpenPdf = document.getElementById('dialog-open-pdf');
    el.dialogDownloadPdf = document.getElementById('dialog-download-pdf');

    el.adminAuthCard = document.getElementById('admin-auth-card');
    el.adminDashboard = document.getElementById('admin-dashboard');
    el.adminLoginForm = document.getElementById('admin-login-form');
    el.adminEmail = document.getElementById('admin-email');
    el.adminPassword = document.getElementById('admin-password');
    el.adminProfileText = document.getElementById('admin-profile-text');
    el.adminLogout = document.getElementById('admin-logout');

    el.adminCategoryForm = document.getElementById('admin-category-form');
    el.categoryId = document.getElementById('category-id');
    el.categoryName = document.getElementById('category-name');
    el.categoryStatus = document.getElementById('category-status');
    el.categorySubmit = document.getElementById('category-submit');
    el.categoryCancel = document.getElementById('category-cancel');
    el.categoryList = document.getElementById('admin-category-list');

    el.adminActivityKeyword = document.getElementById('admin-activity-keyword');
    el.adminActivityFilterCategory = document.getElementById('admin-activity-filter-category');
    el.adminActivitySearch = document.getElementById('admin-activity-search');
    el.adminActivityReset = document.getElementById('admin-activity-reset');
    el.adminActivityForm = document.getElementById('admin-activity-form');
    el.activityId = document.getElementById('activity-id');
    el.activityTitle = document.getElementById('activity-title');
    el.activityCategory = document.getElementById('activity-category');
    el.activityDate = document.getElementById('activity-date');
    el.activityLocation = document.getElementById('activity-location');
    el.activityDescription = document.getElementById('activity-description');
    el.activityCover = document.getElementById('activity-cover');
    el.activityPdf = document.getElementById('activity-pdf');
    el.activityStatus = document.getElementById('activity-status');
    el.activityExistingAssets = document.getElementById('activity-existing-assets');
    el.activitySubmit = document.getElementById('activity-submit');
    el.activityCancel = document.getElementById('activity-cancel');
    el.adminActivityList = document.getElementById('admin-activity-list');
    el.adminActivityPrev = document.getElementById('admin-activity-prev');
    el.adminActivityNext = document.getElementById('admin-activity-next');
    el.adminActivityPage = document.getElementById('admin-activity-page');

    el.toast = document.getElementById('toast');
}

function bindEvents() {
    el.modeButtons.forEach((button) => {
        button.addEventListener('click', () => {
            setMode(button.dataset.mode);
        });
    });

    el.publicSearch.addEventListener('click', () => {
        state.public.filters.keyword = el.publicKeyword.value.trim();
        state.public.filters.category_id = el.publicCategory.value;
        state.public.filters.page = 1;
        void loadPublicActivities();
    });

    el.publicReset.addEventListener('click', () => {
        el.publicKeyword.value = '';
        el.publicCategory.value = '';
        state.public.filters.keyword = '';
        state.public.filters.category_id = '';
        state.public.filters.page = 1;
        void loadPublicActivities();
    });

    el.publicCategory.addEventListener('change', () => {
        state.public.filters.category_id = el.publicCategory.value;
        state.public.filters.page = 1;
        void loadPublicActivities();
    });

    el.publicKeyword.addEventListener('keydown', (event) => {
        if (event.key === 'Enter') {
            event.preventDefault();
            el.publicSearch.click();
        }
    });

    el.publicPrev.addEventListener('click', () => {
        if (state.public.meta.current_page <= 1) {
            return;
        }
        state.public.filters.page -= 1;
        void loadPublicActivities();
    });

    el.publicNext.addEventListener('click', () => {
        if (state.public.meta.current_page >= state.public.meta.last_page) {
            return;
        }
        state.public.filters.page += 1;
        void loadPublicActivities();
    });

    el.publicGrid.addEventListener('click', (event) => {
        const detailButton = event.target.closest('[data-action="detail"]');
        if (!detailButton) {
            return;
        }
        void openPublicDetail(detailButton.dataset.id);
    });

    el.dialogClose.addEventListener('click', () => closeDialog());
    el.dialog.addEventListener('click', (event) => {
        if (event.target === el.dialog) {
            closeDialog();
        }
    });

    el.adminLoginForm.addEventListener('submit', (event) => {
        event.preventDefault();
        void loginAdmin();
    });

    el.adminLogout.addEventListener('click', () => {
        void logoutAdmin();
    });

    el.adminCategoryForm.addEventListener('submit', (event) => {
        event.preventDefault();
        void saveCategory();
    });

    el.categoryCancel.addEventListener('click', () => {
        resetCategoryForm();
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

    el.adminActivityForm.addEventListener('submit', (event) => {
        event.preventDefault();
        void saveActivity();
    });

    el.activityCancel.addEventListener('click', () => {
        resetActivityForm();
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
}

function setMode(mode, updateHistory = true) {
    state.mode = mode === 'admin' ? 'admin' : 'public';

    el.modeButtons.forEach((button) => {
        button.classList.toggle('is-active', button.dataset.mode === state.mode);
    });

    el.publicView.classList.toggle('hidden', state.mode !== 'public');
    el.adminView.classList.toggle('hidden', state.mode !== 'admin');

    if (updateHistory) {
        const target = state.mode === 'admin' ? '/admin' : '/';
        if (window.location.pathname !== target) {
            window.history.replaceState({}, '', target);
        }
    }

    if (state.mode === 'admin') {
        void ensureAdminSession();
    }
}

async function loadPublicCategories() {
    const response = await api('/public/categories');
    state.public.categories = response.data || [];
    renderPublicCategoryOptions();
}

async function loadPublicActivities() {
    setPublicLoading(true);

    try {
        const query = buildQuery(state.public.filters);
        const response = await api(`/public/activities${query}`);
        state.public.activities = response.data || [];
        state.public.meta = response.meta || { ...defaultMeta, per_page: state.public.filters.per_page };
        renderPublicActivities();
    } catch (error) {
        el.publicSummary.textContent = 'ไม่สามารถโหลดข้อมูลกิจกรรมได้';
        showToast(errorToMessage(error), 'error');
    } finally {
        setPublicLoading(false);
    }
}

function renderPublicCategoryOptions() {
    const selected = state.public.filters.category_id || '';
    const options = state.public.categories
        .map((category) => `<option value="${category.id}">${escapeHtml(category.name)}</option>`)
        .join('');

    el.publicCategory.innerHTML = `<option value="">ทั้งหมด</option>${options}`;
    el.publicCategory.value = selected;
}

function renderPublicActivities() {
    const { activities, meta } = state.public;

    if (!activities.length) {
        el.publicGrid.innerHTML = `
            <article class="empty-state">
                <h4>ไม่พบกิจกรรม</h4>
                <p>ลองเปลี่ยนคำค้นหา หรือเลือกหมวดหมู่อื่น</p>
            </article>
        `;
    } else {
        el.publicGrid.innerHTML = activities.map((activity) => publicActivityCard(activity)).join('');
    }

    el.publicSummary.textContent = `แสดง ${activities.length} รายการ จากทั้งหมด ${meta.total ?? 0} รายการ`;
    el.publicPage.textContent = `หน้า ${meta.current_page ?? 1} / ${meta.last_page ?? 1}`;
    el.publicPrev.disabled = (meta.current_page ?? 1) <= 1;
    el.publicNext.disabled = (meta.current_page ?? 1) >= (meta.last_page ?? 1);
}

function publicActivityCard(activity) {
    const cover = activity.cover_image_url
        ? `<img src="${escapeAttr(resolveAssetUrl(activity.cover_image_url))}" alt="${escapeAttr(activity.title)}">`
        : `<div class="cover-fallback">${escapeHtml((activity.title || 'A').slice(0, 1).toUpperCase())}</div>`;

    const categoryName = activity.category?.name || 'ไม่ระบุหมวดหมู่';
    const shortDescription = truncate(activity.description || 'ไม่มีรายละเอียดเพิ่มเติม', 140);
    const openPdfButton = activity.pdf_url
        ? `<a class="btn btn-muted" href="${escapeAttr(resolveAssetUrl(activity.pdf_url))}" target="_blank" rel="noopener">เปิด PDF</a>`
        : '';
    const downloadPdfButton = activity.pdf_url
        ? `<a class="btn btn-muted" href="${escapeAttr(resolveAssetUrl(activity.pdf_url))}" target="_blank" rel="noopener" download>ดาวน์โหลด PDF</a>`
        : '';

    return `
        <article class="activity-card">
            <div class="activity-cover">${cover}</div>
            <div class="activity-body">
                <p class="card-meta">${escapeHtml(categoryName)}${activity.activity_date ? ` • ${formatDate(activity.activity_date)}` : ''}</p>
                <h3>${escapeHtml(activity.title || '-')}</h3>
                <p>${escapeHtml(shortDescription)}</p>
                <div class="inline-actions">
                    <button type="button" class="btn btn-primary" data-action="detail" data-id="${activity.id}">ดูรายละเอียด</button>
                    ${openPdfButton}
                    ${downloadPdfButton}
                </div>
            </div>
        </article>
    `;
}

async function openPublicDetail(id) {
    try {
        const response = await api(`/public/activities/${id}`);
        const activity = response.data;

        if (activity.cover_image_url) {
            el.dialogImage.src = resolveAssetUrl(activity.cover_image_url);
            el.dialogImage.alt = activity.title || '';
            el.dialogImage.classList.remove('hidden');
        } else {
            el.dialogImage.classList.add('hidden');
            el.dialogImage.removeAttribute('src');
            el.dialogImage.alt = '';
        }

        el.dialogTitle.textContent = activity.title || '-';
        el.dialogMeta.textContent = [activity.category?.name, activity.activity_date ? formatDate(activity.activity_date) : null, activity.location]
            .filter(Boolean)
            .join(' • ');
        el.dialogDescription.textContent = activity.description || 'ไม่มีรายละเอียดเพิ่มเติม';

        if (activity.pdf_url) {
            const pdfUrl = resolveAssetUrl(activity.pdf_url);
            el.dialogOpenPdf.href = pdfUrl;
            el.dialogOpenPdf.classList.remove('hidden');
            el.dialogDownloadPdf.href = pdfUrl;
            el.dialogDownloadPdf.classList.remove('hidden');
        } else {
            el.dialogOpenPdf.classList.add('hidden');
            el.dialogDownloadPdf.classList.add('hidden');
        }

        if (typeof el.dialog.showModal === 'function') {
            el.dialog.showModal();
        } else {
            el.dialog.setAttribute('open', 'open');
        }
    } catch (error) {
        showToast(errorToMessage(error), 'error');
    }
}

function closeDialog() {
    if (typeof el.dialog.close === 'function' && el.dialog.open) {
        el.dialog.close();
        return;
    }
    el.dialog.removeAttribute('open');
}

async function ensureAdminSession() {
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
    resetCategoryForm();
    resetActivityForm();
    renderAdminLoggedOut();
    showToast('ออกจากระบบแล้ว', 'info');
}

async function loadAdminData() {
    await loadAdminCategories();
    await loadAdminActivities();
}

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
                <td colspan="3" class="table-empty">ยังไม่มีหมวดหมู่</td>
            </tr>
        `;
        return;
    }

    el.categoryList.innerHTML = state.admin.categories
        .map((category) => {
            const status = Number(category.status) === 1;

            return `
                <tr>
                    <td>${escapeHtml(category.name)}</td>
                    <td><span class="pill ${status ? 'pill-on' : 'pill-off'}">${status ? 'เปิดใช้งาน' : 'ปิดใช้งาน'}</span></td>
                    <td class="table-actions">
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

function editCategory(id) {
    const category = state.admin.categories.find((item) => String(item.id) === String(id));
    if (!category) {
        return;
    }

    el.categoryId.value = category.id;
    el.categoryName.value = category.name || '';
    el.categoryStatus.checked = Number(category.status) === 1;
    el.categorySubmit.textContent = 'บันทึกการแก้ไข';
    el.categoryCancel.classList.remove('hidden');
    el.categoryName.focus();
}

function resetCategoryForm() {
    el.adminCategoryForm.reset();
    el.categoryId.value = '';
    el.categoryStatus.checked = true;
    el.categorySubmit.textContent = 'เพิ่มหมวดหมู่';
    el.categoryCancel.classList.add('hidden');
}

async function saveCategory() {
    const id = el.categoryId.value;
    const payload = {
        name: el.categoryName.value.trim(),
        status: el.categoryStatus.checked ? 1 : 0,
    };

    if (!payload.name) {
        showToast('กรุณาระบุชื่อหมวดหมู่', 'error');
        return;
    }

    try {
        if (id) {
            await api(`/admin/categories/${id}`, {
                method: 'PUT',
                auth: true,
                body: payload,
            });
            showToast('อัปเดตหมวดหมู่แล้ว', 'success');
        } else {
            await api('/admin/categories', {
                method: 'POST',
                auth: true,
                body: payload,
            });
            showToast('เพิ่มหมวดหมู่แล้ว', 'success');
        }

        resetCategoryForm();
        await loadAdminCategories();
    } catch (error) {
        showToast(errorToMessage(error), 'error');
    }
}

async function deleteCategory(id) {
    const category = state.admin.categories.find((item) => String(item.id) === String(id));
    const categoryName = category?.name || 'หมวดหมู่นี้';

    const confirmed = window.confirm(`ยืนยันการลบ "${categoryName}" ?`);
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
                <td colspan="6" class="table-empty">ยังไม่พบกิจกรรม</td>
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
                            <p class="cell-sub">${escapeHtml(activity.location || '')}</p>
                        </td>
                        <td>${escapeHtml(activity.category?.name || '-')}</td>
                        <td>${activity.activity_date ? formatDate(activity.activity_date) : '-'}</td>
                        <td><span class="pill ${status ? 'pill-on' : 'pill-off'}">${status ? 'แสดงผล' : 'ปิด'}</span></td>
                        <td>${files || '-'}</td>
                        <td class="table-actions">
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

        resetActivityForm();
        await loadAdminActivities();
    } catch (error) {
        showToast(errorToMessage(error), 'error');
    }
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

        el.activitySubmit.textContent = 'บันทึกการแก้ไข';
        el.activityCancel.classList.remove('hidden');

        el.adminActivityForm.scrollIntoView({
            behavior: 'smooth',
            block: 'start',
        });
    } catch (error) {
        showToast(errorToMessage(error), 'error');
    }
}

function resetActivityForm() {
    el.adminActivityForm.reset();
    el.activityId.value = '';
    el.activityStatus.checked = true;
    el.activityExistingAssets.innerHTML = '';
    el.activitySubmit.textContent = 'เพิ่มกิจกรรม';
    el.activityCancel.classList.add('hidden');
}

async function deleteActivity(id) {
    const target = state.admin.activities.find((item) => String(item.id) === String(id));
    const label = target?.title || 'กิจกรรมนี้';
    const confirmed = window.confirm(`ยืนยันการลบ "${label}" ?`);
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

async function api(path, options = {}) {
    const {
        method = 'GET',
        body = null,
        auth = false,
    } = options;

    const headers = {
        Accept: 'application/json',
    };

    if (auth && state.admin.session?.token) {
        headers.Authorization = `Bearer ${state.admin.session.token}`;
    }

    let payload = body;

    if (body && !(body instanceof FormData)) {
        headers['Content-Type'] = 'application/json';
        payload = JSON.stringify(body);
    }

    const response = await fetch(`${API_PREFIX}${path}`, {
        method,
        headers,
        body: payload,
    });

    const data = await response.json().catch(() => ({}));

    if (!response.ok || data.success === false) {
        const error = new Error(data.message || `Request failed (${response.status})`);
        error.status = response.status;
        error.errors = data.errors || null;
        throw error;
    }

    return data;
}

function buildQuery(params) {
    const search = new URLSearchParams();

    Object.entries(params).forEach(([key, value]) => {
        if (value === null || value === undefined || value === '') {
            return;
        }
        search.set(key, String(value));
    });

    const query = search.toString();
    return query ? `?${query}` : '';
}

function setPublicLoading(isLoading) {
    if (isLoading) {
        el.publicSummary.textContent = 'กำลังโหลดข้อมูล...';
    }
}

function formatDate(value) {
    if (!value) {
        return '-';
    }

    const date = new Date(value);
    if (Number.isNaN(date.getTime())) {
        return value;
    }

    return new Intl.DateTimeFormat('th-TH', {
        dateStyle: 'medium',
    }).format(date);
}

function truncate(text, maxLength) {
    if (text.length <= maxLength) {
        return text;
    }

    return `${text.slice(0, maxLength).trim()}...`;
}

function escapeHtml(value) {
    return String(value)
        .replaceAll('&', '&amp;')
        .replaceAll('<', '&lt;')
        .replaceAll('>', '&gt;')
        .replaceAll('"', '&quot;')
        .replaceAll("'", '&#039;');
}

function escapeAttr(value) {
    return escapeHtml(value);
}

function resolveAssetUrl(url) {
    return new URL(url, window.location.origin).toString();
}

function showToast(message, type = 'info') {
    if (!el.toast) {
        return;
    }

    el.toast.textContent = message;
    el.toast.className = `toast ${type}`;
    window.clearTimeout(showToast.timeout);
    showToast.timeout = window.setTimeout(() => {
        el.toast.className = 'toast hidden';
    }, 2800);
}

function errorToMessage(error) {
    if (error?.errors && typeof error.errors === 'object') {
        const firstField = Object.keys(error.errors)[0];
        if (firstField && Array.isArray(error.errors[firstField])) {
            return error.errors[firstField][0];
        }
    }

    return error?.message || 'เกิดข้อผิดพลาดที่ไม่ทราบสาเหตุ';
}

function loadAdminSession() {
    try {
        const raw = localStorage.getItem(ADMIN_SESSION_KEY);
        return raw ? JSON.parse(raw) : null;
    } catch {
        return null;
    }
}

function saveAdminSession(session) {
    localStorage.setItem(ADMIN_SESSION_KEY, JSON.stringify(session));
}

function clearAdminSession() {
    state.admin.session = null;
    state.admin.bootstrapped = false;
    localStorage.removeItem(ADMIN_SESSION_KEY);
}
