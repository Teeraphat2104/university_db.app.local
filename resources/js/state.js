/**
 * State management module.
 * Centralises application state and admin session persistence.
 */

export const ADMIN_SESSION_KEY = 'university-admin-session-v1';

export const defaultMeta = {
    current_page: 1,
    last_page: 1,
    total: 0,
    per_page: 10,
};

export const state = {
    mode: 'public',
    public: {
        viewMode: 'categories',
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

/* ── Session helpers ── */

export function loadAdminSession() {
    try {
        const raw = localStorage.getItem(ADMIN_SESSION_KEY);
        return raw ? JSON.parse(raw) : null;
    } catch {
        return null;
    }
}

export function saveAdminSession(session) {
    localStorage.setItem(ADMIN_SESSION_KEY, JSON.stringify(session));
}

export function clearAdminSession() {
    state.admin.session = null;
    state.admin.bootstrapped = false;
    localStorage.removeItem(ADMIN_SESSION_KEY);
}
