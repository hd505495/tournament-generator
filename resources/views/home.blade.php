<html>

    <head>
        <style>
            ::-webkit-scrollbar {
                -webkit-appearance: none;
                width: 8px;
                padding-top: 20px;
            }

            ::-webkit-scrollbar-thumb {
                border-radius: 5px;
                background-color: rgba(0,0,0,.5);
                -webkit-box-shadow: 0 0 1px rgba(255,255,255,.5);
            }

            th {
                border-bottom: 1px solid;
            }

            .teamContainer {
                min-width: 300px;
                margin-right: 10px;
                margin-bottom: 10px;
                padding: 8px;
                border: 1px solid;
                border-radius: 10px;
                background: rgba(0, 0, 0, 0.1);
            }
        </style>
    </head>

    <body>
        <h1>Tournament Time!</h1>

        @if ($error)
        <p>Error: {{ $error }}</p>
        @endif

        <div style="display: flex; flex-wrap: wrap;">
            @foreach ($teams as $team)
            <span class="teamContainer">
                <div>
                    <h2>{{ $team->getName() }}</h2>
                    <p>Players: {{ $team->getPlayerCount() }}</p>
                    <p>Total player ranking: {{ $team->getTotalPlayerRanking() }}</p>
                </div>

                <div style=" max-height: 200px; overflow-y: scroll; padding-right: 15px; margin-right: 5px;">
                    <table>
                        <thead>
                            <tr>
                                <th colspan="4" style="text-align: center; font-weight: 700; font-size: larger;">Players</th>
                            </tr>
                            <tr>
                                <th></th>
                                <th>Name</th>
                                <th style="text-align: right;">Ranking</th>
                                <th style="text-align: right; padding-left: 10px;">Goalie?</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($team->getPlayers() as $key => $player)
                            <tr style="border-bottom: 1px solid">
                                <td style="font-weight:100;">{{ $key + 1 }}</td>
                                <td>{{ $player->getFullnameAttribute() }}</td>
                                <td style="text-align: right;">{{ $player->getRankingAttribute() }}</td>
                                <td style="text-align: right;">{{ $player->getIsGoalieAttribute() ? 'Yes' : 'No' }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </span>
            @endforeach
        </div>
    </body>

</html>