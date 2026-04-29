<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans antialiased text-gray-900 min-h-screen flex flex-col">
    <nav class="bg-slate-900 text-white shadow">
        <div class="max-w-7xl mx-auto px-4 py-3 flex flex-wrap items-center justify-between gap-4 text-sm">
            <div class="flex flex-wrap items-center gap-2 lg:gap-3">
                <a href="{{ route('home') }}" class="font-semibold hover:text-slate-300 mr-1">{{ config('app.name') }}</a>

                @php
                    $caret = '<svg class="w-4 h-4 opacity-70 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>';
                @endphp

                {{-- Módulo: Administración (hover: abrir / salir ratón: cerrar) --}}
                <div data-nav-dropdown class="relative z-50 inline-block text-left">
                    <div class="flex cursor-default items-center gap-1 px-2 py-1 rounded hover:bg-slate-800 text-slate-200 select-none">
                        <span>Administración</span>
                        {!! $caret !!}
                    </div>
                    <div data-nav-panel class="hidden absolute left-0 top-full z-50 min-w-[220px] pt-1">
                        <div class="rounded-lg bg-slate-800 border border-slate-600 py-1 shadow-xl">
                        <a href="{{ route('admin.roles.index') }}"
                            class="block px-4 py-2.5 {{ request()->routeIs('admin.roles.*') ? 'bg-slate-700 text-white font-medium' : 'text-slate-100 hover:bg-slate-600' }}">
                            Roles
                        </a>
                        <a href="{{ route('admin.permissions.index') }}"
                            class="block px-4 py-2.5 {{ request()->routeIs('admin.permissions.*') ? 'bg-slate-700 text-white font-medium' : 'text-slate-100 hover:bg-slate-600' }}">
                            Permisos
                        </a>
                        <a href="{{ route('admin.users.index') }}"
                            class="block px-4 py-2.5 {{ request()->routeIs('admin.users.*') ? 'bg-slate-700 text-white font-medium' : 'text-slate-100 hover:bg-slate-600' }}">
                            Usuarios
                        </a>
                        </div>
                    </div>
                </div>

                {{-- Módulo: Clientes y proveedores --}}
                <div data-nav-dropdown class="relative z-50 inline-block text-left">
                    <div class="flex cursor-default items-center gap-1 px-2 py-1 rounded hover:bg-slate-800 text-slate-200 select-none">
                        <span>Clientes y proveedores</span>
                        {!! $caret !!}
                    </div>
                    <div data-nav-panel class="hidden absolute left-0 top-full z-50 min-w-[220px] pt-1">
                        <div class="rounded-lg bg-slate-800 border border-slate-600 py-1 shadow-xl">
                            <a href="#" class="block px-4 py-2.5 text-slate-100 hover:bg-slate-600">Clientes</a>
                            <a href="#" class="block px-4 py-2.5 text-slate-100 hover:bg-slate-600">Proveedores</a>
                        </div>
                    </div>
                </div>

                {{-- Módulo: Inventario --}}
                <div data-nav-dropdown class="relative z-50 inline-block text-left">
                    <div class="flex cursor-default items-center gap-1 px-2 py-1 rounded hover:bg-slate-800 text-slate-200 select-none">
                        <span>Inventario</span>
                        {!! $caret !!}
                    </div>
                    <div data-nav-panel class="hidden absolute left-0 top-full z-50 min-w-[220px] pt-1">
                        <div class="rounded-lg bg-slate-800 border border-slate-600 py-1 shadow-xl">
                            <a href="#" class="block px-4 py-2.5 text-slate-100 hover:bg-slate-600">Artículos</a>
                            <a href="#" class="block px-4 py-2.5 text-slate-100 hover:bg-slate-600">Movimientos</a>
                        </div>
                    </div>
                </div>

                {{-- Módulo: Facturación --}}
                <div data-nav-dropdown class="relative z-50 inline-block text-left">
                    <div class="flex cursor-default items-center gap-1 px-2 py-1 rounded hover:bg-slate-800 text-slate-200 select-none">
                        <span>Facturación</span>
                        {!! $caret !!}
                    </div>
                    <div data-nav-panel class="hidden absolute left-0 top-full z-50 min-w-[220px] pt-1">
                        <div class="rounded-lg bg-slate-800 border border-slate-600 py-1 shadow-xl">
                            <a href="#" class="block px-4 py-2.5 text-slate-100 hover:bg-slate-600">Facturas</a>
                        </div>
                    </div>
                </div>

                {{-- Módulo: Reportes --}}
                <div data-nav-dropdown class="relative z-50 inline-block text-left">
                    <div class="flex cursor-default items-center gap-1 px-2 py-1 rounded hover:bg-slate-800 text-slate-200 select-none">
                        <span>Reportes</span>
                        {!! $caret !!}
                    </div>
                    <div data-nav-panel class="hidden absolute left-0 top-full z-50 min-w-[220px] pt-1">
                        <div class="rounded-lg bg-slate-800 border border-slate-600 py-1 shadow-xl">
                            <a href="#" class="block px-4 py-2.5 text-slate-100 hover:bg-slate-600">Reportes generales</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-3">
                @auth
                    <span class="text-slate-400">{{ auth()->user()->name }}</span>
                    <form method="post" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-slate-300 hover:text-white underline text-xs">Salir</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-blue-300 hover:text-white text-xs">Iniciar sesión</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="flex-1 max-w-7xl mx-auto w-full px-4 py-8">
        @if (session('success'))
            <div class="mb-4 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 text-sm">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="mb-4 rounded-lg bg-red-50 border border-red-200 text-red-800 px-4 py-3 text-sm">
                {{ session('error') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="mb-4 rounded-lg bg-red-50 border border-red-200 text-red-800 px-4 py-3 text-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <script>
        document.querySelectorAll('[data-nav-dropdown]').forEach(function (el) {
            var panel = el.querySelector('[data-nav-panel]');
            if (!panel) return;
            el.addEventListener('mouseenter', function () {
                panel.classList.remove('hidden');
            });
            el.addEventListener('mouseleave', function () {
                panel.classList.add('hidden');
            });
        });
    </script>
</body>
</html>
