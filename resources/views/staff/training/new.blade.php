@extends('layouts.master')
@section('title')
New Training Session
@stop
@section('content')
@include('includes.nav._training')
    <h1 class="text-center">Start New Training Session</h1>
    {{ \Form::open() }}
        {{ \Form::hidden('sid', $me->cid) }}
        <div class="form-group">
            <label for="student">Student's CID or Operating Initials</label>
            <input type="text" class="form-control" name="student" id="student"/>
        </div>
        <button type="submit" class="btn btn-primary">Start</button>
    {{ \Form::close() }}
@stop
