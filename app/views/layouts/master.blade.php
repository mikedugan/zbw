<!DOCTYPE html>
<html>
    <head>
    <title>
    @yield('title')
    | vZBW ARTCC</title>
    @include('includes._head')
    </head>
    <body>
    <nav class="navbar-default navbar">
        @include('includes.nav._primary')
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

    <div class="logopad">
        <div class="hidden ajax-success alert alert-success alert-dismissable"><span class="glyphicon glyphicon-thumbs-up green"></span>
            <button type="button" class="close pull-right" data-dismiss="alert" aria-hidden="true">&times;</button>
            <span class="message"></span>
        </div>
        <div class="hidden ajax-error alert alert-danger alert-dismissable"><span class="glyphicon glyphicon-fire red"></span>
            <button type="button" class="close pull-right" data-dismiss="alert" aria-hidden="true">&times;</button>
            <span class="message"></span>
        </div>
    @if(Session::get('flash_info'))
        <div class="alert alert-info alert-dismissable"><span class="glyphicon glyphicon-info-sign blue"></span>
            <button type="button" class="close pull-right" data-dismiss="alert" aria-hidden="true">&times;</button>
              {{  Session::get('flash_info') }}
        </div>
    @endif
    @if (Session::get('flash_success'))
        <div class="alert alert-success alert-dismissable"><span class="glyphicon glyphicon-thumbs-up green"></span>
                <button type="button" class="close pull-right" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{ Session::get('flash_success') }}
        </div>
    @endif
    @if (Session::get('flash_error'))
        <div class="alert alert-danger alert-dismissable"><span class="glyphicon glyphicon-fire red"></span>
            <button type="button" class="close pull-right" data-dismiss="alert" aria-hidden="true">&times;</button>
                @if(is_array(Session::get('flash_error')))
                    @foreach(Session::get('flash_error') as $error)
                        {{ $error[0] }}&nbsp;
                    @endforeach
                @else
                    {{ Session::get('flash_error') }}
                @endif
        </div>
    @endif
    @if (Session::get('flash_warning'))
        <div class="alert alert-warning alert-dismissable"><span class="glyphicon glyphicon-warning-sign orange"></span>
            <button type="button" class="close pull-right" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{ Session::get('flash_warning') }}
        </div>
    @endif
    </div>
    @yield('content')

    <footer class="clear text-center">
        @include('includes._footer')
    </footer>

    @include('includes._includes')
    </body>
</html>
