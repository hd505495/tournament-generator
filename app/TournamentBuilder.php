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

    /*
        determine how many teams will be in tournament
        based on number of players
    */
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

    /*
        initialize teams, sort players, then assign players
    */
    private function buildTeams(): void
    {
        $this->initializeTeams();

        $this->sortPlayersForAssignment();

        $this->assignPlayersToTeams();
    }

    /*
        create pre-determined number of teams, add to tournament
    */
    private function initializeTeams(): void
    {
        for ($i = 0; $i < $this->numTeams; $i++) {
            $this->tournament->addTeam(new Team());
        }
    }

    /*
        goalies sorted highest so that they are assigned first, ensuring 1 per team
        all other player sorted by rank so that best are assigned first
    */
    private function sortPlayersForAssignment(): void
    {
        $this->playerPool = $this->playerPool->sortBy(function (User $player) {
            if ($player->getIsGoalieAttribute()) {
                return 6;
            }
            return $player->getRankingAttribute();
        });
    }

    /*
        assign highest ranked player to the team with lowest
        total ranking until all are assigned
    */
    private function assignPlayersToTeams(): void
    {
        while ($this->playerPool->count() > 0) {
            $team = $this->tournament->getLowestRankedTeam();
            $team->addPlayer($this->playerPool->pop());
        }
    }
}