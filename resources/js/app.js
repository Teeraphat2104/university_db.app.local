import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    const modeButtons = document.querySelectorAll('.mode-btn');
    const publicView = document.getElementById('public-view');
    const adminView = document.getElementById('admin-view');

    modeButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const mode = btn.dataset.mode;
            if (publicView) publicView.classList.toggle('hidden', mode !== 'public');
            if (adminView) adminView.classList.toggle('hidden', mode !== 'admin');
            const target = mode === 'admin' ? '/admin' : '/';
            if (window.location.pathname !== target) {
                window.history.replaceState({}, '', target);
            }
        });
    });
});
