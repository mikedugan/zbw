@extends('layouts.staff')
@section('title')
Boston ARTCC Roster
@stop
@section('content')
@include('includes.nav._public_roster')
    @if(!$view || $view == 'roster')
    @include('zbw.roster.roster')
    @elseif($view === 'staff')
    @include('zbw.roster.staff')
    @elseif($view === 'groups')
    @include('zbw.roster.groups')
    @endif
@stop
