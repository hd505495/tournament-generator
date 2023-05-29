<?php

namespace App;

use App\Team;
use Illuminate\Support\Collection;

class Tournament
{
    private Collection $teams;

    public function __construct()
    {
        $this->teams = new Collection();
    }

    public function addTeam(Team $team): void
    {
        $this->teams->push($team);
    }

    public function getNumberOfTeams(): int
    {
        return count($this->teams);
    }

    public function getTeams(): Collection
    {
        return $this->teams;
    }

    public function getLowestRankedTeam(): ?Team
    {
        $this->teams->sortBy(function (Team $team) {
            return $team->getTotalPlayerRanking();
        });

        // returns null if no teams
        return $this->teams->first();
    }
}
