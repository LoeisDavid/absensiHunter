<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Absensi Hunter</title>
    <script>
        (function() {
            const theme = localStorage.getItem('theme') || 'light';
            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>
    @vite(['resources/css/app.css'])
    <script>
        (function () {
            function applyAntiZoom() {
                var ratio = window.outerWidth / window.innerWidth;
                if (!ratio || !isFinite(ratio) || ratio <= 0) ratio = 1;
                var body = document.body;
                body.style.transform = 'scale(' + (1 / ratio) + ')';
                body.style.transformOrigin = 'top left';
                body.style.width = (ratio * 100) + '%';
                body.style.minHeight = (ratio * 100) + 'vh';
                body.style.overflowX = 'hidden';
            }
            applyAntiZoom();
            window.addEventListener('resize', applyAntiZoom);
        })();
    </script>
</head>
<body class="min-h-screen bg-slate-50 dark:bg-[#121212] flex items-center justify-center">
    <a href="{{ url('/') }}" class="text-blue-600 dark:text-blue-400 underline">Ke Halaman Login</a>
</body>
</html>