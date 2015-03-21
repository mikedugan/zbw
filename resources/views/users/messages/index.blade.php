@extends('layouts.messages')
@section('title')
Messages
@stop
@section('header')
@stop
@section('content')
@include('includes.nav._messenger')
@if(! $view || $view === 'inbox')
    @include('users.messages.inbox')
@elseif($view === 'outbox')
    @include('users.messages.outbox')
@elseif($view === 'compose')
    @include('users.messages.create')
@elseif($view === 'trash')
    @include('users.messages.trash')
@endif
@stop
