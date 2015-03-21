@extends('layouts.staff')
@section('title')
Search Results
@stop
@section('content')
    <div class="col-md-12">
        <h1 class="text-center">Search Results</h1>
    <div class="col-md-6">
        <?php if(count($results) == 1 && ! $results instanceof \Zbw\Users\UserPresenter) { $results = $results[0]; } ?>
    @if(count($results) == 1)
        @include('includes.search._singleresult')
    @else
        <table class="table table-striped">
            <thead>
            <th>Name</th>
            <th>CID</th>
            <th>Email</th>
            <th>Rating</th>
            @if($me->is('Staff'))
            <th>Edit</th>
            @endif
            </thead>
    @foreach($results as $r)
        @include('includes.search._multipleresult')
    @endforeach    </table>
    @endif
    </div>
        <div class="col-md-6">
            @include('includes.search._controller')
        </div>
    </div>
@stop
