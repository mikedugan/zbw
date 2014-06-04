    <h1 class="text-center">My Outbox</h1>
    <div class="col-md-12">
        <table class="table table-striped">
            <thead>
                <th>Date</th>
                <th>To</th>
                <th>Subject</th>
                <th></th>
            </thead>
            <tbody>
                @foreach($outbox as $message)
                    <tr>
                        <td>{{$message->created_at->toFormattedDateString()}}</td>
                        <td>{{$message->recipient->initials or '??'}}</td>
                        <td>{{$message->subject}}</td>
                        <td><a href="/messages/m/{{$message->id}}">View</a> | <a href="/messages/m/{{$message->id}}/delete">Delete</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
