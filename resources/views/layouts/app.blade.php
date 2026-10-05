<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Sistema') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=dm-sans:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'DM Sans', ui-sans-serif, system-ui, sans-serif; }
    </style>
</head>
<body class="bg-slate-100 text-slate-800 antialiased" x-data="{ sidebarOpen: false }">
    <div class="flex min-h-screen">
        {{-- ===== SIDEBAR ===== --}}
        <aside
            class="fixed inset-y-0 left-0 z-40 flex w-64 flex-col bg-slate-900 text-slate-300 transition-transform duration-200 lg:static lg:translate-x-0"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        >
            {{-- Brand --}}
            <div class="flex h-16 items-center gap-3 border-b border-white/10 px-5">
                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-indigo-500 text-sm font-bold text-white shadow-lg shadow-indigo-500/30">
                    {{ strtoupper(substr(config('app.name', 'S'), 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <p class="truncate text-sm font-semibold text-white">{{ config('app.name', 'Sistema') }}</p>
                    <p class="text-[11px] text-slate-500">Gestão integrada</p>
                </div>
            </div>

            {{-- Nav --}}
            <nav class="flex-1 overflow-y-auto px-3 py-4">
                <a href="{{ route('dashboard') }}"
                   class="mb-4 flex items-center gap-2.5 rounded-lg px-3 py-2 text-sm font-medium transition
                   {{ request()->routeIs('dashboard') ? 'bg-indigo-500/15 text-indigo-300' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                    <svg class="h-4.5 w-4.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1h-2z"/>
                    </svg>
                    Dashboard
                </a>

                @foreach (config('modulos') as $grupo => $itens)
                    @php
                        $grupoAtivo = collect($itens)->contains(fn ($i) => request()->routeIs($i[1] . '.*'));
                    @endphp
                    <div class="mb-3" x-data="{ open: {{ $grupoAtivo ? 'true' : 'false' }} }">
                        <button type="button" @click="open = !open"
                            class="flex w-full items-center justify-between rounded-lg px-3 py-1.5 text-[11px] font-semibold uppercase tracking-wider transition
                            {{ $grupoAtivo ? 'text-indigo-300' : 'text-slate-500 hover:text-slate-300' }}">
                            <span>{{ $grupo }}</span>
                            <svg class="h-3.5 w-3.5 transition-transform" :class="open && 'rotate-180'" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="open" x-cloak class="mt-0.5 space-y-0.5">
                            @foreach ($itens as [$rotulo, $prefixo])
                                <a href="{{ route($prefixo . '.index') }}"
                                   class="block rounded-lg px-3 py-2 text-sm transition
                                   {{ request()->routeIs($prefixo . '.*')
                                        ? 'bg-indigo-500/15 font-medium text-indigo-300'
                                        : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                                    {{ $rotulo }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </nav>

            {{-- User footer --}}
            <div class="border-t border-white/10 p-3">
                <div class="flex items-center gap-3 rounded-lg px-2 py-2">
                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-slate-700 text-xs font-semibold text-white">
                        {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="truncate text-sm font-medium text-white">{{ Auth::user()->name ?? '' }}</p>
                        <p class="truncate text-[11px] text-slate-500">{{ Auth::user()->email ?? '' }}</p>
                    </div>
                </div>
                <div class="mt-1 flex gap-1">
                    <a href="{{ route('profile.edit') }}"
                       class="flex-1 rounded-md px-2 py-1.5 text-center text-xs text-slate-400 transition hover:bg-white/5 hover:text-white">
                        Perfil
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="flex-1">
                        @csrf
                        <button type="submit"
                            class="w-full rounded-md px-2 py-1.5 text-xs text-slate-400 transition hover:bg-white/5 hover:text-red-400">
                            Sair
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        {{-- Overlay mobile --}}
        <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false"
             class="fixed inset-0 z-30 bg-slate-900/50 backdrop-blur-sm lg:hidden"></div>

        {{-- ===== MAIN ===== --}}
        <div class="flex min-w-0 flex-1 flex-col">
            {{-- Top bar --}}
            <header class="sticky top-0 z-20 flex h-16 items-center gap-4 border-b border-slate-200/80 bg-white/80 px-4 backdrop-blur-md sm:px-6 lg:px-8">
                <button type="button" @click="sidebarOpen = true"
                    class="rounded-lg p-2 text-slate-500 hover:bg-slate-100 lg:hidden">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <div class="min-w-0 flex-1">
                    @isset($header)
                        {{ $header }}
                    @endisset
                </div>
            </header>

            {{-- Content --}}
            <main class="flex-1">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
