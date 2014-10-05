@extends('layouts.master')
@section('title')
ZBW Controller Scheduler
@stop
@section('content')
<div class="col-md-6">
  <h3 class="text-center">Currently Scheduled</h3>
  @foreach($schedules as $schedule)
    <p><a href="/controllers/{{$schedule->controller->cid}}">{{ $schedule->controller->initials }}</a> is scheduled for {{ $schedule->position }} from {{ $schedule->start->toDayDateTimeString() }} to
    {{ $schedule->end->toDayDateTimeSTring() }}</p>
  @endforeach
</div>
<div class="col-md-6">
  <h3 class="text-center">New Schedule Entry</h3>
  <form action="" method="post">
    <div class="form-group">
      <p>Coming Online</p>
      <input name="start" id="start" class="datepick"/>
    </div>
    <div class="form-group">
      <p>Going Offline</p>
      <input name="end" id="end" class="datepick"/>
    </div>
    <div class="form-group">
      <label for="position">Position</label>
      <input class="form-control" id="position" name="position" type="text"/>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
  <h3 class="text-center">My Schedules</h3>
  @foreach($me->schedules as $schedule)
    <p class="well">{{ $schedule->position }} from {{$schedule->start->toDayDateTimeString()}} to {{ $schedule->end->toDayDateTimeString() }}
    <a href="/schedule/delete/{{$schedule->id}}"><span title="Delete this entry" style="vertical-align:top;margin-left:10px;" class="glyphicons remove red"></span></a>
    </p>
  @endforeach
</div>
@stop
