<?php

namespace App;

use App\Team;
use Illuminate\Support\Collection;

class Tournament
{
    private Collection $teams;

    public function __construct()
    {

    }

    public function addTeam(Team $team): void
    {
        $this->teams->push($team);
    }

    public function getNumTeams(): int
    {
        return count($this->teams);
    }

    public function getTeams(): Collection
    {
        return $this->teams;
    }
}
