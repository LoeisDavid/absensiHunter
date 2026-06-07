<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
</head>
<body class="min-h-screen bg-slate-50 dark:bg-[#121212] flex items-center justify-center">
    <a href="{{ url('/') }}" class="text-blue-600 dark:text-blue-400 underline">Ke Halaman Login</a>
</body>
</html>