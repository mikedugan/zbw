@extends('layouts.staff')
@section('title')
Add Event
@stop
@section('header')
@stop
@section('content')
	<h1 class="text-center">Add Event</h1>
	{{ Form::open(['url' => '/staff/news/add', 'method' => 'POST']) }}
	<div class="form-group">
		{{ Form::label('title', 'Title:')}}
		{{ Form::text('title', ['class' => 'form-control']) }}
	</div>
	<div class="form-group">
		{{ Form::label('starts', 'Starts:')}}
		<div class="datepick" name="starts" id="starts"></div>
	</div>
	<div class="form-group">
		{{ Form::label('ends', 'Ends:') }}
		<div class="datepick" id="ends" name="ends"></div>
	</div>
	<div class="form-group">
		{{ Form::label('content', 'Description:') }}
		{{ Form::textarea('content') }}
	</div>
	{{ Form::close() }}
@stop
