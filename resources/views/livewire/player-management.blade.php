<div>
    @if (session()->has('message'))
        <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-700">
            {{ session('message') }}
        </div>
    @endif

    <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
        @can('players.create')
        <div class="h-fit rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm">
            <h3 class="mb-4 text-lg font-semibold text-slate-800">Crear jugador</h3>
            
            <form wire:submit="createPlayer" class="space-y-4">
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">Nombre del jugador</label>
                    <input type="text" wire:model="name" class="block w-full rounded-xl border border-slate-200 p-2.5 shadow-sm focus:border-brand focus:ring-2 focus:ring-brand/20">
                    @error('name') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">Nacionalidad (opcional)</label>
                    <input type="text" wire:model="nationality" class="block w-full rounded-xl border border-slate-200 p-2.5 shadow-sm focus:border-brand focus:ring-2 focus:ring-brand/20">
                    @error('nationality') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="w-full rounded-xl bg-brand py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-dark">
                    Guardar jugador
                </button>
            </form>
        </div>
        @else
        <div class="h-fit rounded-2xl border border-slate-200/80 bg-slate-50 p-6 text-center italic text-slate-500 shadow-sm">
            No tienes permiso para crear jugadores.
        </div>
        @endcan

        <div class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-sm md:col-span-2">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Nacionalidad</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Creado</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">Acción</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @foreach($players as $player)
                        <tr class="transition hover:bg-slate-50/80">
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="text-sm font-medium text-slate-900">{{ $player->name }}</div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="text-sm text-slate-500">{{ $player->nationality ?? 'N/A' }}</div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-500">
                                {{ $player->created_at->format('d/m/Y') }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                                <a href="/notes?selectedPlayerId={{ $player->id }}" class="rounded-lg bg-teal-50 px-3 py-1.5 text-brand transition hover:bg-teal-100">
                                    Ver notas
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
