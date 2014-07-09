@extends('layouts.master')
@section('title')
Boston ARTCC News
@stop
@section('header')
@stop
@section('content')
<h1 class="text-center">ZBW News</h1>
<h4 class="text-center">For Pilot News, check {{ HTML::linkRoute('pilot-news', 'this page') }}</h4>
@foreach($news as $article)
<div class="col-md-12 well">
    <h1>{{ $article->title }}</h1>
    <strong>Facility:</strong> {{ $article->facility->value}}
    <strong>Starts:</strong> {{$article->starts->toFormattedDateString()}}
    <strong>Ends:</strong> {{$article->ends->toFormattedDateString()}}<br>
    {{$article->content}}
</div>
@endforeach
@stop
