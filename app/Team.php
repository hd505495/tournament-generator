<?php

namespace App;

use App\Models\User;
use Illuminate\Support\Collection;

class Team
{
    private Collection $players;
    private string $name;

    public function __construct()
    {
        $this->players = new Collection();
        $this->generateName();
    }

    public function addPlayer(User $player): void
    {
        $this->players[] = $player;
    }

    public function addPlayers(Collection $players): void
    {
        $this->players->concat($players);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPlayerCount(): int
    {
        return count($this->players);
    }

    public function getTotalPlayerRanking(): int
    {
        return $this->players->reduce(function (int $carry, User $player) {
            return $carry + $player->getRankingAttribute();
        }, 0);
    }

    private function generateName(): void
    {
        $faker = \Faker\Factory::create();
        $faker->addProvider(new \App\Utilities\Faker\TeamName($faker));
        $this->name = $faker->teamName();
    }
}
