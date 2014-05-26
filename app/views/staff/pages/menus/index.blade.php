@extends('layouts.staff')
@section('title')
    Menu Management
@stop
@section('header')
    @include('includes.nav._pages')
@stop
@section('content')

{{-- PAGE --}}

<div class="row">
    <h1 class="text-center">CMS Menus</h1>
    <div class="col-md-6">
        <h3 class="text-center">Current Menus</h3>
        <table class="table-striped">
            @foreach($menus as $menu)
            <tr>
                <td>{{ $menu->title }}</td>
                <td>{{ $menu->location }}</td>
                <td><a href="/pages/menus/{{$menu->id}}/edit">Edit</a></td>
                <td><a href="/pages/menus/{{$menu->id}}/delete">Delete</a></td>
            </tr>
            @endforeach
        </table>
    </div>
    <div class="col-md-6">
        <h3 class="text-center">Add Menu</h3>
        <form action="/pages/menus/create" method="post">
            <div class="input-group">
                <label class="control-label" for="title">Title</label>
                <input class="form-control" type="text" id="title" name="title">
            </div>
            <div class="input-group">
                <label class="control-label" for="location">Location</label>
                <label><input type="checkbox" value="pilots" name="pilots"> Pilots</label>
                <label><input type="checkbox" value="controllers" name="controllers"> Controllers</label>
                <label><input type="checkbox" value="forum" name="forum"> Forum</label>
                <label><input type="checkbox" value="staff" name="staff"> Staff</label>
            </div>
            <button type="submit" class="btn btn-primary">Add</button>
        </form>
    </div>
</div>
