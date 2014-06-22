<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">vZBW Login</h4>
      </div>
      <div class="modal-body">
      <div class = "col-md-6">
        <form action="/login" method="post">
        	<div class="input-group">
        		<label for="username">Username</label>
        		<input class="form-control" type="text" name="username" id="username">
        	</div>
        	<div class="input-group">
        		<label for="password">Password <a href="/password/remind">Forgot Password?</a></label>
        		<input class="form-control" type="password" name="password" id="password">
        	</div>
        	<div class="input-group">
      			<span class="input-group-addon">
        			<input type="checkbox">
      			</span>
      			<input disabled value="Remember Me" type="text" class="form-control">
    		</div><!-- /input-group -->
      </div>
      <div class = "col-md-6">
          <img src='/images/zbw_logo.png'>
      </div>
      <div class="modal-footer text-left">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Login</button>
        </form>
      </div>
    </div>
  </div>
  </div>
</div>
