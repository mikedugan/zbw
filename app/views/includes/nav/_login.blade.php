<form action="{{ URL::to('login') }}" method="post">
<ul class="nav navbar-nav navbar-right col-md-5">
    <li>username <input type="text" name="username"></li>
    <li>password <input type="password" name="password"></li>
    <button type="submit" class="btn btnprimary">login</button>
</ul>
</form>