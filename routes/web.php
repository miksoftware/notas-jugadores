<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Player;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();

        if ($user->can('users.view')) {
            return redirect('/users');
        }
        if ($user->can('players.view')) {
            return redirect('/players');
        }
        if ($user->can('notes.view')) {
            return redirect('/notes');
        }

        abort(403, 'No tienes permisos para acceder a ninguna sección.');
    }
    return redirect('/login');
});

Route::get('/login', App\Livewire\Auth\Login::class)->name('login');
Route::post('/logout', function () {
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect('/login');
});

Route::middleware('auth')->group(function () {
    Route::get('/users', App\Livewire\UserManagement::class)->middleware('permission:users.view');
    Route::get('/permissions', App\Livewire\RolePermissionManagement::class)->middleware('role:Admin');
    Route::get('/players', App\Livewire\PlayerManagement::class)->middleware('permission:players.view');

    Route::get('/notes', App\Livewire\NoteManagement::class)->middleware('permission:notes.view');
});
