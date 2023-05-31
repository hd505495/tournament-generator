<?php

namespace App;

use Exception;
use App\Tournament;
use App\Models\User;
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
        $this->buildTeams();
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
        $poolSize = count($this->playerPool);
        $numTeams = 0;
        $isGoodTeamSize = false;

        while (!$isGoodTeamSize && $numTeams < self::MAX_NUM_TEAMS){
            $numTeams += 2;
            $avgTeamSizeTest = $poolSize / $numTeams;
            $isGoodTeamSize = (self::MIN_TEAM_SIZE <= $avgTeamSizeTest) && ($avgTeamSizeTest <= self::MAX_TEAM_SIZE);
        };

        if (!$isGoodTeamSize) {
            throw new Exception('Teams cannot be formed with current number of players based on given constraints.');
        }

        $this->numTeams = $numTeams;
    }

    private function buildTeams(): void
    {
        $this->initializeTeams();

        $playersSorted = $this->playerPool->sortByDesc(function (User $player) {
            return $player->getRankingAttribute();
        });

        while ($playersSorted->count() > 0) {
            $team = $this->tournament->getLowestRankedTeam();
            $team->addPlayer($playersSorted->pop());
        }
    }

    private function initializeTeams(): void
    {
        for ($i = 0; $i < $this->numTeams; $i++) {
            $this->tournament->addTeam(new Team());
        }
    }
}