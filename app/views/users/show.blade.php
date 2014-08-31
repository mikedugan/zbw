@extends('layouts.master')
@section('title')
View {{ $controller->initials }}
@stop
@section('header')
@stop
@section('content')
<h1 class="text-center">{{ $controller->first_name . ' ' . $controller->last_name . ' ('.$controller->initials.')' }}</h1>
<div class="row">
    <div class="col-md-6">
        <p><b>Initials: </b>{{$controller->initials}}</p>
        <p><b>Rating: </b>{{$controller->rating->long}}</p>
        <p><b>Certification: </b>{{ \Zbw\Core\Helpers::readableCert($controller->cert) }}</p>
        @if($controller->is_staff)
        <p><b>Staff Status: </b>{{ \Zbw\Core\Helpers::staffStatusString($controller) }}</p>
        @endif
    </div>
    <div class="col-md-6">
        <img class="avatar" src="{{$controller->avatar()}}">
        <a href="/messages?v=compose&to={{$controller->initials}}" class="btn btn-success">Message</a>
    </div>
</div>
@stop
