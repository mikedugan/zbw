<div class="col-md-6">

    <p><b>Full Name:</b> {{ $me->first_name . ' ' . $me->last_name }}</p>
    <p><b>Controller ID:</b> {{ $me->cid }}</p>
    <p><b>Operating Initials:</b> {{ $me->initials }}</p>
    <p><b>Rating: </b>{{ $me->rating->grp }} ({{$me->rating->short}})</p>
    <p><b>Email:</b> {{ $me->email }}</p>

    <p><b>Staff Positions:</b><br/>
    @if($me->is_atm)
        ATM <br>
    @endif
    @if($me->is_datm)
        DATM <br>
    @endif
    @if($me->is_ta)
        TA <br/>
    @endif
    @if($me->is_webmaster)
        Webmaster <br/>
    @endif
    @if($me->is_fe)
        FE <br/>
    @endif
    @if($me->is_instructor)
        Instructor
    @endif
    @if($me->is_mentor)
        Mentor
    @endif
    </p>
</div>
<div class="col-md-6">
    <h3>Recent Exams</h3>
    @foreach($me->exams as $exam)
        <p>{{ Zbw\Base\Helpers::readableCert($exam->exam->value) . ' on ' . $exam->created_at->toFormattedDateString() }}</p>
    @endforeach
    <h3>Recent Training</h3>
    @foreach($me->training as $session)
        <p>{{ $session->created_at->toFormattedDateString() . ' at ' . $session->facility->value }}</p>
    @endforeach
    <h3>Recent Staffing</h3>
</div>
