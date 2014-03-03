<ul class="nav navbar-nav navbar-right col-md-1">
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ $me->initials }} <b class="caret"></b></a>
        <ul class="dropdown-menu">
            <li>{{ HTML::link($me->cid."/settings", 'Settings') }}</li>
            <li>{{ HTML::link('training', 'Training Center') }}</li>
            <li>{{ HTML::link($me->cid."/inbox", 'Messages') }}</li>
            <li>{{ HTML::link('schedule', 'Scheduler') }}</li>
            <li>{{ HTML::link('logout', 'Logout') }}</li>
        </ul>
    </li>
</ul>
