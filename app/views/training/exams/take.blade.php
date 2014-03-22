@extends('layouts.training')
@section('header')
@stop
@section('content')
    <h1>vZBW {{$exam->exam->value}} Exam</h1>
    @for($i=0; $i < count($questions); $i++)
        <div class="well">
            <h3>$questions[$i]</h3>
            <div class="well">
            @foreach($answers[$i] as $a)
                <p><input type="radio" name="q{{$i}}" value="{{$i}}">{{$a}}</p>
            @endforeach
            </div>
        </div>
    @endfor
@stop
