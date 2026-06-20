<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Validate;

class UserManagement extends Component
{
    #[Validate('required|min:3')]
    public $name = '';

    #[Validate('required|email|unique:users,email')]
    public $email = '';

    #[Validate('required|min:6')]
    public $password = '';

    #[Validate('required')]
    public $role = '';

    public function createUser()
    {
        $this->validate();

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        $user->assignRole($this->role);

        $this->reset(['name', 'email', 'password', 'role']);
        
        session()->flash('message', 'Usuario creado exitosamente.');
    }

    public function render()
    {
        return view('livewire.user-management', [
            'users' => User::with('roles')->get(),
            'roles' => Role::all(),
        ])->layout('components.layouts.app');
    }
}
