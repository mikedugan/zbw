@extends('layouts.training')
@section('content')
    <h1 class="text-center">Roster Admin</h1>
    <div class="clearfix"></div>
    <div class="col-md-6">
        <h3>Current Roster</h3>
    <table class="full table-bordered table-striped">
        <thead>
            <th>Name</th>
            <th>Email</th>
            <th>CID</th>
            <th>Rating</th>
            <th>Edit</th>
            <th>Training</th>
        </thead>
    @foreach($users as $u)
        <tr>
            <td><a href="/controllers/{{$u->cid}}">{{ $u->username }}</a></td>
            <td>{{ $u->email }}</td>
            <td>{{ $u->cid }}</td>
            <td>{{ $u->rating }}</td>
            <td><a href="#"><button class="btn-xs">Edit</button></a></td>
            <td><a href="#"><button class="btn-xs">Training</button></a></td>
        </tr>
    @endforeach
    </table>
    </div>
    <div class="col-md-6">
        <h3>Search Controllers</h3>
        @include('includes.search._controller')
    </div>
@stop
