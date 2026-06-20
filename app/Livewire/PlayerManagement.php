<?php

namespace App\Livewire;

use App\Models\Player;
use Livewire\Component;
use Livewire\Attributes\Validate;

class PlayerManagement extends Component
{
    #[Validate('required|min:3')]
    public $name = '';

    #[Validate('nullable|string|max:100')]
    public $nationality = '';

    public function createPlayer()
    {
        $this->validate();

        Player::create([
            'name' => $this->name,
            'nationality' => $this->nationality,
        ]);

        $this->reset(['name', 'nationality']);
        
        session()->flash('message', 'Jugador creado exitosamente.');
    }

    public function render()
    {
        return view('livewire.player-management', [
            'players' => Player::orderBy('id', 'desc')->get()
        ])->layout('components.layouts.app');
    }
}
