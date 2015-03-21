@extends('layouts.master')
@section('title')
Edit Comment
@stop
@section('content')
<div class="col-md-6 col-md-offset-3">
  <form action="/staff/comments/{{$comment->id}}/edit" method="post">
    <p><strong>Comment For: </strong> {{ $comment->subject->username . " ({$comment->subject->initials})" }}</p>
    <p><strong>Original Author: </strong> {{ $comment->user->username . " ({$comment->user->initials})" }}</p>
    <p><strong>Date: </strong> {{ $comment->created_at->toFormattedDateString() }}</p>
    <label for="content">Comments</label>
    <textarea class="editor" name="content" id="content" cols="30" rows="10">{{ $comment->content }}</textarea>
    <button type="submit" class="btn btn-primary">Submit</button>
  {{ \Form::close() }}
</div>
@stop
