@php
    $pageTitles = [
        'users' => 'Gestión de Usuarios',
        'players' => 'Gestión de Jugadores',
        'notes' => 'Notas de Jugadores',
        'permissions' => 'Roles y Permisos',
    ];
    $currentSection = request()->segment(1) ?? '';
    $pageTitle = $pageTitles[$currentSection] ?? 'Notas de Jugadores';

    $userInitials = '';
    $userRole = null;
    $navItems = collect();

    if (auth()->check()) {
        $parts = preg_split('/\s+/', trim(auth()->user()->name));
        $userInitials = strtoupper(collect($parts)->take(2)->map(fn ($p) => mb_substr($p, 0, 1))->join(''));

        $roleLabels = [
            'Admin' => 'Administrador',
            'Support Agent' => 'Agente de Soporte',
        ];
        $userRole = auth()->user()->roles->first()
            ? ($roleLabels[auth()->user()->roles->first()->name] ?? auth()->user()->roles->first()->name)
            : null;

        $navItems = collect([
            ['href' => '/users', 'label' => 'Usuarios', 'icon' => 'users', 'can' => 'users.view'],
            ['href' => '/players', 'label' => 'Jugadores', 'icon' => 'players', 'can' => 'players.view'],
            ['href' => '/notes', 'label' => 'Notas', 'icon' => 'notes', 'can' => 'notes.view'],
            ['href' => '/permissions', 'label' => 'Permisos', 'icon' => 'permissions', 'role' => 'Admin'],
        ])->filter(function ($item) {
            if (isset($item['can'])) {
                return auth()->user()->can($item['can']);
            }
            if (isset($item['role'])) {
                return auth()->user()->hasRole($item['role']);
            }
            return true;
        });
    }
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ $title ?? $pageTitle }} · Notas de Jugadores</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            brand: {
                                DEFAULT: '#002c36',
                                dark: '#001a20',
                                light: '#0a4454',
                            },
                        },
                        fontFamily: {
                            sans: ['Inter', 'system-ui', 'sans-serif'],
                        },
                    },
                },
            }
        </script>
        <style>
            [x-cloak] { display: none !important; }
        </style>
        @livewireStyles
    </head>
    <body class="bg-slate-100 font-sans antialiased text-slate-800" x-data="{ sidebarOpen: false }">
        @auth
        <div class="flex min-h-screen">
            {{-- Overlay móvil --}}
            <div
                x-show="sidebarOpen"
                x-cloak
                x-transition:enter="transition-opacity ease-linear duration-200"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity ease-linear duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                @click="sidebarOpen = false"
                class="fixed inset-0 z-40 bg-slate-900/50 lg:hidden"
            ></div>

            {{-- Sidebar --}}
            <aside
                :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
                class="fixed inset-y-0 left-0 z-50 flex w-72 flex-col bg-brand text-white shadow-2xl transition-transform duration-300 lg:static lg:translate-x-0"
            >
                {{-- Logo / App name --}}
                <div class="border-b border-white/10 px-6 py-6">
                    <div class="flex items-center gap-3">
                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-white/10 ring-1 ring-white/20">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-medium uppercase tracking-widest text-white/60">Panel</p>
                            <h1 class="text-lg font-bold leading-tight">Notas de Jugadores</h1>
                        </div>
                    </div>
                </div>

                {{-- User profile --}}
                <div class="border-b border-white/10 px-6 py-5">
                    <div class="flex items-center gap-4">
                        <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-teal-300 to-cyan-500 text-lg font-bold text-brand shadow-lg ring-2 ring-white/30">
                            {{ $userInitials }}
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-base font-semibold leading-snug">{{ auth()->user()->name }}</p>
                            <p class="truncate text-xs text-white/60">{{ auth()->user()->email }}</p>
                            @if($userRole)
                                <span class="mt-1.5 inline-block rounded-full bg-white/15 px-2.5 py-0.5 text-xs font-medium text-teal-100">
                                    {{ $userRole }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Navigation --}}
                <nav class="flex-1 space-y-1 overflow-y-auto px-4 py-5">
                    <p class="mb-3 px-3 text-xs font-semibold uppercase tracking-wider text-white/40">Menú</p>
                    @foreach($navItems as $item)
                        @php $isActive = request()->is(ltrim($item['href'], '/').'*') || request()->is(ltrim($item['href'], '/')); @endphp
                        <a
                            href="{{ $item['href'] }}"
                            @click="sidebarOpen = false"
                            class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition-all duration-200
                                {{ $isActive
                                    ? 'bg-white/15 text-white shadow-sm ring-1 ring-white/20'
                                    : 'text-white/70 hover:bg-white/10 hover:text-white' }}"
                        >
                            @if($item['icon'] === 'users')
                                <svg class="h-5 w-5 shrink-0 {{ $isActive ? 'text-teal-300' : 'text-white/50 group-hover:text-white/80' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" /></svg>
                            @elseif($item['icon'] === 'players')
                                <svg class="h-5 w-5 shrink-0 {{ $isActive ? 'text-teal-300' : 'text-white/50 group-hover:text-white/80' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 0 1 3 3h-15a3 3 0 0 1 3-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0a9.148 9.148 0 0 1-1.5-.124M9.75 8.25a3 3 0 1 1 6 0 3 3 0 0 1-6 0Z" /></svg>
                            @elseif($item['icon'] === 'notes')
                                <svg class="h-5 w-5 shrink-0 {{ $isActive ? 'text-teal-300' : 'text-white/50 group-hover:text-white/80' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" /></svg>
                            @elseif($item['icon'] === 'permissions')
                                <svg class="h-5 w-5 shrink-0 {{ $isActive ? 'text-teal-300' : 'text-white/50 group-hover:text-white/80' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" /></svg>
                            @endif
                            {{ $item['label'] }}
                            @if($isActive)
                                <span class="ml-auto h-1.5 w-1.5 rounded-full bg-teal-300"></span>
                            @endif
                        </a>
                    @endforeach
                </nav>

                {{-- Logout --}}
                <div class="border-t border-white/10 p-4">
                    <form method="POST" action="/logout">
                        @csrf
                        <button type="submit" class="flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-white/70 transition hover:bg-red-500/20 hover:text-red-200">
                            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" /></svg>
                            Cerrar sesión
                        </button>
                    </form>
                </div>
            </aside>

            {{-- Main content --}}
            <div class="flex min-w-0 flex-1 flex-col">
                {{-- Top bar --}}
                <header class="sticky top-0 z-30 border-b border-slate-200/80 bg-white/80 px-4 py-4 backdrop-blur-md sm:px-8">
                    <div class="flex items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <button
                                @click="sidebarOpen = !sidebarOpen"
                                class="rounded-lg p-2 text-slate-500 transition hover:bg-slate-100 hover:text-brand lg:hidden"
                                aria-label="Abrir menú"
                            >
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" /></svg>
                            </button>
                            <div>
                                <p class="text-xs font-medium uppercase tracking-wider text-slate-400">Notas de Jugadores</p>
                                <h2 class="text-xl font-bold text-slate-800 sm:text-2xl">{{ $pageTitle }}</h2>
                            </div>
                        </div>
                        <div class="hidden items-center gap-3 sm:flex">
                            <div class="text-right">
                                <p class="text-sm font-semibold text-slate-800">{{ auth()->user()->name }}</p>
                                @if($userRole)
                                    <p class="text-xs text-slate-500">{{ $userRole }}</p>
                                @endif
                            </div>
                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-brand text-sm font-bold text-white shadow-md">
                                {{ $userInitials }}
                            </div>
                        </div>
                    </div>
                </header>

                <main class="flex-1 p-4 sm:p-8">
                    {{ $slot }}
                </main>
            </div>
        </div>
        @else
        {{ $slot }}
        @endauth

        @livewireScripts
    </body>
</html>
