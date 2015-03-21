@extends('layouts.staff')
@section('title')
Training Session
@stop
@section('content')
    <h1>Training Session</h1>
    <div class="col-md-6 well">
        <h3>Session Info</h3>
        <p><b>Student: </b>{{ $tsession->student->first_name . ' ' . $tsession->student->last_name }}</p>
        <p><b>Date: </b>{{$tsession->session_date}}</p>
        <p><b>Location: </b>{{$tsession->facility->value}}</p>
        <p><b>INS/MTR: </b>{{ $tsession->staff->first_name . ' ' . $tsession->staff->last_name }}</p>
        <p><b>Weather: </b>{{ strtoupper($tsession->weatherType->value) }}</p>
        <p><b>Complexity: </b>{{ ucfirst(str_replace('_', ' ', $tsession->complexityType->value)) }}</p>
        <p><b>Traffic: </b>{{ ucfirst(str_replace('_', ' ', $tsession->workloadType->value)) }}</p>
        <p><b>Brief Time: </b>{{$tsession->brief_time}} minutes</p>
        <p><b>Position Time: </b>{{$tsession->position_time}} minutes</p>
        <p><b>Staff Comments:</b> {{$tsession->staff_comment}}</p>
        <p><b>Student Comments:</b> {{$tsession->student_comment}}</p>
    </div>
    <div class="col-md-6 well">
        <h3 class="text-center">Training Summary</h3>
        <h5>Peformance</h5>
        @foreach(\Config::get('zbw.live_training_performance') as $subject)
          <div class="row">
            <label class="col-sm-6">{{ $subject['label'] }}</label>
            @if($tsession->trainingReport->{$subject['review_name']} == -1)
                <span style="padding:5px" class="col-sm-6 bg-info">Not Observed/Not Applicable</span><br>
            @elseif($tsession->trainingReport->{$subject['review_name']} == 0)
                <span style="padding:5px" class="col-sm-6 bg-danger">Unsatisfactory</span><br>
            @elseif($tsession->trainingReport->{$subject['review_name']} == 5)
                <span style="padding:5px" class="col-sm-6 bg-warning">Needs Improvement</span><br>
            @else
                <span style="padding:5px" class="col-sm-6 bg-success">Satisfactory</span><br>
            @endif
            </div>
        @endforeach
        <div class="col-md-6">
        <h5>Markups</h5>
        @unless(is_null($tsession->trainingReport->markups))
        @foreach(json_decode($tsession->trainingReport->markups, true) as $markup)
            @unless($markup[1] == 0)
                <p><b>{{\Config::get('zbw.live_training_criteria.up.'.$markup[0])}}:</b> <span class="badge alert-success">+{{$markup[1]}}</span></p>
            @endunless
        @endforeach
        @endunless
        </div>
        <div class="col-md-6">
        <h5>Markdowns</h5>
            @unless(is_null($tsession->trainingReport->markdown))
        @foreach(json_decode($tsession->trainingReport->markdown, true) as $markdown)
            @unless($markdown[1] == 0)
                <p><b>{{\Config::get('zbw.live_training_criteria.down.'.$markdown[0])}}:</b> <span class="badge alert-danger">-{{$markdown[1]}}</span></p>
            @endunless
        @endforeach
            @endunless
        </div>
        <div class="col-md-6">
        <h5>Reviews</h5>
        @if($tsession->trainingReport->reviewed != 'null')
            <p><b>Reviewed:</b>
                @foreach(json_decode($tsession->trainingReport->reviewed, true) as $review)
                {{$review}},
                @endforeach
                </p>
        @else
            <p>No content was reviewed.</p>
        @endif
        </div>
        <div class="col-md-6">
            <h5>OTS Status</h5>
            @if($tsession->trainingReport->ots == 0)
            <p>OTS Status: Failed</p>
            @elseif($tsession->trainingReport->ots == -1)
            <p>OTS Status: Not OTS</p>
            @else
            <p>OTS Status: Passed</p>
            @endif
        </div>
    </div>
@stop
