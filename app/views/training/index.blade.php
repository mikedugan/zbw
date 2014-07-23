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
            <div class="progress-bar" role="progressbar" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <h5>Current VATSIM Rating: <span class="sans">{{ $me->rating->long }}</span></h5>
        <h5>Current ZBW Certification: <span class="sans">{{ \Zbw\Base\Helpers::readableCert($me->cert) }}</span></h5>
    </div>
    <div class="col-md-6">
        @if($me->cert < 11)
        <a class="btn btn-primary {{ $me->cert % 3 == 0 ? 'disabled' : ''}}" href="/e/request{{ $me->cid}}/{{ $me->cert + 1 }}">Request {{ \Zbw\Base\Helpers::readableCert($me->cert + 1) }} Exam</a>
        <a class="btn btn-primary" href="/training/request/new">Request Training</a>
        <a class="btn btn-primary" href="/training/take">Take Exam</a>
        <a class="btn btn-primary" href="/training/review">Review Exams</a>
        @else
        <h5>Congratulations! You have already completed all ZBW training and are a fully certed center!</h5>
        @endif
    </div>
@stop
