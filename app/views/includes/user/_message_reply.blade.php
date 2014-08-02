<input type="hidden" name="to" value="{{$message->from}}">
<input type="hidden" name="history" value="{{$message->content}}">
<div class="form-group">
    <span>Forget History? </span><input name="forget_history" value="forget" type="checkbox" class="checkbox-inline">
</div>
<div class="form-group">
    <label for="cc">CC <span class="text-muted">(initials, comma separated)</span> :</label>
    <input class="form-control" type="text" name="cc" id="cc" style="max-width:80%;float:left;">
    <div style="vertical-align: bottom" class="form-group-btn">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">Users <span class="caret"></span></button>
        <ul id="userlist" class="dropdown-menu pull-right">
            @foreach($users as $user)
            @unless($user->cid == 100)
            <li data-name="{{$user->first_name . ' ' . $user->last_name}}" data-initials="{{$user->initials}}">{{$user->first_name . ' ' . $user->last_name . ' ('.$user->initials.')'}}</li>
            @endunless
            @endforeach
        </ul>
    </div>
</div>
<div class="form-group">
    <label for="subject">Subject</label>
    <input class="form-control" type="text" name="subject" id="subject" value="re: {{$message->subject}}">
    </div>
<div class="form-group">
    <label for="message">Message</label>
    <textarea class="editor" name="content"
      data-bv-notempty="true"
      data-bv-notempty-message="Please enter a message"></textarea>
    </div>
<button type="submit" class="btn btn-primary">Send</button>
