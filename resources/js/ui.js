/**
 * UI utilities module.
 * DOM element cache, toast, dialog, confirm popup, and formatting helpers.
 */

export const el = {};

export function cacheElements() {
    el.modeButtons = document.querySelectorAll('.mode-btn');
    el.publicView = document.getElementById('public-view');
    el.adminView = document.getElementById('admin-view');

    /* ── Public: category browsing ── */
    el.publicCategoriesView = document.getElementById('public-categories-view');
    el.publicCategoryGrid = document.getElementById('public-category-grid');
    el.publicActivitiesView = document.getElementById('public-activities-view');
    el.publicBackBtn = document.getElementById('public-back-to-categories');
    el.publicActivitiesTitle = document.getElementById('public-activities-title');
    el.publicActivitiesSubtitle = document.getElementById('public-activities-subtitle');

    el.publicKeyword = document.getElementById('public-keyword');
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

    /* ── Confirm dialog ── */
    el.confirmDialog = document.getElementById('confirm-dialog');
    el.confirmTitle = document.getElementById('confirm-title');
    el.confirmMessage = document.getElementById('confirm-message');
    el.confirmOk = document.getElementById('confirm-ok');
    el.confirmCancel = document.getElementById('confirm-cancel');

    /* ── Admin auth ── */
    el.adminAuthCard = document.getElementById('admin-auth-card');
    el.adminDashboard = document.getElementById('admin-dashboard');
    el.adminLoginForm = document.getElementById('admin-login-form');
    el.adminEmail = document.getElementById('admin-email');
    el.adminPassword = document.getElementById('admin-password');
    el.adminProfileText = document.getElementById('admin-profile-text');
    el.adminLogout = document.getElementById('admin-logout');

    /* ── Category form dialog ── */
    el.categoryFormDialog = document.getElementById('category-form-dialog');
    el.categoryFormDialogTitle = document.getElementById('category-form-dialog-title');
    el.categoryDialogCloseBtn = document.getElementById('category-dialog-close-btn');
    el.categoryAddBtn = document.getElementById('category-add-btn');

    el.adminCategoryForm = document.getElementById('admin-category-form');
    el.categoryId = document.getElementById('category-id');
    el.categoryName = document.getElementById('category-name');
    el.categoryCover = document.getElementById('category-cover');
    el.categoryExistingCover = document.getElementById('category-existing-cover');
    el.categoryStatus = document.getElementById('category-status');
    el.categorySubmit = document.getElementById('category-submit');
    el.categoryCancel = document.getElementById('category-cancel');
    el.categoryList = document.getElementById('admin-category-list');

    /* ── Activity form dialog ── */
    el.activityFormDialog = document.getElementById('activity-form-dialog');
    el.activityFormDialogTitle = document.getElementById('activity-form-dialog-title');
    el.activityDialogCloseBtn = document.getElementById('activity-dialog-close-btn');
    el.activityAddBtn = document.getElementById('activity-add-btn');

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

/* ── Toast ── */

export function showToast(message, type = 'info') {
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

/* ── Activity detail dialog ── */

export function closeDialog() {
    if (typeof el.dialog.close === 'function' && el.dialog.open) {
        el.dialog.close();
        return;
    }
    el.dialog.removeAttribute('open');
}

export function bindDialogEvents() {
    el.dialogClose.addEventListener('click', () => closeDialog());
    el.dialog.addEventListener('click', (event) => {
        if (event.target === el.dialog) {
            closeDialog();
        }
    });
}

/* ── Confirm dialog ── */

/**
 * Shows a styled confirmation popup and returns a Promise<boolean>.
 * Replaces window.confirm() with a premium UI.
 */
export function showConfirmDialog(title, message) {
    return new Promise((resolve) => {
        el.confirmTitle.textContent = title;
        el.confirmMessage.textContent = message;

        let confirmed = false;

        const onConfirm = () => {
            confirmed = true;
            el.confirmDialog.close();
        };

        const onCancel = () => {
            el.confirmDialog.close();
        };

        const onClose = () => {
            el.confirmOk.removeEventListener('click', onConfirm);
            el.confirmCancel.removeEventListener('click', onCancel);
            resolve(confirmed);
        };

        el.confirmOk.addEventListener('click', onConfirm);
        el.confirmCancel.addEventListener('click', onCancel);
        el.confirmDialog.addEventListener('close', onClose, { once: true });

        el.confirmDialog.showModal();
    });
}

/* ── Modal backdrop close (generic) ── */

export function bindModalBackdropClose() {
    document.querySelectorAll('dialog.modal').forEach((dialog) => {
        dialog.addEventListener('click', (event) => {
            if (event.target === dialog) {
                dialog.close();
            }
        });
    });
}

/* ── Formatting helpers ── */

export function escapeHtml(value) {
    return String(value)
        .replaceAll('&', '&amp;')
        .replaceAll('<', '&lt;')
        .replaceAll('>', '&gt;')
        .replaceAll('"', '&quot;')
        .replaceAll("'", '&#039;');
}

export function escapeAttr(value) {
    return escapeHtml(value);
}

export function formatDate(value) {
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

export function truncate(text, maxLength) {
    if (text.length <= maxLength) {
        return text;
    }

    return `${text.slice(0, maxLength).trim()}...`;
}

export function setPublicLoading(isLoading) {
    if (isLoading) {
        el.publicSummary.textContent = 'กำลังโหลดข้อมูล...';
    }
}
