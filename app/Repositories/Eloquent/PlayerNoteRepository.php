<?php

namespace App\Repositories\Eloquent;

use App\Models\PlayerNote;
use App\Repositories\Contracts\PlayerNoteRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class PlayerNoteRepository implements PlayerNoteRepositoryInterface
{
    /**
     * Get all notes for a specific player, ordered by creation date descending.
     *
     * @param int $playerId
     * @return Collection
     */
    public function getNotesByPlayerId(int $playerId): Collection
    {
        return PlayerNote::with('author')
            ->where('player_id', $playerId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Create a new note for a player.
     *
     * @param array $data
     * @return PlayerNote
     */
    public function create(array $data): PlayerNote
    {
        return PlayerNote::create($data);
    }
}
