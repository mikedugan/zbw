@extends('layouts.staff')
@section('title')
Add Event
@stop
@section('header')
    @include('includes.nav._pages')
@stop
@section('content')
<h1 class="text-center">Add CMS Page</h1>
<form action="" method="post">
    <div class="col-md-6">
        <h3>Options</h3>
        <div class="input-group">
            <label for="starts">Start Date</label>
            <input type="text" class="form-control" name="start">
        </div>
        <div class="input-group">
            <label for="ends">End Date</label>
            <input type="text" class="form-control" name="end">
        </div>
        <div class="input-group">
            <label for="audience">Audience</label>
            <p><input type="radio" name="audience" value="pilots">Pilots</p>
            <p><input type="radio" name="audience" value="controllers">Pilots</p>
            <p><input type="radio" name="audience" value="staff">Staff</p>
        </div>
    </div>
    <div class="col-md-6">
        <h3>Page Content</h3>
        <textarea class="editor" name="content" id="" cols="30" rows="10"></textarea>
    </div>
</form>
@stop
