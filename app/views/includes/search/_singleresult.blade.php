<p>Name: <a href="/controllers/{{$results->cid}}">{{ $results->first_name . ' ' . $results->last_name }}</a></p>
<p>CID: {{ $results->cid }}</p>
<p>Email: {{ $results->email }}</p>
<p>Rating: {{ $results->rating->short }}</p>
@if($me->inGroup(\Sentry::findGroupByName('Staff')))
  {{ HTML::linkRoute('staff/{id}/edit', 'Edit Controller', [$results->cid]) }}
@endif
<img class="avatar" src="{{$results->avatar()}}">
