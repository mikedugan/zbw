@extends('layouts.master')

@section('header')
@stop

@section('content')
    <div class="col-md-12 text-center">
        <img src="images/zbw-logo.jpg">
        <h4>Welcome to Boston ARTCC, where excellence is served daily with a cup of MOCHA HAGoTDI</h4>
        <p>We hope you like the new website! If you are a new, transferring, or visiting controller,
        please go to "Controllers" and click on the "New Controller" link.</p>
        <p>If you are a pilot, please check out the "Pilots" section for awesome flight planning
        resources such as charts, weather conditions, online ATC, and more!</p>
    </div>
    <div class="col-md-6">
        <h3 class="text-center">News</h3>
        @include ('includes/loops/_news')
    </div>
    <div class="col-md-6">
        <h3 class="text-center">Upcoming Events</h3>
        @include('includes/loops/_events')
    </div>
@stop