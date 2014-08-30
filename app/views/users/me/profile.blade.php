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
<div class="panel-group" id="accordion">
  <div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">
      <a data-toggle="collapse" data-parent="accordion" href="#collapseOne">Recent Exams</a></h3>
  </div>
  <div id="collapseOne" class="panel-collapse collapse in">
    <div class="panel-body">
      @unless(count($me->exams) == 0)
        @foreach($me->exams as $exam)
            <p>{{ Zbw\Core\Helpers::readableCert($exam->cert_type_id) . ' on ' . $exam->created_at->toFormattedDateString() }}</p>
        @endforeach
      @endunless
    </div>
  </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title">
        <a data-toggle="collapse" data-parent="accordion" href="#collapseTwo">Recent Training</a></h3>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse">
      <div class="panel-body">
        @foreach($me->training()->limit(10)->get() as $session)
                <p>{{ $session->created_at->toFormattedDateString() . ' at ' . $session->facility->value }}</p>
            @endforeach
      </div>
    </div>
    </div>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">
          <a data-toggle="collapse" data-parent="accordion" href="#collapseThree">Recent Staffing</a></h3>
      </div>
      <div id="collapseThree" class="panel-collapse collapse">
        <div class="panel-body">
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
      </div>
      </div>
</div>

</div>
