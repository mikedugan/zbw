@foreach($news as $n)
	<article>
		<h3>{{ $n->title }}</h3>
		<p>{{ $n->content }}</p>
	</article>
@endforeach