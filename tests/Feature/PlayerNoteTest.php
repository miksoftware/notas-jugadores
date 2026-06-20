<?php

namespace Tests\Feature;

use App\Models\Player;
use App\Models\PlayerNote;
use App\Models\User;
use App\Repositories\Contracts\PlayerNoteRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class PlayerNoteTest extends TestCase
{
    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------

    /**
     * Create a user and assign a given permission directly to them.
     */
    private function userWithPermission(string $permission): User
    {
        Permission::firstOrCreate(['name' => $permission]);

        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        $user->givePermissionTo($permission);

        return $user;
    }

    // -------------------------------------------------------------------------
    // Repository unit-style tests
    // -------------------------------------------------------------------------

    public function test_repository_creates_note_and_persists_to_database(): void
    {
        $player = Player::factory()->create();
        $author = User::factory()->create();

        /** @var PlayerNoteRepositoryInterface $repository */
        $repository = app(PlayerNoteRepositoryInterface::class);

        $repository->create([
            'player_id' => $player->id,
            'user_id'   => $author->id,
            'note'      => 'Esta es una nota de prueba para el jugador.',
        ]);

        $this->assertDatabaseHas('player_notes', [
            'player_id' => $player->id,
            'user_id'   => $author->id,
            'note'      => 'Esta es una nota de prueba para el jugador.',
        ]);
    }

    public function test_repository_returns_notes_for_correct_player_only(): void
    {
        $playerA = Player::factory()->create();
        $playerB = Player::factory()->create();
        $author  = User::factory()->create();

        /** @var PlayerNoteRepositoryInterface $repository */
        $repository = app(PlayerNoteRepositoryInterface::class);

        $repository->create(['player_id' => $playerA->id, 'user_id' => $author->id, 'note' => 'Nota de jugador A']);
        $repository->create(['player_id' => $playerB->id, 'user_id' => $author->id, 'note' => 'Nota de jugador B']);

        $notes = $repository->getNotesByPlayerId($playerA->id);

        $this->assertCount(1, $notes);
        $this->assertEquals('Nota de jugador A', $notes->first()->note);
    }

    public function test_repository_returns_notes_ordered_by_most_recent_first(): void
    {
        $player = Player::factory()->create();
        $author = User::factory()->create();

        PlayerNote::factory()->create(['player_id' => $player->id, 'user_id' => $author->id, 'note' => 'Primera nota',  'created_at' => now()->subMinutes(10)]);
        PlayerNote::factory()->create(['player_id' => $player->id, 'user_id' => $author->id, 'note' => 'Segunda nota', 'created_at' => now()->subMinutes(5)]);
        PlayerNote::factory()->create(['player_id' => $player->id, 'user_id' => $author->id, 'note' => 'Tercera nota', 'created_at' => now()]);

        /** @var PlayerNoteRepositoryInterface $repository */
        $repository = app(PlayerNoteRepositoryInterface::class);

        $notes = $repository->getNotesByPlayerId($player->id);

        $this->assertEquals('Tercera nota', $notes->first()->note);
        $this->assertEquals('Primera nota', $notes->last()->note);
    }

    // -------------------------------------------------------------------------
    // Livewire / HTTP feature tests
    // -------------------------------------------------------------------------

    public function test_authenticated_user_with_permission_can_save_note(): void
    {
        $user = User::factory()->create(['password' => Hash::make('password')]);

        Permission::firstOrCreate(['name' => 'notes.view']);
        Permission::firstOrCreate(['name' => 'notes.create']);
        $user->givePermissionTo(['notes.view', 'notes.create']);

        $player = Player::factory()->create();

        Livewire::actingAs($user)
            ->test(\App\Livewire\PlayerNotes::class, ['player' => $player])
            ->set('note', 'Nota creada desde el test de feature de Livewire, con suficientes caracteres.')
            ->call('saveNote')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('player_notes', [
            'player_id' => $player->id,
            'user_id'   => $user->id,
            'note'      => 'Nota creada desde el test de feature de Livewire, con suficientes caracteres.',
        ]);
    }

    public function test_note_field_is_required(): void
    {
        $user = User::factory()->create(['password' => Hash::make('password')]);

        Permission::firstOrCreate(['name' => 'notes.view']);
        Permission::firstOrCreate(['name' => 'notes.create']);
        $user->givePermissionTo(['notes.view', 'notes.create']);

        $player = Player::factory()->create();

        Livewire::actingAs($user)
            ->test(\App\Livewire\PlayerNotes::class, ['player' => $player])
            ->set('note', '')
            ->call('saveNote')
            ->assertHasErrors(['note' => 'required']);
    }

    public function test_note_field_cannot_exceed_maximum_length(): void
    {
        $user = User::factory()->create(['password' => Hash::make('password')]);

        Permission::firstOrCreate(['name' => 'notes.view']);
        Permission::firstOrCreate(['name' => 'notes.create']);
        $user->givePermissionTo(['notes.view', 'notes.create']);

        $player = Player::factory()->create();

        Livewire::actingAs($user)
            ->test(\App\Livewire\PlayerNotes::class, ['player' => $player])
            ->set('note', str_repeat('a', 1001))
            ->call('saveNote')
            ->assertHasErrors(['note' => 'max']);
    }

    public function test_user_without_permission_cannot_save_note(): void
    {
        Permission::firstOrCreate(['name' => 'notes.view']);
        Permission::firstOrCreate(['name' => 'notes.create']);

        $user   = User::factory()->create();  // sin ningún permiso
        $player = Player::factory()->create();

        // Necesita notes.view para que render() no aborte primero
        $user->givePermissionTo('notes.view');

        Livewire::actingAs($user)
            ->test(\App\Livewire\PlayerNotes::class, ['player' => $player])
            ->set('note', 'Intento sin permiso de creacion.')
            ->call('saveNote')
            ->assertForbidden();
    }

    public function test_user_without_notes_view_permission_cannot_render_component(): void
    {
        Permission::firstOrCreate(['name' => 'notes.view']);

        $user   = User::factory()->create();  // sin notes.view
        $player = Player::factory()->create();

        Livewire::actingAs($user)
            ->test(\App\Livewire\PlayerNotes::class, ['player' => $player])
            ->assertForbidden();
    }

    public function test_unauthenticated_user_is_redirected_from_notes_route(): void
    {
        $response = $this->get('/notes');

        $response->assertRedirect('/login');
    }
}
