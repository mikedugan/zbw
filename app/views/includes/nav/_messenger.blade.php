<div class="row">
    <ul class="nav nav-tabs">
        <li class="<?php if(! $view) echo 'active'; ?>"><a href="/messages">Inbox</a></li>
        <li class="<?php if($view == 'outbox') echo 'active'; ?>"><a href="?v=outbox">Outbox</a></li>
        <li class="<?php if($view == 'compose') echo 'active'; ?>"><a href="?v=compose">Compose</a></li>
        <li class="<?php if($view == 'trash') echo 'active'; ?>"><a href="?v=trash">Trash</a></li>
    </ul>
</div>

