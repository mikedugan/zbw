@extends('layouts.master')
@section('title')
ZBW Exam
@stop
@section('content')
    <h1>ZBW {{ Zbw\Base\Helpers::readableCert($exam->cert_type_id) }} Exam</h1>
    <?php $counter = 1; ?>
    <div class="well">
        <p>ZBW exams are open book, you may use necessary resources to complete the exam.</p>
        <p>Do NOT refresh the browser or the system <strong>WILL</strong> automatically <strong>FAIL</strong> you for the exam and you will have to wait 7 days to re-take!</p>
        <p><i>Good Luck!</i></p>
    </div>
    <ol>
    <form action="" method="post">
    @foreach($questions as $id => $question)
        <li>
            <input type="hidden" name="question{{$counter}}" value="{{$id}}">
            <h5>{{ $question->question }}</h5>
            <p><input type="radio" name="answer{{$counter}}" value="a"> {{ $question->answer_a }}</p>
            <p><input type="radio" name="answer{{$counter}}" value="b"> {{ $question->answer_b }}</p>
            <p><input type="radio" name="answer{{$counter}}" value="c"> {{ $question->answer_c }}</p>
            <p><input type="radio" name="answer{{$counter}}" value="d"> {{ $question->answer_d }}</p>
            @if(! empty($question->answer_e))
            <p><input type="radio" name="answer{{$counter}}" value="e"> {{ $question->answer_e }}</p>
                @if(! empty($question->answer_f))
                <p><input type="radio" name="answer{{$counter}}" value="f"> {{ $question->answer_f }}</p>
                @endif
            @endif
        </li>
        <hr/>
    <?php $counter++; ?>
    @endforeach
    </ol>
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="examid" value="{{$exam->id}}">
    <input type="hidden" name="examlength" value="{{$counter}}">
    <button type="submit" class="btn btn-success">Submit</button>
    </form>
@stop
