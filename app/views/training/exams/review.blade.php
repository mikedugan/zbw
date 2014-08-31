@extends('layouts.training')
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
      <p><b>Testing for: </b>{{ $exam->cert->readable() }}</p>
    @endif
    @if($me->cid === $exam->cid || $me->canTrain($exam->cert_type_id))
        @if($exam->reviewed == 1)
        <span class="badge bg-success">Exam Review Complete</span>
        @endif
    @endif
</div>
<div class="col-md-6">
    <h3>Exam Summary</h3>
    <p><b>Date Assigned:</b> {{ $exam->assigned_on or "??"}}</p>
    <p><b>Total Questions: </b>{{$exam->total_questions}}</p>
    <p><b>Number Wrong: </b>{{ $exam->wrong}}&nbsp;
        @if($exam->pass)
            <span class="badge bg-success">Passed</span>
        @else
            <span class="badge bg-danger">Failed</span>
        @endif
    </p>
    <p><b>Score:</b> {{ $exam->score() }}%</p>
    @if($exam->reviewed == 1)
        <p><b>Signed Off By: </b> {{ $exam->staff->initials }}</p>
    @endif
</div>
<div class="col-md-12">
    <h3 class="text-center">Review &amp; Discussion</h3>
    <div class="well">
        <h5 class="text-center">Wrong Answers</h5>
        @if(is_array($review_content))
        @foreach($review_content as $question)
            <p><strong>Question: {{ $question['question']->question }}</strong></p>
            <p>Your Answer:<em>{{ $question['answer'] }}</em></p>
            <p>Correct Answer: <em> {{ $question['question']->{'answer_'.Zbw\Core\Helpers::digitToLetter($question['question']->correct)} }}</em></p>
        @endforeach
        @else
          <p>{{ $review_content }}</p>
          <p><i>If this is a VATUSA exam, please copy and paste your corrections in the forum.</i></p>
        @endif
    </div>
    <p>Please discuss your corrections with the staff here.</p>
</div>
<div class="col-md-12 exam-comment">
    @foreach($comments as $comment)
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
    <form id="examEdit" action="/training/review/{id}" method="post">
        <input type="hidden" name="parent_id" value="{{$exam->id}}">
        <textarea class="form-control editor" name="content" id="comment" cols="30" rows="15"></textarea>
        <button type="submit" class="btn btn-primary">Send Comment</button>
    </form>
</div>
@stop
