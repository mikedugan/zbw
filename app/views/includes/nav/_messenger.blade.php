<ul class="nav navbar-nav navbar-right col-sm-2">
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Messages <b class="caret"></b></a>
        <ul class="dropdown-menu">
            <li>{{ HTML::linkRoute('inbox', 'Inbox') }}</li>
            <li>{{ HTML::linkRoute('outbox', 'Outbox') }}</li>
            <li>{{ HTML::linkRoute('pm-compose', 'Compose') }}</li>
            <li>{{ HTML::linkRoute('pm-trash', 'Trash') }}</li>
        </ul>
    </li>
</ul>
