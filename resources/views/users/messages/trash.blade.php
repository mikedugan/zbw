    <h1 class="text-center">My Trash</h1>
    <div class="col-md-12">
        <table class="table table-striped">
            <thead>
                <th>Date</th>
                <th>From</th>
                <th>Subject</th>
                <th></th>
            </thead>
            <tbody>
                @foreach($trash as $message)
                    @if($message->is_read == 0)
                    <tr class="new-message">
                    @else
                    <tr>
                    @endif
                        <td>{{$message->created_at->toFormattedDateString()}}</td>
                        <td>{{$message->sender->initials}}</td>
                        <td>{{$message->subject}}</td>
                    <td>{{\HTML::linkRoute('messages/{mid}', 'View', [$message->id])}} | {{\HTML::linkRoute('messages/{mid}/restore', 'Restore', [$message->id])}} | {{\HTML::linkRoute('messages/{mid}/delete', 'Delete', [$message->id])}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
