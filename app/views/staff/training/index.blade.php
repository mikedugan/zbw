@extends('layouts.staff')
@section('title')
Training Index
@stop
@section('content')
@include('includes.nav._training')
<div class="col-lg-12 training-summary">
 {{-- this area should contain an overview of recent training, promotions, etc --}}
    <div class="col-lg-3">
        <h4>Recent Reports {{ HTML::linkRoute('staff/training/all', 'View All', '',['class' => 'small']) }}</h4>
        @foreach($reports as $r)
            <p class="well">
                <a href="/staff/training/{{$r->id}}">
                {{ $r->student['initials'] }} was trained by
                {{ $r->staff['initials'] }}
                {{ $r->timeAgo('session_date') }} on
                {{ $r->facility->value }}
                </a>
                @if($r->is_ots == -1)
                <span class="badge bg-info">Not OTS</span>
                @elseif($r->is_ots == 0)
                <span class="badge bg-danger">OTS Fail</span>
                @elseif($r->is_ots == 1)
                <span class="badge bg-success">OTS Pass</span>
                @endif
            </p>
        @endforeach
    </div>
    <div class="col-lg-3">
        <h4>Recent Staffing {{ HTML::linkRoute('staff/staffing', 'View All', '',['class' => 'small']) }}</h4>
        @foreach($staffings as $s)
            <p class="well"><a href="/controllers/{{$s->cid}}">{{ $s->user->initials }}</a> staffed {{$s->position}} for {{ $s->timeOnline() }}</p>
        @endforeach
    </div>
 {{-- this area should contain pending training & exam requests, etc --}}
    <div class="col-lg-3">
        <h4>Requests {{ HTML::linkRoute('training/request/all', 'View All', '',['class' => 'small']) }}</h4>
        @if($requests)
            @foreach($requests as $r)
            @if($me->canTrain($r->cert_id))
                <p class="well">
                <a href="/training/request/{{$r->id}}">{{ $r->student->initials }} has requested training on {{ $r->certType->readable() }}</a>
                    @if($r->is_completed)
                    <span class="badge bg-success">Complete</span>
                        @elseif(!empty($r->sid))
                    <span class="badge bg-warning">Pending</span>
                        @else
                    <span class="badge bg-danger">Available</span>
                    @endif
                </p>
                @endif
            @endforeach
        @endif
    </div>
    <div class="col-lg-3">
        <h4>Exam Reviews {{ HTML::linkRoute('staff/exams/all', 'View All', '',['class' => 'small']) }}</h4>
        @if($exams)
            @foreach($exams as $exam)
            @if($me->canTrain($exam->cert_type_id))
                <p class="well">
                    <a href="/staff/exams/review/{{$exam->id}}">
                    {{ strtoupper($exam->student['initials']) }}
                        took
                        @if($exam->isVatusaExam())
                          VATUSA {{ $exam->studentRating() }}
                        @else
                          {{ $exam->cert->readable() }}
                        @endif
                    , scored
                        {{ $exam->score() }}%
                    </a>
                    @if($exam->failed())
                    <span class="badge bg-danger">Failed</span>
                    @else
                    <span class="badge bg-success">Passed</span>
                    @endif
                </p>
            @endif
            @endforeach
        @endif
    </div>
</div>
@stop
