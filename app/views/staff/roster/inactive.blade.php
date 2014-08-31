<h1 class="text-center">Inactive Controllers</h1>
<table class="table table-bordered">
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
        <td>{{ $staffings[$user->cid] or 'N/A' }}</td>
        <td>{{ $user->last_login or 'N/A' }}</td>
        <td>
        <form class="axform col-md-12" action="/r/terminate/{{$user->cid}}" method="post">
                <button type="submit" class="btn col-md-6 btn-xs btn-danger">Terminate User</button>
        </form>
        </td>
    </tr>
@endforeach
</tbody>
</table>
