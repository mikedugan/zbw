@extends('layouts.master')
@section('title')
Boston ARTCC News
@stop
@section('header')
@stop
@section('content')
<h1 class="text-center">ZBW Pilot News</h1>
<h4 class="text-center">For Controller News, check {{ \HTML::linkRoute('news', 'this page') }}</h4>
@if(count($news) > 0)
  @foreach($news as $article)
  <div class="col-md-12 well">
      <h1>{{ $article->title }}</h1>
      <strong>Facility:</strong> {{ $article->facility->value or 'N/A'}}
      <strong>Starts:</strong> {{$article->starts->toDayDateTimeString()}}
      <strong>Ends:</strong> {{$article->ends->toDayDateTimeString()}}<br>
      {{$article->content}}
  </div>
  @endforeach
@else
<h3 class="text-center">No Current News!</h3>
<p>Please check back later!</p>
@endif
<h1>Forum NOTAMS</h1>
@foreach($notams as $notam)
  <h3><a href="{{ $notam->url }}">{{ $notam->subject }}</a></h3>
  <p>{{ $notam->body }}</p>
@endforeach
@stop
