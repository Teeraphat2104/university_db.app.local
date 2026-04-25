/**
 * Participant search module.
 * Allows students to search activities by Student ID or name.
 */

import { api, errorToMessage } from './api';
import { escapeHtml, escapeAttr, showToast } from './ui';

let searchDialog = null;

/* ── Open / Close ── */

export function openParticipantSearch() {
    searchDialog = document.getElementById('participant-search-dialog');
    if (!searchDialog) return;
    resetSearch();
    searchDialog.showModal();
    document.body.style.overflow = 'hidden';
    document.getElementById('participant-search-input')?.focus();
}

function closeParticipantSearch() {
    searchDialog?.close();
    document.body.style.overflow = '';
}

function resetSearch() {
    const input = document.getElementById('participant-search-input');
    const results = document.getElementById('participant-search-results');
    if (input) input.value = '';
    if (results) results.innerHTML = `
        <p style="color:var(--color-gray-400);font-size:.875rem;text-align:center;padding:1.5rem 0">
            กรอกข้อมูลแล้วกด "ค้นหา"
        </p>
    `;
}

/* ── Search ── */

async function doSearch() {
    const input = document.getElementById('participant-search-input');
    const results = document.getElementById('participant-search-results');
    const q = input?.value.trim() || '';

    if (!q) {
        showToast('กรุณากรอก Student ID หรือชื่อ', 'error');
        return;
    }

    if (results) {
        results.innerHTML = `
            <div style="text-align:center;padding:2rem;color:var(--color-gray-400)">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="animation:spin 1s linear infinite;display:inline-block">
                    <path d="M21 12a9 9 0 1 1-6.219-8.56"/>
                </svg>
                <p style="margin-top:.5rem;font-size:.875rem">กำลังค้นหา...</p>
            </div>
        `;
    }

    try {
        const params = new URLSearchParams({ q });
        const response = await fetch(`/api/public/search?${params}`, {
            headers: { Accept: 'application/json' },
        });
        const data = await response.json();

        if (!data.success && !data.data) {
            renderNoResult(results, q);
            return;
        }

        renderResults(results, data, q);
    } catch (error) {
        if (results) results.innerHTML = `
            <p style="color:var(--color-danger);font-size:.875rem;text-align:center;padding:1.5rem 0">
                เกิดข้อผิดพลาด: ${escapeHtml(error?.message || 'ไม่สามารถเชื่อมต่อได้')}
            </p>
        `;
    }
}

function renderNoResult(container, q) {
    if (!container) return;
    container.innerHTML = `
        <div style="text-align:center;padding:2rem">
            <div style="font-size:2rem;margin-bottom:.5rem">🔍</div>
            <p style="font-weight:600;color:var(--color-gray-700)">ไม่พบข้อมูล</p>
            <p style="font-size:.82rem;color:var(--color-gray-400);margin-top:.25rem">
                ไม่พบ "${escapeHtml(q)}" ในระบบ
            </p>
        </div>
    `;
}

function renderResults(container, data, q) {
    if (!container) return;

    const { count, data: persons, query_type } = data;

    if (!count || !persons?.length) {
        renderNoResult(container, q);
        return;
    }

    const typeLabel = query_type === 'student_id'
        ? `<span style="background:#EEF2FF;color:#4338CA;padding:.15rem .5rem;border-radius:4px;font-size:.73rem">รหัสนักศึกษา</span>`
        : `<span style="background:#F0FDF4;color:#059669;padding:.15rem .5rem;border-radius:4px;font-size:.73rem">ชื่อ</span>`;

    const summary = `
        <div style="display:flex;align-items:center;gap:.5rem;margin-bottom:.75rem;font-size:.82rem;color:var(--color-gray-600)">
            ${typeLabel}
            พบ <strong>${count}</strong> รายการ
        </div>
    `;

    const cards = persons.map((person) => {
        const acts = (person.activities || []).map((a) => activityChip(a)).join('');
        return `
            <div style="border:1px solid var(--color-line);border-radius:var(--radius-md);padding:1rem;margin-bottom:.625rem">
                <div style="display:flex;align-items:center;gap:.5rem;margin-bottom:.625rem">
                    <div style="width:36px;height:36px;border-radius:50%;background:#EEF2FF;color:#6366F1;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.9rem;flex-shrink:0">
                        ${escapeHtml((person.name || '?').slice(0, 1).toUpperCase())}
                    </div>
                    <div>
                        <div style="font-weight:600;color:var(--color-gray-800)">${escapeHtml(person.name || '-')}</div>
                        <div style="font-size:.78rem;color:var(--color-gray-400)">รหัส: ${escapeHtml(person.student_id || '-')}</div>
                    </div>
                </div>
                <div style="display:flex;flex-wrap:wrap;gap:.375rem">
                    ${acts || '<span style="font-size:.8rem;color:var(--color-gray-400)">ยังไม่มีกิจกรรม</span>'}
                </div>
            </div>
        `;
    }).join('');

    container.innerHTML = summary + cards;
}

function activityChip(activity) {
    const date = activity.activity_date
        ? new Intl.DateTimeFormat('th-TH', { dateStyle: 'medium' }).format(new Date(activity.activity_date))
        : '';
    const cat = activity.category?.name || '';
    return `
        <div style="border:1px solid #E0E7FF;background:#F5F7FF;border-radius:var(--radius-sm);padding:.375rem .625rem;font-size:.78rem;max-width:100%">
            <div style="font-weight:600;color:var(--color-gray-800)">${escapeHtml(activity.title || '-')}</div>
            <div style="color:var(--color-gray-500);margin-top:.15rem">
                ${cat ? `<span style="color:#6366F1">${escapeHtml(cat)}</span>` : ''}
                ${date ? `<span style="margin-left:.375rem">📅 ${date}</span>` : ''}
                ${activity.location ? `<span style="margin-left:.375rem">📍 ${escapeHtml(activity.location)}</span>` : ''}
            </div>
        </div>
    `;
}

/* ── Event bindings ── */

export function bindParticipantSearchEvents() {
    document.getElementById('participant-search-dialog-close')?.addEventListener('click', closeParticipantSearch);

    document.getElementById('participant-search-dialog')?.addEventListener('click', (event) => {
        if (event.target === event.currentTarget) closeParticipantSearch();
    });

    document.getElementById('participant-search-dialog')?.addEventListener('close', () => {
        document.body.style.overflow = '';
    });

    document.getElementById('participant-search-btn')?.addEventListener('click', () => void doSearch());

    document.getElementById('participant-search-input')?.addEventListener('keydown', (event) => {
        if (event.key === 'Enter') {
            event.preventDefault();
            void doSearch();
        }
    });

    // Hint pills
    document.getElementById('ps-hint-id')?.addEventListener('click', () => {
        const input = document.getElementById('participant-search-input');
        if (input) { input.value = '6601234567'; input.focus(); }
    });
    document.getElementById('ps-hint-name')?.addEventListener('click', () => {
        const input = document.getElementById('participant-search-input');
        if (input) { input.value = 'สมชาย'; input.focus(); }
    });

    // Open via hero button
    document.getElementById('open-participant-search')?.addEventListener('click', openParticipantSearch);

    // Open via stat-registered-wrap click
    document.getElementById('stat-registered-wrap')?.addEventListener('click', openParticipantSearch);
}
