<?php

namespace App;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

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

    public function getName(): string
    {
        return $this->name;
    }

    public function getPlayerCount(): int
    {
        return count($this->players);
    }

    public function getPlayers(): Collection
    {
        return $this->players;
    }

    /*
        return number of players on this team with can_play_goalie flag set
    */
    public function getNumberOfGoalies(): int
    {
        return $this->players->filter(fn ($player) => (bool) $player->can_play_goalie)->count();
    }

    /*
        sum player ranking for all players on team
    */
    public function getTotalPlayerRanking(): int
    {
        return $this->players->reduce(function (int $carry, User $player) {
            return $carry + $player->getRankingAttribute();
        }, 0);
    }

    /*
        generate a fake team name using Faker package
    */
    private function generateName(): void
    {
        $faker = \Faker\Factory::create();
        $faker->addProvider(new \App\Utilities\Faker\TeamName($faker));
        $this->name = $faker->teamName();
    }
}
