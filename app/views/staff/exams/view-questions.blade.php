@extends('layouts.staff')
@section('header')
@stop
@section('content')
    <h1 class="text-center">vZBW Exam Question Bank</h1>

    <div class="col-md-6">
        <h3>Filter Options</h3>
        <select class="dropdown" ¡name="question-filter" id="question-filter">
            <option value="1">Class C/D S1</option>
            <option value="2">Class B S1</option>
            <option value="3">Class C/D S2</option>
            <option value="4">Class B S2</option>
            <option value="5">Class C S3</option>
            <option value="6">Class B S3</option>
            <option vaue="7">Center</option>
        </select>
        <a class="btn btn-sm" href="#">Update</a>
    </div>
    <div class="col-md-6">
        <h3>Add Question</h3>
        <form action="/staff/exams/add-question" method="post">
            <div class="form-group">
                <label class="control-label" for="question">Question</label>
                <input type="text" class="form-control" name="question" id="question">
            </div>
            <div class="form-group">
                <label class="control-label" for="answers">Answers</label>
                <label class="control-label pull-right">Correct?</label>
                <input class="form-control" name="answera" id="answera" type="text">
                <input type="radio" name="correct" value="a">
                <input class="form-control" name="answerb" id="answerb" type="text">
                <input type="radio" name="correct" value="b">
                <input class="form-control" name="answerc" id="answerc" type="text">
                <input type="radio" name="correct" value="c">
                <input class="form-control" name="answerd" id="answerd" type="text">
                <input type="radio" name="correct" value="d">
                <input class="form-control" name="answere" id="answere" type="text">
                <input type="radio" name="correct" value="e">
                <input class="form-control" name="answerf" id="answerf" type="text">
                <input type="radio" name="correct" value="f">
            </div>
        </form>
    </div>
