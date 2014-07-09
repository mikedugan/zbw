<div class="row">
    <ul class="nav nav-tabs">
        <li class="<?php if(! $view) echo 'active'; ?>"><a href="/staff/roster">Roster</a></li>
        <li class="<?php if($view === 'staff') echo 'active'; ?>"><a href="?v=staff">Staff</a></li>
        <li class="<?php if($view === 'groups') echo 'active'; ?>"><a href="?v=groups">Groups</a></li>
    </ul>
</div>
