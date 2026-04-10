/**
 * API communication module.
 * Wraps fetch with auth, JSON handling, and error normalisation.
 */

import { state } from './state';

const API_PREFIX = '/api';

export async function api(path, options = {}) {
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

export function buildQuery(params) {
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

export function errorToMessage(error) {
    if (error?.errors && typeof error.errors === 'object') {
        const firstField = Object.keys(error.errors)[0];
        if (firstField && Array.isArray(error.errors[firstField])) {
            return error.errors[firstField][0];
        }
    }

    return error?.message || 'เกิดข้อผิดพลาดที่ไม่ทราบสาเหตุ';
}

export function resolveAssetUrl(url) {
    return new URL(url, window.location.origin).toString();
}
