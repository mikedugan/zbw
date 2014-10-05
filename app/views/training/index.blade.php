@extends('layouts.training')
@section('title')
Your Training
@stop
@section('header')
	@yield('header')
@stop
@section('content')
    <div class="col-md-6">
        <h2 class="text-center">Your Training Progress</h2>
        <div id="training" class="progress progress-striped active">
            <div class="progress-bar" role="progressbar" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100" style="width:{{ $progress }}%"></div>
        </div>
        <h5>Current VATSIM Rating: <span class="sans">{{ $me->rating->long }}</span></h5>
        @if($me->cert > 0)
        <h5>Current ZBW Certification: <span class="sans">{{ $me->certification->readable() }}</span></h5>
        @else
        <h5>Current ZBW Certification: <span class="sans">N/A</span></h5>
        @endif
        @if($me->cert < 11)
        @if($me->cert == 2 && $me->rating_id < 2)
          <form class="axform" action="/me/request/vatusa" method="post">
            <button type="submit" class="btn btn-primary">Request VATUSA S1 Exam</button>
          </form>
        @elseif($me->cert == 5 && $me->rating_id < 3)
        <form class="axform" action="/me/request/vatusa" method="post">
            <button type="submit" class="btn btn-primary">Request VATUSA S2 Exam</button>
        </form>
        @elseif($me->cert == 8 && $me->rating_id < 4)
        <form class="axform" action="/me/request/vatusa" method="post">
            <button type="submit" class="btn btn-primary">Request VATUSA S3 Exam</button>
        </form>
        @elseif($me->cert == 10 && $me->rating_id < 5)
        <form class="axform" action="/me/request/vatusa" method="post">
            <button type="submit" class="btn btn-primary">Request VATUSA C1 Exam</button>
        </form>
    @endif
    <a class="btn btn-primary" href="/training/request/new">Request Training</a>
    {{--@if($me->canTakeNextExam())--}}
    @if(in_array($me->cert_id, [0,1,2,4,5,7,8,10]))
      @if($me->cert_id > 0)
      <a class="btn btn-primary" href="/training/local-exam">Request {{ $me->certification->nextReadable()  }} Exam</a>
      @else
      <a class="btn btn-primary" href="/training/local-exam">Request SOP Exam</a>
      @endif
    @endif
    @if($me->hasReviews())
        @if(false)
        <a class="btn btn-primary" href="/training/review">Review Exams</a>
        @endif
    @endif
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
      </div>
    </div>
@stop
