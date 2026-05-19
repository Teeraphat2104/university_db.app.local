/**
 * Application entry point.
 * Bootstraps modules, binds mode switching, and initialises views.
 */

import './bootstrap';

import { state } from './state';
import { errorToMessage } from './api';
import { cacheElements, el, showToast, bindDialogEvents, bindModalBackdropClose } from './ui';
import { loadPublicCategories, loadPublicActivities, bindPublicEvents } from './public';
import { ensureAdminSession, bindAdminEvents } from './admin';
import { bindParticipantSearchEvents } from './participant-search';

document.addEventListener('DOMContentLoaded', async () => {
    cacheElements();
    bindPublicEvents();
    bindAdminEvents();
    bindParticipantSearchEvents();
    bindDialogEvents();
    bindModalBackdropClose();
    bindModeSwitch();

    /* ── Standalone admin page (no SPA elements) → skip ── */
    if (!el.publicView) return;

    const initialMode = window.location.pathname.startsWith('/admin') ? 'admin' : 'public';
    setMode(initialMode, false);

    try {
        await Promise.all([loadPublicCategories(), loadPublicActivities()]);
        await ensureAdminSession();
    } catch (error) {
        showToast(errorToMessage(error), 'error');
    }
});

/* ── Mode switching ── */

function bindModeSwitch() {
    el.modeButtons.forEach((button) => {
        button.addEventListener('click', () => {
            setMode(button.dataset.mode);
        });
    });
}

function setMode(mode, updateHistory = true) {
    state.mode = mode === 'admin' ? 'admin' : 'public';

    if (!el.publicView || !el.adminView) return;

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
