@extends('layouts.staff')
@section('content')
    <h2>View {{ $user->initials }}</h2>
    <div class="col-md-12">
        <p>Name: {{ $user->first_name . ' ' . $user->last_name }}</p>
    </div>
@stop
