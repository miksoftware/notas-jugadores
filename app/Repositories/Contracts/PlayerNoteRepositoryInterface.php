<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface PlayerNoteRepositoryInterface
{
    /**
     * Get all notes for a specific player.
     *
     * @param int $playerId
     * @return Collection
     */
    public function getNotesByPlayerId(int $playerId): Collection;

    /**
     * Create a new note for a player.
     *
     * @param array $data
     * @return \App\Models\PlayerNote
     */
    public function create(array $data);
}
