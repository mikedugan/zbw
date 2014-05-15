@extends('layouts.master')
@section('title')
News and Events
@stop
@section('header')
@stop
@section('content')
    <h1 class="text-center">ZBW News and Events</h1>
    <p class="text-center"><a class="btn btn-primary" href="/staff/news/add">Add Event/News</a>
    <div class="panel-group" id="accordion1">
    <div class="col-md-6 panel panel-default">
        <div class="panel-heading"><h3 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion1" href="#collapse11">Active Events</a></h3></div>
        <div id="collapse11" class="panel-collapse collapse in">
            <div class="panel-body">
                @if(count($events['active']) === 0)
                    <p><em>No active events!</em></p>
                @else
                    @foreach($events['active'] as $event)
                        <div class="event">
                            <h4>{{ $event->title }}<p class="small">Ends {{ $event->ends->toFormattedDateString() }}</p></h4>
                            <p><i>Facility: </i> {{ $event->facility->value }}</p>
                            <p>{{ $event->content }}</p>
                            <a class="" href="/news/{{ $event->id}}">View</a>
                            <a class="" href="/staff/news/{{ $event->id}}">Edit</a>
                        </div>
                    @endforeach
                @endif
            </div>
            </div>
    <div class="panel-heading"><h3 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion1" href="#collapse12">Upcoming Events</a></h3></div>
        <div id="collapse12" class="panel-collapse collapse in">
        <div class="panel-body">
            @if(count($events['upcoming']) === 0)
            <p><em>No upcoming events!</em></p>
            @else
            @foreach($events['upcoming'] as $event)
            <div class="event">
                <h4>{{ $event->title }}<p class="small">Starts {{ $event->starts->toFormattedDateString() }}</p></h4>
                <p><i>Facility: </i> {{ $event->facility->value }}</p>
                <p>{{ $event->content }}</p>
                <a class="" href="/news/{{ $event->id}}">View</a>
                <a class="" href="/staff/news/{{ $event->id}}">Edit</a>
            </div>
            @endforeach
            @endif
        </div>
            </div>
    <div class="panel-heading"><h3 class="panel-title">
            <a data-toggle="collapse" data-parent="accordion" href="#collapse13">Past Events</a></h3></div>
        <div id="collapse13" class="panel-collapse collapse in">
        <div class="panel-body">
            @foreach($events['expired'] as $event)
            <div class="event">
                <h4>{{ $event->title }}<p class="small">Ended {{ $event->ends->toFormattedDateString() }}</p></h4>
                <p><i>Facility: </i> {{ $event->facility->value }}</p>
                <p>{{ $event->content }}</p>
                <a class="" href="/news/{{ $event->id}}">View</a>
                <a class="" href="/staff/news/{{ $event->id}}">Edit</a>
            </div>
            @endforeach
            </div>
            </div>
    </div>
    <div class="panel-group" id="accordion2">
    <div class="col-md-6 panel panel-default">
        <div class="panel-heading"><h3 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion2" href="#collapse21">Staff News</a>
            </h3></div>
        <div id="collapse21" class="panel-collapse collapse in">
        <div class="panel-body">
        @foreach($staffnews as $event)
        <div class="event">
            <h4>{{ $event->title }}<p class="small"> Date: {{$event->starts->toFormattedDateString() }}</p></h4>
            <p>{{ $event->content }}<br>
            <a href="/staff/news/{{$event->id}}">Edit</a></p>
        </div>
        @endforeach
        </div>
        </div>

        <div class="panel-heading"><h3 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion2" href="#collapse22">Recent News</a>
            </h3></div>
        <div id="collapse22" class="panel-collapse collapse in">
        <div class="panel-body">
        @foreach($generalnews as $event)
        <div class="event">
            <h4>{{ $event->title }}<p class="small"> Date: {{$event->starts->toFormattedDateString() }}</p></h4>
            <p>{{ $event->content }}<br>
            <a href="/staff/news/{{$event->id}}">Edit</a></p>
        </div>
        @endforeach
        </div>
        </div>
    </div>
@stop
