<h1 class="text-center">Roster Admin</h1>
<div class="row">
<div class="col-md-9">
    <h3>Current Roster</h3>
    <a href="?num=all">View All</a>
    <a href="?num=active">View Active</a>
    <table class="full table-bordered">
        <thead>
        <th>Name</th>
        <th>Email</th>
        <th>CID</th>
        <th>Rating</th>
        <th>Edit</th>
        <th>Training</th>
        </thead>
        @foreach($users as $u)
        @if(in_array($u->cid, $executive))
        <tr class="danger">
        @elseif(in_array($u->cid, $instructors))
        <tr class="warning">
        @elseif(in_array($u->cid, $staff))
        <tr class="info">
        @elseif($u->artcc !== 'ZBW')
        <tr class="success">
        @else
        <tr>
        @endif
            @if(!$u->activated)
            <td>
                <a style="color: #999" href="/controllers/{{$u->cid}}">{{ $u->username }}</a>
                &nbsp;<span class="orange glyph-sm glyphicons circle_exclamation_mark pointer" title="User is suspended"></span>
            </td>
            @elseif($u->is_terminated)
            <td>
                <a style="color: #999" href="/controllers/{{$u->cid}}">{{ $u->username }}</a>
                &nbsp;<span class="red glyph-sm glyphicons circle_exclamation_mark pointer" title="User is terminated"></span>
            </td>
            @else
            <td><a href="/controllers/{{$u->cid}}">{{ $u->username }}</a></td>
            @endif
            <td>{{ $u->email }}</td>
            <td>{{ $u->cid }}</td>
            <td>{{ $u->rating->short }}</td>
            <td><a class="btn btn-sm" href="/staff/{{$u->cid}}/edit">Edit</a></td>
            <td><a class="btn btn-sm" href="#">Training</a></td>
        </tr>
        @endforeach
    </table>
    @if(! \Input::has('num'))
        {{ $users->links() }}
    @endif
</div>
<div class="col-md-3">
    <h3>Search Controllers</h3>
    @include('includes.search._controller')
    <br>
    <p class="info">Mentor</p>
    <p class="warning">Instructor</p>
    <p class="danger">ARTCC Staff</p>
    <p class="success">Visiting Controller</p>
</div>
</div>
