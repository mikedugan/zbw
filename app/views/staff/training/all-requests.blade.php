@extends('layouts.master')
@section('title')
All Training Requests
@stop
@section('content')
<h1 class="text-center">Training Requests</h1>
<div class="row">
    <div class="col-md-12">
        <div class="col-md-6">
            @if($paginate)
             {{ $requests->links() }}
            @else
                {{ HTML::linkRoute('training/request/all', 'View All') }}
            @endif
            @foreach($requests as $request)
            <div class="well">
                <p>{{ $request->student->initials }} has requested training on {{ Zbw\Core\Helpers::readableCert($request->certType->id) }}</p>
                <p>Between {{ $request->start->toDayDateTimeString() }} and {{ $request->end->toDayDateTimeString() }}</p>
                @if($request->accepted_at)
                <p>Training session has been accepted by {{ $request->staff->initials }}
                    @if($request->is_completed)
                         and has been completed
                    @endif
                    </p>
                @else
                <p>Training session is still available</p>
                @endif
            </div>
            @endforeach
        </div>
        <div class="col-md-6">
            <h3>Filter Results</h3>
            <form action="" method="GET">
                <div class="form-group col-md-12">
                    <label for="initials" class="control-label">Student Initials</label>
                    <input type="text" maxlength="2" name="initials" id="initials" class="form-control">
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
