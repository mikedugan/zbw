@extends('layouts.staff')
@section('title')
Edit Controller
@stop
@section('header')
@stop
@section('content')
  <div class="row">
    <div class="col-md-12">
        <h1 class="text-center">Edit {{$user->initials}}</h1>
        @if($me->inGroup(\Sentry::findGroupByName('Executive')))
          @include('includes.forms.edit_user_admin')
        @elseif($me->inGroup(\Sentry::findGroupByName('Staff')))
          @include('includes.forms.edit_user_staff')
        @endif
        </div>
    </div>
  </div>
@stop
