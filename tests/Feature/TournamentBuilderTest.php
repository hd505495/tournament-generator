<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\TournamentBuilder;
use App\Models\User;

class TournamentBuilderTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testTeamSizeDetermination () 
    {
/*
		test that tournament builder correctly determines number of teams
        based on number of players
*/
        $result = User::where('user_type', 'player')->where('can_play_goalie', 1)->count();
        $this->assertTrue($result > 1);

        $players = User::OfPlayers()->get();
        $tb = new TournamentBuilder($players);
        $tb->build();

        $this->assertEquals($tb->getNumberOfTeams(), 4);

        $players = User::OfPlayers()->take(43)->get();
        $tb = new TournamentBuilder($players);
        $tb->build();

        $this->assertEquals($tb->getNumberOfTeams(), 2);

        $players = User::OfPlayers()->get();

        for ($i=0; $i < 35; $i++) {
            $base = $players[0];
            $base->id = 91 + $i;
            $players->push($base);
        }

        // $players->concat($morePlayers);
        $this->assertEquals(count($players), 120);
        $tb = new TournamentBuilder($players);
        $tb->build();

        $this->assertEquals($tb->getNumberOfTeams(), 6);

    }

}
