<script>
    (function () {
        try {
            var stored = localStorage.getItem('shaghalny-theme');
            var prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            var theme = stored || (prefersDark ? 'dark' : 'light');
            var root = document.documentElement;
            root.classList.toggle('dark', theme === 'dark');
            root.style.colorScheme = theme;
        } catch (e) {}
    })();
</script>
