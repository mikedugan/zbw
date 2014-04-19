@extends('layouts.master')
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
                @foreach($messages as $message)
                    <tr>
                        <td>{{$message->date->toFormattedDateString()}}</td>
                        <td>{{$message->sender->initials}}</td>
                        <td>$message->subject}}</td>
                        <td><a href="/messages/{{$message->id}}">View</a><a href="/messages/{{$message-id}}/delete">Delete</a></td>
                    </tr>
            </tbody>
        </table>
    </div>
@stop
