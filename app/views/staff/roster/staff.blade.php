<h1 class="text-center">ZBW Staff</h1>
<div class="col-md-8">
    <h3>ZBW Staff</h3>
    <table class="full table-bordered">
        <thead>
        <th>Name</th>
        <th>Position</th>
        <th>Email</th>
        <th>CID</th>
        <th>Rating</th>
        <th>Edit</th>
        </thead>
        @foreach($staff as $u)
        @if($u->is_ta || $u->is_atm || $u->is_datm || $u->is_webmaster)
        <tr class="danger">
            @elseif($u->is_instructor)
        <tr class="warning">
            @elseif($u->is_staff || $u->is_mentor)
        <tr class="info">
            @elseif($u->artcc !== 'ZBW')
        <tr class="success">
            @else
        <tr>
            @endif
            <td><a href="/controllers/{{$u->cid}}">{{ $u->username }}</a></td>
            <td>
                @if($u->is_atm)
                ATM
                @elseif($u->is_datm)
                DATM
                @elseif($u->is_ta)
                TA
                @elseif($u->is_webmaster)
                Webmaster
                @elseif($u->is_fe)
                FE
                @endif
                @if($u->is_instructor)
                 Instructor
                @endif
                @if($u->is_mentor)
                 Mentor
                @endif
            </td>
            <td>{{ $u->email }}</td>
            <td>{{ $u->cid }}</td>
            <td>{{ $u->rating->short }}</td>
            <td><a class="btn btn-sm" href="/staff/{{$u->cid}}/edit">Edit</a></td>
        </tr>
        @endforeach
    </table>
</div>
<div class="col-md-4">
    <h3>Contact Staff</h3>
    @include('includes._staffcontact')
</div>
