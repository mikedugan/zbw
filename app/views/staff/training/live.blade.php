@extends('layouts.master')
@section('title')
Training Session
@stop
@section('content')
<form id="training_session" action="" method="post">
<h1 class="text-center">Training Session</h1>
<div class="row">
    <div class="col-md-6" style="width:790px;">
        <button data-timer="start" id="start" class="timer btn btn-primary btn-block">Start Brief/Review</button>
    </div>
    <div class="col-md-6" style="width:790px;">
        <button data-timer="live" id="live" disabled class="timer btn btn-primary btn-block">Start Live Session</button>
    </div>
</div>
    <div class="row">
<div class="col-md-6" style="width:790px;">
    <div class="row form-horizontal">
        <label class="control-label col-md-6">Training Facility</label>
        <div class="form-group col-md-6">
            <select class="form-control" name="facility" id="facility">
                @foreach($facilities as $facility)
                <option value="{{$facility->id}}">{{$facility->value}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row form-horizontal">
        <label class="control-label col-md-6">Training Type</label>
        <div class="form-group col-md-6">
            <select class="form-control" name="training_type" id="training_type">
                @foreach($types as $type)
                <option value="{{$type->id}}">{{$type->value}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <h3 class="text-center">General Performance</h3>
    @foreach(\Config::get('zbw.live_training_performance') as $options)
        @include('includes.options._live_performance', ['options' => $options])
    @endforeach
    <div class="row">
        <div class="col-md-4">
            <button class="btn btn-default btn-block" id="update-score">Update Score</button>
        </div>
        <div class="col-md-8">
            <div class="score"></div>
        </div>
    </div>
</div>
<div class="col-md-6" style="width:790px;">

    <h3 class="text-center">Markups & Markdowns</h3>
    <div class="row">
        <div class="col-md-4">
        <h5 class="text-center">DEL/GND</h5>
            <button id="md-wafdof-r" class="btn btn-info markdownr col-sm-2">-</button><button data-points="2" class="markdown btn col-sm-10 btn-warning" id="md-wafdof">WAFDOF <span class="badge">0</span></button>
            <button id="md-squawk-r" class="btn btn-info markdownr col-sm-2">-</button><button data-points="2" class="markdown btn col-sm-10 btn-warning" id="md-squawk">Missed Squawk <span class="badge">0</span></button>
            <button id="md-cl_late-r" class="btn btn-info markdownr col-sm-2">-</button><button data-points="1" class="markdown btn col-sm-10 btn-warning" id="md-cl_late">Delayed Clrnc <span class="badge">0</span></button>
            <button id="md-cl_wrong-r" class="btn btn-info markdownr col-sm-2">-</button><button data-points="2" class="markdown btn col-sm-10 btn-warning" id="md-cl_wrong">Incorrect Clrnc <span class="badge">0</span></button>
            <button id="md-taxi-r" class="btn btn-info markdownr col-sm-2">-</button><button data-points="3" class="markdown btn col-sm-10 btn-warning" id="md-taxi">Invalid Taxi <span class="badge">0</span></button>
        </div>
        <div class="col-md-4">
            <h5 class="text-center">Local</h5>
            <button id="md-landing-r" class="markdownr col-sm-2 btn btn-info">-</button><button data-points="2" class="markdown btn col-sm-10 btn-warning" id="md-landing">Invalid Landing <span class="badge">0</span></button>
            <button id="md-takeoff-r" class="markdownr col-sm-2 btn btn-info">-</button><button data-points="2" class="markdown btn col-sm-10 btn-warning" id="md-takeoff">Invalid Takeoff <span class="badge">0</span></button>
            <button id="md-luaw-r" class="markdownr col-sm-2 btn btn-info">-</button><button data-points="4" class="markdown btn col-sm-10 btn-warning" id="md-luaw">LUAW While Landing <span class="badge">0</span></button>
            <button id="md-waketurb-r" class="markdownr col-sm-2 btn btn-info">-</button><button data-points="3" class="markdown btn col-sm-10 btn-warning" id="md-waketurb">Wake Turbulence <span class="badge">0</span></button>
        </div>
        <div class="col-md-4">
            <h5 class="text-center">Tracon</h5>
            <button id="md-cl_approach-r" class="markdownr col-sm-2 btn btn-info">-</button><button data-points="2" class="markdown btn col-sm-10 btn-warning" id="md-cl_approach">Approach Clearance <span class="badge">0</span></button>
            <button id="md-mva-r" class="markdownr col-sm-2 btn btn-info">-</button><button data-points="4" class="markdown btn col-sm-10 btn-warning" id="md-mva">Vector Below MVA <span class="badge">0</span></button>
            <button id="md-sop-r" class="markdownr col-sm-2 btn btn-info">-</button><button data-points="1" class="markdown btn col-sm-10 btn-warning" id="md-sop">LOA/SOP Violation <span class="badge">0</span></button>
            <button id="md-fix-r" class="markdownr col-sm-2 btn btn-info">-</button><button data-points="2" class="markdown btn col-sm-10 btn-warning" id="md-fix">Incorrect Fix/VOR <span class="badge">0</span></button>
            <button id="md-final-r" class="markdownr col-sm-2 btn btn-info">-</button><button data-points="1" class="markdown btn col-sm-10 btn-warning" id="md-final">Late Final Vectors <span class="badge">0</span></button>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-4">
            <h5 class="text-center">Conditions</h5>
            <div class="row">
                <label class="control-label">Weather</label>
                <div class="form-group">
                    <select class="form-control condition" name="cond-weather" id="cond-weather">
                        <option data-points="0" value="vfr">VFR</option>
                        <option data-points="1" value="mvfr">MVFR</option>
                        <option data-points="2" value="ifr">IFR</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <label class="control-label">Complexity</label>
                <div class="form-group">
                    <select class="form-control condition" name="cond-complexity" id="cond-complexity">
                        <option data-points="0" value="ve">Very Easy</option>
                        <option data-points="2" value="e">Easy</option>
                        <option data-points="4" value="m">Moderate</option>
                        <option data-points="6" value="d">Difficult</option>
                        <option data-points="9" value="vd">Very Difficult</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <label class="control-label">Traffic</label>
                <div class="form-group">
                    <select class="form-control condition" name="cond-traffic" id="cond-traffic">
                        <option data-points="0" value="vl">Very Light</option>
                        <option data-points="2" value="l">Light</option>
                        <option data-points="4" value="m">Moderate</option>
                        <option data-points="6" value="h">Heavy</option>
                        <option data-points="9" value="vh">CTP (Very Heavy)</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <h5 class="text-center">Markups</h5>
            <button id="mu-flow-r" class="btn btn-info col-sm-2 markupr">-</button><button data-points="2" class="markup btn col-sm-10 btn-success" id="mu-flow">Traffic Flow <span class="badge">0</span></button>
            <button id="mu-separation-r" class="btn btn-info col-sm-2 markupr">-</button><button data-points="3" class="markup btn col-sm-10 btn-success" id="mu-separation">Separation <span class="badge">0</span></button>
            <button id="mu-pharseology-r" class="btn btn-info col-sm-2 markupr">-</button><button data-points="2" class="markup btn col-sm-10 btn-success" id="mu-phraseology">Phraseology <span class="badge">0</span></button>
            <button id="mu-situation-r" class="btn btn-info col-sm-2 markupr">-</button><button data-points="2" class="markup btn col-sm-10 btn-success" id="mu-situation">Situation Handling <span class="badge">0</span></button>
            <button id="mu-pointouts-r" class="btn btn-info col-sm-2 markupr">-</button><button data-points="3" class="markup btn col-sm-10 btn-success" id="mu-pointouts">Alerts & Pointouts <span class="badge">0</span></button>
            <button id="mu-sequencing-r" class="btn btn-info col-sm-2 markupr">-</button><button data-points="2" class="markup btn col-sm-10 btn-success" id="mu-sequencing">Speed & Sequencing <span class="badge">0</span></button>
        </div>
        <div class="col-md-4">
            <h5 class="text-center">Other Markdows</h5>
            <button id="md-flow-r" class="btn btn-info col-sm-2 markdownr">-</button><button data-points="1" class="markdown btn col-sm-10 btn-warning" id="md-flow">Slow Traffic Flow <span class="badge">0</span></button>
            <button id="md-separation-r" class="btn btn-info col-sm-2 markdownr">-</button><button data-points="2" class="markdown btn col-sm-10 btn-warning" id="md-separation">Loss of Separation <span class="badge">0</span></button>
            <button id="md-phraseology-r" class="btn btn-info col-sm-2 markdownr">-</button><button data-points="1" class="markdown btn col-sm-10 btn-warning" id="md-phraseology">Phraseology <span class="badge">0</span></button>
            <button id="md-near_incident-r" class="btn btn-info col-sm-2 markdownr">-</button><button data-points="4" class="markdown btn col-sm-10 btn-danger" id="md-near_incident">Near Incident <span class="badge">0</span></button>
            <button id="md-incident-r" class="btn btn-info col-sm-2 markdownr">-</button><button data-points="7" class="markdown btn col-sm-10 btn-danger" id="md-incident">Crashed Planes <span class="badge">0</span></button>
            <button id="md-coordination-r" class="btn btn-info col-sm-2 markdownr">-</button><button data-points="2" class="markdown btn col-sm-10 btn-warning" id="md-coordination">Missed Coordination <span class="badge">0</span></button>
            <button id="md-readback-r" class="btn btn-info col-sm-2 markdownr">-</button><button data-points="1" class="markdown btn col-sm-10 btn-warning" id="md-readback">Incorrect Readback <span class="badge">0</span></button>
        </div>
    </div>
    <div style="margin-top:10px" class="row form-horizontal">
        <div class="col-sm-12 form-inline">
            <label style="padding-top:7px" class="col-sm-2">Comment:</label><input class="col-sm-5 form-control" type="text" name="mu-other" id="mu-other">
            <label style="padding-top:7px" class="col-sm-1">Points</label><input style="max-width: 100px;" class="col-sm-1 form-control" type="number" name="mu-other-points" id="mu-other-points">
            <button style="width:160px;" class="col-sm-2 col-sm-offset-1 btn btn-success" id="mu-other-add">Add Markup <span class="badge">0</span></button>
        </div>
        <div style="margin-top:5px" class="col-sm-12 form-inline">
            <label style="padding-top:7px" class="col-sm-2">Comment:</label><input class="col-sm-5 form-control" type="text" name="md-other" id="md-other">
            <label style="padding-top:7px" class="col-sm-1">Points</label><input style="max-width: 100px;" class="col-sm-1 form-control" type="number" name="md-other-points" id="md-other-points">
            <button style="width:160px;" class="col-sm-2 col-md-offset-1 btn btn-danger" id="md-other-add">Add Markdown <span class="badge">0</span></button>
        </div>
    </div>
    <div class="row">
        <table class="table">
            <thead><tr class="text-center"><td colspan="3">OTS Status</td></tr></thead><tbody><tr>
            <td><input type="radio" name="ots" value="n"> Not OTS</td>
            <td><input type="radio" name="ots" value="p"> Pass</td>
            <td><input type="radio" name="ots" value="f"> Fail</td>
        </tr></tbody></table>
    </div>
</div>
    </div>
<div class="row">
    <div class="col-md-6" style="width:790px;">
        <h3 class="text-center">Staff Comment</h3>
        <textarea class="editor" name="comment-db" id="comment-db" cols="30"
                  rows="10"></textarea>
    </div>
    <div class="col-md-6" style="width:790px;">
        <h3 class="text-center">Student Comment</h3>
        <textarea class="editor" name="comment-student" id="comment-student" cols="30"
                  rows="10"></textarea>
    </div>
    <div class="col-md-6" style="width:790px;">
        <button data-timer="debrief" id="debrief" disabled class="timer btn btn-primary btn-block">Start Debrief/Review</button>
    </div>
    <div class="col-md-6" style="width:790px;">
        <input type="hidden" name="pos_points" id="pos_points" value="0">
        <input type="hidden" name="neg_points" id="neg_points" value="0">
        <input type="hidden" name="modifier" id="modifier" value="1">
        <input type="hidden" name="student" id="student" value="{{$student->cid}}">
        <input type="hidden" name="final_markdowns" id="final_markdowns">
        <input type="hidden" name="final_markups" id="final_markups">
        <input type="hidden" name="final_score" id="final_score">
        <input type="hidden" name="final_timers" id="final_timers">
        <input type="hidden" name="final_conditions" id="final_conditions">
        <input type="hidden" name="final_reviews" id="final_reviews">
        <input type="hidden" name="final_performance" id="final_performance">
        <button disabled data-timer="complete" id="complete" class="timer btn btn-primary btn-block">Complete Session</button>
    </div>
</div>
</form>
@stop
@section('scripts')
    {{ HTML::script('js/live-session.js') }}
@stop
