@extends('layouts.master')
@section('title')
ZBW Flights
@stop
@section('content')
<h1 class="text-center">ZBW Traffic</h1>
<div class="strip row text-left">
    <table class="table">
    <tbody>
    @foreach($flights as $flight)
			<tr style="border-top:2px solid #555;border-left:2px solid #555;border-right:2px solid #555;
			@if(in_array($flight->destination, \Config::get('zbw.airports')))
			  background: #eee;
			@endif
			">
				<td>{{ $flight->callsign }}</td>
				<td>{{ $flight->departure }}</td>
				<td>{{ $flight->route }}</td>
				<td>{{ $flight->name }}</td>
			</tr>
      <tr style="border-bottom:2px solid #555;border-left:2px solid #555;border-right:2px solid #555;
      @if(in_array($flight->destination, \Config::get('zbw.airports')))
        background: #eee;
      @endif
      ">
          <td>{{ $flight->aircraft }}</td>
          <td>{{ $flight->destination }}</td>
          <td>{{ $flight->altitude }}</td>
          <td>
              @if($flight->eta == 0)
              ETE: under 1 hour</td>
              @else
              ETE: {{ $flight->eta }} hours</td>
              @endif
      </tr>
    @endforeach
        </tbody>
    </table>
</div>
@stop
