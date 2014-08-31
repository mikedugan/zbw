@extends('layouts.master')
@section('title')
ZBW Controller Statistics
@stop

@section('content')
<h1 class="text-center">Controller Statistics</h1>
<div class="row">
  <div class="col-md-3">
    <h3 class="text-center">Overall</h3>
    <table class="table">
    <thead>
      <tr>
        <td>Controller</td>
        <td>Time</td>
      </tr>
    </thead>
    <tbody>
    @foreach($overall['set'] as $user)
      <tr>
        <td>{{$user->username}}</td>
        <td>{{$user->onlinetime}}</td>
      </tr>
    @endforeach
    <tr>
          <td>Total</td>
          <td>{{$overall['total']}}</td>
        </tr>
    </tbody>
      </table>
  </div>
  <div class="col-md-3">
    <h3 class="text-center">TRACON</h3>
  <table class="table">
  <thead>
    <tr>
      <td>Controller</td>
      <td>Time</td>
    </tr>
  </thead>
  <tbody>
  @foreach($tracon['set'] as $user)
    <tr>
      <td>{{$user->username}}</td>
      <td>{{$user->onlinetime}}</td>
    </tr>
  @endforeach
    <tr>
      <td>Total</td>
      <td>{{$tracon['total']}}</td>
    </tr>
  </tbody>
    </table>
  </div>
  <div class="col-md-3">
    <h3 class="text-center">Tower</h3>
  <table class="table">
  <thead>
    <tr>
      <td>Controller</td>
      <td>Time</td>
    </tr>
  </thead>
  <tbody>
  @foreach($tower['set'] as $user)
      <tr>
        <td>{{$user->username}}</td>
        <td>{{$user->onlinetime}}</td>
      </tr>
  @endforeach
  <tr>
        <td>Total</td>
        <td>{{$tower['total']}}</td>
      </tr>
  </tbody>
    </table>
  </div>
  <div class="col-md-3">
    <h3 class="text-center">Ground</h3>
  <table class="table">
  <thead>
    <tr>
      <td>Controller</td>
      <td>Time</td>
    </tr>
  </thead>
  <tbody>
  @foreach($ground['set'] as $user)
      <tr>
        <td>{{$user->username}}</td>
        <td>{{$user->onlinetime}}</td>
      </tr>
  @endforeach
  <tr>
        <td>Total</td>
        <td>{{$ground['total']}}</td>
      </tr>
  </tbody>
  </table>
  </div>
</div>
@stop
