@extends('layouts.master')
@section('title')
ZBW Exams
@stop
@section('content')
<h1 class="text-center">ZBW Exams</h1>
<div class="row">
    <div class="col-md-12">
        <div class="col-md-6">
            @if($paginate)
                {{ $exams->links() }}
            @else
                {{ HTML::linkRoute('staff/exams/all', 'View All') }}
            @endif

            @foreach($exams as $exam)
                <div class="well">
                    <a href="/staff/exams/review/{{$exam->id}}">
                        {{ strtoupper($exam->student['initials']) }}
                        took
                        {{ Zbw\Core\Helpers::readableCert($exam->cert['id']) }}
                        , scored
                        <?php $score = \Zbw\Core\Helpers::getScore($exam); echo $score ?>%
                    </a>
                    @if($score < 80)
                    <span class="col-md-2 badge bg-danger pull-right">Failed</span>
                    @else
                    <span class="col-md-2 badge bg-success pull-right">Passed</span>
                    @endif
                    @if($exam->reviewed)
                    <span class="col-md-2 badge bg-success pull-right">Reviewed</span>
                    @else
                    <span class="col-md-2 badge bg-warning pull-right">Under Review</span>
                    @endif
                </div>
            @endforeach

            @if($paginate)
                {{ $exams->links() }}
            @endif
        </div>
        <div class="col-md-6">
            <form action="" method="GET">
                <h3>Filter Exams</h3>
                <div class="form-group">
                    <label for="initials">Student Initials</label>
                    <input type="text" name="initials" id="initials" maxlength="2" class="form-control">
                </div>
                <div class="form-group">
                    <label for="reviewed">Return Reviewed Exams?</label>
                    &nbsp;<input type="checkbox" name="reviewed" value="true" id="reviewed">
                </div>
                <div class="form-group">
                    <label style="display:block" for="before">Taken Before</label>
                    <input name="before" id="before" class="datepickopen">
                </div>
                <div class="form-group">
                    <label style="display:block" for="after">Taken After</label>
                    <input name="after" id="after" class="datepickopen">
                </div>
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
        </div>
    </div>
</div>
@stop
