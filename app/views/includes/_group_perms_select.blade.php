<select name="{{ $selecttitle }}" id="{{ $selecttitle }}" class="form-control">
    <option value="">Select One</option>
    @if($options === 'cvuda')
    <option value="5">All</option>
    <option value="4">Delete</option>
    <option value="3">Update</option>
    <option value="2">Create</option>
    <option value="1">View</option>
    <option value="0">None</option>
    @elseif($options === 'files')
    <option value="4">Delete</option>
    <option value="3">All Uploads</option>
    <option value="2">Sector Files</option>
    <option value="1">Forum/Images Only</option>
    <option value="0">None</option>
    @elseif($options === 'sessions')
    <option value="2">Cancel</option>
    <option value="1">Accept/Drop</option>
    <option value="0">None</option>
    @endif
</select>
