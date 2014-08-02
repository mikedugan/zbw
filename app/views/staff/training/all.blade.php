@extends('layouts.master')
@section('title')
All Training Sessions
@stop
@section('content')
<h1 class="text-center">Training Sessions</h1>
<div class="row">
    <div class="col-md-12">
        <div class="col-md-6">
            @if($paginate)
                {{ $sessions->links() }}
            @else
                {{ HTML::linkRoute('staff/training/all', 'View All') }}
            @endif
            @foreach($sessions as $session)
                <h3>{{ $session->student->initials }} <span class="small">was trained by {{ $session->staff->initials or '??' }} on {{ $session->facility->value }}</span>
                <span class="pull-right"><a class="small" href="/staff/training/{{$session->id}}">View</a></span>
                </h3>
                <h4>{{ $session->created_at->toDayDateTimeString() }}</h4>
                <p>{{ $session->staff_comment }}</p>
                <p><b>Duration:</b> {{ $session->brief_time + $session->position_time }} minutes</p>
                <hr>
            @endforeach
            @if($paginate)
                {{ $sessions->links() }}
            @endif
        </div>
        <div class="col-md-6">
            <h3>Filter Results</h3>
            <form action="" method="GET">
                <div class="form-group col-md-12">
                    <label for="cinitials" class="control-label">Student Initials</label>
                    <input type="text" maxlength="2" name="cinitials" id="cinitials" class="form-control">
                </div>
                <div class="form-group col-md-12">
                    <label for="sinitials" class="control-label">Staff Initials</label>
                    <input type="text" maxlength="2" name="sinitials" id="sinitials" class="form-control">
                </div>
                <div class="form-group col-md-12">
                    <label for="before" style="display:block" class="control-label">Before</label>
                    <input class="datepickopen" name="before" id="before">
                </div>
                <div class="form-group col-md-12">
                    <label for="after" style="display:block;" class="control-label">After</label>
                    <input class="datepickopen" name="after" id="after">
                </div>
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop
