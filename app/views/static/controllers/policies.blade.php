@extends('layouts.master')
@section('title')
ZBW Policies
@stop
@section('content')
<h1 class="text-center">Boston ARTCC Controller Policies</h1>
<div class="row">
  <div class="col-md-12">
    <p>As a ZBW controller, it is important you review each of these policies prior to the start of training. They cover topics you are expected to comply with in addition to VATSIM and VATUSA regulations.</p>
    <div class="col-md-4">
      <ul>
        <li>{{ HTML::linkRoute('training-outline', 'Training Outline') }}</li>
        <li>{{ HTML::linkRoute('policies/sign-on-off', 'Sign On/Off Policy') }}</li>
        <li>{{ HTML::linkRoute('policies/position-restrictions', 'Position Restrictions') }}</li>
        <li>{{ HTML::linkRoute('policies/visiting-transfer', 'Visitor and Transfer Policy') }}</li>
        <li>{{ HTML::linkRoute('policies/roster-removal', 'Roster Removal') }}</li>
      </ul>
    </div>
  </div>
</div>
@stop
