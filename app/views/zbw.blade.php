@extends('layouts.master')
@section('title')
Welcome
@stop
@section('header')
@stop

@section('content')
<div class="row text-center">
    <div class="col-md-8">
        <div class="hidden-sm hidden-xs" id="slideshow">
            @include('includes._slideshow')
        </div>
    </div>
    <div class="col-md-4">
        <h4>Welcome to Boston ARTCC, where excellence is served daily with a cup
            of MOCHA HAGoTDI</h4><br>

        <p>Whether you are a pilot, controller, or a little of both; ZBW is the
            premier airspace in VATSIM</p>

        <div class="list-group">
            <a class="list-group-item" href="/join">Join Boston ARTCC</a>
            <a class="list-group-item" href="/visit">Visit Boston ARTCC</a>
            <a class="list-group-item" href="http://vatsim.net">VATSIM</a>
            <a class="list-group-item" href="http://vatusa.net">VATUSA</a>
            @foreach($positions as $position)
            <span style="background:limegreen" class="list-group-item col-md-3">{{ $position }}</span>
            @endforeach
        </div>
    </div>
</div>
<div style="margin-top:20px;" class="row">
    <div class="col-md-6 news">
        <h3>News</h3>
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
            <a id="parse" href="javascript:void()">raw</a>
        </span>
        </h3>
        @include('includes.bj._metar')
    </div>
</div>
@stop
@section('scripts')
<script>
    $('#parse').click(function(e) {
        e.preventDefault();
        $this = $(this);
        if($this.text() == 'raw') { $this.text('parsed'); }
        else $this.text('raw');
        $('.metar-pretty').toggleClass('hidden');
        $('.metar-raw').toggleClass('hidden');
    });
</script>
@stop
