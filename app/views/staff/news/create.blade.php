@extends('layouts.master')
@section('title')
Make News
@stop
@section('header')
@stop

@section('content')
    <h1 class="text-center">Add Event/News</h1>
    <form id="newsCreate"role="form" action="" method="post">
        <div class="col-md-5">
            <div class="form-group">
                <label class="control-label" for="title">Title</label>
                <input class="form-control" id="title" name="title" maxlength="60">
            </div>
            <div class="form-group">
                <label class="control-label" for="content">Event Description</label>
            </div>
            <textarea class="form-control raptor" name="content" id="content" rows="10"></textarea>
            <div class="form-group">
                <label class="control-label" for="facility">Facility</label>
                <select class="form-control" name="facility" id="facility">
                    @foreach($facilities as $facility)
                        <option value="{{$facility->id}}">{{$facility->value}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="control-label" for="news_type">News Type</label>
                <select class="form-control" name="news_type" id="news_type">
                    @foreach($news_types as $type)
                        <option value="{{$type->id}}">{{Str::title($type->value)}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="control-label" for="audience">Target Audience</label>
                <select class="form-control" name="audience" id="audience">
                    @foreach($audiences as $a)
                        <option value="{{$a->id}}">{{Str::title($a->value)}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-5 col-md-offset-2">
            <input type="hidden" id="starts" name="starts" value="">
            <input type="hidden" id="ends" name="ends">
            <div class="form-group">
                <label class="control-label" for="starts">Start</label>
            </div>
            <div class="datepick" data-field="starts" id="starts-dp"></div>

            <div class="form-group">
                <label class="control-label" for="ends">End</label>
            </div>
            <div class="datepick" data-field="ends" id="ends-dp"></div>
            <div class="clearfix"></div>
            <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>


@stop
