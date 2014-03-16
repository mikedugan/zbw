@extends('layouts.staff')
@section('header')

@stop
@section('content')
	<div class="col-md-6">
		<h1 class="text-center">Recent Staff Notifications</h1>
		<table class="table-striped table">
			<thead>
				<th>Subject CID</th>
				<th>Title</th>
				<th>Description</th>
				<th>Link</th>
				<th>Complete</th>
				<th>Date</th>
			</thead>
			@foreach($actions as $a)
			<tr>
				<td>{{$action->cid}}</td>
				<td>{{$action->title}}</td>
				<td>{{$action->description}}</td>
				<td><a href="{{$action->url}}">Click</a></td>
				<td><form class="axform" action="/a/complete/{{$action->id}}" method="post"><button class="btn-xs" type="button">Mark Completed</button></form>
				<td>{{$action->created_at}}</td>
			</tr>
		</table>
	</div>
	<div class="col-md-6">
		<h2>About Notifications</h2>
		<p>The notifications on this page are registered specifically by the ZBW system because they require a specific action by a staff member. The most common notifications will be exam and training requests.</p>
	</div>
@stop