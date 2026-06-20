<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public $email = '';
    public $password = '';

    public function mount()
    {
        if (Auth::check()) {
            return redirect($this->homeRouteForUser());
        }
    }

    public function login()
    {
        $credentials = $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            session()->regenerate();
            return redirect()->intended($this->homeRouteForUser());
        }

        $this->addError('email', 'Las credenciales proporcionadas no coinciden con nuestros registros.');
    }

    private function homeRouteForUser(): string
    {
        $user = Auth::user();

        if ($user->can('users.view')) {
            return '/users';
        }
        if ($user->can('players.view')) {
            return '/players';
        }
        if ($user->can('notes.view')) {
            return '/notes';
        }

        return '/login';
    }

    public function render()
    {
        return view('livewire.auth.login')->layout('components.layouts.app');
    }
}
