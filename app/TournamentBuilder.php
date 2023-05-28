<?php

namespace App;

use Exception;
use App\Tournament;
use Illuminate\Support\Collection;

class TournamentBuilder
{
    const MAX_TEAM_SIZE = 22;
    const MIN_TEAM_SIZE = 18;
    const MAX_NUM_TEAMS = 16;

    private Collection $playerPool;
    private int $numTeams;
    private Tournament $tournament;

    public function __construct(Collection $players)
    {
        $this->playerPool = $players;
        $this->tournament = new Tournament();
    }

    public function build(): void
    {
        // determine number of teams in tournament based on player count
        $this->determineNumberOfTeams();

        // assign players to teams
        // $this->buildTeams();
    }

    public function getTournament(): Tournament
    {
        return $this->tournament;
    }

    public function getNumberOfTeams(): int
    {
        return $this->numTeams;
    }

    private function determineNumberOfTeams(): void
    {

    }
}