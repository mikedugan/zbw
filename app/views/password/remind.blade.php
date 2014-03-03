@extends('layouts.master')
@section('header')
@stop

@section('content')
	<h1>Forgot Password</h1>
	<h3>Don't worry, Boston John will reset it for you!</h3>
	<form class="col-md-4" action="/password/remind" method="post">
	<fieldset>
		<label for='email'>Email:</label>
		<input type="text" class="form-control" name="email" id="email">
		<button type="submit">Submit</button>
	</fieldset>

	</form>
@stop