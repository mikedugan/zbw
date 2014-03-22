@extends('layouts.staff')
@section('header')
@stop
@section('content')
<div class="col-md-12">
    <h1 class="text-center">Add ZBW Controller</h1>
    <form action="/staff/roster/add-controller" method="post">
        <div class="form-group">
            <label class="control-label" for="name">Name</label>
            <input class="form-control" name="name" type="text" id="name"/>
        </div>
        <div class="form-group">
            <label class="control-label" for="email">Email</label>
            <input class="form-control" type="email" name="email" id="email"/>
        </div>
        <p>The new controller will be emailed an initial password, as well as
        instructions on accessing the forum, training center, and their operating initials.</p>
    </form>
</div>
@stop
