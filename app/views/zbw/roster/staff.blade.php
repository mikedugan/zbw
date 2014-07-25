<h1 class="text-center">Boston ARTCC Staff</h1>
<div class="col-md-8">
    <h3>Executive, Training, and Support Staff</h3>
    <table class="full table-bordered">
        <thead>
        <th>Name</th>
        <th>Position</th>
        <th>Email</th>
        <th>CID</th>
        <th>Rating</th>
        </thead>
        @foreach($staff as $u)
            <tr>
            <td><a href="/controllers/{{$u->cid}}">{{ $u->username }}</a></td>
            <td>
                @if($u->is('ATM'))
                ATM
                @elseif($u->is('DATM'))
                DATM
                @elseif($u->is('TA'))
                TA
                @elseif($u->is('WEB'))
                Webmaster
                @elseif($u->is('FE'))
                FE
                @endif
                @if($u->is('Instructors'))
                 Instructor
                @elseif($u->is('Mentors'))
                 Mentor
                @endif
            </td>
            <td>{{ $u->email }}</td>
            <td>{{ $u->cid }}</td>
            <td>{{ $u->rating->short }}</td>
        </tr>
        @endforeach
    </table>
</div>
<div class="col-md-4">
    <h3>Contact Staff</h3>
    @include('includes._staffcontact')
</div>
