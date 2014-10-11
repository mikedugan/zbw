@extends('layouts.staff')
@section('title')
View Feedback
@stop
@section('content')
<h1 class="text-center">View Feedback</h1>
<div class="col-md-12">
    <table class="table-striped table-bordered table">
        <thead>
            <tr>
                <td>Name</td>
                <td>Email</td>
                <td>Rating</td>
                <td>Controller</td>
                <td>Response?</td>
                <td>Submitted</td>
                <td style="max-width:250px;">Message</td>
            </tr>
        @foreach($feedbacks as $feedback)
            <tr>
                <td>{{ $feedback->name }}</td>
                <td><a href="mailto:{{$feedback->email}}">{{ $feedback->email }}</a></td>
                <td>{{ Zbw\Core\Helpers::pilotFeedbackRating($feedback->rating) }}</td>
                <td>{{ \User::whereCid($feedback->cid)->first()->initials }}</td>
                <td>{{ $feedback->response == 1 ? 'Yes' : 'No' }}</td>
                <td>{{ $feedback->created_at->toDayDateTimeString() }}</td>
                <td style="max-width:250px;">{{ $feedback->comments }}</td>
            </tr>
        @endforeach
        </thead>
    </table>
</div>
@stop
