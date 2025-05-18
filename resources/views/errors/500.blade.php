<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - Kesalahan Server</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #fafafa;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full">
        <div class="text-center">
            <h1 class="text-8xl font-semibold text-gray-900 mb-6">
                500
            </h1>

            <h2 class="text-xl font-medium text-gray-800 mb-3">
                Kesalahan Server
            </h2>
            <p class="text-gray-500 mb-8">
                Maaf, terjadi kesalahan pada server. Kami akan menangani ini secepatnya.
            </p>

            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <button onclick="history.back()" 
                        class="inline-flex items-center px-4 py-2 text-sm font-medium btn btn-soft btn-secondary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali
                </button>
                <a href="{{ url('/') }}" 
                   class="inline-flex items-center px-4 py-2 text-sm font-medium btn btn-accent btn-soft">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Beranda
                </a>
            </div>
        </div>
    </div>
</body>
</html> 