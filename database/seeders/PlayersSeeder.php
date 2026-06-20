<?php

namespace Database\Seeders;

use App\Models\Player;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PlayersSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the top 5 best football players in the world.
     */
    public function run(): void
    {
        $players = [
            ['name' => 'Erling Haaland',    'nationality' => 'Noruega'],
            ['name' => 'Kylian Mbappé',      'nationality' => 'Francia'],
            ['name' => 'Vinicius Jr.',        'nationality' => 'Brasil'],
            ['name' => 'Lionel Messi',        'nationality' => 'Argentina'],
            ['name' => 'Rodri',               'nationality' => 'España'],
        ];

        foreach ($players as $player) {
            Player::firstOrCreate(
                ['name' => $player['name']],
                ['nationality' => $player['nationality']]
            );
        }
    }
}
