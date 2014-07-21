@extends('layouts.master')
@section('title')
Access Denied
@stop
@section('content')
    <h1 class="text-center">Access Denied</h1>
    <p>We're sorry, but you do not have adequate permissions to view this page.</p>
    <p>If you believe this is an error, please contact a staff member!</p>
    @if(\Sentry::check())
    <p><b>User:</b> {{$me->username}}</p>
    @else
    <p><b>User:</b> Not Logged In</p>
    <p><b>Requested Page: </b>{{$page}}</p>
    <p><b>Access Level Needed: </b>{{$needed}}</p>
    @endif
@stop
