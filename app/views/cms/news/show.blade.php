@extends('layouts.master')
@section('title')
News
@stop
@section('header')
@stop
@section('content')
    <h1>{{ $news->title }}</h1>
    <div class="col-md-6">
        <p><strong>Facility:</strong> {{$event->rfacility->value}}</p>
        <p><strong>Starts:</strong> {{$event->starts->toFormattedDateString()}}</p>
        <p><strong>Ends:</strong> {{$event->ends->toFormattedDateString()}}</p>
    </div>
    <div class="col-md-6">
        <h3>Summary</h3>
        {{$event->content}}
    </div>
@stop
