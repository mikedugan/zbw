<div class="row">
    <ul class="nav nav-tabs">
        <li class="<?php if (!$v) {echo 'active';}?>"><a href="/staff/pages">Pages</a></li>
        <li class="<?php if ($v == 'create') {echo 'active';}?>"><a href="?v=create">Create</a></li>
        <li class="<?php if ($v == 'edit') {echo 'active';}?>"><a href="?v=edit">Edit</a></li>
        <li class="<?php if ($v == 'trash') {echo 'active';}?>"><a href="?v=trash">Trash</a></li>
        <li class="<?php if ($v == 'menus') {echo 'active';}?>"><a href="?v=menus">Menus</a></li>
	</ul>
</div>
