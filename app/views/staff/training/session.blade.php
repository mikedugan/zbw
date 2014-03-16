@extends('layouts.staff')
@section('content')
    <h1>Training Session</h1>
    <div class="col-md-6 well">
        {{-- accessible: student, location, staff --}}
        <h3>Session Info</h3>
        <p><b>Student: </b>{{ $student->first_name . ' ' . $student->last_name }}</p>
        <p><b>Date: </b>{{$tsession->session_date}}</p>
        <p><b>Location: </b>{{$location->value}}</p>
        <p><b>INS/MTR: </b>{{ $staff->first_name . ' ' . $staff->last_name }}</p>
        <p><b>Weather: </b>{{ ucfirst($tsession->weatherType->value) }}</p>
        <p><b>Complexity: </b>{{ ucfirst($tsession->complexityType->value) }}</p>
        <p><b>Traffic: </b>{{ ucfirst($tsession->workloadType->value) }}</p>
        <p><b>Brief Time: </b>{{$tsession->brief_time}} minutes</p>
        <p><b>Position Time: </b>{{$tsession->position_time}} minutes</p>
        <p><b>Staff Comments:</b> {{$tsession->staff_comment}}</p>
        <p><b>Student Comments:</b> {{$tsession->student_comment}}</p>
    </div>
    <div class="col-md-6 well">
        <h3>Training Summary</h3>
    </div>
@stop
