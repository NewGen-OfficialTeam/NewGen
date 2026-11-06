(function() {
    const moonIcon = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z"/></svg>`;
    const sunIcon = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M8 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6zm0 1a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z"/></svg>`;

    function getSavedTheme() {
        // Por defecto es 'dark'
        return localStorage.getItem('newgen_theme') || localStorage.getItem('theme') || 'dark';
    }

    function applyTheme(theme) {
        localStorage.setItem('newgen_theme', theme);
        localStorage.setItem('theme', theme);
        document.cookie = "newgen_theme=" + theme + "; path=/; max-age=31536000";

        if (theme === 'light') {
            document.documentElement.classList.add('light-mode');
            if (document.body) {
                document.body.classList.add('light-mode');
            }
        } else {
            document.documentElement.classList.remove('light-mode');
            if (document.body) {
                document.body.classList.remove('light-mode');
            }
        }
        updateIcon();
    }

    function updateIcon() {
        const toggle = document.getElementById('themeToggle');
        if (!toggle) return;
        const isLight = (document.body && document.body.classList.contains('light-mode')) || 
                        document.documentElement.classList.contains('light-mode');
        toggle.innerHTML = isLight ? moonIcon : sunIcon;
    }

    function toggleTheme() {
        const current = getSavedTheme();
        const next = (current === 'light') ? 'dark' : 'light';
        applyTheme(next);
    }

    function init() {
        const current = getSavedTheme();
        applyTheme(current);

        const toggle = document.getElementById('themeToggle');
        if (toggle) {
            toggle.onclick = function(e) {
                e.preventDefault();
                toggleTheme();
            };
        }
    }

    // Inicializar inmediatamente y también al cargar el DOM para asegurar listener
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    window.NewGenTheme = {
        get: getSavedTheme,
        set: applyTheme,
        toggle: toggleTheme
    };
})();
