    <h1 class="text-center">New Message</h1>
    <div class="row">
        <form class="col-md-6 col-md-offset-3" action="/messages/send" method="post">
            <div class="form-group">
                {{ Form::label('to', 'To (Initials, Comma separated)') }}
                <input class="form-control" name="to" id="to" value="{{ $to }}">
            </div>
            <div class="form-group">
                {{ Form::label('subject', 'Subject') }}
                <input class="form-control" name="subject" id="subject">
            </div>
                {{ Form::label('message', 'Message') }}
                <textarea name="message" class="editor"></textarea>
                <button type="reset" class="btn-default">Clear</button>
                <button type="submit" class="btn-primary">Send</button>
            </div>
        </form>
    </div>
