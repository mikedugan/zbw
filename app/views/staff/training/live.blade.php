@extends('layouts.master')
@section('title')
Training Session
@stop
@section('content')
<form id="training_session" action="" method="post">
<h1 class="text-center">Training Session</h1>
<div class="row">
    <div class="col-md-6">
        <button data-timer="start" id="start" class="timer btn btn-primary btn-block">Start Brief/Review</button>
    </div>
    <div class="col-md-6">
        <button data-timer="live" id="live" class="timer btn btn-primary btn-block">Start Live Session</button>
    </div>
</div>
    <div class="row">
<div class="col-md-6">
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
<div class="col-md-6">

    <h3 class="text-center">Markups & Markdowns</h3>
    <div class="row">
        <div class="col-md-4">
        <h5 class="text-center">DEL/GND</h5>
            <button data-points="2" class="markdown btn btn-block btn-warning" id="md-wafdof">WAFDOF</button>
            <button data-points="2" class="markdown btn btn-block btn-warning" id="md-squawk">Missed Squawk</button>
            <button data-points="1" class="markdown btn btn-block btn-warning" id="md-cl_late">Delayed Clrnc</button>
            <button data-points="2" class="markdown btn btn-block btn-warning" id="md-cl_wrong">Incorrect Clrnc</button>
            <button data-points="3" class="markdown btn btn-block btn-warning" id="md-taxi">Invalid Taxi</button>
        </div>
        <div class="col-md-4">
            <h5 class="text-center">Local</h5>
            <button data-points="2" class="markdown btn btn-block btn-warning" id="md-landing">Invalid Landing</button>
            <button data-points="2" class="markdown btn btn-block btn-warning" id="md-takeoff">Invalid Takeoff</button>
            <button data-points="4" class="markdown btn btn-block btn-warning" id="md-luaw">LUAW While Landing</button>
            <button data-points="3" class="markdown btn btn-block btn-warning" id="md-waketurb">Wake Turbulence</button>
        </div>
        <div class="col-md-4">
            <h5 class="text-center">Tracon</h5>
            <button data-points="2" class="markdown btn btn-block btn-warning" id="md-cl_approach">Approach Clearance</button>
            <button data-points="4" class="markdown btn btn-block btn-warning" id="md-mva">Vector Below MVA</button>
            <button data-points="1" class="markdown btn btn-block btn-warning" id="md-sop">LOA/SOP Violation</button>
            <button data-points="2" class="markdown btn btn-block btn-warning" id="md-fix">Incorrect Fix/VOR</button>
            <button data-points="1" class="markdown btn btn-block btn-warning" id="md-final">Late Final Vectors</button>
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
            <button data-points="2" class="markup btn btn-block btn-success" id="mu-flow">Traffic Flow</button>
            <button data-points="3" class="markup btn btn-block btn-success" id="mu-separation">Separation</button>
            <button data-points="2" class="markup btn btn-block btn-success" id="mu-phraseology">Phraseology</button>
            <button data-points="2" class="markup btn btn-block btn-success" id="mu-situation">Situation Handling</button>
            <button data-points="3" class="markup btn btn-block btn-success" id="mu-pointouts">Alerts & Pointouts</button>
            <button data-points="2" class="markup btn btn-block btn-success" id="mu-sequencing">Speed & Sequencing</button>
        </div>
        <div class="col-md-4">
            <h5 class="text-center">Other Markdows</h5>
            <button data-points="1" class="markdown btn btn-block btn-warning" id="md-flow">Slow Traffic Flow</button>
            <button data-points="2" class="markdown btn btn-block btn-warning" id="md-separation">Loss of Separation</button>
            <button data-points="1" class="markdown btn btn-block btn-warning" id="md-phraseology">Incorrect Phraseology</button>
            <button data-points="4" class="markdown btn btn-block btn-danger" id="md-near_incident">Near Incident</button>
            <button data-points="7" class="markdown btn btn-block btn-danger" id="md-incident">Crashed Planes</button>
            <button data-points="2" class="markdown btn btn-block btn-warning" id="md-coordination">Missed Coordination</button>
            <button data-points="1" class="markdown btn btn-block btn-warning" id="md-readback">Incorrect Readback</button>
        </div>
    </div>
    <div style="margin-top:10px" class="row form-horizontal">
        <div class="col-sm-12 form-inline">
            <label style="padding-top:7px" class="col-sm-2">Comment:</label><input class="col-sm-5 form-control" type="text" name="mu-other" id="mu-other">
            <label style="padding-top:7px" class="col-sm-1">Points</label><input class="col-sm-1 form-control" type="number" name="mu-other-points" id="mu-other-points">
            <button class="col-sm-2 col-sm-offset-1 btn btn-success" id="mu-other-add">Add Markup</button>
        </div>
        <div style="margin-top:5px" class="col-sm-12 form-inline">
            <label style="padding-top:7px" class="col-sm-2">Comment:</label><input class="col-sm-5 form-control" type="text" name="md-other" id="md-other">
            <label style="padding-top:7px" class="col-sm-1">Points</label><input class="col-sm-1 form-control" type="number" name="md-other-points" id="md-other-points">
            <button class="col-sm-2 col-md-offset-1 btn btn-danger" id="md-other-add">Add Markdown</button>
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
    <div class="col-md-6">
        <h3 class="text-center">Staff Comment</h3>
        <textarea class="editor" name="comment-db" id="comment-db" cols="30"
                  rows="10"></textarea>
    </div>
    <div class="col-md-6">
        <h3 class="text-center">Student Comment</h3>
        <textarea class="editor" name="comment-student" id="comment-student" cols="30"
                  rows="10"></textarea>
    </div>
    <div class="col-md-6">
        <button data-timer="debrief" id="debrief" class="timer btn btn-primary btn-block">Start Debrief/Review</button>
    </div>
    <div class="col-md-6">
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
