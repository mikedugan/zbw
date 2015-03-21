@extends('layouts.staff')
@section('title')
Staff Area
@stop
@section('content')
    <div class="col-md-6">
        <p>Welcome to the ZBW Staff Area. Within here, you can tackle tasks
        such as roster and staff management, announcements, training, and
        much more.</p>
    </div>
    <div class="col-md-6 panels">
        <h2>Administrative Panels</h2>
        <p>{{ \HTML::link('/staff/roster', 'Roster') }}</p>
        <p>{{ \HTML::linkRoute('staff.emails', 'Email Templates') }}</p>
    </div>
@stop
