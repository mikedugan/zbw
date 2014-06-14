@extends('layouts.staff')
@section('title')
Roster Admin
@stop
@section('content')
@include('includes.nav._roster')
    @if(!$view || $view == 'roster')
    @include('staff.roster.roster')
    @elseif($view === 'staff')
    @include('staff.roster.staff')
    @elseif($view === 'controller')
    @include('staff.roster.addcontroller')
    @elseif($view === 'staff')
    @include('staff.roster.addstaff')
    @elseif($view === 'remove')
    @include('staff.roster.remove')
    @endif
@stop
