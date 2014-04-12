@extends('layouts.master')
@section('header')
@stop
@section('content')
    <h1 class="text-center">ZBW News and Events</h1>
    <p class="text-center">
    <div class="col-md-6">
        <h3>Active Events</h3>
            @foreach($events['active'] as $event)
            <div class="event">
                <p><strong>{{ $event->title }}</strong></p>
                <p><i>Ends: </i> {{ $event->ends->toFormattedDateString() }}</p>
                <p><i>Facility: </i> {{ $event->facility }}</p>
                <a class="" href="/news/{{ $event->id}}">View</a>
                <a class="" href="/staff/news/{{ $event->id}}">Edit</a>
            </div>
            @endforeach
        <h3>Upcoming Events</h3>
            @foreach($events['upcoming'] as $event)
            <div class="event">
                <p><strong>{{ $event->title}}</strong></p>
                <p><i>Starts: </i> {{ $event->starts->toFormattedDateString() }}</p>
                <p><i>Facility: </i> {{ $event->facility }}</p>
                <a class="" href="/news/{{ $event->id}}">View</a>
                <a class="" href="/staff/news/{{ $event->id}}">Edit</a>
            </div>
            @endforeach
        <h3>Expired Events</h3>
            @foreach($events['expired'] as $event)
            <div class="event">
                <p><strong>{{ $event->title }}</strong></p>
                <p><i>Ended: </i> {{ $event->ends->toFormattedDateString() }}</p>
                <p><i>Facility: </i> {{ $event->facility }}</p>
                <a class="" href="/news/{{ $event->id}}">View</a>
                <a class="" href="/staff/news/{{ $event->id}}">Edit</a>
            </div>
            @endforeach
    </div>
    <div class="col-md-6">
        <h3 class="text-center">Staff News</h3>
        @foreach($staffnews as $event)
        <div class="event">
            <h4>{{ $event->title }}<p class="small"> Date: {{$event->starts->toFormattedDateString() }}</p></h4>
            <p>{{ $event->content }}<br>
            <a href="/staff/news/{{$event->id}}">Edit</a></p>
        </div>
        @endforeach
        <h3 class="text-center">Recent News</h3>
        @foreach($generalnews as $event)
        <div class="event">
            <h4>{{ $event->title }}<p> Date: {{$event->starts->toFormattedDateString() }}</p></h4>
            <p>{{ $event->content }}<br>
            <a href="/staff/news/{{$event->id}}">Edit</a></p>
        </div>
        @endforeach
    </div>

@stop
