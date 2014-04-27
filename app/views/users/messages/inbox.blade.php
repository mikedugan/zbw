@extends('layouts.master')
@section('title')
Inbox
@stop
@section('header')

@stop
@section('content')
    <h1>My Inbox</h1>
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
                    <tr>
                        <td>{{$message->created_at->toFormattedDateString()}}</td>
                        <td>{{$message->sender->initials}}</td>
                        <td>{{$message->subject}}</td>
                        <td><a href="/u/{{$me->cid}}/inbox/{{$message->id}}">View</a> | <a href="/u/{{$me->cid}}/inbox/{{$message->id}}/delete">Delete</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@stop
