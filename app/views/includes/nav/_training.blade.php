<div class="row">
    <ul class="nav nav-tabs">
        <li class="<?php if(Request::path() == 'staff/training') echo 'active'; ?>"><a href="/staff/training">Overview</a></li>
        <li class="<?php if(Request::path() == 'staff/training/new') echo 'active'; ?>"><a href="/staff/training/new">New Training Session</a></li>
        <li class="<?php if(Request::path() == 'staff/training/availability') echo 'active'; ?>"><a href="/staff/training/availability">Staff Availability</a></li>
        @if($me->is('Instructors') || $me->is('Executive'))
        <li class="<?php if(Request::path() == 'staff/exams/questions') echo 'active'; ?>"><a href="/staff/exams/questions">Exam Questions</a></li>
        @endif
    </ul>
</div>
