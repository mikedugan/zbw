@extends('layouts.master')
@section('title')
Dashboard
@stop
@section('content')
<div class="row">
    <ul class="nav nav-tabs">
        <li role="presentation" class="active"><a href="#exams" aria-controls="exams" role="tab" data-toggle="tab">VATUSA Exams</a></li>
        <li role="presentation"><a href="#training" aria-controls="training" role="tab" data-toggle="tab">ZBW Training</a></li>
        <li role="presentation"><a href="#comments" aria-controls="comments" role="tab" data-toggle="tab">Roster Comments</a></li>
    </ul>
</div>
<div class="tab-content">
    <div class="active tab-pane" id="exams" role="tabpanel">
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
                @if($comment->author === $me->cid || $me->inGroup(\Sentry::findGroupByName('Executive')))
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
