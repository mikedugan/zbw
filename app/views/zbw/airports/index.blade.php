@extends('layouts.master')
@section('title')
    ZBW Airports
@stop
@section('content')
    <p>Sort:
        <a href="/pilots/airports?sort=tracon">by Tracon</a> |
        <a href="/pilots/airports?sort=alpha">Alphabetically</a> |
        <a href="/pilots/airports?sort=airspace">by Airspace</a>
     (Click ICAO code to view Airnav)</p>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ICAO</th>
                <th>Name</th>
                <th>Location</th>
                <th>TRACON</th>
                <th>Airspace</th>
            </tr>
        </thead>
        <tbody>
        @foreach($airports as $airport)
            <tr>
                <td><a target="_new" href="http://airnav.com/airport/{{ $airport->icao }}">{{ $airport->icao }}</a></td>
                <td>{{ $airport->name }}</td>
                <td>{{ $airport->location }}</td>
                <td>{{ $airport->tracon }}</td>
                <td>{{ $airport->airspace }}</td>
            </tr>
            <tr>
                <td colspan="5">
                @foreach($airport->frequencies as $freq)
                    <span class="col-md-4"><em>{{ $freq->name }}</em> : <b style="font-family:monospace">{{ $freq->freq1 }}</b></span>
                @endforeach
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@stop
