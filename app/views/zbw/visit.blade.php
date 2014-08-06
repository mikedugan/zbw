@extends('layouts.master')
@section('title')
Visit ZBW
@stop
@section('content')
<h1 class="text-center">Visit Boston ARTCC</h1>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
       <p>ZBW is happy to welcome visitors from across VATUSA and VATSIM. Please fill out the following form to get started:</p>
        <div class="panel-default">
            <div class="panel-heading"><h3>Visiting Controller Application</h3></div>
            <div class="panel-body">
                <form id="visit" action="" method="POST">
                    <div class="form-group">
                        <label for="cid" class="control-label">CID</label>
                        <input type="number" name="cid" id="cid" class="form-control">
                    </div>
                    <div class="hidden form-group">
                        <label for="fname">First Name</label>
                        <input type="text" name="fname" id="fname" class="form-control">
                    </div>
                    <div class="hidden form-group">
                        <label for="lname">Last Name</label>
                        <input type="text" name="lname" id="lname" class="form-control">
                    </div>
                    <div class="hidden form-group">
                        <label for="rating">Rating</label>
                        <input type="text" name="rating" id="rating" class="form-control">
                    </div>
                    <div class="hidden form-group">
                        <label for="home" class="control-label">Home ARTCC</label>
                        <input type="text" maxlength="3" id="home" name="home" class="form-control">
                    </div>
                    <div class="hidden form-group">
                        <label for="email" class="control-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control">
                    </div>
                    <div class="hidden form-group">
                        <label for="message" class="control-label">Tell us a little about yourself and why you want to visit ZBW</label>
                        <textarea class="form-control" name="editor" id="message" cols="30"rows="10"></textarea>
                     </div>
                    <button type="submit" class="hidden btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
@stop
