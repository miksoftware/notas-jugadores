<div>
    <div class="mb-6 rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm">
        <label class="mb-2 block text-sm font-medium text-slate-700">Seleccione un jugador para ver o agregar notas</label>
        <select wire:model.live="selectedPlayerId" class="block w-full max-w-md rounded-xl border border-slate-200 bg-white p-2.5 shadow-sm focus:border-brand focus:ring-2 focus:ring-brand/20">
            <option value="">-- Seleccionar jugador --</option>
            @foreach($players as $player)
                <option value="{{ $player->id }}">{{ $player->name }} {{ $player->nationality ? "({$player->nationality})" : '' }}</option>
            @endforeach
        </select>
    </div>

    @if($selectedPlayer)
        <div class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm">
            @livewire('player-notes', ['player' => $selectedPlayer], key($selectedPlayer->id))
        </div>
    @else
        <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 py-16 text-center text-slate-500">
            <svg class="mx-auto mb-4 h-12 w-12 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
            </svg>
            <p>Selecciona un jugador de la lista superior para comenzar.</p>
        </div>
    @endif
</div>
