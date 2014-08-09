<?php use Zbw\Cms\MessagesRepository;
$me = Sentry::getUser();
$messages = $me ? MessagesRepository::newMessageCount($me->cid) : 0;
?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>
        @yield('title')
        | vZBW ARTCC</title>
    @include('includes._head')
    </head>
    <body>
    <nav class="navbar-default navbar">
        <?php $pages = \Page::all(); ?>
        @include('includes.nav._primary')
        @if($me)
            @include('includes.nav._user')
            @if($me->inGroup(\Sentry::findGroupByName('Staff')))
            @include('includes.nav._staff')
            @endif
        @else
            @include('includes.nav._login')
        @endif
        @yield('header')
    </nav>

    <div class="logopad">
        <div class="hidden ajax-success alert alert-success alert-dismissable"><span class="green glyphicons ok_2"></span>
            <button type="button" class="close pull-right" data-dismiss="alert" aria-hidden="true">&times;</button>
            <span class="message"></span>
        </div>
        <div class="hidden ajax-error alert alert-danger alert-dismissable"><span class="red glyphicons fire"></span>
            <button type="button" class="close pull-right" data-dismiss="alert" aria-hidden="true">&times;</button>
            <span class="message"></span>
        </div>
    @if(Session::get('flash_info'))
        <div class="alert alert-info alert-dismissable"><span class="blue glyphicons notes_2"></span>
            <button type="button" class="close pull-right" data-dismiss="alert" aria-hidden="true">&times;</button>
              {{  Session::get('flash_info') }}
        </div>
    @endif
    @if (Session::get('flash_success'))
        <div class="alert alert-success alert-dismissable"><span class="green glyphicons ok_2"></span>
                <button type="button" class="close pull-right" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{ Session::get('flash_success') }}
        </div>
    @endif
    @if (Session::get('flash_error'))
        <div class="alert alert-danger alert-dismissable"><span class="red glyphicons fire"></span>
            <button type="button" class="close pull-right" data-dismiss="alert" aria-hidden="true">&times;</button>
                @if(!is_string(Session::get('flash_error')))
                    @foreach(Session::get('flash_error')->toArray() as $error)
                        {{ $error[0] }}&nbsp;
                    @endforeach
                @else
                    {{ Session::get('flash_error') }}
                @endif
        </div>
    @endif
    @if (Session::get('flash_warning'))
        <div class="alert alert-warning alert-dismissable"><span class="orange glyphicon warning_sign"></span>
            <button type="button" class="close pull-right" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{ Session::get('flash_warning') }}
        </div>
    @endif
    </div>
    <div class="container">
      <div class="row">
        <div class="col-md-10 col-md-offset-1">
          @yield('content')
        </div>
      </div>
    </div>
    <footer class="clear text-center">
        @include('includes._footer')
    </footer>

    @include('includes._includes')
    </body>
</html>
