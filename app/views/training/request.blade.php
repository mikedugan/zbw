@extends('layouts.training')
@section('title')
Training Request
@stop
@section('content')
<h1 class="text-center">Request Training Session</h1>
<div class="col-md-12">
  <form id="request-training">
    <div class="row">
      <p>Your training request will be for <i>{{Zbw\Core\Helpers::readableCert($me->cert)}}</i></p>
      <input id="cert" type="hidden" value="{{ $me->cert }}">
      <input id="cid" type="hidden" value="{{$me->cid }}">
    </div>
    <div class="row">
      <div class="well col-md-12">
          <div class="col-md-6">
            <div class="row">
              <div class="datepick col-md-12" id="session_start" data-field="session_start" name="session_start"></div>
            </div>
            <div class="row">
              <div class="col-md-12">
               <h3>Start Time</h3>
               <p>Select a starting time for your training session request. This shouldn't
               be an exact time, but a range of time that you will be available. You may only
               request training for the next 30 days.</p>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="row">
              <div class="datepick col-md-12" id="session_end" data-field="session_end" name="session_end"></div>
            </div>
            <div class="row">
              <h3>End Time</h3>
              <p>Select the latest time you would be available for a training session.
              Remember, you should be available on TeamSpeak or the forum for the duration
              of your request.</p>
            </div>
          </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <label for="comment">Notes for Staff</label>
        <textarea class="form-control" name="comment" id="comment" cols="10" rows="4"></textarea>
        <button style="margin-top:15px;" class="btn btn-primary" disabled type="submit">Submit</button>
      </div>
      <div class="col-md-6">
        @foreach($available as $session)
          @include('includes.loops._availability')
        @endforeach
      </div>
    </div>
  </form>
</div>
@stop
