<div>
    <h3 class="mb-4 text-lg font-semibold text-slate-800">Notas de {{ $player->name }}</h3>

    @if (session()->has('success'))
        <div class="mb-4 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @can('notes.create')
        <div class="mb-6 rounded-xl border border-slate-200 bg-slate-50 p-5">
            <h4 class="mb-3 text-sm font-semibold text-slate-700">Agregar nueva nota</h4>
            <form wire:submit="saveNote">
                <textarea
                    wire:model="note"
                    class="w-full rounded-xl border border-slate-200 p-3 text-slate-800 shadow-sm focus:border-brand focus:ring-2 focus:ring-brand/20"
                    rows="4"
                    placeholder="Escribe una observación sobre este jugador..."></textarea>

                <p class="mt-1 text-xs text-slate-500">Mínimo 50 caracteres, máximo 1000.</p>

                @error('note') <span class="mt-1 block text-sm text-red-500">{{ $message }}</span> @enderror

                <div class="mt-3 text-right">
                    <button type="submit" class="rounded-xl bg-brand px-5 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-dark">
                        Guardar nota
                    </button>
                </div>
            </form>
        </div>
    @endcan

    <div class="space-y-4">
        @forelse($notes as $item)
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <div class="mb-2 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        @php
                            $parts = preg_split('/\s+/', trim($item->author->name ?? 'U'));
                            $initials = strtoupper(collect($parts)->take(2)->map(fn ($p) => mb_substr($p, 0, 1))->join(''));
                        @endphp
                        <div class="flex h-9 w-9 items-center justify-center rounded-full bg-brand text-xs font-bold text-white">
                            {{ $initials }}
                        </div>
                        <span class="font-semibold text-slate-800">{{ $item->author->name ?? 'Autor desconocido' }}</span>
                    </div>
                    <span class="text-xs text-slate-400">{{ $item->created_at->format('d/m/Y H:i') }}</span>
                </div>
                <p class="whitespace-pre-line pl-12 text-slate-600">{{ $item->note }}</p>
            </div>
        @empty
            <p class="py-8 text-center italic text-slate-400">No hay notas registradas para este jugador.</p>
        @endforelse
    </div>
</div>
