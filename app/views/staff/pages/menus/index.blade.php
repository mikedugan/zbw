@extends('layouts.staff')
@section('title')
    Menu Management
@stop
@section('header')
@stop
@section('content')

<div class="row">
    <h1 class="text-center">CMS Menus</h1>
    <div class="col-md-5 col-md-offset-1">
        <h3 class="text-center">Current Menus</h3>
        <table class="table-striped">
            @if(count($menus) == 0)
            <p class="text-center">No menus! You can add one over on the right!</p>
            @else
            @foreach($menus as $menu)
            <tr>
                <td>{{ $menu->title }}</td>
                <td><?php implode(',', $menu->getLocation()) ?></td>
                <td><a href="/pages/menus/{{$menu->id}}/edit">Edit</a></td>
                <td><a href="/pages/menus/{{$menu->id}}/delete">Delete</a></td>
            </tr>
            @endforeach
            @endif
        </table>
    </div>
    <div class="col-md-2">
        <h4>Add Menu</h4>
        <form id="menuCreate"action="/pages/menus/create" method="post">
            <div class="input-group">
                <label class="control-label" for="title">Title</label>
                <input class="form-control" type="text" id="title" name="title">
            </div>
            <div class="input-group">
                <label class="control-label" for="location">Location</label><br>
                <select name="location[]" multiple>
                    <option value="pilots">Pilots</option>
                    <option value="controllers">Controllers</option>
                    <option value="staff">Staff</option>
                    <option value="forum">Forum</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Add</button>
        </form>
    </div>
    <div class="col-md-3">
        <h4>What are menus?</h4>
        <p>ZBW makes use of two different types of menus. We have permanent menus - the ones up top with links to various
        parts of the website. We also have more flexible menus to allow for the addition and removal of custom pages. Each
        of these menus will be added, with its assigned pages, to the locatio indicated.</p>
    </div>
</div>
@stop
