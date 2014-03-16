@extends('layouts.staff')
@section('content')
    <div class="col-md-6">
        <p>Welcome to the ZBW Staff Area. Within here, you can tackle tasks
        such as roster and staff management, announcements, training, and
        much more.</p>
    </div>
    <div class="col-md-6 panels">
        <h2>Administrative Panels</h2>
        <p><a href="/staff/roster"><button class="btn-lg btn-primary">Roster</button></a></p>
        <p><button class="btn-lg btn-primary">Training</button></p>
        <p><button class="btn-lg btn-primary">Pages</button></p>
        <p><button class="btn-lg btn-primary">News and Events</button></p>
        <p><button class="btn-lg btn-primary">Forum</button></p>
        <p><button class="btn-lg btn-primary">Teamspeak Server</button></p>
    </div>
@stop
