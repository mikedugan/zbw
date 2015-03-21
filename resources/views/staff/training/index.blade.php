@extends('layouts.staff')
@section('title')
Training Index
@stop
@section('content')
<div class="col-md-12"></div>
@include('includes.nav._training')
<div class="col-lg-12 training-summary">
 <div class="panel-group" id="accordion">
   <div class="row">
     <div class="col-md-6 panel panel-default">
       <div class="panel-heading">
           <h3 class="panel-title">
            <a data-toggle="collapse" data-parent="accordion" href="#collapseOne">
            Training Reports {{ \HTML::linkRoute('staff/training/all', 'View All', '',['class' => 'small']) }}
            </a>
           </h3>
       </div>
       <div id="collapseOne" class="panel-collapse collapse">
         <div class="panel-body">
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
       </div>
     </div>
     <div class="col-md-6 panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">
             <a data-toggle="collapse" data-parent="accordion" href="#collapseTwo">
             Controller Staffing {{ \HTML::linkRoute('staff/staffing', 'View All', '',['class' => 'small']) }}
             </a>
            </h3>
        </div>
        <div id="collapseTwo" class="panel-collapse collapse">
          <div class="panel-body">
          @foreach($staffings as $s)
            <p class="well"><a href="/controllers/{{$s->cid}}">{{ $s->user->initials }}</a> staffed {{$s->position}} for {{ $s->timeOnline() }}</p>
          @endforeach
          </div>
        </div>
     </div>
   </div>
   <div class="row">
     <div class="col-md-6 panel panel-default">
          <div class="panel-heading">
              <h3 class="panel-title">
               <a data-toggle="collapse" data-parent="accordion" href="#collapseThr">
               Training Requests {{ \HTML::linkRoute('training/request/all', 'View All', '',['class' => 'small']) }}
               </a>
              </h3>
          </div>
          <div id="collapseThr" class="panel-collapse collapse">
            <div class="panel-body">
            @if($requests)
                @foreach($requests as $r)
                @if($me->canTrain($r->cert_id))
                  <p class="well">
                  <a href="/training/request/{{$r->id}}">{{ $r->student->initials }} requests {{ $r->certType->readable() }} training for {{ $r->start->toDayDateTimeString() }}</a>
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
          </div>
        </div>
     <div class="col-md-6 panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">
              <a data-toggle="collapse" data-parent="accordion" href="#collapseFour">
              Completed Exams {{ \HTML::linkRoute('staff/exams/all', 'View All', '',['class' => 'small']) }}
              </a>
            </h3>
        </div>
        <div id="collapseFour" class="panel-collapse collapse">
          <div class="panel-body">
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
     </div>
   </div>
  </div>
</div>
@stop
