@extends('layouts.master')
@section('title')
Make News
@stop
@section('header')
@stop

@section('content')
    <h1 class="text-center">Edit Event/News</h1>
    <form role="form" action="/staff/news/edit" method="post">
        <div class="col-md-5 col-md-offset-1">
            <div class="form-group">
                <label class="control-label" for="title">Title</label>
                <input class="form-control" value="{{ $event->title }}" id="title" name="title" maxlength="60">
            </div>
            <div class="form-group">
                <label class="control-label" for="content">Event Description</label>
            </div>
            <textarea class="form-control editor" name="content" id="content" rows="10">{{ $event->content }}</textarea>
            <div class="form-group">
                <label class="control-label" for="facility">Facility</label>
                <select class="form-control" name="facility_id" id="facility">
                    @foreach($facilities as $facility)
                        @if($event->facility_id == $facility->id)
                        <option selected="selected" value="{{$facility->id}}">{{$facility->value}}</option>
                        @else
                        <option value="{{$facility->id}}">{{$facility->value}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="control-label" for="news_type">News Type</label>
                <select class="form-control" name="news_type_id" id="news_type">
                    @foreach($news_types as $type)
                        @if($event->news_type_id === $type->id)
                        <option selected="selected" value="{{$type->id}}">{{Str::title($type->value)}}</option>
                        @else
                        <option value="{{$type->id}}">{{Str::title($type->value)}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="control-label" for="audience">Target Audience</label>
                <select class="form-control" name="audience_type_id" id="audience">
                    @foreach($audiences as $a)
                        @if($event->audience_type_id === $a->id)
                    <option selected="selected" value="{{$a->id}}">{{Str::title($a->value)}}</option>
                        @else
                        <option value="{{$a->id}}">{{Str::title($a->value)}}</option>
                        @endif
                    @endforeach
                </select>
            </div>

        </div>
        <div class="col-md-5">
            <div class="form-group">
                <label class="control-label" for="starts">Current Start</label>
                <input class="form-control" type="text" value="{{ $event->starts}}" name="starts" id="starts">
            </div>
            <div class="form-group">
                <label class="control-label" for="ends">Current End</label>
                <input class="form-control" type="text" value="{{ $event->ends}}" name="ends" id="ends">
            </div>
            <input type="hidden" value="{{$event->id}}" name="event_id">
            <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>


@stop
