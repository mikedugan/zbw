@extends('layouts.master')
@section('title')
ZBW Teamspeak Manager
@stop
@section('content')
<h1 class="text-center">ZBW Teamspeak Manager</h1>
<div class="col-md-8">
  <h3 class="text-center">Connected Clients</h3>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>CID</th>
        <th>Initials</th>
        <th>Name</th>
        <th>Kick</th>
        <th>Message</th>
      </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
      <tr>
        <td>{{ $user[1]->cid }}</td>
        <td>{{ $user[1]->initials }}</td>
        <td>{{ $user[1]->username }}</td>
        <td>{{ Form::open(['route' => ['teamspeak.kick', $user[1]->cid]]) }}
            <input type="text" name="message">
            <button type="sumbit" class="btn btn-xs btn-success">Kick</button>
            {{ Form::close() }}
        </td>
        <td>{{ Form::open(['route' => ['teamspeak.message', $user[1]->cid]]) }}
            <input type="text" name="message">
            <button type="sumbit" class="btn btn-xs btn-success">Send</button>
            {{ Form::close() }}
        </td>
      </tr>
    @endforeach
    </tbody>
  </table>
</div>
@stop
