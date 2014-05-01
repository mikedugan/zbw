@extends('layouts.staff')
@section('title')
Exam Question Bank
@stop
@section('header')
@stop
@section('content')
    <h1 class="text-center">vZBW Exam Question Bank</h1>

    <div class="col-md-6">
        <h3>Filter Options</h3>
<<<<<<< HEAD
        <select class="dropdown" ¡name="question-filter" id="question-filter">
=======
        <select style="margin-bottom: 1%" class="btn btn-sm" name="question-filter" id="question-filter">
>>>>>>> 161258e83cb2506b1016b3e7778bd351f872230d
            <option value="1">Class C/D S1</option>
            <option value="2">Class B S1</option>
            <option value="3">Class C/D S2</option>
            <option value="4">Class B S2</option>
            <option value="5">Class C S3</option>
            <option value="6">Class B S3</option>
            <option vaue="7">Center</option>
        </select>
        @foreach($questions as $q)
            <div class="col-md-12 well">
            <p><b>Exam: </b> {{ Zbw\Helpers::readableCert($q->exam->value) }}</p>
            <p><b>Question:</b> {{$q->question}}</p>
            <p><b>Answers:</b></p>
            <input type="hidden" value="{{$q->correct}}" class="correct-answer">
            <ul class="answers">
                <li>{{ $q->answer_a }}</li>
                <li>{{ $q->answer_b }}</li>
                <li>{{ $q->answer_c }}</li>
                @if($q->answer_d != '')
                <li>{{ $q->answer_d }}</li>
                @endif
                @if($q->answer_e != '')
                <li>{{ $q->answer_e }}</li>
                @endif
                @if($q->answer_f != '')
                <li>{{ $q->answer_f }}</li>
                @endif
            </ul>
            </div>
        @endforeach
    </div>
    <div class="col-md-6">
        <h3>Add Question</h3>
        <form action="/staff/exams/questions" method="post">
            <div class="form-group">
                <label class="control-label" for="question">Question</label>
                <input type="text" class="form-control" name="question" id="question">
            </div>
            <div class="form-group">
                <label class="control-label" for="answers">Answers (3 required, select correct option)</label>
                <div class="input-group">
                    <span class="input-group-addon">
                        <input type="radio" name="correct" value="0">
                    </span>
                    <input class="form-control" name="answera" id="answera" type="text">
                </div>
                <div class="input-group">
                    <span class="input-group-addon">
                        <input type="radio" name="correct" value="1">
                    </span>
                    <input class="form-control" name="answerb" id="answerb" type="text">
                </div>
                <div class="input-group">
                    <span class="input-group-addon">
                        <input type="radio" name="correct" value="2">
                    </span>
                    <input class="form-control" name="answerc" id="answerc" type="text">
                </div>
                <div class="input-group">
                    <span class="input-group-addon">
                        <input type="radio" name="correct" value="3">
                    </span>
                    <input class="form-control" name="answerd" id="answerd" type="text">
                </div>
                <div class="input-group">
                    <span class="input-group-addon">
                        <input type="radio" name="correct" value="4">
                    </span>
                    <input class="form-control" name="answere" id="answere" type="text">
                </div>
                <div class="input-group">
                    <span class="input-group-addon">
                        <input type="radio" name="correct" value="5">
                    </span>
                    <input class="form-control" name="answerf" id="answerf" type="text">
                </div>
                <br>
            <select class="btn btn-info" name="exam" id="exam">
                <option value="1">Class C/D S1</option>
                <option value="2">Class B S1</option>
                <option value="3">Class C/D S2</option>
                <option value="4">Class B S2</option>
                <option value="5">Class C S3</option>
                <option value="6">Class B S3</option>
                <option vaue="7">Center</option>
            </select>
            </div>
            <button type="submit" class="btn btn-primary">Add Question</button>
        </form>
    </div>
@stop
