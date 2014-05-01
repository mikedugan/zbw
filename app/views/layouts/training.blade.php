@extends('layouts.master')
@section('title')
	@yield('title')
@stop
@section('header')
<ul class="nav navbar-nav navbar-right col-md-1">
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Tools <b class="caret"></b></a>
        <ul class="dropdown-menu">
            <li><a href="#">Add Controller</a></li>
            <li><a href="#">Add Staff</a></li>
            <li><a href="#">Remove Controller</a></li>
            @yield('tools')
        </ul>
    </li>
</ul>
	@yield('header')
@stop
@section('content')
	@yield('content')
@stop
