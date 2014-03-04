@extends('layouts.master')

@section('header')
@stop

@section('content')
  <div class="col-md-12 text-center">
  <h4>Welcome to Boston ARTCC, where excellence is served daily with a cup of MOCHA HAGoTDI</h4>
  		<div id="slideshow">
    		@include('includes._slideshow')
    	</div>
        <p>We hope you like the new website! If you are a new, transferring, or visiting controller,
        please go to "Controllers" and click on the "New Controller" link.</p>
        <p>If you are a pilot, please check out the "Pilots" section for awesome flight planning
        resources such as charts, weather conditions, online ATC, and more!</p>
    <div class="col-md-6 news">
        <h3 class="text-center">News</h3>
        @if($news)
        	@include ('includes.loops._news')
        @endif
    </div>
    <div class="col-md-6">
        <h3 class="text-left">ATC Online</h3>
        @include('includes._atc')
        <h3 class="text-left">Air Traffic</h3>
        @include('includes._flightstrip')
        <h3 class="text-left">Weather</h3>
        @include('includes.bj._metar')
    </div>
@stop