@extends('layouts.training')
@section('header')
@stop
@section('content')
    <h1 class="text-center">vZBW Exam</h1>
    <p>Welcome to the ZBW exam center. When you are ready, click "start"
     to begin your exam. Exams are not timed and are open book, so take
    your time and do your best!</p>
    <h3>Good Luck!</h3>
    <h3><a class="btn btn-primary" href="/training/e/{{$exam->id}}/start">Start</a></h3>
@stop
