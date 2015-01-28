    <h1 class="text-center">My Inbox</h1>
    <div class="col-md-12 subnav">
        {{ HTML::linkRoute('messages.allread', 'Mark All Read', null, ['class' => 'btn btn-xs']) }}
        @if($unread == 'true')
        <a href="/messages" class="btn btn-xs">Show All</a>
        @else
        <a href="/messages?unread=true" class="btn btn-xs">Show Unread</a>
        @endif
    </div>
    {{ Form::open() }}
    <div class="col-md-12">
        <table class="table table-striped">
            <thead>
                <th>Date</th>
                <th>From</th>
                <th>Subject</th>
                <th>Select</th>
                <th></th>
            </thead>
            <tbody>
                @foreach($inbox as $message)
                    @if($message->is_read == 0)
                    <tr class="new-message">
                    @else
                    <tr>
                    @endif
                        <td>{{$message->created_at->toFormattedDateString()}}</td>
                        <td>{{$message->sender->initials or 'User Deleted'}}</td>
                        <td>{{$message->subject}}</td>
                        <td><input type="checkbox" name="selected[]" value="{{ $message->id }}"/></td>
                        <td>{{HTML::linkRoute('messages/{mid}', 'View', [$message->id])}} | {{HTML::linkRoute('messages/{mid}/delete', 'Delete', [$message->id])}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pull-right text-right col-md-6">
            <div class="form-group col-md-4 col-md-offset-6">
                <select name="action" class="form-control">
                    <option value="delete">Delete</option>
                    <option value="read">Mark Read</option>
                </select>
            </div>
            <button type="submit" class="pull-right btn btn-primary">Execute</button>
        </div>
    </div>
    {{ Form::close() }}
