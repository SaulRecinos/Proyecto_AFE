<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso denegado — {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-900 to-slate-800 flex items-center justify-center px-4">
    <div class="text-center">
        <p class="text-9xl font-black text-red-500 leading-none select-none">403</p>

        <div class="flex items-center justify-center gap-3 my-6">
            <div class="h-px w-16 bg-slate-600"></div>
            <svg class="w-6 h-6 text-slate-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
            </svg>
            <div class="h-px w-16 bg-slate-600"></div>
        </div>

        <h1 class="text-2xl font-bold text-white mb-2">Acceso denegado</h1>
        <p class="text-slate-400 text-sm mb-8 max-w-sm mx-auto">
            No tienes permiso para acceder a esta sección. Contacta al administrador si crees que esto es un error.
        </p>

        <a href="{{ route('home') }}"
            class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-2.5 rounded-lg text-sm transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Volver al inicio
        </a>
    </div>
</body>
</html>
