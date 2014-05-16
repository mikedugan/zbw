@extends('layouts.master')
@section('title')
My Profile
@stop
@section('header')
@stop
@section('content')
	<h1 class="text-center">My Profile</h1>
    <div class="col-md-12">
    <form action="/u/{{$me->cid}}/settings/update" method="post">
	    <p><b>Full Name:</b> {{ $me->first_name . ' ' . $me->last_name }}</p>
	    <p><b>Controller ID:</b> {{ $me->cid }}</p>
	    <p><b>Operating Initials:</b> {{ $me->initials }}
		<div class="input-group">
			{{ Form::label('email', 'Email'); }}
			<input type="email" name="email" id="email" value="{{$me->email}}" class="form-control">
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
        <p><b>Email Hidden:</b></p>
        {{ Form::checkbox('Hidden', 'hidded', false); }}
        <p><b>Signature</b></p> {{ $me->signature}}
		<button type="submit" class="btn btn-primary">Update</button>
    </form>
    </div>
    <div class="col-md-12">
        <img src= 'images/zbw_logo.png'>
    </div>         
@stop