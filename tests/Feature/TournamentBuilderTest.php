<?php

namespace Tests\Feature;

use App\Team;
use App\Tournament;
use Tests\TestCase;
use App\Models\User;
use App\TournamentBuilder;
use Illuminate\Support\Collection;

class TournamentBuilderTest extends TestCase
{
    const NUM_PLAYER_RECORDS = 85;

    /*
        test that tournament builder correctly determines number of teams
        based on number of players
    */
    public function testTeamSizeDetermination () 
    {
        $tournament = $this->buildTournament();

        $this->assertEquals($tournament->getNumberOfTeams(), 4);

        $tournament = $this->buildTournament(43);

        $this->assertEquals($tournament->getNumberOfTeams(), 2);

        $tournament = $this->buildTournament(120);

        $this->assertEquals($tournament->getNumberOfTeams(), 6);
    }

    /*
        test that tournament object can correctly determine its
        lowest ranked team
    */
    public function testGetLowestRankedTeam()
    {
        $tournament = $this->buildTournament();

        $teams = $tournament->getTeams();
        $sorted = $teams->sortBy(function (Team $team) {
            return $team->getTotalPlayerRanking();
        });

        $this->assertEquals($tournament->getLowestRankedTeam(), $sorted->first());
    }

    /*
        utility method, returns tournament build with $playerCount players
    */
    private function buildTournament($playerCount = self::NUM_PLAYER_RECORDS): Tournament
    {

        $players = $this->getPlayers($playerCount);
        $tb = new TournamentBuilder($players);
        $tb->build();
        return $tb->getTournament();
    }
    /*

        utility method, returns $num 'player' users 
    */
    private function getPlayers($num): Collection
    {
        $players = User::OfPlayers()->take($num)->get();

        if ($num > self::NUM_PLAYER_RECORDS) {
            for ($i=0; $i < $num - 85; $i++) {
                $base = $players[0];
                $base->id = 91 + $i;
                $players->push($base);
            }
        }

        return $players;
    }

}
