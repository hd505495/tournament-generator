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

    /*
        return team in tournament with lowest total player ranking
    */
    public function getLowestRankedTeam(): ?Team
    {
        $sorted = $this->teams->sortBy(function (Team $team) {
            return $team->getTotalPlayerRanking();
        });

        // returns null if no teams
        return $sorted->first();
    }
}
