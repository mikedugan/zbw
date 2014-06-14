<p>Name: <a href="/staff/u/{{$results[0]->cid}}">{{ $results[0]->first_name . ' ' . $results[0]->last_name }}</a></p>
<p>CID: {{ $results[0]->cid }}</p>
<p>Email: {{ $results[0]->email }}</p>
<p>Rating: {{ $results[0]->rating->short }}</p>
