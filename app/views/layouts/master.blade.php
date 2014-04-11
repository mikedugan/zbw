<!DOCTYPE html>
<html>
    <head>
    <title>{{ $title }} | vZBW ARTCC</title>
    @include('includes._head')
    </head>
    <body>
    <nav class="navbar-default navbar">
        @include('includes._header')
        @if($me)
            @include('includes.nav._user')
            @if($me->is_staff)
            @include('includes.nav._staff')
            @endif
        @else
            @include('includes.nav._login')
        @endif
        @yield('header')
    </nav>

    <div id="content" class="col-md-10 center-block">
    @if(Session::get('flash_info'))
        <div class="alert alert-info alert-dismissable"><span class="glyphicon glyphicon-info-sign blue">
            <button type="button" class="close pull-right" data-dismiss="alert" aria-hidden="true">&times;</button>
              {{  Session::get('flash_info') }}
        </span></div>
    @endif
    @if (Session::get('flash_success'))
        <div class="alert alert-success alert-dismissable"><span class="glyphicon glyphicon-thumbs-up green">
                <button type="button" class="close pull-right" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{ Session::get('flash_success') }}
        </span></div>
    @endif
    @if (Session::get('flash_info'))
        <div class="alert alert-error alert-dismissable"><span class="glyphicon glyphicon-fire red">
            <button type="button" class="close pull-right" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{ Session::get('flash_error') }}
        </span></div>
    @endif
    @if (Session::get('flash_warning'))
        <div class="alert alert-warning alert-dismissable"><span class="glyphicon glyphicon-warning-sign orange">
            <button type="button" class="close pull-right" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{ Session::get('flash_warning') }}
        </span></div>
    @endif
    @yield('content')
    </div>

    <footer class="clear text-center">
        @include('includes._footer')
    </footer>

    @include('includes._includes')
    @yield('inc')
    </body>
</html>
