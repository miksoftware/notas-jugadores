<?php

namespace App\Livewire;

use App\Models\Player;
use Livewire\Component;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Contracts\PlayerNoteRepositoryInterface;

class PlayerNotes extends Component
{
    public Player $player;

    #[Validate('required|min:50|max:1000')]
    public string $note = '';

    protected function messages(): array
    {
        return [
            'note.required' => 'La nota es obligatoria.',
            'note.min' => 'La nota debe tener al menos :min caracteres.',
            'note.max' => 'La nota no puede superar :max caracteres.',
        ];
    }

    public function mount(Player $player)
    {
        $this->player = $player;
    }

    public function saveNote(PlayerNoteRepositoryInterface $repository)
    {
        // Permission check
        if (!Auth::check() || !Auth::user()->hasPermissionTo('notes.create')) {
            abort(403, 'No tienes permiso para agregar notas.');
        }

        $this->validate();

        $repository->create([
            'player_id' => $this->player->id,
            'user_id' => Auth::id(),
            'note' => $this->note,
        ]);

        $this->reset('note');
        session()->flash('success', 'Nota guardada correctamente.');
    }

    public function render(PlayerNoteRepositoryInterface $repository)
    {
        if (!Auth::check() || !Auth::user()->hasPermissionTo('notes.view')) {
            abort(403, 'No tienes permiso para ver las notas.');
        }

        $notes = $repository->getNotesByPlayerId($this->player->id);

        return view('livewire.player-notes', [
            'notes' => $notes,
        ]);
    }
}
