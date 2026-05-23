<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso denegado — ERP Lite</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-900 flex items-center justify-center px-4">
    <div class="text-center">
        <p class="text-8xl font-black text-indigo-500 leading-none select-none mb-6">403</p>
        <h1 class="text-2xl font-bold text-white mb-2">Acceso denegado</h1>
        <p class="text-slate-400 text-sm mb-8 max-w-sm mx-auto">
            No tienes permiso para acceder a esta sección.<br>Contacta al administrador si crees que es un error.
        </p>
        <a href="{{ route('home') }}"
           class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-5 py-2.5 rounded-lg text-sm transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Volver al inicio
        </a>
    </div>
</body>
</html>
