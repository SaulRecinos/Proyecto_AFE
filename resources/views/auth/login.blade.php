<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Iniciar sesión — {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8 space-y-6">
        <div class="text-center">
            <h1 class="text-xl font-bold text-slate-800">{{ config('app.name') }}</h1>
            <p class="text-sm text-slate-500 mt-2">Acceso al panel de administración</p>
        </div>

        @if (session('error'))
            <div class="rounded-lg bg-red-50 border border-red-200 text-red-800 px-4 py-3 text-sm">
                {{ session('error') }}
            </div>
        @endif

        <p class="text-xs text-slate-500 text-center">
            Modo provisional: al pulsar el botón se inicia sesión <strong>sin comprobar contraseña</strong>
            (usuario <code class="bg-slate-100 px-1 rounded">admin@proyectoafe.com</code> o el primero en la tabla <code class="bg-slate-100 px-1">users</code>).
        </p>

        <form method="post" action="{{ url('/login') }}" class="space-y-4">
            @csrf
            <button type="submit"
                class="w-full py-3 px-4 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm transition shadow-sm">
                Entrar
            </button>
        </form>

        <p class="text-center text-sm">
            <a href="{{ url('/') }}" class="text-blue-600 hover:underline">Volver al inicio</a>
        </p>
    </div>
</body>
</html>
