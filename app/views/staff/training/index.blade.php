@extends('layouts.staff')

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
                {{ \Zbw\Helpers::timeAgo($r->session_date) }} on
                {{ $r->location->facility }}
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
        <p class="well">
            AS has requested training on B_S3
        </p>
        <p class="well">
            PG has requested training on C_S2
        </p>
        <p class="well">
            AB has requested training on C1
        </p>
        @if($requests)
            @foreach($exams as $e)
                {{-- training requests --}}
            @endforeach
        @endif
    </div>
    <div class="col-md-6">
        <h4>Exam Reviews</h4>
        @if($exams)
            @foreach($exams as $e)
                <p class="well">
                    <a href="#">
                    {{ strtoupper($e->student['initials']) }} took {{ $e->exam['value'] }}
                    , scored {{ \zbw\Helpers::getScore($e) }}%
                    </a>
                </p>
            @endforeach
        @endif
    </div>
</div>
@stop
