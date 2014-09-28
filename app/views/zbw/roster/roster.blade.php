<h1 class="text-center">ZBW Controllers</h1>
<div class="col-md-8">
    <h3>Current Roster</h3>
    <table class="full table-bordered">
        <thead>
        <th>Name</th>
        <th>Email</th>
        <th>CID</th>
        <th>Rating</th>
        </thead>
        @foreach($users as $u)
        @if($u->inGroup($executive))
        <tr class="danger">
        @elseif($u->inGroup($instructors))
        <tr class="warning">
        @elseif($u->inGroup($staff) || $u->inGroup($mentors))
        <tr class="info">
        @elseif($u->artcc !== 'ZBW')
        <tr class="success">
        @else
        <tr>
        @endif
            @if(!$u->activated)
            <td>
                <a style="color: #999" href="/controllers/{{$u->cid}}">{{ $u->username }}</a>
                &nbsp;<span class="orange glyph-sm glyphicons circle_exclamation_mark pointer" title="User is inactive"></span>
            </td>
            @else
            <td><a href="/controllers/{{$u->cid}}">{{ $u->username . ' (' . $u->initials . ')'}}</a></td>
            @endif
            <td>
                @if(isset($u->settings->email_hidden) && $u->settings->email_hidden == 0)
                <a href="mailto:{{ $u->email }}">{{$u->email}}</a>
                @else
                <i>Hidden</i>
                @endif
            </td>
            <td>{{ $u->cid }}</td>
            <td>{{ $u->rating->short }}</td>
        </tr>
        @endforeach
    </table>
    {{ $users->links() }}
</div>
<div class="col-md-4">
    <h3>Search Controllers</h3>
    @include('includes.search._controller_public')
    <br>
    <p class="info">Mentor</p>
    <p class="warning">Instructor</p>
    <p class="danger">ARTCC Staff</p>
    <p class="success">Visiting Controller</p>
</div>
