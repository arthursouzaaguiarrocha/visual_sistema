{{-- Menu dos módulos (desktop). Inclua dentro de layouts/navigation.blade.php: <x-menu-modulos /> --}}
<div class="hidden sm:flex sm:items-center sm:space-x-6">
    @foreach (config('modulos') as $grupo => $itens)
        @php
            $ativo = collect($itens)->contains(fn ($i) => request()->routeIs($i[1] . '.*'));
        @endphp
        <div class="relative" x-data="{ open: false }" @click.outside="open = false">
            <button type="button" @click="open = ! open"
                class="inline-flex items-center border-b-2 px-1 pt-1 text-sm font-medium leading-5 transition {{ $ativo ? 'border-indigo-400 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }}">
                {{ $grupo }}
                <svg class="ml-1 h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.17l3.71-3.94a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" /></svg>
            </button>
            <div x-show="open" x-cloak style="display: none"
                class="absolute left-0 z-50 mt-2 w-52 rounded-md bg-white py-1 shadow-lg ring-1 ring-black/5">
                @foreach ($itens as [$rotulo, $prefixo])
                    <a href="{{ route($prefixo . '.index') }}"
                        class="block px-4 py-2 text-sm hover:bg-gray-100 {{ request()->routeIs($prefixo . '.*') ? 'font-semibold text-indigo-700' : 'text-gray-700' }}">{{ $rotulo }}</a>
                @endforeach
            </div>
        </div>
    @endforeach
</div>
