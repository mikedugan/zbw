<h1 class="text-center">ZBW Staff</h1>
<div class="col-md-8">
    <h3>ZBW Staff</h3>
    <table class="full table-bordered">
        <thead>
        <th>Name</th>
        <th>Position</th>
        <th>Email</th>
        <th>CID</th>
        <th>Rating</th>
        <th>Edit</th>
        </thead>
        <tbody>
            <?php
                if(! $atm) {
                    $atm = new User();
                    $atm->cid = 99999999;
                    $atm->rating = new \stdClass();
                    $rating->short = 'VACANT';
                }
            ?>
            @if($atm->cid == 99999999)
            <tr class="danger">
                <td><a href="/controllers/{{$atm->cid}}">{{ $atm->username }}</a></td>
                <td>Air Traffic Manager<?php if(in_array($atm->cid, $instructors)) { echo " / Instructor"; } else if (in_array($atm->cid, $mentors)) { echo " / Mentor"; } ?></td>
                <td><a href="mailto:{{$atm->email}}">{{ $atm->email }}</a></td>
                <td>{{ $atm->cid }}</td>
                <td>{{ $atm->rating->short }}</td>
                <td><a class="btn btn-sm" href="/staff/{{$atm->cid}}/edit">Edit</a></td>
            </tr>
            @endif
            <tr class="danger">
                <td><a href="/controllers/{{$datm->cid}}">{{ $datm->username }}</a></td>
                <td>Deputy Air Traffic Manager<?php if(in_array($datm->cid, $instructors)) { echo " / Instructor"; } else if (in_array($datm->cid, $mentors)) { echo " / Mentor"; } ?></td>
                <td><a href="mailto:{{$datm->email}}">{{ $datm->email }}</a></td>
                <td>{{ $datm->cid }}</td>
                <td>{{ $datm->rating->short }}</td>
                <td><a class="btn btn-sm" href="/staff/{{$datm->cid}}/edit">Edit</a></td>
            </tr>
            <tr class="danger">
                <td><a href="/controllers/{{$ta->cid}}">{{ $ta->username }}</a></td>
                <td>Training Administrator</td>
                <td><a href="mailto:{{$ta->email}}">{{ $ta->email }}</a></td>
                <td>{{ $ta->cid }}</td>
                <td>{{ $ta->rating->short }}</td>
                <td><a class="btn btn-sm" href="/staff/{{$ta->cid}}/edit">Edit</a></td>
            </tr>
            <tr class="warning">
                <td><a href="/controllers/{{$events->cid}}">{{ $events->username }}</a></td>
                <td>Events Coordinator<?php if(in_array($events->cid, $instructors)) { echo " / Instructor"; } else if (in_array($events->cid, $mentors)) { echo " / Mentor"; } ?></td>
                <td><a href="mailto:{{$events->email}}">{{ $events->email }}</a></td>
                <td>{{ $events->cid }}</td>
                <td>{{ $events->rating->short }}</td>
                <td><a class="btn btn-sm" href="/staff/{{$events->cid}}/edit">Edit</a></td>
            </tr>
            <tr class="warning">
                <td><a href="/controllers/{{$web->cid}}">{{ $web->username }}</a></td>
                <td>Webmaster<?php if(in_array($web->cid, $instructors)) { echo " / Instructor"; } else if (in_array($web->cid, $mentors)) { echo " / Mentor"; } ?></td>
                <td><a href="mailto:{{$web->email}}">{{ $web->email }}</a></td>
                <td>{{ $web->cid }}</td>
                <td>{{ $web->rating->short }}</td>
                <td><a class="btn btn-sm" href="/staff/{{$web->cid}}/edit">Edit</a></td>
            </tr>
            <tr class="warning">
                <td><a href="/controllers/{{$fe->cid}}">{{ $fe->username }}</a></td>
                <td>Facilities Engineer<?php if(in_array($fe->cid, $instructors)) { echo " / Instructor"; } else if (in_array($fe->cid, $mentors)) { echo " / Mentor"; } ?></td>
                <td><a href="mailto:{{$fe->email}}">{{ $fe->email }}</a></td>
                <td>{{ $fe->cid }}</td>
                <td>{{ $fe->rating->short }}</td>
                <td><a class="btn btn-sm" href="/staff/{{$fe->cid}}/edit">Edit</a></td>
            </tr>
        @foreach($staff_users as $u)
        @if(in_array($u->cid, $instructors) && ! in_array($u->cid, [$atm->cid, $datm->cid, $ta->cid, $fe->cid, $events->cid, $web->cid]))
            <tr class="info">
            <td><a href="/controllers/{{$u->cid}}">{{ $u->username }}</a></td>
            <td>Instructor</td>
            <td><a href="mailto:{{$u->email}}">{{ $u->email }}</a></td>
            <td>{{ $u->cid }}</td>
            <td>{{ $u->rating->short }}</td>
            <td><a class="btn btn-sm" href="/staff/{{$u->cid}}/edit">Edit</a></td>
            </tr>
            @elseif(in_array($u->cid, $mentors) && ! in_array($u->cid, [$atm->cid, $datm->cid, $ta->cid, $fe->cid, $events->cid, $web->cid]))
            <tr class="success">
                <td><a href="/controllers/{{$u->cid}}">{{ $u->username }}</a></td>
                <td>Mentor</td>
                <td><a href="mailto:{{$u->email}}">{{ $u->email }}</a></td>
                <td>{{ $u->cid }}</td>
                <td>{{ $u->rating->short }}</td>
                <td><a class="btn btn-sm" href="/staff/{{$u->cid}}/edit">Edit</a></td>
            </tr>
        @endif
        @endforeach
        </tbody>
    </table>
</div>
<div class="col-md-4">
    <h3>Contact Staff</h3>
    @include('includes._staffcontact')
</div>
