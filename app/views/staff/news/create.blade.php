@extends('layouts.master')
@section('header')
@stop

@section('content')
    <h1 class="text-center">Add Event/News</h1>
    <form role="form" action="/staff/news/add" method="post">
        <div class="col-md-5">
            <div class="form-group">
                <label class="control-label" for="title">Title</label>
                <input class="form-control" id="title" name="title" maxlength="60">
            </div>
            <div class="form-group">
                <label class="control-label" for="content">Event Description</label>
            </div>
            <textarea class="form-control editor" name="content" id="content" rows="10"></textarea>
            <div class="form-group">
                <label class="control-label" for="facility">Facility</label>
                <select class="form-control" name="facility" id="facility">
                    <option value="0">ZBW</option>
                    <option value="1">BOS</option>
                    <option value="2">BDL</option>
                    <option value="3">PVD</option>
                    <option value="4">ALB</option>
                    <option value="5">PWM</option>
                    <option value="6">BTV</option>
                    <option value="7">K90</option>
                    <option value="8">ZNY</option>
                    <option value="9">ZUL</option>
                </select>
            </div>
            <div class="form-group">
                <label class="control-label" for="type">News Type</label>
                <select class="form-control" name="type" id="type">
                    <option value="0">News</option>
                    <option value="1">Event</option>
                    <option value="2">Announcement</option>
                </select>
            </div>
            <div class="form-group">
                <label class="control-label" for="audience">Target Audience</label>
                <select class="form-control" name="audience" id="audience">
                    <option value="0">All</option>
                    <option value="1">Controllers</option>
                    <option value="2">Pilots</option>
                    <option value="3">Staff</option>
                </select>
            </div>
            <div class="form-group">
                <label class="control-label" for="placement">Announcement Location</label>
                <select class="form-control" name="placement" id="placement">
                    <option value="0">Home Page</option>
                    <option value="1">Staff Area</option>
                    <option value="2">Training Area</option>
                    <opton value="3">Forum</opton>
                </select>
            </div>
        </div>
        <div class="col-md-5 col-md-offset-2">
            <div class="form-group">
                <label class="control-label" for="start">Start</label>
            </div>
            <div class="datepick" name="start"></div>

            <div class="form-group">
                <label class="control-label" for="end">End</label>
            </div>
            <div class="datepick" name="end"></div>
            <div class="clearfix"></div>
            <button type="submit" class="btn btn-primary">Submit</button>
            </form>
            <form class="file-form" action="/f/upload/images" method="POST">
                <div class="form-group">
                    <input type="file" name="photos[]" multiple/>
                    <p class="help-block">Use this to upload images for your event</p>
                    <button type="submit">Upload</button>
                </div>
            </form>
        </div>


@stop
