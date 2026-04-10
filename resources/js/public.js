/**
 * Public view module.
 * Category browsing → click category → activity list within that category.
 */

import { state, defaultMeta } from './state';
import { api, buildQuery, resolveAssetUrl, errorToMessage } from './api';
import { el, showToast, escapeHtml, escapeAttr, formatDate, truncate, setPublicLoading } from './ui';

/* ── Data loading ── */

export async function loadPublicCategories() {
    try {
        const response = await api('/public/categories');
        state.public.categories = response.data || [];
        renderPublicCategoryGrid();
    } catch (error) {
        showToast(errorToMessage(error), 'error');
    }
}

export async function loadPublicActivities() {
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

/* ── View switching ── */

function showCategoriesView() {
    state.public.viewMode = 'categories';
    state.public.filters.category_id = '';
    state.public.filters.keyword = '';
    state.public.filters.page = 1;

    el.publicCategoriesView.classList.remove('hidden');
    el.publicActivitiesView.classList.add('hidden');
}

function showActivitiesView(categoryId, categoryName) {
    state.public.viewMode = 'activities';
    state.public.filters.category_id = categoryId;
    state.public.filters.keyword = '';
    state.public.filters.page = 1;

    el.publicActivitiesTitle.textContent = categoryName;
    el.publicActivitiesSubtitle.textContent = 'ค้นหาและกรองกิจกรรม พร้อมเปิดหรือดาวน์โหลดเอกสาร PDF ได้ทันที';
    el.publicKeyword.value = '';

    el.publicCategoriesView.classList.add('hidden');
    el.publicActivitiesView.classList.remove('hidden');

    void loadPublicActivities();
}

/* ── Category grid rendering ── */

function renderPublicCategoryGrid() {
    const categories = state.public.categories;

    if (!categories.length) {
        el.publicCategoryGrid.innerHTML = `
            <div class="border border-dashed border-line rounded-xl bg-slate-50 p-6 text-center col-span-full">
                <h4 class="m-0 mb-1 font-semibold">ไม่พบหมวดหมู่</h4>
                <p class="m-0 text-muted">ยังไม่มีหมวดหมู่กิจกรรมในระบบ</p>
            </div>
        `;
        return;
    }

    el.publicCategoryGrid.innerHTML = categories.map((cat) => categoryCard(cat)).join('');
}

function categoryCard(category) {
    const cover = category.cover_image_url
        ? `<img src="${escapeAttr(resolveAssetUrl(category.cover_image_url))}" alt="${escapeAttr(category.name)}" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">`
        : `<div class="w-full h-full grid place-items-center font-display text-4xl text-primary/60 bg-gradient-to-br from-teal-50 to-emerald-100">${escapeHtml(category.name.slice(0, 1).toUpperCase())}</div>`;

    return `
        <button type="button" class="group grid grid-rows-[140px_auto] border border-line rounded-xl bg-white overflow-hidden text-left cursor-pointer hover:shadow-card transition-all duration-200" data-action="browse" data-id="${category.id}" data-name="${escapeAttr(category.name)}">
            <div class="overflow-hidden">${cover}</div>
            <div class="p-3.5">
                <h3 class="m-0 text-base font-semibold group-hover:text-primary transition-colors">${escapeHtml(category.name)}</h3>
            </div>
        </button>
    `;
}

/* ── Activity list rendering ── */

function renderPublicActivities() {
    const { activities, meta } = state.public;

    if (!activities.length) {
        el.publicGrid.innerHTML = `
            <article class="border border-dashed border-line rounded-xl bg-slate-50 p-6 text-center col-span-full">
                <h4 class="m-0 mb-1 font-semibold">ไม่พบกิจกรรม</h4>
                <p class="m-0 text-muted">ลองเปลี่ยนคำค้นหา หรือยังไม่มีกิจกรรมในหมวดนี้</p>
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
        ? `<img src="${escapeAttr(resolveAssetUrl(activity.cover_image_url))}" alt="${escapeAttr(activity.title)}" class="w-full h-full object-cover">`
        : `<div class="w-full h-full grid place-items-center font-display text-3xl text-primary">${escapeHtml((activity.title || 'A').slice(0, 1).toUpperCase())}</div>`;

    const categoryName = activity.category?.name || 'ไม่ระบุหมวดหมู่';
    const shortDescription = truncate(activity.description || 'ไม่มีรายละเอียดเพิ่มเติม', 140);
    const openPdfButton = activity.pdf_url
        ? `<a class="btn btn-muted" href="${escapeAttr(resolveAssetUrl(activity.pdf_url))}" target="_blank" rel="noopener">เปิด PDF</a>`
        : '';
    const downloadPdfButton = activity.pdf_url
        ? `<a class="btn btn-muted" href="${escapeAttr(resolveAssetUrl(activity.pdf_url))}" target="_blank" rel="noopener" download>ดาวน์โหลด PDF</a>`
        : '';

    return `
        <article class="grid grid-rows-[156px_1fr] border border-line rounded-xl bg-white overflow-hidden hover:shadow-card transition-shadow duration-200">
            <div class="bg-gradient-to-br from-teal-100 to-emerald-50">${cover}</div>
            <div class="p-3.5 grid gap-2">
                <p class="text-xs text-muted m-0">${escapeHtml(categoryName)}${activity.activity_date ? ` • ${formatDate(activity.activity_date)}` : ''}</p>
                <h3 class="m-0 text-base font-semibold">${escapeHtml(activity.title || '-')}</h3>
                <p class="m-0 text-sm text-gray-600">${escapeHtml(shortDescription)}</p>
                <div class="inline-flex flex-wrap items-center gap-2 mt-1">
                    <button type="button" class="btn btn-primary" data-action="detail" data-id="${activity.id}">ดูรายละเอียด</button>
                    ${openPdfButton}
                    ${downloadPdfButton}
                </div>
            </div>
        </article>
    `;
}

/* ── Detail dialog ── */

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

/* ── Event bindings ── */

export function bindPublicEvents() {
    /* ── Category grid click → navigate to activity list ── */
    el.publicCategoryGrid.addEventListener('click', (event) => {
        const card = event.target.closest('[data-action="browse"]');
        if (!card) {
            return;
        }
        showActivitiesView(card.dataset.id, card.dataset.name);
    });

    /* ── Back to categories ── */
    el.publicBackBtn.addEventListener('click', () => {
        showCategoriesView();
    });

    /* ── Search & filter within category ── */
    el.publicSearch.addEventListener('click', () => {
        state.public.filters.keyword = el.publicKeyword.value.trim();
        state.public.filters.page = 1;
        void loadPublicActivities();
    });

    el.publicReset.addEventListener('click', () => {
        el.publicKeyword.value = '';
        state.public.filters.keyword = '';
        state.public.filters.page = 1;
        void loadPublicActivities();
    });

    el.publicKeyword.addEventListener('keydown', (event) => {
        if (event.key === 'Enter') {
            event.preventDefault();
            el.publicSearch.click();
        }
    });

    /* ── Pagination ── */
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

    /* ── Activity detail ── */
    el.publicGrid.addEventListener('click', (event) => {
        const detailButton = event.target.closest('[data-action="detail"]');
        if (!detailButton) {
            return;
        }
        void openPublicDetail(detailButton.dataset.id);
    });
}
