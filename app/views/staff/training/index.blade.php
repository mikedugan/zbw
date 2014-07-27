@extends('layouts.staff')
@section('title')
Training Index
@stop
@section('content')
<div class="col-lg-12 training-summary">
 {{-- this area should contain an overview of recent training, promotions, etc --}}
    <div class="col-lg-3">
        <h4>Recent Reports</h4>
        @foreach($reports as $r)
            <p class="well">
                <a href="/staff/training/{{$r->id}}">
                {{ strtoupper($r->student['initials']) }} was trained by
                {{ strtoupper($r->staff['initials']) }}
                {{ \Zbw\Base\Helpers::timeAgo($r->session_date) }} on
                {{ $r->facility->value }}
                </a>
            </p>
        @endforeach
    </div>
    <div class="col-lg-3">
        <h4>Recent Staffing</h4>
        @foreach($staffings as $s)
            <p class="well"><a href="/controllers/{{$s->cid}}">{{ $s->user->initials }}</a> staffed {{$s->position}} for
                <?php
                $minutes = $s->created_at->diffInMinutes($s->stop);
                $hours = 0;
                if($minutes > 60) { $hours = floor($minutes / 60); $minutes = $minutes % 60; }
                echo $hours > 0 ? $hours . ' hour(s) ' . $minutes . ' minutes' : $minutes . ' minutes';
                ?>
            </p>
        @endforeach
    </div>
 {{-- this area should contain pending training & exam requests, etc --}}
    <div class="col-lg-3">
        <h4>Requests</h4>
        @if($requests)
            @foreach($requests as $r)
                <p class="well">
                <a href="/training/request/{{$r->id}}">{{ $r->student->initials }} has requested training on {{ Zbw\Base\Helpers::readableCert($r->certType->id) }}</a>
                    @if($r->is_completed)
                    <span class="badge bg-success">Complete</span>
                        @elseif(!empty($r->sid))
                    <span class="badge bg-warning">Pending</span>
                        @else
                    <span class="badge bg-danger">Available</span>
                    @endif
                </p>
            @endforeach
        @endif
    </div>
    <div class="col-lg-3">
        <h4>Exam Reviews</h4>
        @if($exams)
            @foreach($exams as $e)
                <p class="well">
                    <a href="/staff/exams/review/{{$e->id}}">
                    {{ strtoupper($e->student['initials']) }}
                        took
                        {{ Zbw\Base\Helpers::readableCert($e->exam['id']) }}
                    , scored
                        {{ \Zbw\Base\Helpers::getScore($e) }}
                        %
                    </a>
                </p>
            @endforeach
        @endif
    </div>
</div>
@stop
