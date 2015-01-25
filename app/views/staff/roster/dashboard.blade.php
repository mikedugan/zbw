@extends('layouts.master')
@section('title')
Dashboard
@stop
@section('content')
<div class="row">
    <ul class="nav nav-tabs">
        <li role="presentation" class="active"><a href="#exams" aria-controls="exams" role="tab" data-toggle="tab">Exams</a></li>
        <li role="presentation"><a href="#training" aria-controls="training" role="tab" data-toggle="tab">ZBW Training</a></li>
        <li role="presentation"><a href="#comments" aria-controls="comments" role="tab" data-toggle="tab">Roster Comments</a></li>
    </ul>
</div>
<div class="tab-content">
    <div class="active tab-pane" id="exams" role="tabpanel">
        <h3 class="text-center">ZBW Exams</h3>
        <form action="/staff/{{ $controller->cid }}/exam-records" method="POST">
            <?php $exams = [
            'SOP' => 'SOP Exam',
            'C_S1' => 'Class C S1',
            'B_S1' => 'Class B S1',
            'V_S1' => 'VATUSA S1',
            'C_S2' => 'Class C S2',
            'B_S2' => 'Class B S2',
            'V_S2' => 'VATUSA S2',
            'C_S3' => 'Class C S3',
            'B_S3' => 'Class B S3',
            'V_S3' => 'VATUSA S3',
            'C' => 'Center',
            'V_C' => 'VATUSA Center'
            ];?>
            <div class="form-group">
                <?php $i = 0; ?>
                @foreach($exams as $exam => $title)
                    <div style="width:240px;margin:5px 0 0 10px" class="checkbox checkbox-inline" title="Last updated {{ $controller->examRecords->{$exam.'_assigned_on'} }} by {{ $controller->examRecords->{$exam.'_assigned_by'} }}">
                        <input value="1" name="{{$exam}}_assigned" type="checkbox"
                            @if($controller->examRecords->{$exam.'_assigned'} == 1)
                                checked
                            @endif
                            /> {{ $title }} Assigned
                    </div>
                    <div style="width: 240px;margin: 5px 0 0 10px" class="checkbox checkbox-inline" title="Last updated {{ $controller->examRecords->{$exam.'_checked_off_on'} }} by {{ $controller->examRecords->{$exam.'_checked_off_by'} }}">
                        <input value="1" name="{{$exam}}_checked_off" type="checkbox"
                            @if($controller->examRecords->{$exam.'_checked_off'} == 1)
                                checked
                            @endif
                            /> {{ $title }} Checked Off
                    </div>
                @endforeach
            </div>
        {{ Form::submit('Update', ['class' => 'btn btn-primary']) }}
        </form>
        <hr/>
        <h3 class="text-center">VATUSA Exams</h3>
    </div>
    <div class="tab-pane" id="training" role="tabpanel">
        @foreach($controller->training()->orderBy('created_at', 'DESC')->get() as $session)
             <h3>{{ $controller->initials }} <span class="small">was trained by {{ $session->staff->initials or '??' }} on {{ $session->facility->value }}</span>
            <span class="pull-right"><a class="small" href="/staff/training/{{$session->id}}">View</a></span>
            </h3>
            <h4>{{ $session->created_at->toDayDateTimeString() }}</h4>
            <p>{{ $session->staff_comment }}</p>
            <p><b>Duration:</b> {{ $session->brief_time + $session->position_time }} minutes</p>
            <hr>
        @endforeach
    </div>
    <div class="tab-pane" id="comments" role="tabpanel">
        <h3>Comments</h3>
        @if($comments->count() > 0)
            @foreach($comments as $comment)
            <div class="row">
              <div class="col-md-9"><p>{{ $comment->content }}</p></div>
              <div class="col-md-3">
                <p>by: <strong>{{ $comment->user->initials or '??'}} on {{ $comment->created_at->toFormattedDateString() }}</strong></p>
                @if($comment->author === $me->cid || $me->inGroup($executive))
                  <p><a href="/staff/comments/{{$comment->id}}/delete">Delete</a></p>
                  <p><a href="/staff/comments/{{$comment->id}}/edit">Edit</a></p>
                @endif
                </div>
            </div>
                <hr/>
            @endforeach
        @endif
    </div>
</div>
@stop
@section('scripts')
<script>
        $.get('/staff/roster/vatusa_exams/{{ $controller->cid  }}', function(data) {
            var exams = JSON.parse(data);
            for(var i = exams.length - 1; i >= 0; i--) {
                printExam(exams[i]);
            }
        });

        function printExam(exam)
        {
            var html =
            '<div class="row">' +
               '<div class="col-md-12 well">' +
                  '<p><b>Exam:</b> ' + exam.exam[0] + '</p>' +
                  '<p><b>Exam Date:</b> ' + exam.exam_date[0] + '</p>' +
                  '<p><b>Score:</b> ' + exam.exam_score[0] + '</p>' +
               '</div>' +
            '</div>';
            $('#exams').append(html);
        }
</script>
@stop
