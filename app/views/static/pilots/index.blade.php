@extends('layouts.master')
@section('title')
ZBW Pilots
@stop
@section('content')
<h1 class="text-center">Pilot Resource Home</h1>
<div class="row">
    <div class="col-md-12">
      <p>Welcome to Boston ARTCC! Whether you'll be flying in or out of any of our over 100 spectacular airports, our controllers are here to provide you with top-notch ATC every mile of the way.</p>
      <p>Check out the links below for more information on getting started and flying in ZBW!</p>
      <ul>
        <li>{{ HTML::linkRoute('pilots/getting-started', 'Getting Started') }}</li>
        <li>{{ HTML::linkRoute('pilots/vfr-tutorial', 'VFR Tutorial') }}</li>
        <li>{{ HTML::linkRoute('pilots/airports', 'Airports') }}</li>
      </ul>
    </div>
    </div>
@stop
