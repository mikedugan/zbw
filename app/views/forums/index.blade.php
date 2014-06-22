@extends('layouts.forum')
@section('header')
	@yield('header')
@stop
@section('content')
	@yield('content')
<h1 class="text-center">Boston ARTCC Forums</h1>
@foreach($forums as $forum)
    @include('includes.forums.forum-row')
@stop
