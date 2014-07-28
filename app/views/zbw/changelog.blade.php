@extends('layouts.master')
@section('title')
Changelog
@stop
@section('content')
<h1 class="text-center">Changelog</h1>
<h3>v2.0.4b</h3>
mikedugan rm teamspeak from staff routes, fix some things with news <br>
mikedugan fixed email in search results, fixed message link on user view <br>
mikedugan feedback controller list sorted by last update <br>
mikedugan fixed private message reply bug <br>
mikedugan login fix <br>
mikedugan patched up student commenting and exam review view <br>
mikedugan fixed exam commenting, added badge for status, and reopen button <br>
mikedugan fixed exam commenting and made training requests more obvious <br>
<h3>v2.0.3b</h3>
mikedugan fixes #52 feedback <br>
mikedugan fixes #53, adds report link to training request <br>
mikedugan fixes #54 <br>
mikedugan disable mail for dev, work on staff view <br>
mikedugan refactoring of repositories to use appropriate validation <br>
Mike Dugan Merge branch 'master' into 'develop' <br>
mikedugan all eloquent models now extend  BaseModel <br>
mikedugan validation rules and refactoring <br>
mikedugan typo in route <br>
<h3>v2.0.2b</h3>
mikedugan pilot feedback up and running<br>
mikedugan did some visual work to clean up air traffic on front page<br>
mikedugan fixed staffing parsing from datafeed<br>
mikedugan training session accept/drop notifications complete<br>
mikedugan added email functiosn<br>
mikedugan fixes #45 (training request date)<br>
mikedugan added more notifications for training sessions<br>
mikedugan refactor automated messages to use views<br>
mikedugan added base model and validation<br>
<h3>v2.0.1b</h3>
mikedugan fixes #41 fixes #43 (nonexistent user data / user seeders)<br>
mikedugan fixes #46 #47 (training request dates)<br>
mikedugan fixed training requests<br>
mike fixes #39 (search by single cid)<br>
mike fixes #44 (public groups page removed)<br>
<h3>v2.0.0b</h3>
mikedugan fixed roster import bug and a couple issues with roster views<br>
mikedugan typo<br>
mikedugan fixes #28 #29<br>
mikedugan damned queues<br>
mikedugan fixed profile information display<br>
mikedugan fixed training session and staffing view<br>
mikedugan numerous fixes and updates to training and permissions<br>
mikedugan fixed 403 pages<br>
@stop
