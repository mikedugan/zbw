@extends('layouts.staff')
@section('content')
    <div class="col-md-12">
        <h1 class="text-center">Search Results</h1>
    <div class="col-md-6">
    @if(count($results) == 1)
        @include('includes.search._singleresult')
    @else
        <table class="table table-striped">
            <thead>
            <th>Name</th>
            <th>CID</th>
            <th>Email</th>
            <th>Rating</th>
            </thead>
    @foreach($results as $r)
        @include('includes.search._multipleresult')
    @endforeach
    </table>
    @endif
    </div>
        <div class="col-md-6">
            @include('includes.search._controller')
        </div>
    </div>
@stop
