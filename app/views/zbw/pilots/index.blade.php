@extends('layouts.master')
@section('title')
Pilot Area
@stop
@section('header')
<ul class="nav navbar-nav navbar-right col-md-1">
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Pilots <b class="caret"></b></a>
        <ul class="dropdown-menu">
            <li><a href="#">Charts</a></li>
            <li><a href="#">Events</a></li>
            <li><a href="#">Learning</a></li>
            <li><a href="#">News</a></li>
        </ul>
    </li>
</ul>
@stop

@section('content')
<h1>Welcome to the vZBW Pilot Area!</h1>
<h3>Hello, {{ $me->initials or 'Guest'}}</h3>
@stop