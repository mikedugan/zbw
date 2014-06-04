<form action="/u/{{$me->cid}}/settings/update" method="post">
    <div class="col-md-12">
        <div class="input-group">
            {{ Form::label('email', 'Email'); }}
            <input type="text" name="me[email]" id="email" value="{{$me->email}}" class="form-control">
        </div>
        <div class="input-group">
        <p><b>Email Hidden:</b> {{ Form::checkbox('Hidden', 'hidden', false); }}</p>
        </div>
        <div class="input-group">
        <p><b>Signature:</b></p>
        <textarea class="form-control" cols="40" rows="5">{{ $me->signature}}</textarea>
        </div>
    </div>
    <div class="col-md-12">
        <div class="input-group">
            <label class="label-control" for="tskey">Teamspeak Key</label>
            <input class="form-control" name="tskey" id="tskey" type="text">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </div>
</form>
