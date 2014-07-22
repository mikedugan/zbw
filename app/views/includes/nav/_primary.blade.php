<a class="hidden-sm hidden-xs" id="logo" href="{{ url('/') }}">{{ HTML::image('dist/images/zbw_logo.png', 'vZBW ARTCC') }}</a>
<ul class="col-sm-6 nav navbar-nav navbar-left">
    <li class="dropdown">
        <a href="/controllers" class="dropdown-toggle" data-toggle="dropdown">Controllers <b class="caret"></b></a>
        <ul class="dropdown-menu">
            <li><a href="/roster">Roster</a></li>
            @if(\Sentry::check())
            <li>{{ HTML::linkRoute('news', 'NOTAMS') }}</li>
            @endif
            <li><a href="/pages/sops">ZBW Resources</a></li>
            <li><a href="/pages/resources">Other Resources</a></li>
            <li><a href="#">ATC Pages</a>
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
            <li>{{ HTML::linkRoute('pilot-news', 'NOTAMS') }}</li>
            <li><a href="/pages/airports">Airports & Charts</a></li>
            <li><a href="#">About ZBW</a></li>
            <li><a href="#">Airports</a></li>
            <li><a href="/news">Events & News</a></li>
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
            <li><a href="#">NOTAMS</a></li>
            <li><a href="#">Pilots</a></li>
            @if(\Sentry::check())
            <li><a href="#">Controllers</a></li>
            @endif
            <li><a href="#">Off-Topic</a></li>
        </ul>
    </li>
</ul>
