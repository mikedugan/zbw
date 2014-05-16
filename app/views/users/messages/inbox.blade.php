@extends('layouts.messages')
@section('title')
Inbox
@stop
@section('header')
    @include('includes.nav._messenger')
@stop
@section('content')
    <h1 class="text-center">My Inbox</h1>
    <div class="col-md-12 subnav">
        <form class="axform" style="margin:0;" action="/me/markallread" method="post">
            <button type="submit" class="btn btn-xs">Mark All as Read</button>
        </form>
        @if($unread == 'true')
        <a href="{{URL::route('inbox')}}" class="btn btn-xs">Show All</a>
        @else
        <a href="{{URL::route('inbox').'?unread=true'}}" class="btn btn-xs">Show Unread</a>
        @endif
    </div>
    <div class="col-md-12">
        <table class="table table-striped">
            <thead>
                <th>Date</th>
                <th>From</th>
                <th>Subject</th>
                <th></th>
            </thead>
            <tbody>
                @foreach($inbox as $message)
                    @if($message->is_read == 0)
                    <tr class="new-message">
                    @else
                    <tr>
                    @endif
                        <td>{{$message->created_at->toFormattedDateString()}}</td>
                        <td>{{$message->sender->initials}}</td>
                        <td>{{$message->subject}}</td>
                        <td><a href="/messages/inbox/{{$message->id}}">View</a> | <a href="/messages/inbox/{{$message->id}}/delete">Delete</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@stop
