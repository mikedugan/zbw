@extends('layouts.master')
@section('title')
    ZBW Email Templates
@stop
@section('content')
    {{ Form::open() }}
        <label for="contents">Email Template</label>
        {{ Form::hidden('filename', $filename) }}
        <textarea rows="30" class="editor form-control" name="contents" id="contents">{{ $contents }}</textarea>
        <br/>
        <button type="submit" class="btn btn-primary">Update</button>
    {{ Form::close() }}
@stop
