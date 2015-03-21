<h1 class="text-center">Edit Group</h1>
<div class="row">
    <div class="col-md-6">
        {{ \Form::open(['route' => 'staff/roster/edit-group', 'method' => 'POST', 'id' => 'groupEdit']) }}
            <input type="hidden" value="{{$group->id}}" name="group_id">

            <h3 class="text-center">{{$group->name}}</h3>

            <div class="form-group">
                <label for="name" class="control-label">Group Name</label>
                <input type="text" name="name" id="name" class="form-control"
                       value="{{ $group->name }}">
            </div>
            <div class="form-group">
                {{ \Form::label('new_users', 'Add Users', ['class' =>
                'control-label']) }}
                {{ \Form::text('new_users', '', ['class' => 'form-control']) }}
            </div>
            <div class="form-group">
                {{ \Form::label('remove_users', 'Remove Users', ['class' =>
                'control-label']) }}
                {{ \Form::text('remove_users', '', ['class' => 'form-control'])
                }}
            </div>
            <div class="row">
                @foreach(\Config::get('zbw.permission_group_info') as $perm)
                <div class="form-group col-sm-4">
                    {{ \Form::label($perm[0], $perm[1], ['class' => 'control-label']) }}
                    @include('includes._group_perms_select', ['selecttitle' => $perm[0], 'existing' => $group->truePermissions(), 'options' => \Config::get('zbw.permission_sets')[$perm[2]]])
                </div>
                @endforeach
            </div>
            {{ \Form::submit('Update', ['class' => 'btn btn-primary']) }}
        {{ \Form::close() }}
    </div>
    <div class="col-md-6">
        <div class="col-md-6">
            <h5>Members</h5>
            @foreach($members as $member)
            <p>{{ $member->username }} ({{$member->initials}})</p>
            @endforeach
        </div>
        <div class="col-md-6">
            <h5>Permissions</h5>
            @foreach($group->permissions as $k => $v)
            <?php
            $perm_title = explode('.', $k);
            if ($v === 1 && $perm_title[1] != 'none') {
                $perm_title = 'Can ' . str_replace(
                    'all',
                    'administer',
                    $perm_title[1]
                  ) . ' ' . $perm_title[0];
            } else {
                if ($v === 1 && $perm_title[1] == 'none') {
                    $perm_title = 'Cannot ' . $perm_title[1] . ' ' . $perm_title[0];
                }
            }
            echo '<p>' . $perm_title . '</p>';
            ?>
            @endforeach
        </div>
    </div>
</div>
<div class="row">
    <form class="axform confirm"
          data-warning="Any users depending on this group for permissions will no longer have access!"
          action="/staff/roster/groups/{{$group->id}}/delete" method="post">
        <button class="btn btn-danger">Delete Group</button>
    </form>
</div>
