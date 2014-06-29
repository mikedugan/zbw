@extends('layouts.training')
@section('title')
View Request
@stop
@section('header')
@stop
@section('content')

    <h1 class="text-center">View Training Request</h1>
    <div class="well col-md-6">
        <p><b>Student: </b>{{$request->student->username . " (" . $request->student->initials . ")"}}</p>
        <p><b>Staff: </b>{{$request->staff->initials or 'Not accepted yet'}}</p>
        <p><b>Position: </b>{{Zbw\Base\Helpers::readableCert($request->certType->value)}}</p>
        <p><b>Completed? </b>
        @if($request->is_completed)
            Yes
        @else
            No
        @endif
        </p>
    </div>
    <div class="col-md-6 well">
        <p><b>Training Request Start: </b>{{ $request->start }}</p>
        <p><b>Training Request End: </b>{{ $request->end }}</p>
        <p><b>Request Submitted: </b>{{$request->created_at}}</p>
        <p><b>Request Completed: </b>{{$request->completed_at or 'Not Yet'}}</p>
    </div>
    @if($me == $request->student || $me->is_atm || $me->is_datm || $me->is_ta || $me->is_webmaster)
    <form class="axform" action="/t/request/{{$request->id}}/cancel" method="post">
        <button type="submit" class="btn btn-sm btn-warning">Cancel Request</button>
    </form>
    @endif
    @if($me->is_mentor || $me->is_instructor)
    <form class="axform" action="/t/request/{{$request->id}}/accept" method="post">
        <button type="submit" class="btn btn-sm btn-success">Accept Request</button>
    </form>
    @endif
@stop
