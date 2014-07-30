<form id="loginSubmit" action="/login" method="post">
<ul id="nav-login" class="nav navbar-nav navbar-right col-md-5">
    @if(App::environment('production'))
    <li class="pull-right"><a href="/auth">Login</a></li>
    @else
    <li class="pull-right"><a href="#" data-toggle="modal" data-target="#loginModal">Login</a></li>
    @endif
</ul>
</form>
@include('includes._modal_login')
