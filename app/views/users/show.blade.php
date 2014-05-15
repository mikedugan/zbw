@extends('layouts.master')
@section('title')
View {{ $controller->iniials }}
@stop
@section('header')
@stop
@section('content')
<h1 class="text-center">{{ $controller->first_name . ' ' . $controller->last_name . ' ('.$controller->initials.')' }}</h1>
<div class="row">
    <div class="col-md-6">
    </div>
    <div class="col-md-6">
    </div>
</div>
@stop
