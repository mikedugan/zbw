@extends('layouts.staff')
@section('title')
Edit Controller
@stop
@section('header')
@stop
@section('content')
  <div class="row">
    <div class="col-md-6">
        <h1 class="text-center">Edit {{$user->initials}}</h1>
        @if($me->inGroup(\Sentry::findGroupByName('Executive')))
          @include('includes.forms.edit_user_admin')
        @elseif($me->inGroup(\Sentry::findGroupByName('Staff')))
          @include('includes.forms.edit_user_staff')
        @endif
    </div>
    <div class="col-md-6">
      <h1 class="text-center">Roster Comments</h1>
      <form action="/staff/{{$user->cid}}/comment" method="post">
        <h3 class="text-center">Add Comment</h3>
        <textarea class="editor" name="comment" id="comment" cols="30" rows="10"></textarea>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
      @if(count($comments) > 0)
        @foreach($comments as $comment)
          <div class="well">
            <div class="row">
              <div class="col-md-9"><p>{{ $comment->content }}</p></div>
              <div class="col-md-3">
                <p>by: <strong>{{ $comment->user->initials or '??'}}</strong></p>
                <p>{{ $comment->created_at->toFormattedDateString() }}</p>
                @if($comment->author === $me->cid || $me->inGroup(\Sentry::findGroupByName('Executive')))
                  <p><a href="/staff/comments/{{$comment->id}}/delete">Delete</a></p>
                  <p><a href="/staff/comments/{{$comment->id}}/edit">Edit</a></p>
                @endif
                </div>
            </div>
          </div>
        @endforeach
      @else
        <p class="well">No Comments</p>
      @endif
    </div>
  </div>
@stop
