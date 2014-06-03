@extends('layouts.master')
@section('title')
My Profile
@stop
@section('header')
@stop
@section('content')
	<h1 class="text-center">My Profile</h1>
    <div class="col-md-10 col-md-offset-2">
    <form action="/u/{{$me->cid}}/settings/update" method="post">
        <div class="col-md-12">
            
            <p><b>Full Name:</b> {{ $me->first_name . ' ' . $me->last_name }}</p>
            <p><b>Controller ID:</b> {{ $me->cid }}</p>
            <p><b>Operating Initials:</b> {{ $me->initials }}
            
            <div class="input-group">
                {{ Form::label('email', 'Email'); }}
                <input type="text" name="me[email]" id="email" value="{{$me->email}}" class="form-control">
            </div>
            <p><b>Subscribed:</b></p>
            @if($me->is_subscribed)
            <form class="axform" action="path/to/subscribe" method="post">
                <button type="submit">Subscribe</button>
            </form>
            @else
            <form class="axform" action="path/to/unsubscribe" method="post">
                <button type="submit">Unsubscribe</button>
            </form>
            @endif
            <p><b>Email Hidden:</b></p> {{ Form::checkbox('Hidden', 'hidden', false); }}
            <p><b>Signature</b></p> 
            {{ $me->signature}}
        </div>
        <div class="col-md-12">
            <div class="input-group">
                <label class="label-control" for="tskey">Teamspeak Key</label>
                <input class="form-control" name="tskey" id="tskey" type="text">
            </div>
        </div>
		<form class="axform" action="/users/me/settings.blade.php" method="post">
            <button type="submit">Submit</button>
        </form>
    </form>
    </div>       
@stop
