@extends('layouts.staff')
@section('title')
Edit Controller
@stop
@section('header')
@stop
@section('content')
    <div class="col-md-12">
        <h1 class="text-center">Edit {{$user->initials}}</h1>

        <form id="rosterEdit"action="/staff/{{$user->cid}}/edit" method="post">
            <div class="form-group">
                <label for="fname">First Name</label>
                <input class="form-control" type="text" name="fname" id="fname" value="{{$user->first_name}}">
            </div>
            <div class="form-group">
                <label class="control-label" for="lname">Last Name</label>
                <input class="form-control" type="text" name="lname" id="lname" value="{{$user->last_name}}">
            </div>
            <div class="form-group">
                <label class="control-label" for="initials">Initials</label>
                <input class="form-control" type="text" name="initials" id="initials" value="{{$user->initials}}">
            </div>
            <div class="form-group">
                <label class="control-label" for="artcc">ARTCC</label>
                <input class="form-control" type="text" name="artcc" id="artcc" value="{{$user->artcc}}">
            </div>
            <div class="row">
                <div class="form-group col-md-3">
                    <label class="control-label" for="groups">Groups</label>
                    <select multiple name="groups[]" id="groups" class="form-control">
                        @foreach($groups as $group)
                            <option value="{{$group->id}}" <?php if($user->inGroup($group)) echo "selected"; ?>>{{ $group->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-9">
                    @if($user->activated == 1)
                    <form class="axform col-md-12" action="/m/staff-welcome/{{$user->cid}}" method="post">
                        <button type="submit" class="btn col-md-3 btn-success btn-xs" id="staff-welcome">Send Staff Welcome Email</button>
                    </form>
                    <form class="axform col-md-12" action="/r/promote/{{$user->cid}}" method="post">
                        <button type="submit" class="btn col-md-3 btn-success btn-xs" id="cert-promote">Promote User to {{ $user->nextCert() }}</button>
                    </form>
                    <form class="axform col-md-12" action="/r/demote/{{$user->cid}}" method="post">
                        <button type="submit" class="btn col-md-3 btn-warning btn-xs" id="cert-demote">Demote User to {{ $user->lastCert() }}</button>
                    </form>
                    <form class="axform col-md-12" action="/r/suspend/{{$user->cid}}" method="post">
                        <button type="submit" class="btn col-md-3 btn-warning btn-xs">Suspend User</button>
                    </form>
                    <form class="axform col-md-12" action="/r/terminate/{{$user->cid}}" method="post">
                        <button type="submit" class="btn col-md-3 btn-xs btn-danger">Terminate User</button>
                    </form>
                    @elseif($user->activated == 0)
                    <form class="axform col-md-12" action="/r/activate/{{$user->cid}}" method="post">
                        <button type="submit" class="btn col-md-3 btn-xs btn-success">Activate User</button>
                    </form>
                    <form class="axform col-md-12" action="/r/terminate/{{$user->cid}}" method="post">
                        <button type="submit" class="btn col-md-3 btn-xs btn-danger">Terminate User</button>
                    </form>
                    @elseif($user->activated == -1)
                    <form class="axform col-md-12" action="/r/activate/{{$user->cid}}" method="post">
                        <button type="submit" class="btn col-md-3 btn-xs btn-success">Activate User</button>
                    </form>
                    @endif
                </div>
            </div>
            <div class="row">
              <div class="col-md-3">
                <button class="btn btn-primary" type="submit">Save</button>
              </div>
            </div>
        </form>
        </div>
    </div>
@stop
