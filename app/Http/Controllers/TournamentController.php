<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\TournamentBuilder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class TournamentController extends Controller
{
    public function __invoke()
    {
        $error = null;
        $teams = new Collection();

        try {
            $tournament = $this->buildTournament();
            $teams = $tournament->getTeams();
        } catch (Exception $e) {
            $errorMsg = $e->getMessage();
            Log::info("Exception: $errorMsg");
            $error = $errorMsg;
        }

        return view('home', ['error' => $error, 'teams' => $teams]);
    }

    private function buildTournament()
    {
        $players = User::OfPlayers()->get();
        $tournamentBuilder = new TournamentBuilder($players);
        $tournamentBuilder->build();

        return $tournamentBuilder->getTournament();
    }
}
