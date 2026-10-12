import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

const THEME_KEY = 'shaghalny-theme';

function applyTheme(theme) {
    const root = document.documentElement;
    root.classList.toggle('dark', theme === 'dark');
    root.style.colorScheme = theme;
}

window.toggleTheme = function () {
    const next = document.documentElement.classList.contains('dark') ? 'light' : 'dark';
    try {
        localStorage.setItem(THEME_KEY, next);
    } catch (e) {}
    applyTheme(next);
};

window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function (event) {
    try {
        if (localStorage.getItem(THEME_KEY)) return;
    } catch (e) {}
    applyTheme(event.matches ? 'dark' : 'light');
});

Alpine.start();
