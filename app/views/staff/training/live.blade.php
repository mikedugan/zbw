@extends('layouts.master')
@section('title')
Training Session
@stop
@section('content')
<h1 class="text-center">Training Session</h1>
<div class="row">
    <div class="col-md-6">
        <button class="btn btn-primary btn-block">Start Brief/Review</button>
    </div>
    <div class="col-md-6">
        <button class="btn btn-primary btn-block">Start Live Session</button>
    </div>
</div>
<div class="col-md-6">
    <h3 class="text-center">General Performance</h3>
    <div class="row form-horizontal">
        <label class="control-label col-md-4">Sign-On Brief</label>
        <div class="col-md-2 checkbox">
            <label><input type="checkbox" value="true" name="review-brief"> Reviewed</label>
        </div>
        <div class="form-group col-md-6">
            <select class="form-control" name="brief">
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
            <label><input type="checkbox" value="true" name="review-runway"> Reviewed</label>
        </div>
        <div class="form-group col-md-6">
            <select class="form-control" name="runway">
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
            <label><input type="checkbox" value="true" name="review-weather"> Reviewed</label>
        </div>
        <div class="form-group col-md-6">
            <select class="form-control" name="weather">
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
            <label><input type="checkbox" value="true" name="review-coordination"> Reviewed</label>
        </div>
        <div class="form-group col-md-6">
            <select class="form-control" name="coordination">
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
            <label><input type="checkbox" value="true" name="review-flow"> Reviewed</label>
        </div>
        <div class="form-group col-md-6">
            <select class="form-control" name="flow">
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
            <label><input type="checkbox" value="true" name="review-identity"> Reviewed</label>
        </div>
        <div class="form-group col-md-6">
            <select class="form-control" name="identity">
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
            <label><input type="checkbox" value="true" name="review-separation"> Reviewed</label>
        </div>
        <div class="form-group col-md-6">
            <select class="form-control" name="separation">
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
            <label><input type="checkbox" value="true" name="review-pointouts"> Reviewed</label>
        </div>
        <div class="form-group col-md-6">
            <select class="form-control" name="pointouts">
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
            <label><input type="checkbox" value="true" name="review-airspace"> Reviewed</label>
        </div>
        <div class="form-group col-md-6">
            <select class="form-control" name="airspace">
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
            <label><input type="checkbox" value="true" name="review-loa"> Reviewed</label>
        </div>
        <div class="form-group col-md-6">
            <select class="form-control" name="loa">
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
            <label><input type="checkbox" value="true" name="review-phraseology"> Reviewed</label>
        </div>
        <div class="form-group col-md-6">
            <select class="form-control" name="phraseology">
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
            <label><input type="checkbox" value="true" name="review-priority"> Reviewed</label>
        </div>
        <div class="form-group col-md-6">
            <select class="form-control" name="priority">
                <option value="na">NA or Not Observed</option>
                <option value="u">Unsatisfactory</option>
                <option value="n">Needs Improvement</option>
                <option value="s">Satisfactory</option>
            </select>
        </div>
    </div>
</div>
<div class="col-md-6">
    <h3 class="text-center">Markups & Markdowns</h3>
    <div class="row">
        <div class="col-md-4">
        <h5 class="text-center">DEL/GND</h5>
            <button class="btn btn-block btn-warning" id="md-wafdof">WAFDOF</button>
            <button class="btn btn-block btn-warning" id="md-squawk">Missed Squawk</button>
            <button class="btn btn-block btn-warning" id="md-cl-late">Delayed Clrnc</button>
            <button class="btn btn-block btn-warning" id="md-cl-wrong">Incorrect Clrnc</button>
            <button class="btn btn-block btn-warning" id="md-taxi">Invalid Taxi</button>
        </div>
        <div class="col-md-4">
            <h5 class="text-center">Local</h5>
            <button class="btn btn-block btn-warning" id="md-landing">Invalid Landing</button>
            <button class="btn btn-block btn-warning" id="md-takeoff">Invalid Takeoff</button>
            <button class="btn btn-block btn-warning" id="md-luaw">LUAW While Landing</button>
            <button class="btn btn-block btn-warning" id="md-waketurb">Wake Turbulence</button>
        </div>
        <div class="col-md-4">
            <h5 class="text-center">Tracon</h5>
            <button class="btn btn-block btn-warning" id="md-cl-approach">Approach Clearance</button>
            <button class="btn btn-block btn-warning" id="md-taxi">Vector Below MVA</button>
            <button class="btn btn-block btn-warning" id="md-sop">LOA/SOP Violation</button>
            <button class="btn btn-block btn-warning" id="md-fix">Incorrect Fix/VOR</button>
            <button class="btn btn-block btn-warning" id="md-final">Late Final Vectors</button>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-4">
            <div class="row">
                <label class="control-label">Weather</label>
                <div class="form-group">
                    <select class="form-control" name="cond-weather" id="cond-weather">
                        <option value="vfr">VFR</option>
                        <option value="mvfr">MVFR</option>
                        <option value="ifr">IFR</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <label class="control-label">Complexity</label>
                <div class="form-group">
                    <select class="form-control" name="cond-complexity" id="cond-complexity">
                        <option value="ve">Very Easy</option>
                        <option value="e">Easy</option>
                        <option value="m">Moderate</option>
                        <option value="d">Difficult</option>
                        <option value="vd">Very Difficult</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <label class="control-label">Traffic</label>
                <div class="form-group">
                    <select class="form-control" name="cond-traffic" id="cond-traffic">
                        <option value="vl">Very Light</option>
                        <option value="l">Light</option>
                        <option value="m">Moderate</option>
                        <option value="h">Heavy</option>
                        <option value="vh">CTP (Very Heavy)</option>
                    </select>
                </div>
            </div>
            <button class="btn btn-block btn-success" id="mu-other">Other Markup</button>
            <button class="btn btn-block  btn-warning" id="md-other">Other Markdown</button>
        </div>
        <div class="col-md-4">
            <button class="btn btn-block btn-success" id="mu-flow">Traffic Flow</button>
            <button class="btn btn-block btn-success" id="mu-separation">Separation</button>
            <button class="btn btn-block btn-success" id="mu-phraseology">Phraseology</button>
            <button class="btn btn-block btn-success" id="mu-situation">Situation Handling</button>
            <button class="btn btn-block btn-success" id="mu-pointouts">Alerts & Pointouts</button>
            <button class="btn btn-block btn-success" id="mu-sequencing">Speed & Sequencing</button>
        </div>
        <div class="col-md-4">
            <button class="btn btn-block btn-warning" id="md-flow">Slow Traffic Flow</button>
            <button class="btn btn-block btn-warning" id="md-separation">Loss of Separation</button>
            <button class="btn btn-block btn-warning" id="md-phraseology">Incorrect Phraseology</button>
            <button class="btn btn-block btn-danger" id="md-near-incident">Near Incident</button>
            <button class="btn btn-block btn-danger" id="md-incident">Crashed Planes</button>
            <button class="btn btn-block btn-warning" id="md-coordination">Missed Coordination</button>
            <button class="btn btn-block btn-warning" id="md-readback">Incorrect Readback</button>
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
        <button class="btn btn-primary btn-block">Start Debrief/Review</button>
    </div>
    <div class="col-md-6">
        <button class="btn btn-primary btn-block">Complete Session</button>
    </div>
</div>
@stop
