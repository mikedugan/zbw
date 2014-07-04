<h1 class="text-center">Edit Group</h1>
<div class="row">
    <div class="col-md-6">
        <h3 class="text-center">{{$group->name}}</h3>
        <h5>Members</h5>
        @foreach($members as $member)
            <p>{{ $member->username }} ({{$member->initials}})</p>
        @endforeach
    </div>
    <div class="col-md-6">
        @foreach($group->permissions as $k => $v)
            <?php
                $perm_title = explode('.', $k);
                if($v === 1 && $perm_title[1] != 'none') {
                    $perm_title = 'Can '.str_replace('all', 'administer', $perm_title[1]).' '.$perm_title[0];
                }
                else if($v === 1 && $perm_title[1] == 'none') {
                    $perm_title = 'Cannot '.$perm_title[1].' '.$perm_title[0];
                }
            echo '<p>'.$perm_title.'</p>';
            ?>
        @endforeach
    </div>
</div>
