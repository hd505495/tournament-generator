<html>
    <body>
        <h1>Tournament of Champions</h1>

        @foreach ($teams as $team)
            <p>{{ $team->getName() }}</p>
            <p>{{ $team->getTotalPlayerRanking() }}</p>
            <p>{{ $team->getPlayerCount() }}</p>
        @endforeach
    </body>
</html>