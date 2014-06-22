@extends('layouts.master')
@section('title')
Welcome
@stop
@section('header')
@stop

@section('content')
  <div class="col-md-12 text-center">
  <h4>Welcome to Boston ARTCC, where excellence is served daily with a cup of MOCHA HAGoTDI</h4>
  		<div class="hidden-sm hidden-xs" id="slideshow">
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
        @include('includes.bj._atc')
        <h3 class="text-left">Air Traffic</h3>
        @include('includes.bj._flightstrip')
        <h3 class="text-left col-md-6">Weather
        <span class="small">
            @if(\Input::get('raw') == true)
            <a href="/">parsed</a>
            @else
            <a href="/?raw=true">raw</a>
            @endif
        </span>
        </h3>
        @include('includes.bj._metar')
    </div>
@stop
