@extends('layouts.master')
@section('title')
ZBW Exam
@stop
@section('content')
    <h1>ZBW {{ Zbw\Core\Helpers::readableCert($exam->cert_type_id) }} Exam</h1>
    <?php $counter = 1; ?>
    <div class="well">
        <p>ZBW exams are open book, you may use necessary resources to complete the exam.</p>
        <p>Do NOT refresh the browser or the system <strong>WILL</strong> automatically <strong>FAIL</strong> you for the exam and you will have to wait 7 days to re-take!</p>
        <p><i>Good Luck!</i></p>
    </div>
    <form action="" method="post">
    <ol>
    @foreach($questions as $question)
        <li>
            <input type="hidden" name="question{{$counter}}" value="{{$question->id}}">
            <h5 style="font-family:'Courier New', Monospace">{{ $question->question }}</h5>
            <p><em>Correct:</em><strong>{{ $question->answer_a }}</strong></p>
            <?php
              $max = 4;
              $q = ['answer_a','answer_b','answer_c','answer_d'];
              if(! empty($question->answer_f)) {
                array_push($q, ['answer_f', 'answer_e']);
                $max++;
              }
              else if (! empty($question->answer_e)) {
                array_push($q, ['answer_e']);
                $max += 2;
              }

              shuffle($q);
            ?>

            @for($i = 0; $i < $max; $i++)
              <?php $answer = array_pop($q); $value = explode('_',$answer)[1]; ?>
              <p><input type="radio" name="answer{{$counter}}" value="{{$value}}"> {{ $question->$answer }}</p>
            @endfor
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
