<?php

namespace Tests\Feature;

use App\Tournament;
use Tests\TestCase;
use App\Models\User;
use App\TournamentBuilder;
use Illuminate\Support\Collection;

class PlayersIntegrityTest extends TestCase
{
    const NUM_PLAYER_RECORDS = 85;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGoaliePlayersExist () 
    {
/*
		Check there are players that have can_play_goalie set as 1   
*/
		$result = User::where('user_type', 'player')->where('can_play_goalie', 1)->count();
		$this->assertTrue($result > 1);
    }

    public function testAtLeastOneGoaliePlayerPerTeam () 
    {
/*
	    calculate how many teams can be made so that there is an even number of teams and they each have between 18-22 players.
	    Then check that there are at least as many players who can play goalie as there are teams
*/
        $tournament = $this->buildTournament();

        foreach ($tournament->getTeams() as $team) {
            $this->assertGreaterThan(0, $team->getNumberOfGoalies());
        }
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
