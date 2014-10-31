@extends('layouts.messages')
@section('title')
View Message
@stop
@section('header')
@stop
@section('content')
@include('includes.nav._messenger')
    <h1 class="text-center">View Message from {{$message->sender->initials}}</h1>
    <div class="col-md-6">
        <h2>Subject</h2>
        <p>{{$message->subject}}</p>
        <h2>Message</h2>
        @if(!empty($message->history))
        <div class="well">
            {{$message->history}}
        </div>
        @endif
        <p>{{$message->content}}</p>
    </div>
    <div class="col-md-6">
        <h2>Date</h2>
        <p>{{$message->created_at->toFormattedDateString()}}</p>
        <hr/>
        <h2>Reply</h2>
        <form class="bsv" action="" id="pm-reply" method="post"
        data-bv-feedbackicons-valid="glyphicons ok_2 green"
        data-bv-feedbackicons-invalid="glyphicon remove_2 red">
            @if($message->sender->cid == 100)
            <p>Boston John is a tower controller and doesn't provide radar services for replies!</p>
            @else
            @include('includes.user._message_reply')
            @endif
        </form>
    </div>
@stop
