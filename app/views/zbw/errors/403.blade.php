@extends('layouts.master')
@section('content')
    <h1 class="text-center">Access Denied</h1>
    <p>We're sorry, but you do not have adequate permissions to view this page.</p>
    <p>If you believe this is an error, please contact a staff member!</p>
    <p><b>User:</b> {{$me->username}}</p>
    <p><b>Requested Page: </b>{{$page}}</p>
    <p><b>Access Level Needed: </b>{{$needed}}</p>
@stop
