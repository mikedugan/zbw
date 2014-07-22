<div class="col-md-6">

    <p><b>Full Name:</b> {{ $me->first_name . ' ' . $me->last_name }}</p>
    <p><b>Controller ID:</b> {{ $me->cid }}</p>
    <p><b>Operating Initials:</b> {{ $me->initials }}</p>
    <p><b>Rating: </b>{{ $me->rating->grp }} ({{$me->rating->short}})</p>
    <p><b>Email:</b> {{ $me->email }}</p>

    <p><b>Staff Positions:</b><br/>
        @if($me->inGroup(Sentry::findGroupByName('ATM')))
        ATM
        @elseif($me->inGroup(Sentry::findGroupByName('DATM')))
        DATM
        @elseif($me->inGroup(Sentry::findGroupByName('TA')))
        TA
        @elseif($me->inGroup(Sentry::findGroupByName('WEB')))
        Webmaster
        @elseif($me->inGroup(Sentry::findGroupByName('FE')))
        FE
        @endif
        @if($me->inGroup(Sentry::findGroupByName('Instructors')))
        Instructor
        @elseif($me->inGroup(Sentry::findGroupByName('Mentors')))
        Mentor
        @endif
    </p>
</div>
<div class="col-md-6">
    <h3>Recent Exams</h3>
    @foreach($me->exams as $exam)
        <p>{{ Zbw\Base\Helpers::readableCert($exam->exam->id) . ' on ' . $exam->created_at->toFormattedDateString() }}</p>
    @endforeach
    <h3>Recent Training</h3>
    @foreach($me->training as $session)
        <p>{{ $session->created_at->toFormattedDateString() . ' at ' . $session->facility->value }}</p>
    @endforeach
    <h3>Recent Staffing</h3>
    @foreach($me->staffing as $staffing)
    <p>Staffed {{$staffing->position}} for
        <?php
        $minutes = $staffing->created_at->diffInMInutes($staffing->stop);
        $hours = 0;
        if($minutes > 60) { $hours = floor($minutes / 60); $minutes = $minutes % 60; }
        echo $hours > 0 ? $hours . ' hour(s) ' . $minutes . ' minutes' : $minutes . ' minutes';
        ?>
    </p>
    @endforeach
</div>
