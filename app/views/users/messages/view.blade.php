@extends('layouts.master')
@section('title')
View Message
@stop
@section('header')
@stop

@section('content')
    <h1 class="text-center">View Message from {{$message->sender->initials}}</h1>
    <div class="col-md-6">
        <h2>Subject</h2>
        <p>{{$message->subject}}</p>
        <h2>Message</h2>
        <p>{{$message->content}}</p>
    </div>
    <div class="col-md-6">
        <h2>Date</h2>
        <p>{{$message->created_at->toFormattedDateString()}}</p>
        @if($message->has_attachments)
            <h3>This message has attachments:</h3>
        @else
            <h3>No attachments.</h3>
        @endif
        <hr/>
        <h2>Reply</h2>
        <form action="" id="pm-reply" method="post">
            @include('includes.user._message_reply')
        </form>
    </div>
@stop
