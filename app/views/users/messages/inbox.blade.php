
    <h1 class="text-center">My Inbox</h1>
    <div class="col-md-12 subnav">
        <form class="axform" style="margin:0;" action="/markallread" method="post">
            <button type="submit" class="btn btn-xs">Mark All as Read</button>
        </form>
        @if($unread == 'true')
        <a href="/messages" class="btn btn-xs">Show All</a>
        @else
        <a href="/messages?unread=true" class="btn btn-xs">Show Unread</a>
        @endif
    </div>
    <div class="col-md-12">
        <table class="table table-striped">
            <thead>
                <th>Date</th>
                <th>From</th>
                <th>Subject</th>
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
                        <td>{{$message->sender->initials}}</td>
                        <td>{{$message->subject}}</td>
                        <td>{{HTML::linkRoute('messages/{mid}', 'View', [$message->id])}} | {{HTML::linkRoute('messages/{mid}/delete', 'Delete', [$message->id])}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
