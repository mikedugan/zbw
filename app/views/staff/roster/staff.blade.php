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
            <tr class="danger">
                <?php $u = \Sentry::findAllUsersInGroup(\Sentry::findGroupByName('ATM'))[0]; ?>
                <td><a href="/controllers/{{$u->cid}}">{{ $u->username }}</a></td>
                <td>Air Traffic Manager<?php if($u->is('Instructors')) { echo " / Instructor"; } else if ($u->is('Mentors')) { echo " / Mentor"; } ?></td>
                <td><a href="mailto:{{$u->email}}">{{ $u->email }}</a></td>
                <td>{{ $u->cid }}</td>
                <td>{{ $u->rating->short }}</td>
                <td><a class="btn btn-sm" href="/staff/{{$u->cid}}/edit">Edit</a></td>
            </tr>
            <tr class="danger">
                <?php $u = \Sentry::findAllUsersInGroup(\Sentry::findGroupByName('DATM'))[0]; ?>
                <td><a href="/controllers/{{$u->cid}}">{{ $u->username }}</a></td>
                <td>Deputy Air Traffic Manager<?php if($u->is('Instructors')) { echo " / Instructor"; } else if ($u->is('Mentors')) { echo " / Mentor"; } ?></td>
                <td><a href="mailto:{{$u->email}}">{{ $u->email }}</a></td>
                <td>{{ $u->cid }}</td>
                <td>{{ $u->rating->short }}</td>
                <td><a class="btn btn-sm" href="/staff/{{$u->cid}}/edit">Edit</a></td>
            </tr>
            <tr class="danger">
                <?php $u = \Sentry::findAllUsersInGroup(\Sentry::findGroupByName('TA'))[0]; ?>
                <td><a href="/controllers/{{$u->cid}}">{{ $u->username }}</a></td>
                <td>Training Administrator<?php if($u->is('Instructors')) { echo " / Instructor"; } else if ($u->is('Mentors')) { echo " / Mentor"; } ?></td>
                <td><a href="mailto:{{$u->email}}">{{ $u->email }}</a></td>
                <td>{{ $u->cid }}</td>
                <td>{{ $u->rating->short }}</td>
                <td><a class="btn btn-sm" href="/staff/{{$u->cid}}/edit">Edit</a></td>
            </tr>
            <tr class="warning">
                <?php $u = \Sentry::findAllUsersInGroup(\Sentry::findGroupByName('Events'))[0]; ?>
                <td><a href="/controllers/{{$u->cid}}">{{ $u->username }}</a></td>
                <td>Events Coordinator<?php if($u->is('Instructors')) { echo " / Instructor"; } else if ($u->is('Mentors')) { echo " / Mentor"; } ?></td>
                <td><a href="mailto:{{$u->email}}">{{ $u->email }}</a></td>
                <td>{{ $u->cid }}</td>
                <td>{{ $u->rating->short }}</td>
                <td><a class="btn btn-sm" href="/staff/{{$u->cid}}/edit">Edit</a></td>
            </tr>
            <tr class="warning">
                <?php $u = \Sentry::findAllUsersInGroup(\Sentry::findGroupByName('WEB'))[0]; ?>
                <td><a href="/controllers/{{$u->cid}}">{{ $u->username }}</a></td>
                <td>Webmaster<?php if($u->is('Instructors')) { echo " / Instructor"; } else if ($u->is('Mentors')) { echo " / Mentor"; } ?></td>
                <td><a href="mailto:{{$u->email}}">{{ $u->email }}</a></td>
                <td>{{ $u->cid }}</td>
                <td>{{ $u->rating->short }}</td>
                <td><a class="btn btn-sm" href="/staff/{{$u->cid}}/edit">Edit</a></td>
            </tr>
            <tr class="warning">
                <?php $u = \Sentry::findAllUsersInGroup(\Sentry::findGroupByName('FE'))[0]; ?>
                <td><a href="/controllers/{{$u->cid}}">{{ $u->username }}</a></td>
                <td>Facilities Engineer<?php if($u->is('Instructors')) { echo " / Instructor"; } else if ($u->is('Mentors')) { echo " / Mentor"; } ?></td>
                <td><a href="mailto:{{$u->email}}">{{ $u->email }}</a></td>
                <td>{{ $u->cid }}</td>
                <td>{{ $u->rating->short }}</td>
                <td><a class="btn btn-sm" href="/staff/{{$u->cid}}/edit">Edit</a></td>
            </tr>
        @foreach($staff as $u)
        @if($u->inGroup(\Sentry::findGroupByName('Instructors')) && $u->not('Executive') && $u->not('Events') && $u->not('WEB') && $u->not('FE'))
            <tr class="info">
            <td><a href="/controllers/{{$u->cid}}">{{ $u->username }}</a></td>
            <td>Instructor</td>
            <td><a href="mailto:{{$u->email}}">{{ $u->email }}</a></td>
            <td>{{ $u->cid }}</td>
            <td>{{ $u->rating->short }}</td>
            <td><a class="btn btn-sm" href="/staff/{{$u->cid}}/edit">Edit</a></td>
            </tr>
            @elseif($u->inGroup(\Sentry::findGroupByName('Mentors')) && $u->not('Executive') && $u->not('Events') && $u->not('WEB') && $u->not('FE'))
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
