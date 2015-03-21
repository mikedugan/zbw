@foreach($news as $n)
	<article>
		<h3><a href="/news/{{$n->id}}">{{ $n->title }}</a></h3>
		<p>{{ $n->content }}</p>
        <p class="small">{{ Zbw\Core\Helpers::timeAgo($n->created_at) }}</p>
	</article>
@endforeach
