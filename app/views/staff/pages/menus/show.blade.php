@extends('layouts.staff')
@section('title')
    {{ $menu->title }}
@stop
@section('header')
    @include('includes.nav._pages')
@stop
@section('content')
    <h1 class="text-center">View Menu '{{ $menu->title }}'</h1>
    <div class="row">
        <div class="col-md-6">
            <form action="/pages/menus/{{$menu->id}}/update" method="post">
                <div class="input-group">
                    <label class="label-control" for="title">Title</label>
                    <input class="form-control" type="text" name="title" id="title">
                </div>
                <div class="input-group">
                    <label class="control-label" for="location">Location</label>
                    <label><input type="checkbox" value="pilots" name="pilots"> Pilots</label>
                    <label><input type="checkbox" value="controllers" name="controllers"> Controllers</label>
                    <label><input type="checkbox" value="forum" name="forum"> Forum</label>
                    <label><input type="checkbox" value="staff" name="staff"> Staff</label>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
            <form action="/pages/menus/{{$menu->id}}/delete" method="post">
                <p class="small">Any assigned pages will be orphaned when you delete this menu!</p>
                <button type="submit" class="btn btn-warning">Delete</button>
            </form>
        </div>
        <div class="col-md-6">
            <h3 class="text-center">Assigned Pages</h3>
            <table class="table-striped">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>URL</th>
                    </tr>
                </thead>
                @foreach($menu->pages as $page)
                    <tr>
                        <td>{{ $page->title }}</td>
                        <td><a href="/pages/{{ $page->getUrlPath() }}">http://bostonartcc.net/pages/{{ $page->getUrlPath() }}</a></td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@stop
