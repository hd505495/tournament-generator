<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\TournamentBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class TournamentController extends Controller
{
    public function __invoke()
    {
        $tournament = $this->buildTournament();
        return View::make('home', ['teams' => $tournament->getTeams()]);


        // try {
        //     $tournament = $this->buildTournament();
        // } catch (Exception $e) {
            
        // }

    }

    private function buildTournament()
    {
        // get player pool
        $players = User::OfPlayers()->get();
        
        // initialize tournament builder with player pool
        $tournamentBuilder = new TournamentBuilder($players);

        $tournamentBuilder->build();
        return $tournamentBuilder->getTournament();
    }
}
