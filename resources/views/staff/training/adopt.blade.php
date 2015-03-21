@extends('layouts.master')
@section('title')
Adopt a Student
@stop
@section('content')
<h1 class="text-center">Adopt a Student</h1>
<div class="row">
  <div class="col-md-6">
    <p>Thanks for picking up this student! Remember, nothing beats the person-to-person interaction for a controller just getting started.</p>
    <p>Please fill out the form below to email the user an invitation to join you on Teamspeak for an introductory training session.</p>
    <div class="panel panel-default">
      <div class="panel-heading">Student Information</div>
      <div class="panel-body">
        <p><b>Name: </b> {{ $student->username }}</p>
        <p><b>CID: </b> {{ $student->cid }}</p>
        <p><b>Initials: </b> {{ $student->initials }}</p>
        <p><b>VATSIM Rating: </b> {{ $student->rating->long }}</p>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <form action="" method="post">
        <input type="hidden" name="cid" value="{{$student->cid}}">
        <input type="hidden" name="sid" value="{{$me->cid}}">
        <div class="form-group">
            <label class="control-label" for="subject">Subject</label>
            <input type="text" name="subject" id="subject" class="form-control">
        </div>
        <div class="form-group">
            <label class="control-label" for="meeting">Meeting Time</label>
        </div>
        <input class="datepickopen form-control" name="meeting" id="meeting">
        <div class="form-group">
            <label class="control-label" for="message">Your Message</label>
            <textarea class="editor form-control" name="message" id="message"></textarea>
        <button type="submit" class="btn btn-success">Submit</button>
    </form>
  </div>
</div>
@stop
