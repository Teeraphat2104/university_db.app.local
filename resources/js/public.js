/**
 * Public view module.
 * Category browsing → click category → activity list within that category.
 */

import { state, defaultMeta } from './state';
import { api, buildQuery, resolveAssetUrl, errorToMessage } from './api';
import { el, showToast, escapeHtml, escapeAttr, formatDate, truncate, setPublicLoading } from './ui';

/* ── View type: 'card' | 'table' ── */
let publicViewType = 'card';

function setPublicViewType(type) {
    publicViewType = type;
    const grid  = document.getElementById('public-activity-grid');
    const table = document.getElementById('public-activity-table-wrap');
    const cardBtn  = document.getElementById('view-card-btn');
    const tableBtn = document.getElementById('view-table-btn');

    if (type === 'table') {
        grid?.classList.add('hidden');
        table?.classList.remove('hidden');
        cardBtn?.classList.remove('is-active');
        tableBtn?.classList.add('is-active');
    } else {
        grid?.classList.remove('hidden');
        table?.classList.add('hidden');
        cardBtn?.classList.add('is-active');
        tableBtn?.classList.remove('is-active');
    }

    renderPublicActivities();
}

/* ── Data loading ── */

export async function loadPublicCategories() {
    try {
        const response = await api('/public/home');
        state.public.categories = response.data?.categories || [];
        renderPublicCategoryGrid();
        // Update stats from server
        const stats = response.data?.stats || {};
        updateStatsFromServer(stats, state.public.categories.length);
    } catch (error) {
        showToast(errorToMessage(error), 'error');
    }
}

function updateStatsFromServer(stats, categoryCount) {
    const statActivities = document.getElementById('stat-activities');
    const statCategories = document.getElementById('stat-categories');
    const statDocuments  = document.getElementById('stat-documents');
    const statRegistered = document.getElementById('stat-registered');

    if (statActivities) animateNumber(statActivities, stats.total_activities || 0);
    if (statCategories) animateNumber(statCategories, categoryCount);
    if (statDocuments)  animateNumber(statDocuments, stats.total_documents || 0);
    if (statRegistered) animateNumber(statRegistered, 0);
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
        el.publicCategoryGrid.innerHTML = `<p style="color:var(--color-gray-400);font-size:.875rem;padding:2rem 0">ยังไม่มีหมวดหมู่กิจกรรม</p>`;
        return;
    }

    el.publicCategoryGrid.innerHTML = categories.map((cat) => categoryCard(cat)).join('');
    updateStats(categories.length);
}

function updateStats(categoryCount) {
    const statActivities = document.getElementById('stat-activities');
    const statCategories = document.getElementById('stat-categories');
    const statRegistered = document.getElementById('stat-registered');
    const statDocuments = document.getElementById('stat-documents');

    if (statCategories) {
        animateNumber(statCategories, categoryCount);
    }

    if (statActivities) {
        const totalActivities = state.public.activities.length;
        animateNumber(statActivities, totalActivities || 0);
    }

    if (statRegistered) {
        animateNumber(statRegistered, 0);
    }

    if (statDocuments) {
        animateNumber(statDocuments, 0);
    }
}

function animateNumber(element, target) {
    if (!element) return;

    const duration = 1000;
    const start = 0;
    const startTime = performance.now();

    function update(currentTime) {
        const elapsed = currentTime - startTime;
        const progress = Math.min(elapsed / duration, 1);
        const easeOut = 1 - Math.pow(1 - progress, 3);
        const current = Math.floor(start + (target - start) * easeOut);
        element.textContent = current.toLocaleString('th-TH');

        if (progress < 1) {
            requestAnimationFrame(update);
        }
    }

    requestAnimationFrame(update);
}

function categoryCard(category) {
    const colors = [
        ['#EEF2FF','#6366F1'], ['#F0FDF4','#10B981'], ['#FFFBEB','#F59E0B'],
        ['#FAF5FF','#8B5CF6'], ['#FFF1F2','#F43F5E'], ['#ECFEFF','#06B6D4'],
    ];
    const [bg, fg] = colors[category.id % colors.length];

    const thumbnail = category.cover_image_url
        ? `<div class="cat-card-img"><img src="${escapeAttr(resolveAssetUrl(category.cover_image_url))}" alt="${escapeAttr(category.name)}"></div>`
        : `<div class="cat-card-placeholder" style="background:${bg};color:${fg}">${escapeHtml(category.name.slice(0, 1).toUpperCase())}</div>`;

    return `
        <button type="button" class="cat-card" data-action="browse" data-id="${category.id}" data-name="${escapeAttr(category.name)}">
            ${thumbnail}
            <div class="cat-card-body">
                <p class="cat-card-name">${escapeHtml(category.name)}</p>
                <p class="cat-card-hint">ดูกิจกรรม →</p>
            </div>
        </button>
    `;
}

/* ── Activity list rendering ── */

function renderPublicActivities() {
    const { activities, meta } = state.public;

    if (publicViewType === 'table') {
        renderPublicActivitiesTable(activities);
    } else {
        if (!activities.length) {
            el.publicGrid.innerHTML = `<p style="color:var(--color-gray-400);font-size:.875rem;padding:2rem 0">ไม่พบกิจกรรม</p>`;
        } else {
            el.publicGrid.innerHTML = activities.map((activity) => publicActivityCard(activity)).join('');
        }
    }

    el.publicSummary.textContent = `แสดง ${activities.length} รายการ จากทั้งหมด ${meta.total ?? 0} รายการ`;
    el.publicPage.textContent = `หน้า ${meta.current_page ?? 1} / ${meta.last_page ?? 1}`;
    el.publicPrev.disabled = (meta.current_page ?? 1) <= 1;
    el.publicNext.disabled = (meta.current_page ?? 1) >= (meta.last_page ?? 1);

    updateStats(state.public.categories.length);
}

function renderPublicActivitiesTable(activities) {
    const tbody = document.getElementById('public-activity-table-body');
    if (!tbody) return;

    if (!activities.length) {
        tbody.innerHTML = `<tr><td colspan="6" style="text-align:center;color:var(--color-gray-400);padding:2rem">ไม่พบกิจกรรม</td></tr>`;
        return;
    }

    tbody.innerHTML = activities.map((activity) => {
        const thumb = activity.cover_image_url
            ? `<img class="table-thumb" src="${escapeAttr(resolveAssetUrl(activity.cover_image_url))}" alt="">`
            : `<div class="table-thumb-ph" style="background:#EEF2FF;color:#6366F1">${escapeHtml((activity.title || '?').slice(0, 1).toUpperCase())}</div>`;

        const catName = activity.category?.name || '';
        const catBadge = catName ? `<span class="pill" style="background:#EEF2FF;color:#4338CA">${escapeHtml(catName)}</span>` : '—';

        return `
            <tr>
                <td style="width:52px">${thumb}</td>
                <td>
                    <div style="font-weight:600;color:var(--color-gray-800)">${escapeHtml(activity.title || '-')}</div>
                    ${activity.location ? `<div style="font-size:.75rem;color:var(--color-gray-400);margin-top:.15rem">${escapeHtml(activity.location)}</div>` : ''}
                </td>
                <td>${catBadge}</td>
                <td style="white-space:nowrap;font-size:.82rem">${activity.activity_date ? formatDate(activity.activity_date) : '—'}</td>
                <td>
                    <button type="button" class="btn btn-primary btn-sm" data-action="detail" data-id="${activity.id}">ดูรายละเอียด</button>
                </td>
            </tr>
        `;
    }).join('');
}

function publicActivityCard(activity) {
    const cover = activity.cover_image_url
        ? `<img src="${escapeAttr(resolveAssetUrl(activity.cover_image_url))}" alt="${escapeAttr(activity.title)}">`
        : `<div class="act-card-img-ph">📋</div>`;

    const categoryName = activity.category?.name || '';
    const shortDescription = truncate(activity.description || 'ไม่มีรายละเอียด', 90);
    const pdfLink = activity.pdf_url
        ? `<a style="font-size:.8rem;color:var(--color-primary)" href="${escapeAttr(resolveAssetUrl(activity.pdf_url))}" target="_blank" rel="noopener">PDF</a>`
        : '';
    const catBadge = categoryName
        ? `<span class="act-card-cat">${escapeHtml(categoryName)}</span>` : '';

    return `
        <article class="act-card">
            <div class="act-card-img">${cover}${catBadge}</div>
            <div class="act-card-body">
                <p class="act-card-meta">${activity.activity_date ? formatDate(activity.activity_date) : ''}${activity.location ? ` • ${escapeHtml(activity.location)}` : ''}</p>
                <h3 class="act-card-title">${escapeHtml(activity.title || '-')}</h3>
                <p class="act-card-desc">${escapeHtml(shortDescription)}</p>
                <div class="act-card-foot">
                    <button type="button" class="btn btn-primary btn-sm" data-action="detail" data-id="${activity.id}">ดูรายละเอียด</button>
                    ${pdfLink}
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

    /* ── View toggle ── */
    document.getElementById('view-card-btn')?.addEventListener('click', () => setPublicViewType('card'));
    document.getElementById('view-table-btn')?.addEventListener('click', () => setPublicViewType('table'));

    /* ── Activity detail (card view) ── */
    el.publicGrid.addEventListener('click', (event) => {
        const detailButton = event.target.closest('[data-action="detail"]');
        if (!detailButton) return;
        void openPublicDetail(detailButton.dataset.id);
    });

    /* ── Activity detail (table view) ── */
    document.getElementById('public-activity-table-body')?.addEventListener('click', (event) => {
        const detailButton = event.target.closest('[data-action="detail"]');
        if (!detailButton) return;
        void openPublicDetail(detailButton.dataset.id);
    });
}
