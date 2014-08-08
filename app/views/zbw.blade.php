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
    <div class="col-md-6 news">
        <h3 class="text-center">News</h3>
        @if($news)
        	@include ('includes.loops._news')
        @endif
        <h3 class="text-center">Links</h3>
        <div class="panel panel-default">
            <div class="list-group">
                <a class="list-group-item" href="/join">Join Boston ARTCC</a>
                <a class="list-group-item" href="/visit">Visit Boston ARTCC</a>
                <a class="list-group-item" href="http://vatsim.net">VATSIM</a>
                <a class="list-group-item" href="http://vatusa.net">VATUSA</a>
            </div>
        </div>
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
