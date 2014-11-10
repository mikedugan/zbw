<div class="col-md-8">
    <h3>Executive, Training, and Support Staff</h3>
    <table class="full table-bordered">
            <thead>
            <th>Name</th>
            <th>Position</th>
            <th>Email</th>
            <th>CID</th>
            <th>Rating</th>
            </thead>
            <tbody>
                <?php
                    if(! $atm) {
                        $atm = new User();
                        $atm->cid = 99999999;
                    }
                ?>
                @if($atm->cid == 99999999)
                <tr class="danger">
                    <td><a href="/controllers/{{$atm->cid}}">{{ $atm->username }}</a></td>
                    <td>Air Traffic Manager<?php if($atm->inGroup($instructors)) { echo " / Instructor"; } else if ($atm->inGroup($mentors)) { echo " / Mentor"; } ?></td>
                    <td><a href="mailto:{{$atm->email}}">{{ $atm->email }}</a></td>
                    <td>{{ $atm->cid }}</td>
                    <td>{{ $atm->rating->short }}</td>
                </tr>
                @endif
                <tr class="danger">
                    <td><a href="/controllers/{{$datm->cid}}">{{ $datm->username }}</a></td>
                    <td>Deputy Air Traffic Manager<?php if($datm->inGroup($instructors)) { echo " / Instructor"; } else if ($datm->inGroup($mentors)) { echo " / Mentor"; } ?></td>
                    <td><a href="mailto:{{$datm->email}}">{{ $datm->email }}</a></td>
                    <td>{{ $datm->cid }}</td>
                    <td>{{ $datm->rating->short }}</td>
                </tr>
                <tr class="danger">
                    <td><a href="/controllers/{{$ta->cid}}">{{ $ta->username }}</a></td>
                    <td>Training Administrator<?php if($ta->inGroup($instructors)) { echo " / Instructor"; } else if ($ta->inGroup($mentors)) { echo " / Mentor"; } ?></td>
                    <td><a href="mailto:{{$ta->email}}">{{ $ta->email }}</a></td>
                    <td>{{ $ta->cid }}</td>
                    <td>{{ $ta->rating->short }}</td>
                </tr>
                <tr class="warning">
                    <td><a href="/controllers/{{$events->cid}}">{{ $events->username }}</a></td>
                    <td>Events Coordinator<?php if($events->inGroup($instructors)) { echo " / Instructor"; } else if ($events->inGroup($mentors)) { echo " / Mentor"; } ?></td>
                    <td><a href="mailto:{{$events->email}}">{{ $events->email }}</a></td>
                    <td>{{ $events->cid }}</td>
                    <td>{{ $events->rating->short }}</td>
                </tr>
                <tr class="warning">
                    <td><a href="/controllers/{{$web->cid}}">{{ $web->username }}</a></td>
                    <td>Webmaster<?php if($web->inGroup($instructors)) { echo " / Instructor"; } else if ($web->inGroup($mentors)) { echo " / Mentor"; } ?></td>
                    <td><a href="mailto:{{$web->email}}">{{ $web->email }}</a></td>
                    <td>{{ $web->cid }}</td>
                    <td>{{ $web->rating->short }}</td>
                </tr>
                <tr class="warning">
                    <td><a href="/controllers/{{$fe->cid}}">{{ $fe->username }}</a></td>
                    <td>Facilities Engineer<?php if($fe->inGroup($instructors)) { echo " / Instructor"; } else if ($fe->inGroup($mentors)) { echo " / Mentor"; } ?></td>
                    <td><a href="mailto:{{$fe->email}}">{{ $fe->email }}</a></td>
                    <td>{{ $fe->cid }}</td>
                    <td>{{ $fe->rating->short }}</td>
                </tr>
            @foreach($staff_users as $u)

            @if($u->inGroup($instructors) && ($u->cid != $fe->cid && $u->cid != $events->cid && $u->cid != $atm->cid && $u->cid != $web->cid && $u->cid != $ta->cid && $u->cid != $datm->cid))
                <tr class="info">
                <td><a href="/controllers/{{$u->cid}}">{{ $u->username }}</a></td>
                <td>Instructor</td>
                <td><a href="mailto:{{$u->email}}">{{ $u->email }}</a></td>
                <td>{{ $u->cid }}</td>
                <td>{{ $u->rating->short }}</td>
                </tr>
                @elseif($u->inGroup($mentors) && ($u->cid != $fe->cid && $u->cid != $events->cid && $u->cid != $atm->cid && $u->cid != $web->cid && $u->cid != $ta->cid && $u->cid != $datm->cid))
                <tr class="success">
                    <td><a href="/controllers/{{$u->cid}}">{{ $u->username }}</a></td>
                    <td>Mentor</td>
                    <td><a href="mailto:{{$u->email}}">{{ $u->email }}</a></td>
                    <td>{{ $u->cid }}</td>
                    <td>{{ $u->rating->short }}</td>
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
