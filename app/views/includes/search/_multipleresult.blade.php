<tr>
    <td><a href="/controllers/{{$r->cid}}">{{$r->first_name . ' ' . $r->last_name}}</a></td>
    <td>{{$r->cid}}</td>
    <td>{{$r->email}}</td>
    <td>{{$r->rating->short}}</td>
    @if($me->is('Staff'))
    <td><a href="/staff/{{$r->cid}}/edit">Edit</a></td>
    @endif
</tr>
