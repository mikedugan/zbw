@extends('layouts.training')
@section('title')
Your Training
@stop
@section('header')
	@yield('header')
@stop
@section('content')
    <div class="col-md-6">
        <!--<h2 class="text-center">Your Training Progress</h2>
        <div id="training" class="progress progress-striped active">
            <div class="progress-bar" role="progressbar" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100" style="width:{{ $progress }}%"></div>
        </div>-->
        <h5>Current VATSIM Rating: <span class="sans">{{ $me->rating->long }}</span></h5>
        @if($me->cert > 0)
        <h5>Current ZBW Certification: <span class="sans">{{ $me->certification->readable() }}</span></h5>
        @else
        <h5>Current ZBW Certification: <span class="sans">N/A</span></h5>
        @endif

        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
            <div style="display:none" class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseVatusaExams" aria-expanded="true" aria-controls="collapseOne">
                            VATUSA Exams
                        </a>
                    </h4>
                </div>
                <div id="collapseVatusaExams" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body">
                        @for($i = 3; $i < 7; $i++)
                            <form class="axform" action="/me/request/vatusa/{{$i - 1}}" method="post">
                                <button type="submit" class="btn btn-primary">Request VATUSA {{ $ratings[$i]->short }} Exam</button>
                            </form>
                        @endfor
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingTwo">
                    <h4 class="panel-title">
                        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseZbwExams" aria-expanded="false" aria-controls="collapseTwo">
                            ZBW Exams
                        </a>
                    </h4>
                </div>
                <div id="collapseZbwExams" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                    <div class="panel-body">
                        @for($i = 0; $i < $certifications->count() - 3; $i++)
                            @if(in_array($i, [0,1,3,4,6,7,9,10]))
                            <form class="axform" action="/me/request/zbw/{{$i + 1}}" method="post">
                                <button type="submit" class="btn btn-primary">Request {{ $i == 0 ? 'SOP' : \Zbw\Core\Helpers::readableCert($certifications[$i]->id)  }} Exam</button>
                            </form>
                            @endif
                        @endfor
                    </div>
                </div>
            </div>
        </div>


    @if($me->cert < 11)
    <a class="btn btn-primary" href="/training/request/new">Request Training</a>
    @else
    <h5>Congratulations! You have already completed all ZBW training and are a fully certed center!</h5>
    @endif
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
            @unless(count($student->exams) == 0)
              @foreach($student->exams as $exam)
                  @if($exam->reviewed === 0)
                    <a href="/training/review"><p>{{ Zbw\Core\Helpers::readableCert($exam->cert_type_id) . ' on ' . $exam->created_at->toFormattedDateString() }}</p></a>
                  @else
                    <p>{{ Zbw\Core\Helpers::readableCert($exam->cert_type_id) . ' on ' . $exam->created_at->toFormattedDateString() }}</p>
                  @endif
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
              @foreach($student->training()->limit(10)->get() as $session)
                      <p><a href="/training/{{$session->id}}">{{ $session->created_at->toFormattedDateString() . ' at ' . $session->facility->value }}</a></p>
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
                @foreach($student->staffing as $staffing)
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
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">
                <a data-toggle="collapse" data-parent="accordion" href="#collapseFour">Staff Availability</a></h3>
            </div>
            <div id="collapseFour" class="panel-collapse collapse">
              <div class="panel-body">
                @foreach($available as $session)
                  @include('includes.loops._availability')
                @endforeach
              </div>
            </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                  <h3 class="panel-title">
                    <a data-toggle="collapse" data-parent="accordion" href="#collapseFive">My Training Requests</a></h3>
                </div>
                <div id="collapseFive" class="panel-collapse collapse">
                  <div class="panel-body">
                  @foreach($requests as $request)
                  <form action="/training/request/{{$request->id}}/cancel" class="form-inline" style="font-size:15px">
                    <label>{{ $request->start->toDayDateTimeString().": {$request->presentCert()}" }}</label>
                    <button type="submit" class="btn btn-warning btn-xs">Cancel</button>
                  </form>
                  @endforeach
                  </div>
                </div>
            </div>
      </div>
    </div>
@stop
