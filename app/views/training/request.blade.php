@extends('layouts.training')
@section('title')
Training Request
@stop
@section('header')
@stop

@section('content')
    <h1 class="text-center">Request Training Session</h1>
    <div class="col-md-12">
    <form id="request-training">
        <p>Your training request will be for <i>{{Zbw\Base\Helpers::readableCert($me->cert)}}</i></p>
        <input id="cert" type="hidden" value="{{ $me->cert }}">
        <input id="cid" type="hidden" value="{{$me->cid }}">
        <div class="well col-md-12">
            <div class="col-md-3">
                <div class="datepick" id="session_start" data-field="session_start" name="session_start"></div>
            </div>
            <div class="col-md-3">
                <h3>Start Time</h3>
                <p>Select a starting time for your training session request. This shouldn't
                be an exact time, but a range of time that you will be available. You may only
                request training for the next 30 days.</p>
            </div>
            <div class="col-md-3">
                <div class="datepick col-md-6" id="session_end" data-field="session_end" name="session_end"></div>
           </div>
            <div class="col-md-3">
                <h3>End Time</h3>
                <p>Select the latest time you would be available for a training session.
                Remember, you should be available on TeamSpeak or the forum for the duration
                of your request.</p>
            </div>
        </div>
        <button class="btn btn-primary" disabled type="submit">Submit</button>
    </form>
    </div>
@stop
