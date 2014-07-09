<h1 class="text-center">ZBW Controllers</h1>
<div class="col-md-8">
    <h3>Current Roster</h3>
    <span>Results per page:
        <a href="/staff/roster?num=10">10</a>
        <a href="/staff/roster?num=25">25</a>
        <a href="/staff/roster?num=50">50</a>
    </span>
    <table class="full table-bordered">
        <thead>
        <th>Name</th>
        <th>Email</th>
        <th>CID</th>
        <th>Rating</th>
        </thead>
        @foreach($users as $u)
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
            @if($u->is_suspended)
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
        </tr>
        @endforeach
    </table>
    {{ $users->links() }}
</div>
<div class="col-md-4">
    <h3>Search Controllers</h3>
    @include('includes.search._controller')
</div>
