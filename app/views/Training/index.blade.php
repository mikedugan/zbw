@extends('layouts.training')
@section('header')
	@yield('header')
@stop
@section('content')
    <div class="col-md-6">
        <a class="btn btn-primary" href="{{ url_to('training/request') }}">Request Exam</a>
        <a class="btn btn-primary" href="{{ url_to('training/take') }}">Take Exam</a>
        <a class="btn btn-primary" href="{{ url_to('training/review') }}">Review Exams</a>
    </div>
@stop