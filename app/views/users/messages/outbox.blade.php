@extends('layouts.messages')
@section('title')
Inbox
@stop
@section('header')
    @include('includes.nav._messenger')
@stop
@section('content')
    <h1 class="text-center">My Inbox</h1>
    <div class="col-md-12">
        <table class="table table-striped">
            <thead>
                <th>Date</th>
                <th>To</th>
                <th>Subject</th>
                <th></th>
            </thead>
            <tbody>
                @foreach($inbox as $message)
                    <tr>
                        <td>{{$message->created_at->toFormattedDateString()}}</td>
                        <td>{{$message->recipient->initials or '??'}}</td>
                        <td>{{$message->subject}}</td>
                        <td><a href="/messages/outbox/{{$message->id}}">View</a> | <a href="/messages/inbox/{{$message->id}}/delete">Delete</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@stop
