@extends('layouts.master')
@section('header')

@stop
@section('content')
	<h1>Reset Password</h1>
	<form id="passwordReset"action="/password/reset" method="post">
		<input type="hidden" name="token" value="{{ $token }}">
		<div class="form-group">
			<label for="email">Email</label>
			<input type="text" name="email" id="email">
		</div>
		<div class="form-group">
			<label for="password">New Password</label>
			<input class="form-control" type="password" name="password" id="password">
		</div>
		<div class="form-group">
			<label for="confirm">Confirm Password</label>
			<input class="form-control" type="password" id="confirm" name="password_confirmation">
		</div>
		<button type="submit">Reset Password</button>
		</form>
@stop