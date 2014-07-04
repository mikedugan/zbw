<h1 class="text-center">ZBW Groups</h1>
<div class="row">
    <div class="col-md-6">
        <h3 class="text-center">Current Groups</h3>
        <table class="table table-striped">
            <thead>
            <tr>
                <td>Group</td>
                <td></td>
                <td></td>
            </tr>
            </thead>
            <tbody>
            @foreach($groups as $group)
            <tr>
                <td>{{ $group->name }}</td>
                <td><a href="?v=groups&id={{$group->id}}&action=edit">Edit</a></td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="col-md-6">
        <h3 class="text-center">Add Group</h3>
        {{ Form::open(['route' => 'staff/roster/add-group']) }}
        <div class="form-group">
            {{ Form::label('name', 'Group Name', ['class' => 'control-label']) }}
            {{ Form::text('name', '', ['class' => 'form-control']) }}
        </div>
        <div class="form-group">
            <label for="members" class="control-label">Members</label><span class="small"> (comma separated initials)</span>
            {{ Form::text('members', '', ['class' => 'form-control']) }}
        </div>
        <h4 class="text-center">Permissions <span class="small">Leave as "Select One" to inherit</span></h4>
        <div class="form-group">
            {{ Form::label('base_group', 'Base Group', ['class' => 'control-label']) }}
            <select class="form-control" name="base_group" id="base_group">
                <option value="0">None</option>
                @foreach($groups as $group)
                <option value="{{ $group->id }}">{{ $group->name }}</option>
                @endforeach
            </select>
        </div>
        <hr/>
        <div class="row">
            @foreach(\Config::get('zbw.permission_group_info') as $perm)
            <div class="form-group col-sm-4">
                {{ Form::label($perm[0], $perm[1], ['class' => 'control-label']) }}
                @include('includes._group_perms_select', ['selecttitle' => $perm[0], 'options' => \Config::get('zbw.permission_sets')[$perm[2]]])
            </div>
            @endforeach
        </div>
        {{ Form::submit('Create', ['class' => 'btn btn-primary']) }}
        {{ Form::close() }}
    </div>
</div>
