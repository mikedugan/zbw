@extends('layouts.staff')
@section('title')
Training Index
@stop
@section('content')
<div class="col-md-6">
 {{-- this area should contain an overview of recent training, promotions, etc --}}
    <div class="col-md-6">
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
    <div class="col-md-6">
        <h4>Recent Staffing</h4>
        <p class="well">
            AS staffed PVD_APP for 73 minutes on 2/21/14
        </p>
        <p class="well">
            WY staffed BOS_CTR for 85 minutes on 2/18/14
        </p>
        <p class="well">
            PG staffed PWM_GND for 51 minutes on 2/14/14
        </p>
        @foreach($sessions as $s)

        @endforeach
    </div>
</div>
<div class="col-md-6">
 {{-- this area should contain pending training & exam requests, etc --}}
    <div class="col-md-6">
        <h4>Requests</h4>
        @if($requests)
            @foreach($requests as $r)
                <p class="well"><a href="/training/request/{{$r->id}}">{{ strtoupper($r->student->initials) }} has requested training on {{ Zbw\Base\Helpers::readableCert($r->certType->value) }}</a></p>
            @endforeach
        @endif
    </div>
    <div class="col-md-6">
        <h4>Exam Reviews</h4>
        @if($exams)
            @foreach($exams as $e)
                <p class="well">
                    <a href="/staff/exams/review/{{$e->id}}">
                    {{ strtoupper($e->student['initials']) }} took {{ $e->exam['value'] }}
                    , scored {{ \Zbw\Base\Helpers::getScore($e) }}%
                    </a>
                </p>
            @endforeach
        @endif
    </div>
</div>
@stop
