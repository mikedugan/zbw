<a class="hidden-sm hidden-xs" id="logo" href="{{ url('/') }}">{{ HTML::image('dist/images/zbw_logo_alt.png', 'vZBW ARTCC') }}</a>
<ul class="col-sm-8 nav navbar-nav navbar-right">
    @if($me)
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                @if($messages > 0)
                <span class="red">{{ $me->initials }}</span> <b class="caret"></b></a>
                @else
                <span>{{ $me->initials }}</span> <b class="caret"></b></a>
                @endif
            <ul class="dropdown-menu">
                <li>{{ HTML::link("/me/profile", 'Profile') }}</li>
                <li>{{ HTML::link('/training', 'Training Center') }}</li>
                <li><a href="/messages">Messages
                        @if($messages > 0)
                        <span class="sans badge bg-info">{{ $messages }}</span>
                        @endif
                    </a></li>
                <li>{{ HTML::link('/schedule', 'Scheduler') }}</li>
                <li>{{ HTML::link('/logout', 'Logout') }}</li>
            </ul>
        </li>
      @if($me->inGroup(\Sentry::findGroupByName('Staff')))
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Staff <b class="caret"></b></a>
            <ul class="dropdown-menu">
                @if($me->hasAccess('roster.all'))
                <li>{{ HTML::link('staff/roster', 'Roster') }}</li>
                @endif
                @if($me->hasAccess('reports.view'))
                <li>{{ HTML::link('staff/training', 'Training') }}</li>
                @endif
                <li style="display:none">{{ HTML::link('staff/ts', 'Teamspeak') }}</li>
                <li>{{ HTML::link('staff/news', 'News & Events') }}</li>
                @if($me->hasAccess('files.sector'))
                <li>{{ HTML::linkRoute('staff.files', 'Files') }}</li>
                @endif
                @if($me->hasAccess('pages.all'))
                <li>{{ HTML::linkRoute('poker', 'Poker') }}</li>
                <li>{{ HTML::linkRoute('staff/feedback', 'Feedback') }}</li>
                <li>{{ HTML::link('staff/pages', 'Pages') }}</li>
                @endif
                <li style="display:none"><a href="#">Staff Pages</a>
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
        @endif
    @else
      @if(App::environment('production'))
      <li class="dropdown"><a href="/auth">Login</a></li>
      @else
      <li class="dropdown"><a href="#" data-toggle="modal" data-target="#loginModal">Login</a></li>
      @endif
    @endif
    <li class="dropdown">
            <a href="/controllers" class="dropdown-toggle" data-toggle="dropdown">Controllers <b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li><a href="/roster">Roster</a></li>
                @if(\Sentry::check())
                <li>{{ HTML::linkRoute('news', 'NOTAMS') }}</li>
                @endif
                <li>{{ HTML::linkRoute('controllers/policies', 'ZBW Policies') }}</li>
                <li>{{ HTML::linkRoute('controllers.resources', 'Resources') }}</li>
                <li>{{ HTML::linkRoute('statistics', 'Statistics') }}</li>
                <li style="display:none"><a href="#">ATC Pages</a>
                    <ul>
                        @foreach($pages as $page)
                            @if($page->audience_type_id === 1 || $page->audience_type_id === 3)
                            <li><a href="/pages/{{$page->slug}}">{{$page->title}}</a></li>
                            @endif
                        @endforeach
                    </ul>
                </li>
            </ul>
        </li>
        <li class="dropdown">
            <a href="/pilots" class="dropdown-toggle" data-toggle="dropdown">Pilots <b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li>{{ HTML::linkRoute('pilots', 'Home') }}</li>
                <li>{{ HTML::linkRoute('pilot-news', 'NOTAMS') }}</li>
                <li>{{ HTML::linkRoute('feedback', 'Feedback') }}</li>
                <li>{{ HTML::linkRoute('pilots/airports', 'Airports') }}</li>
                <li><a href="#">Pilot Pages</a>
                    <ul>
                        @foreach($pages as $page)
                        @if($page->audience_type_id === 1 || $page->audience_type_id === 2)
                        <li><a href="/pages/{{$page->slug}}">{{$page->title}}</a></li>
                        @endif
                        @endforeach
                    </ul>
                </li>
            </ul>
        </li>
        <li class="dropdown">
            <a href="/forum" class="dropdown-toggle" data-toggle="dropdown">Forum <b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li><a href="/forum">Home</a></li>
                <li><a href="/forum/index.php?board=2.0">NOTAMS</a></li>
                <li><a href="/forum/index.php?board=10.0">Pilots</a></li>
                @if(\Sentry::check())
                <li><a href="/forum/index.php?board=5.0">Controllers</a></li>
                @endif
                <li><a href="/forum/index.php?board=3.0">General Discussion</a></li>
            </ul>
        </li>
</ul>
@include('includes._modal_login')
