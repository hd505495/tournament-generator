<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\TournamentBuilder;
use Illuminate\Support\Collection;

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
        // $players = User::OfPlayers()->get();
        $players = $this->getPlayers(120);
        $tournamentBuilder = new TournamentBuilder($players);
        $tournamentBuilder->build();

        return $tournamentBuilder->getTournament();
    }

    private function getPlayers($num): Collection
    {
        $players = User::OfPlayers()->take($num)->get();

        if ($num > 85) {
            for ($i=0; $i < $num - 85; $i++) {
                $base = $players[0];
                $base->id = 91 + $i;
                $players->push($base);
            }
        }

        return $players;
    }
}
