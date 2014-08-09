@extends('layouts.staff')
@section('title')
Exam Review
@stop
@section('header')
@stop
@section('content')
    <h1 class="text-center">Exam Review</h1>
    <div class="col-md-6">
        <h3>Student Info</h3>
        <p><b>Student:</b> {{$exam->student->username}} ({{$exam->student->initials}})</p>
        <p><b>Rating: </b> {{$exam->student->rating->short}}</p>
        @if(in_array($exam->student->cert, [2,5,8,10]))
        <p><b>Testing For: </b> {{ \Rating::find($exam->student->rating->id + 1)->long }}</p>
        @else
        <p><b>Testing for: </b>{{ \Zbw\Base\Helpers::readableCert($exam->cert->id)}}</p>
        @endif
        @if(in_array($me->cid, Zbw\Users\UserRepository::canTrain($exam->cert_id)) && ! $exam->reviewed == 1)
            <form data-reload="true" class="axform" action="/staff/exams/review/{{$exam->id}}/complete" method="post">
                <button class="btn btn-xs btn-success">Exam Review Complete</button>
            </form>
        @else
        <form data-reload="true" class="axform" action="/staff/exams/review/{{$exam->id}}/reopen" method="post">
            <button class="btn btn-xs btn-warning">Reopen Exam Review</button>
        </form>
        @endif
        @if($me->cid === $exam->cid || in_array($me->cid, Zbw\Users\UserRepository::canTrain($exam->cert_id)))
            @if($exam->reviewed == 1)
                <span class="badge bg-success">Exam Review Complete</span>
            @endif
        @endif
    </div>
    <div class="col-md-6">
        <h3>Exam Summary</h3>
        <p><b>Date Assigned:</b> {{ $exam->assigned_on or "??"}}</p>
        <p><b>Total Questions: </b>{{$exam->total_questions}}</p>
        <p><b>Number Wrong: </b>{{count(explode(',',$exam->wrong_answers)) -1}}</p>
        @if($exam->reviewed == 1)
        <p><b>Signed Off By: </b> {{ $exam->staff->initials }}</p>
        @endif
    </div>
    <div class="col-md-12">
        <h3 class="text-center">Review &amp; Discussion</h3>
        <div class="well">
            <h5 class="text-center">Wrong Answers</h5>
            @if(is_array($wrong))
              @foreach($wrong as $question)
              <p><strong>Question: {{ $question['question']->question }}</strong></p>
              <p>Student's Answer:<em>{{ $question['answer'] }}</em></p>
              <p>Correct Answer: <em> {{ $question['question']->{'answer_'.Zbw\Base\Helpers::digitToLetter($question['question']->correct)} }}</em></p>
              @endforeach
            @else
              <p>{{ $wrong }}</p>
              <p><i>If this is a VATUSA exam, please copy and paste your corrections in the comments.</i></p>
            @endif
        </div>
        <p>Discuss corrections with the student below.</p>
    </div>
    <div class="col-md-12 exam-comment">
        @foreach($exam->comments()->where('comment_type', \MessageType::where('value','c_exam')->first()->id)->get() as $comment)
            <div class="col-md-12 well">
                <div class="col-md-8">
                    <div>{{ $comment->content }}</div>
                </div>
                <div class="col-md-2">
                    <p>posted by {{ $comment->user->initials }}<br>
                    {{ $comment->created_at->diffForHumans() }}</p>
                </div>
                <div class="col-md-2">
                    <img src="{{ $comment->user->avatar() }}">
                </div>
            </div>
        @endforeach
    </div>
    <div class="col-md-12">
        <form id="examReviewEdit"action="/staff/exams/review/{{$exam->id}}" method="post">
            <input type="hidden" name="parent_id" value="{{$exam->id}}">
            <textarea class="form-control editor" name="content" id="comment" cols="30" rows="15"></textarea>
            <button type="submit" class="btn btn-primary">Send Comment</button>
        </form>
    </div>
@stop
