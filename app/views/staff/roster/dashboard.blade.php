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
        <h3>Training</h3>
    </div>
    <div class="tab-pane" id="comments" role="tabpanel">
        <h3>Comments</h3>
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
