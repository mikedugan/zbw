<!DOCTYPE html>
<html>
    <head>
    <title>{{ $title }}</title>
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

    <div id="content" class="col-md-12 center-block">
    @if(Session::get('flash_info'))
        <div class="flash flash-info"><span class="glyphicon glyphicon-info-sign blue">
              {{  Session::get('flash_info') }}
        </span></div>
    @endif
    @if (Session::get('flash_success'))
        <div class="flash flash-success"><span class="glyphicon glyphicon-thumbs-up green">
                {{ Session::get('flash_success') }}
        </span></div>
    @endif
    @if (Session::get('flash_info'))
        <div class="flash flash-error"><span class="glyphicon glyphicon-fire red">
                {{ Session::get('flash_error') }}
        </span></div>
    @endif
    @if (Session::get('flash_warning'))
        <div class="flash flash-error"><span class="glyphicon glyphicon-warning-sign orange">
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