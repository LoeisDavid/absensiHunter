<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
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
            document.addEventListener('wheel', function (e) {
                if (e.ctrlKey) { e.preventDefault(); }
            }, { passive: false });
            document.addEventListener('keydown', function (e) {
                if (e.ctrlKey && (e.key === '+' || e.key === '-' || e.key === '=' || e.key === '_' || e.key === '0')) {
                    e.preventDefault();
                }
            });
        })();
    </script>
</head>
<body class="min-h-screen bg-slate-50 dark:bg-[#121212] flex items-center justify-center">
    <a href="{{ url('/') }}" class="text-blue-600 dark:text-blue-400 underline">Ke Halaman Login</a>
</body>
</html>