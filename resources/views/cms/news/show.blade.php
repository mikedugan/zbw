@extends('layouts.master')
@section('title')
News
@stop
@section('header')
@stop
@section('content')
    <h1>{{ $news->title }}</h1>
    <div class="col-md-6">
        <p><strong>Facility:</strong> {{ $news->facility->value}}</p>
        <p><strong>Starts:</strong> {{$news->starts->toFormattedDateString()}}</p>
        <p><strong>Ends:</strong> {{$news->ends->toFormattedDateString()}}</p>
    </div>
    <div class="col-md-6">
        <h3>Summary</h3>
        {{$news->content}}
    </div>
@stop
