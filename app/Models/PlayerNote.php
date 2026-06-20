<?php

namespace App\Models;

use Database\Factories\PlayerNoteFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['player_id', 'user_id', 'note'])]
class PlayerNote extends Model
{
    /** @use HasFactory<PlayerNoteFactory> */
    use HasFactory;

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
