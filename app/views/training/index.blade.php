@extends('layouts.training')
@section('header')
	@yield('header')
@stop
@section('content')
    <div class="col-md-12">
        <h2 class="text-center">Your Training Progress</h2>
        <div id="training" class="progress progress-striped active">
            <div class="progress-bar" role="progressbar" aria-valuenow="{{ $user->trainingProgress() }}" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <h5>Current Rating: {{ $user->rating() }}</h5>
        <h5>Current Certification {{ $user->certTitle() }}</h5>
    </div>
    <div class="col-md-6">
        <form class="axform" id="request-exam" action="/e/request/{{ $user->cid() }}/{{ $user->availableExams()[0] }}" method="post">
            <button type="submit" class="btn btn-primary">Request {{ $user->availableExams()[1] }}</button>
        </form>
        <a class="btn btn-primary" href="/training/take">Take Exam</a>
        <a class="btn btn-primary" href="/training/review">Review Exams</a>
    </div>
@stop
