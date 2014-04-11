@extends('layouts.staff')
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
		{{ Form::label('start', 'Starts:')}}
		<div class="datepick" name="start" id="start"></div>
	</div>
	<div class="form-group">
		{{ Form::label('ends', 'Ends:') }}
		<div class="datepick" id="ends" name="ends"></div>
	</div>
	<div class="form-group">
		{{ Form::label('description', ['class' => 'form-control']) }}
		{{ Form::textarea('description') }}
	</div>
	{{ Form::close() }}
@stop