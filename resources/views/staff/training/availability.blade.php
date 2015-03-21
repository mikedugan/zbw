@extends('layouts.master')
@section('title')
Staff Training Availability
@stop
@section('content')
<div class="col-md-6">
  <h3 class="text-center">Current Availability</h3>
  @foreach($available as $session)
    <div class="well">
      <p>{{ $session->controller->initials }} is available up to {{Zbw\Core\Helpers::readableCert($session->cert_id)}}
       from {{$session->start->toDayDateTimeString()}} to {{$session->end->toDayDateTimeString()}}</p>
       @if(!empty($session->comment))
       <p><b>Notes</b>
       @if($session->cid === $me->cid)
       <a class="pull-right" href="/staff/training/availability/delete/{{$session->id}}"><span title="Delete this entry" style="vertical-align:top;margin-left:10px;" class="glyphicons remove red"></span></a>
       @endif
       </p>
       <hr/>
       {{ $session->comment }}
       @endif
    </div>
  @endforeach
</div>
<div class="col-md-6">
  <h3 class="text-center">Add Availability</h3>
  <form action="" method="post">
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <p>Available From</p>
          <input name="start" id="start" class="datepick"/>
        </div>
        <div class="form-group">
          <p>Available To</p>
          <input name="end" id="end" class="datepick"/>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="cert_id">Training Up To</label>
          <select class="form-control" name="cert_id" id="cert_id">
            @for($i = 2; $i <= $me->cert; $i++)
              <option value="{{$i}}">{{ Zbw\Core\Helpers::readableCert($i) }}</option>
            @endfor
          </select>
        </div>
        <div class="form-group">
          <label for="comment">Notes</label>
          <textarea class="editor" name="comment" id="comment" cols="30" rows="4"></textarea>
        </div>
      </div>
    </div>
    <button type="submit" class="btn btn-primary">Add</button>
  </form>
</div>

@stop
