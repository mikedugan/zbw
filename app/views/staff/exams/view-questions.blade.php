@extends('layouts.staff')
@section('title')
Exam Question Bank
@stop
@section('header')
@stop
@section('content')
@include('includes.nav._training')
    <h1 class="text-center">vZBW Exam Question Bank</h1>

    <div class="col-md-6">
        <h3>Filter Options</h3>
        <form action="" class="col-md-12" method="GET">
            <select class="btn btn-sm" name="exam" id="exam">
                <option value="1">SOP</option>
                <option value="2">Class C/D S1</option>
                <option value="3">Class B S1</option>
                <option value="5">Class C/D S2</option>
                <option value="6">Class B S2</option>
                <option value="8">Class C S3</option>
                <option value="9">Class B S3</option>
                <option value="11">Center</option>
            </select>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
        <div class="col-md-12">
            @if($paginate)
                {{ $questions->links() }}
            @else
                {{ HTML::linkRoute('staff/exams/questions', 'View All') }}
            @endif
        </div>
        @foreach($questions as $q)
            <div class="col-md-12 well">
            <p><b>Exam: </b> {{ Zbw\Core\Helpers::readableCert($q->exam->id) }}</p>
            <p><b>Question:</b> {{$q->question}}</p>
            <p><b>Answers:</b></p>
            <input type="hidden" value="{{$q->correct}}" class="correct-answer">
            <ul class="answers col-md-9">
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
                <div class="col-md-3">
                    {{ HTML::linkRoute('staff/exams/questions/{id}', 'Edit', $q->id, ['class' => 'btn btn-success']) }}
                    <form class="confirm form-inline" data-warning="This will permanently delete the question" action="/staff/exams/questions/{{$q->id}}/delete" method="post"><button type="submit" class="btn btn-danger">Delete</button></form>
                </div>
            </div>
        @endforeach
    </div>
    <div class="col-md-6">
        <h3 class="text-center">Add Question</h3>
        <form id="questionAdd" action="/staff/exams/questions" method="post">
            <div class="form-group">
                <label class="control-label" for="question">Question</label>
                <input type="text" class="form-control" name="question" id="question">
            </div>
            <div class="form-group">
                <div class="form-group">
                    <label>Answer A</label>
                    <input class="form-control" name="answera" id="answera" type="text">
                </div>
                <div class="form-group">
                    <label>Answer B</label>
                    <input class="form-control" name="answerb" id="answerb" type="text">
                </div>
                <div class="form-group">
                    <label>Answer C</label>
                    <input class="form-control" name="answerc" id="answerc" type="text">
                </div>
                <div class="form-group">
                    <label>Answer D</label>
                    <input class="form-control" name="answerd" id="answerd" type="text">
                </div>
                <div class="form-group">
                    <label>Answer E</label>
                    <input class="form-control" name="answere" id="answere" type="text">
                </div>
                <div class="form-group">
                    <label>Answer F</label>
                    <input class="form-control" name="answerf" id="answerf" type="text">
                </div>
                <div class="col-md-6">
                    <label>Correct Answer</label>
                    <select class="form-control" name="correct" id="correct">
                        <option value="reqd">Select One</option>
                        <option value="1">Answer A</option>
                        <option value="2">Answer B</option>
                        <option value="3">Answer C</option>
                        <option value="4">Answer D</option>
                        <option value="5">Answer E</option>
                        <option value="6">Answer F</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label>Exam</label>
                    <select class="form-control col-md-6" name="exam" id="exam">
                        <option value="reqd">Select One</option>
                        <option value="1">SOP</option>
                        <option value="2">Class C/D S1</option>
                        <option value="3">Class B S1</option>
                        <option value="5">Class C/D S2</option>
                        <option value="6">Class B S2</option>
                        <option value="8">Class C S3</option>
                        <option value="9">Class B S3</option>
                        <option value="11">Center</option>
                    </select>
                </div>
            </div>
            <div class="col-md-12 text-center" style="margin-top:10px;">
                <button type="submit" class="btn btn-primary">Add Question</button>
            </div>
        </form>
    </div>
@stop
