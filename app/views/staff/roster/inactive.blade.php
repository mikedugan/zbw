<h1 class="text-center">Inactive Controllers</h1>
<table>
    <thead>
    <tr>
        <td>CID</td>
        <td>Initials</td>
        <td>Email</td>
        <td>Last Controlled</td>
        <td>Last Login</td>
        <td></td>
    </tr>
    </thead>
    <tbody>
@foreach($users as $user)
    <tr>
        <td>{{ $user->cid }}</td>
        <td>{{ $user->initials }}</td>
        <td>{{ $user->email }}</td>
        <td>{{ \Staffing::whereCid($user->cid)->latest()->first()->created_at->toDayDateTimeString() }}</td>
        <td>{{ $user->last_login->toDayDateTimeString() }}</td>
        <td>
        <form class="axform col-md-12" action="/r/terminate/{{$user->cid}}" method="post">
                <button type="submit" class="btn col-md-6 btn-xs btn-danger">Terminate User</button>
        </form>
        </td>
    </tr>
@endforeach
</tbody>
</table>
