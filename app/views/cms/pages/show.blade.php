@extends('layouts.master')
@section('title')
{{ $page->title }}
@stop
@section('content')
<div class="container">
    <h1 class="text-center">{{$page->title}}</h1>
    <div class="container">
        {{$page->content}}
    </div>
</div>
@stop
