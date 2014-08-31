@extends('layouts.master')
@section('title')
ZBW Controller Statistics
@stop

@section('content')
<h1 class="text-center">Controller Statistics</h1>
<div class="row">

  <div class="col-md-3">
    <h3 class="text-center">Center</h3>
    <table class="table">
    <thead>
      <tr>
        <td><b>Controller</b></td>
        <td><b>Time</b></td>
      </tr>
    </thead>
    <tbody>
    @foreach($center['set'] as $user)
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
      <td><b>Controller</b></td>
      <td><b>Time</b></td>
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
      <td><b>Controller</b></td>
      <td><b>Time</b></td>
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
      <td><b>Controller</b></td>
      <td><b>Time</b></td>
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
<div class="row">

  <div class="col-md-3">
    <h3 class="text-center">Overall</h3>
    <table class="table">
    <thead>
      <tr>
        <td><b>Controller</b></td>
        <td><b>Time</b></td>
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
    <h3 class="text-center">This Month</h3>
    <table class="table">
    <thead>
      <tr>
        <td><b>Controller</b></td>
        <td><b>Time</b></td>
      </tr>
    </thead>
    <tbody>
    @foreach($this_month['set'] as $user)
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
      <h3 class="text-center">Last Month</h3>
      <table class="table">
      <thead>
        <tr>
          <td><b>Controller</b></td>
          <td><b>Time</b></td>
        </tr>
      </thead>
      <tbody>
      @foreach($last_month['set'] as $user)
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
    <h3 class="text-center">Positions</h3>
  <table class="table">
  <thead>
    <tr>
      <td><b>Position</b></td>
      <td><b>Time</b></td>
    </tr>
  </thead>
  <tbody>
  @foreach($positions as $set)
      <tr>
        <td>{{$set['position']}}</td>
        <td>{{$set['time']}}</td>
      </tr>
  @endforeach
  </tbody>
  </table>
  </div>
</div>
@stop
