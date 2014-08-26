@extends('layouts.master')
@section('title')
Changelog
@stop
@section('content')
<h1 class="text-center">Changelog</h1>
<h3>2.0.11b</h3>
mikedugan wip refactoring auth <br>
mikedugan adopt a user to command, training controller updated <br>
mikedugan refactored training session grader to command <br>
mikedugan damned html <br>
mikedugan accordions on training index <br>
mikedugan refactored training index to view presenters <br>
mikedugan added presenters, removed unused migrations <br>
mikedugan Merge branch 'working' of git.mjdugan.com:mike/zbw into working <br>
mikedugan added message nav to individual views <br>
mikedugan fixed missing cid in messages controller <br>
mikedugan updated message sending to use commands <br>
mikedugan converted recent activity on profile to panels <br>
mikedugan fixed avatar uploads <br>
mikedugan refactored a bunch of things to command/handler, fixed user settings <br>
mikedugan updated online indicator size <br>
<h3>2.0.10b</h3>
mikedugan fixed position online indicator <br>
mikedugan added some responsive helpers <br>
mikedugan homstead and bugsnag user check" <br>
mikedugan fixed responsive slideshow bug <br>
mikedugan updated model docs <br>
mikedugan pilots with dotted routes <br>
<h3>2.0.9b</h3>
mikedugan added js toggle for home page metars <br>
mikedugan home page changes, added position online indicator <br>
mikedugan added breadcrumbs to forum <br>
mikedugan added select prompts and JS checking <br>
mikedugan replaced redactor with froala, optimized js includes <br>
mikedugan refactor a few classes, add documentation, add Message service class <br>
mikedugan rm unnecessary stuff <br>
mikedugan adopt a user <br>
mike global refactoring <br>
<h3>2.0.8b</h3>
mikedugan wip on promotions <br>
mikedugan added automatic promotion messages <br>
mikedugan finished visitor application processing <br>
mikedugan working on visitor applications <br>
mikedugan added staff contact, fixed alert size <br>
mikedugan some responsive changes, roster order updated' <br>
mikedugan added a bunch more static pages <br>
mikedugan more work on new user email <br>
mikedugan finished up new user emails <br>
mikedugan airport links now go to airnav <br>
mikedugan added static pilot info pages <br>
mikedugan style updates to forum <br>
<h3>v2.0.7b</h3>
mikedugan added the new forum <br>
mikedugan added wrong questions to staff exam review <br>
mikedugan added spinner for controller info loading <br>
mikedugan added visiting controller application <br>
mikedugan added idiot proofing for exams <br>
mikedugan first round of exam review population <br>
mikedugan wip <br>
mikedugan added edit/delete for exam questions <br>
mikedugan added support for importing and creating exam questions <br>
mikedugan Merge branch 'working' of git.mjdugan.com:mike/zbw into working <br>
<h3>v2.0.6b</h3>
mikedugan all exams view with filters <br>
mikedugan view all requests with filtering <br>
mikedugan added view for all models with filtering <br>
mikedugan fixes #48 #12 live training view <br>
mikedugan added global error handling for (most) ModelNotFound <br>
mikedugan fixes #65 carbon <br>
mikedugan fixed metar display <br>
mikedugan added phpdocs to models <br>
<h3>v2.0.5b</h3>
mikedugan fixes message size <br>
mikedugan set perms so mtr/ins cant see reviews/requests they cant give <br>
mikedugan added training badges <br>
Erik Malmstrom-Partridge Id's for validation <br>
mikedugan removed timer, scoring now event based <br>
mikedugan resolves #50 #51 #6 live training sessions <br>
Mike Dugan Merge branch 'working' into 'develop' <br>
mikedugan fixed datafeed parser <br>
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
