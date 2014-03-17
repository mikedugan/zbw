<a id="logo" href="{{ url('/') }}">{{ HTML::image('images/zbw_logo.png', 'vZBW ARTCC') }}</a>
<ul class="col-md-6 nav navbar-nav navbar-left">
        <li class="left"><a href="{{  url('controllers') }}">Controllers</a></li>
        <li class="left"><a href="{{  url('pilots') }}">Pilots</a></li>
        <li class="left">{{ HTML::link('forum', 'Forum') }}</li>
    </ul>
