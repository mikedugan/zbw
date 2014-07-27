@extends('layouts.master')
@section('title')
ZBW Pilot Feedback
@stop
@section('content')
<h1 class="text-center">Pilot Feedback</h1>
<div class="row">
    <div class="col-md-12">
        <form class="col-md-6" action="" method="post">
            <div class="form-group col-md-6">
                <label for="fname">First Name</label>
                <input class="form-control" name="fname" id="fname" type="text">
            </div>
            <div class="form-group col-md-6">
                <label class="control-label" for="lname">Last Name</label>
                <input class="form-control" id="lname" name="lname" type="text"/>
            </div>
            <div class="form-group col-md-6">
                <label class="control-label" for="email">Email</label>
                <input class="form-control" id="email" name="email" type="email">
            </div>
            <div class="form-group col-md-6">
                <label class="control-label" for="controller">Controller</label>
                <select class="form-control" name="controller" id="controller">
                    @foreach($controllers as $controller)
                    <option value="{{ $controller->cid}}">{{ $controller->first_name . ' ' . $controller->last_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-6 col-md-offset-3">
                <label class="control-label" for="rating">How Would You Rate Your ATC?</label>
                <select class="form-control" name="rating" id="rating">
                    <option value="0">Eek</option>
                    <option value="1">Poor</option>
                    <option value="2">Fair</option>
                    <option value="3">Average</option>
                    <option value="4">Good</option>
                    <option value="5">Excellent</option>
                    <option value="6">Whoa</option>
                </select>
            </div>
            <div class="form-group col-md-12">
                <label for="message">Tell Us How We Did</label>
                <textarea class="editor" name="message" id="message" cols="30"rows="10"></textarea>
            </div>
            <div class="clearfix"></div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        <div class="col-md-6">
            <h3 class="text-center">Thanks!</h3>
            <p>At ZBW, we pride ourselves on a high standard of excellence. Your feedback is incredibly valuable to let us know when we are doing well and in what areas we can improve.</p>
            <p>If you require a response, one of our staff members will be in touch as soon as possible.</p>
            <p>Note: Your CID and contact information are stored securely and only used for verification purposes, and not shared with the public.</p>
        </div>
    </div>
</div>
@stop
