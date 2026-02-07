/* ============================================
   Nexora Admin Dashboard - Dark Mode Toggle
   الوضع الليلي
   ============================================ */

(function () {
    'use strict';

    var STORAGE_KEY = 'nexora-theme';
    var DARK = 'dark';
    var LIGHT = 'light';

    // Get saved theme or detect system preference
    function getPreferredTheme() {
        var saved = localStorage.getItem(STORAGE_KEY);
        if (saved) return saved;
        return window.matchMedia('(prefers-color-scheme: dark)').matches ? DARK : LIGHT;
    }

    // Apply theme to document
    function applyTheme(theme) {
        document.documentElement.setAttribute('data-theme', theme);
        updateToggleIcon(theme);
    }

    // Update toggle button icon
    function updateToggleIcon(theme) {
        var btn = document.getElementById('darkModeToggle');
        if (!btn) return;
        var icon = btn.querySelector('i');
        if (!icon) return;

        if (theme === DARK) {
            icon.className = 'fas fa-sun';
        } else {
            icon.className = 'fas fa-moon';
        }
    }

    // Initialize on page load
    var currentTheme = getPreferredTheme();
    applyTheme(currentTheme);

    // Toggle on button click
    document.addEventListener('DOMContentLoaded', function () {
        var btn = document.getElementById('darkModeToggle');
        if (btn) {
            updateToggleIcon(currentTheme);
            btn.addEventListener('click', function () {
                var theme = document.documentElement.getAttribute('data-theme');
                var newTheme = theme === DARK ? LIGHT : DARK;
                localStorage.setItem(STORAGE_KEY, newTheme);
                applyTheme(newTheme);
            });
        }
    });

    // Listen for system theme changes
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function (e) {
        if (!localStorage.getItem(STORAGE_KEY)) {
            applyTheme(e.matches ? DARK : LIGHT);
        }
    });
})();
