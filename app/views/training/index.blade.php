@extends('layouts.training')
@section('title')
Your Training
@stop
@section('header')
	@yield('header')
@stop
@section('content')
    <div class="col-md-12">
        <h2 class="text-center">Your Training Progress</h2>
        <div id="training" class="progress progress-striped active">
            <div class="progress-bar" role="progressbar" aria-valuenow="{{ Zbw\Repositories\UserRepository::trainingProgress($me->cid) }}" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <h5>Current Rating: {{ $me->rating }}</h5>
        <h5>Current Certification {{ Zbw\Helpers::readableCert($me->rating) }}</h5>
    </div>
    <div class="col-md-6">
        <form class="axform" id="request-exam" action="/e/request/{{ $me->cid }}/{{ Zbw\Repositories\ExamsRepository::availableExams($me->cid)[1] }}" method="post">
            <button type="submit" class="btn btn-primary">Request {{ Zbw\Repositories\ExamsRepository::availableExams($me->cid)[1] }} Exam</button>
        </form>
        <a class="btn btn-primary" href="/training/request/new">Request Training</a>
        <a class="btn btn-primary" href="/training/take">Take Exam</a>
        <a class="btn btn-primary" href="/training/review">Review Exams</a>
    </div>
@stop
