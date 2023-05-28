<h1>Tournament of Champions</h1>

@foreach ($teams as $team) {
    echo {{ $team->name }}
}