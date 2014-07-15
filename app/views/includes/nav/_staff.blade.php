<ul class="nav navbar-nav navbar-right col-sm-2">
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Staff <b class="caret"></b></a>
        <ul class="dropdown-menu">
            <li>{{ HTML::link('staff/roster', 'Roster') }}</li>
            <li>{{ HTML::link('staff/training', 'Training') }}</li>
            <li>{{ HTML::link('staff/ts', 'Teamspeak') }}</li>
            <li>{{ HTML::link('staff/news', 'News & Events') }}</li>
            <li>{{ HTML::linkRoute('poker', 'Poker') }}</li>
            <li>{{ HTML::link('staff/pages', 'Pages') }}</li>
            <li><a href="#">Staff Pages</a>
                <ul>
                    @foreach($pages as $page)
                    @if($page->audience_type_id === 4)
                    <li><a href="/pages/{{$page->slug}}">{{$page->title}}</a></li>
                    @endif
                    @endforeach
                </ul>
            </li>
        </ul>
    </li>
</ul>
