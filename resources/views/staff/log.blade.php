@extends('layouts.staff')
@section('title')
Log
@stop
@section('header')
@stop
@section('content')
    <h1 class="text-center">ZBW Log</h1>
    <div class="col-md-12">
        @include('includes.bj.log')
    </div>
@stop
