@extends('layouts.master')
@section('title')
Send Message
@stop
@section('header')
@stop
@section('content')
    <h1>New Message</h1>
    <form action="/messages/send" action="post">
        <div class="form-group">
            {{ Form::label('to', 'To') }}
            <input type="text" maxlength="30" name="to" id="to">
        </div>
        <div class="form-group">
            {{ Form::label('subject', 'Subject') }}
            <input type="text" maxlength="100" name="subject" id="subject">
        </div>
    </form>
@stop
