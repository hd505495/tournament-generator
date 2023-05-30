<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\TournamentBuilder;

class TournamentController extends Controller
{
    public function __invoke()
    {
        $tournament = $this->buildTournament();
        // dd($tournament);
        return view('home', ['teams' => $tournament->getTeams()]);


        // try {
        //     $tournament = $this->buildTournament();
        // } catch (Exception $e) {
            
        // }

    }

    private function buildTournament()
    {
        $players = User::OfPlayers()->get();
        $tournamentBuilder = new TournamentBuilder($players);
        $tournamentBuilder->build();

        return $tournamentBuilder->getTournament();
    }
}
