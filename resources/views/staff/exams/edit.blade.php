@extends('layouts.master')
@section('title')
Edit Question
@stop
@section('content')
<div class="row">
    <h3 class="text-center">Edit Question</h3>
    <form id="questionAdd" action="" method="post">
    <div class="form-group">
        <label class="control-label" for="question">Question</label>
        <input type="text" class="form-control" value="{{ $question->question }}" name="question" id="question">
    </div>
    <div class="form-group">
        <div class="form-group">
            <label>Answer A</label>
            <input class="form-control" name="answera" id="answera" type="text" value="{{ $question->answer_a }}">
        </div>
        <div class="form-group">
            <label>Answer B</label>
            <input class="form-control" name="answerb" id="answerb" type="text" value="{{ $question->answer_b }}">
        </div>
        <div class="form-group">
            <label>Answer C</label>
            <input class="form-control" name="answerc" id="answerc" type="text" value="{{ $question->answer_c }}">
        </div>
        <div class="form-group">
            <label>Answer D</label>
            <input class="form-control" name="answerd" id="answerd" type="text" value="{{ $question->answer_d }}">
        </div>
        <div class="form-group">
            <label>Answer E</label>
            <input class="form-control" name="answere" id="answere" type="text" value="{{ $question->answer_e }}">
        </div>
        <div class="form-group">
            <label>Answer F</label>
            <input class="form-control" name="answerf" id="answerf" type="text" value="{{ $question->answer_f }}">
        </div>
        <div class="col-md-6">
            <label>Correct Answer</label>
            <select class="form-control" name="correct" id="correct">
                <option <?php echo $question->correct == 1 ? 'selected' : '' ?> value="1">Answer A</option>
                <option <?php echo $question->correct == 2 ? 'selected' : '' ?> value="2">Answer B</option>
                <option <?php echo $question->correct == 3 ? 'selected' : '' ?> value="3">Answer C</option>
                <option <?php echo $question->correct == 4 ? 'selected' : '' ?> value="4">Answer D</option>
                <option <?php echo $question->correct == 5 ? 'selected' : '' ?> value="5">Answer E</option>
                <option <?php echo $question->correct == 6 ? 'selected' : '' ?> value="6">Answer F</option>
            </select>
        </div>
        <div class="col-md-6">
            <label>Exam</label>
            <select class="form-control col-md-6" name="exam" id="exam">
                <option <?php echo $question->cert_type_id == 1 ? 'selected' : ''; ?> value="1">SOP</option>
                <option <?php echo $question->cert_type_id == 2 ? 'selected' : ''; ?> value="2">Class C/D S1</option>
                <option <?php echo $question->cert_type_id == 3 ? 'selected' : ''; ?> value="3">Class B S1</option>
                <option <?php echo $question->cert_type_id == 5 ? 'selected' : ''; ?> value="5">Class C/D S2</option>
                <option <?php echo $question->cert_type_id == 6 ? 'selected' : ''; ?> value="6">Class B S2</option>
                <option <?php echo $question->cert_type_id == 8 ? 'selected' : ''; ?> value="8">Class C S3</option>
                <option <?php echo $question->cert_type_id == 9 ? 'selected' : ''; ?> value="9">Class B S3</option>
                <option <?php echo $question->cert_type_id == 11 ? 'selected' : ''; ?> value="11">Center</option>
            </select>
        </div>
    </div>
    <div class="col-md-12 text-center" style="margin-top:10px;">
        <input type="hidden" name="id" value="{{ $question->id }}">
        <button type="submit" class="btn btn-success">Save</button>
    </div>
    </form>
</div>
@stop
