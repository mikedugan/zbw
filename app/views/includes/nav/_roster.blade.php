<div class="row">
    <ul class="nav nav-tabs">
        <li class="<?php if(! $view) echo 'active'; ?>"><a href="/staff/roster">Roster</a></li>
        <li class="<?php if($view === 'staff') echo 'active'; ?>"><a href="?v=staff">Staff</a></li>
        <li class="<?php if($view === 'adopt') echo 'active'; ?>"><a href="?v=adopt">Adopt a Student</a></li>
        @if($me->is('Executive'))
            <li class="<?php if($view === 'groups') echo 'active'; ?>"><a href="?v=groups">Groups</a></li>
            <li class="<?php if($view === 'visitor') echo 'active'; ?>"><a href="?v=visitor">Visitor Requests</a></li>
            <li class="<?php if($view === 'inactive') echo 'active'; ?>"><a href="?v=inactive">Inactive</a></li>
            <li class="<?php if($view === 'controller') echo 'active'; ?>"><a href="?v=controller">Add Controller</a></li>
            <!--<li class="<?php if($view === 'staff') echo 'active'; ?>"><a href="?v=staff">Add Staff</a></li>-->
            <!--<li class="<?php if($view === 'remove') echo 'active'; ?>"><a href="?v=remove">Remove</a></li>-->
        @endif
    </ul>
</div>
