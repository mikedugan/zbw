<div class="row">
    <ul class="nav nav-tabs">
        <li class="<?php if(! $view) echo 'active'; ?>"><a href="/me/settings">Profile</a></li>
        <li class="<?php if($view == 'settings') echo 'active'; ?>"><a href="?v=settings">Settings</a></li>
        <li class="<?php if($view == 'subscriptions') echo 'active'; ?>"><a href="?v=subscriptions">Subscriptions</a></li>
        <li><a href="/messages">Messages</a></li>
    </ul>
</div>
