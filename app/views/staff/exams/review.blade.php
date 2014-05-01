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
        <p><b>Rating: </b> {{$exam->student->rating}}</p>
        <p><b>Testing for: </b>{{ \Zbw\Helpers::readableCert($exam->exam->value)}}</p>
    </div>
    <div class="col-md-6">
        <h3>Exam Summary</h3>
        <p><b>Date Assigned:</b> {{ $exam->assigned_on or "??"}}</p>
        <p><b>Total Questions: </b>{{$exam->total_questions}}</p>
        <p><b>Number Wrong: </b>{{count(explode(',',$exam->wrong_answers)) -1}}</p>
    </div>
    <div class="col-md-12">
        <h3 class="text-center">Review &amp; Discussion</h3>
        <p>Please discuss your corrections with the staff here.</p>
    </div>
    <div class="col-md-12">
        <form action="/staff/exams/review/{{$exam->id}}" method="post">
            <textarea class="form-control editor" name="comment" class="" id="comment" cols="30" rows="15"></textarea>
            <button type="submit" class="btn btn-primary">Send Comment</button>
        </form>
    </div>
@stop
