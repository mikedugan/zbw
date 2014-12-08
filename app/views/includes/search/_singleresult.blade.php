<p>Name: <a href="/controllers/{{$results->cid}}">{{ $results->first_name . ' ' . $results->last_name }}</a></p>
<p>CID: {{ $results->cid }}</p>
<p>Email: {{ $results->email }}</p>
<p>Rating: {{ $results->rating->short }}</p>
@if(\Sentry::check() && $me->inGroup(\Sentry::findGroupByName('Staff')))
  <p>{{ HTML::linkRoute('staff/{id}/edit', 'Edit Controller', [$results->cid]) }}</p>
  <p><a href="/staff/{{$results->cid}}/training">View Training</a></p>
@endif
<img class="avatar" src="{{$results->avatar()}}">
