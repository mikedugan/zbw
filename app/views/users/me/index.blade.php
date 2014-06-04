@extends('layouts.me')
@section('title')
My Profile
@stop
@section('header')
@stop
@section('content')
@include('includes.nav._me')
<div class="col-md-10 col-md-offset-2">
    @if(! $view)
    @include('users.me.profile')
    @elseif ($view == 'settings')
    @include('users.me.settings')
    @elseif ($view == 'subscriptions')
    @include('users.me.subscriptions')
    @else
    @include('users.me.profile')
    @endif
</div>
@stop
