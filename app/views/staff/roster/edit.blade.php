@extends('layouts.staff')
@section('header')
@stop
@section('content')
    <div class="col-md-12">
        <h1 class="text-center">Edit {{$user->initials}}</h1>

        <form action="/staff/{{$user->cid}}/edit" method="post">
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
            <div class="form-group form-inline">
                <label for="ismentor">Is Mentor?</label>
                <input class="checkbox-inline checkbox" value="1" type="checkbox" name="ismentor" id="ismentor" {{{ $user->is_mentor ? 'checked' : '' }}}>
                <label for="isins">Is Instructor?</label>
                <input class="checkbox-inline checkbox" value="1" type="checkbox" name="isins" id="isins" {{{ $user->is_instructor ? 'checked' : '' }}}>
                <label for="isfe">Is FE?</label>
                <input class="checkbox-inline checkbox" value="1" type="checkbox" name="isfe" id="isfe" {{{ $user->is_facilities ? 'checked' : '' }}}>
                <label for="isweb">Is Webmaster?</label>
                <input class="checkbox-inline checkbox" value="1" type="checkbox" name="isweb" id="isweb" {{{ $user->is_webmaster ? 'checked' : '' }}}>
                <label for="isatm">Is ATM?</label>
                <input class="checkbox-inline checkbox" value="1" type="checkbox" name="isatm" id="isatm" {{{ $user->is_atm ? 'checked' : '' }}}>
                <label for="isdatm">Is DATM?</label>
                <input class="checkbox-inline checkbox" value="1" type="checkbox" name="isdatm" id="isdatm" {{{ $user->is_datm ? 'checked' : '' }}}>
                <label for="ista">Is TA?</label>
                <input class="checkbox-inline checkbox" value="1" type="checkbox" name="ista" id="ista" {{{ $user->is_ta ? 'checked' : '' }}}>
                <label for="isemeritus">Is Emeritus?</label>
                <input class="checkbox-inline checkbox" value="1" type="checkbox" name="isemeritus" id="isemeritus" {{{ $user->is_emeritus ? 'checked' : '' }}}>
            </div>
            <button class="btn btn-primary" type="submit">Save</button>
        </form>
        <br>
        @if($user->is_active == 1)
        <form class="axform" action="/m/staff-welcome/{{$user->cid}}" method="post">
            <button type="submit" class="btn btn-sm" id="staff-welcome">Send Staff Welcome Email</button>
        </form>
        <form class="axform" action="/r/suspend/{{$user->cid}}" method="post">
            <button type="submit" class="btn btn-warning">Suspend User</button>
        </form>
        <form class="axform" action="/r/terminate/{{$user->cid}}" method="post">
            <button type="submit" class="btn btn-danger">Terminate User</button>
        </form>
        @elseif($user->is_active == 0)
        <form class="axform" action="/r/activate/{{$user->cid}}" method="post">
            <button type="submit" class="btn btn-success">Activate User</button>
        </form>
        <form class="axform" action="/r/terminate/{{$user->cid}}" method="post">
            <button type="submit" class="btn btn-danger">Terminate User</button>
        </form>
        @elseif($user->is_active == -1)
        <form class="axform" action="/r/activate/{{$user->cid}}" method="post">
            <button type="submit" class="btn btn-success">Activate User</button>
        </form>
        @endif
    </div>
@stop