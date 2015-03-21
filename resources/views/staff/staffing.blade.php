@extends('layouts.master')
@section('title')
ZBW Staffing
@stop
@section('content')
<h1 class="text-center">ZBW Staffing</h1>
<div class="col-md-6">
  @for($i = 0; $i < count($staffings) / 2; $i++)
  <p><a href="/controllers/{{$staffings[$i]->cid}}">{{ $staffings[$i]->user->initials or 'NA' }}</a> staffed {{$staffings[$i]->position}} for {{ $staffings[$i]->timeOnline() }}</p>
  @endfor
</div>
<div class="col-md-6">
  @for($i = count($staffings) / 2; $i < count($staffings); $i++)
  <p><a href="/controllers/{{$staffings[$i]->cid}}">{{ $staffings[$i]->user->initials or 'NA' }}</a> staffed {{$staffings[$i]->position}} for {{ $staffings[$i]->timeOnline() }}</p>
  @endfor
</div>
{{ $staffings->links() }}
@stop
