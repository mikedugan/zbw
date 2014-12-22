@extends('layouts.master')
@section('title')
    ZBW Email Templates
@stop
@section('content')
    @foreach($templates as $template)
        <p><a href="/staff/emails/edit?template={{ $template->getBasename() }}">Edit {{ $template->getBasename('.blade.php') }}</a></p>
    @endforeach
@stop
