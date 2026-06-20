<?php

namespace App\Livewire;

use App\Models\Player;
use Livewire\Component;
use Livewire\Attributes\Url;

class NoteManagement extends Component
{
    #[Url]
    public ?int $selectedPlayerId = null;

    public function render()
    {
        $selectedPlayer = $this->selectedPlayerId
            ? Player::find($this->selectedPlayerId)
            : null;

        return view('livewire.note-management', [
            'players'        => Player::orderBy('name')->get(),
            'selectedPlayer' => $selectedPlayer,
        ])->layout('components.layouts.app');
    }
}
