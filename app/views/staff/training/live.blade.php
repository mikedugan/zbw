@extends('layouts.master')
@section('title')
Training Session
@stop
@section('content')
<h1 class="text-center">Training Session</h1>
<div class="row">
    <div class="col-md-6">
        <button data-timer="start" id="start" class="timer btn btn-primary btn-block">Start Brief/Review</button>
    </div>
    <div class="col-md-6">
        <button data-timer="live" id="live" class="timer btn btn-primary btn-block">Start Live Session</button>
    </div>
</div>
<div class="col-md-6">
    <h3 class="text-center">General Performance</h3>
    <div class="row form-horizontal">
        <label class="control-label col-md-4">Sign-On Brief</label>
        <div class="col-md-2 checkbox">
            <label><input type="checkbox" value="true" class="reviewbox" data-subject="sign on briefs" id="review-brief" name="review-brief"> Reviewed</label>
        </div>
        <div class="form-group col-md-6">
            <select class="form-control performance" id="brief" name="brief">
                <option value="na">NA or Not Observed</option>
                <option value="u">Unsatisfactory</option>
                <option value="n">Needs Improvement</option>
                <option value="s">Satisfactory</option>
            </select>
        </div>
    </div>
    <div class="row form-horizontal">
        <label class="control-label col-md-4">Runway Selection</label>
        <div class="col-md-2 checkbox">
            <label><input type="checkbox" value="true" class="reviewbox" data-subject="runway selection" id="review-runway" name="review-runway"> Reviewed</label>
        </div>
        <div class="form-group col-md-6">
            <select class="form-control performance" name="runway" id="runway">
                <option value="na">NA or Not Observed</option>
                <option value="u">Unsatisfactory</option>
                <option value="n">Needs Improvement</option>
                <option value="s">Satisfactory</option>
            </select>
        </div>
    </div>
    <div class="row form-horizontal">
        <label class="control-label col-md-4">Weather Conditions</label>
        <div class="col-md-2 checkbox">
            <label><input type="checkbox" value="true" name="review-weather" class="reviewbox" data-subject="weather conditions" id="review-weather"> Reviewed</label>
        </div>
        <div class="form-group col-md-6">
            <select class="form-control performance" name="weather" id="weather">
                <option value="na">NA or Not Observed</option>
                <option value="u">Unsatisfactory</option>
                <option value="n">Needs Improvement</option>
                <option value="s">Satisfactory</option>
            </select>
        </div>
    </div>
    <div class="row form-horizontal">
        <label class="control-label col-md-4">Controller Coordination</label>
        <div class="col-md-2 checkbox">
            <label><input type="checkbox" value="true" name="review-coordination" class="reviewbox" data-subject="controller coordiation" id="review-coordination"> Reviewed</label>
        </div>
        <div class="form-group col-md-6">
            <select class="form-control performance" name="coordination" id="coordination">
                <option value="na">NA or Not Observed</option>
                <option value="u">Unsatisfactory</option>
                <option value="n">Needs Improvement</option>
                <option value="s">Satisfactory</option>
            </select>
        </div>
    </div>
    <div class="row form-horizontal">
        <label class="control-label col-md-4">Traffic Flow & Delays</label>
        <div class="col-md-2 checkbox">
            <label><input type="checkbox" value="true" name="review-flow" class="reviewbox" data-subject="traffic flow" id="review-flow"> Reviewed</label>
        </div>
        <div class="form-group col-md-6">
            <select class="form-control performance" name="flow" id="flow">
                <option value="na">NA or Not Observed</option>
                <option value="u">Unsatisfactory</option>
                <option value="n">Needs Improvement</option>
                <option value="s">Satisfactory</option>
            </select>
        </div>
    </div>
    <div class="row form-horizontal">
        <label class="control-label col-md-4">Aircraft Identity</label>
        <div class="col-md-2 checkbox">
            <label><input type="checkbox" value="true" name="review-identity" class="reviewbox" data-subject="maintaining aircraft identity" id="review-identity"> Reviewed</label>
        </div>
        <div class="form-group col-md-6">
            <select class="form-control performance" name="identity" id="identity">
                <option value="na">NA or Not Observed</option>
                <option value="u">Unsatisfactory</option>
                <option value="n">Needs Improvement</option>
                <option value="s">Satisfactory</option>
            </select>
        </div>
    </div>
    <div class="row form-horizontal">
        <label class="control-label col-md-4">Separation</label>
        <div class="col-md-2 checkbox">
            <label><input type="checkbox" value="true" name="review-separation" class="reviewbox" data-subject="aircraft separation" id="review-separation"> Reviewed</label>
        </div>
        <div class="form-group col-md-6">
            <select class="form-control performance" name="separation" id="separation">
                <option value="na">NA or Not Observed</option>
                <option value="u">Unsatisfactory</option>
                <option value="n">Needs Improvement</option>
                <option value="s">Satisfactory</option>
            </select>
        </div>
    </div>
    <div class="row form-horizontal">
        <label class="control-label col-md-4">Pointouts & Alerts</label>
        <div class="col-md-2 checkbox">
            <label><input type="checkbox" value="true" name="review-pointouts" class="reviewbox" data-subject="pointouts and alerts" id="review-pointouts"> Reviewed</label>
        </div>
        <div class="form-group col-md-6">
            <select class="form-control performance" name="pointouts" id='pointouts'>
                <option value="na">NA or Not Observed</option>
                <option value="u">Unsatisfactory</option>
                <option value="n">Needs Improvement</option>
                <option value="s">Satisfactory</option>
            </select>
        </div>
    </div>
    <div class="row form-horizontal">
        <label class="control-label col-md-4">Airspace Knowledge</label>
        <div class="col-md-2 checkbox">
            <label><input type="checkbox" value="true" name="review-airspace" class="reviewbox" data-subject="airspace knowledge" id="review-airspace"> Reviewed</label>
        </div>
        <div class="form-group col-md-6">
            <select class="form-control performance" name="airspace" id="airspace">
                <option value="na">NA or Not Observed</option>
                <option value="u">Unsatisfactory</option>
                <option value="n">Needs Improvement</option>
                <option value="s">Satisfactory</option>
            </select>
        </div>
    </div>
    <div class="row form-horizontal">
        <label class="control-label col-md-4">LOA Knowledge</label>
        <div class="col-md-2 checkbox">
            <label><input type="checkbox" value="true" name="review-loa" class="reviewbox" data-subject="SOP and LOA knowledge" id="review-loa"> Reviewed</label>
        </div>
        <div class="form-group col-md-6">
            <select class="form-control performance" name="loa" id="loa">
                <option value="na">NA or Not Observed</option>
                <option value="u">Unsatisfactory</option>
                <option value="n">Needs Improvement</option>
                <option value="s">Satisfactory</option>
            </select>
        </div>
    </div>
    <div class="row form-horizontal">
        <label class="control-label col-md-4">Phraseology</label>
        <div class="col-md-2 checkbox">
            <label><input type="checkbox" value="true" name="review-phraseology" class="reviewbox" data-subject="controller phraseology" id="review-phraseology"> Reviewed</label>
        </div>
        <div class="form-group col-md-6">
            <select class="form-control performance" name="phraseology" id="phraseology">
                <option value="na">NA or Not Observed</option>
                <option value="u">Unsatisfactory</option>
                <option value="n">Needs Improvement</option>
                <option value="s">Satisfactory</option>
            </select>
        </div>
    </div>
    <div class="row form-horizontal">
        <label class="control-label col-md-4">Duty Priority</label>
        <div class="col-md-2 checkbox">
            <label><input type="checkbox" value="true" name="review-priority" class="reviewbox" data-subject="duty priorities" id="review-priority"> Reviewed</label>
        </div>
        <div class="form-group col-md-6">
            <select class="form-control performance" name="priority" id="priority">
                <option value="na">NA or Not Observed</option>
                <option value="u">Unsatisfactory</option>
                <option value="n">Needs Improvement</option>
                <option value="s">Satisfactory</option>
            </select>
        </div>
    </div>
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
            <button class="btn btn-block btn-success" id="mu-other">Other Markup</button>
            <button class="btn btn-block  btn-warning" id="md-other">Other Markdown</button>
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
    <div class="row">
        <table class="table">
            <thead><tr class="text-center"><td colspan="3">OTS Status</td></tr></thead><tbody><tr>
            <td><input type="radio" name="ots" value="n"> Not OTS</td>
            <td><input type="radio" name="ots" value="p"> Pass</td>
            <td><input type="radio" name="ots" value="f"> Fail</td>
        </tr></tbody></table>
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
        <button data-timer="complete" id="complete" class="timer btn btn-primary btn-block">Complete Session</button>
    </div>
</div>
@stop
