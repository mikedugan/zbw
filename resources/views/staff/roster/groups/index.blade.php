@if(empty($id) && empty($action))
@include('staff.roster.groups.groups')
@else
@include('staff.roster.groups.edit')
@endif
