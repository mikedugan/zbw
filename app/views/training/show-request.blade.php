@extends('layouts.training')
@section('title')
View Request
@stop
@section('header')
@stop
@section('content')

    <h1 class="text-center">View Training Session Request</h1>
    <div class="well col-md-6">
        <p><b>Student: </b>{{$request->student->username . " (" . $request->student->initials . ")"}}</p>
        <p><b>Staff: </b>{{$request->staff->initials or 'Not accepted yet'}}</p>
        <p><b>Position: </b>{{Zbw\Core\Helpers::readableCert($request->certType->id)}}</p>
        @if($request->is_completed)
          <p><b>Completed? </b> Yes (<a href="/staff/training/{{$request->training_session_id}}">View Report</a>)
        @else
          <p><b>Notes: </b> {{ $request->comment or '' }}</p>
        @endif
    </div>
    <div class="col-md-6 well">
        <p><b>Availability Start: </b>{{ $request->start }}</p>
        <p><b>Availability End: </b>{{ $request->end }}</p>
        <p><b>Training Request Submitted: </b>{{$request->created_at}}</p>
        <p><b>Training Session Completed: </b>{{$request->completed_at or 'Not Yet'}}</p>
    </div>
    <div class="col-md-6">
    @if(($me->is_exec()) && !$request->is_completed)
    <form action="/t/request/{{$request->id}}/cancel" method="post">
        <button type="submit" class="btn btn-sm btn-danger">Cancel Request</button>
    </form>
    @endif
    @if($me->is_mentor() || $me->is_instructor())
        @if(($request->sid === $me->cid) && !$request->is_completed)
        <form data-reload="true" class="axform" action="/t/request/{{$request->id}}/drop" method="post">
            <button type="submit" class="btn btn-sm btn-warning">Drop Request</button>
        </form>
        @elseif(!$request->sid && !$request->is_completed)
        <form id="accept-request-ajax" data-reload="true" action="/t/request/{{$request->id}}/accept" method="post">
            <label for="comment">Note to Student</label>
            <textarea class="form-control" name="comment" id="comment" cols="30" rows="4"></textarea>
            <button style="margin-top:15px;" type="submit" class="btn btn-sm btn-success">Accept Request</button>
        </form>
        @endif
    @endif
    </div>
    <div class="col-md-6">
        @if($request->sid === $me->cid && !$request->is_completed)
        <a href="/staff/live/{{$request->id}}" class="btn btn-success">Start Session</a>
        @endif
    </div>
@stop
