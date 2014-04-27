<ul class="dropdown-menu">
    @foreach($users as $user)
    <li>{{$user->first_name . ' ' . $user->last_name . ' ('.$user->initials.')'}}</li>
    @endforeach
</ul>
