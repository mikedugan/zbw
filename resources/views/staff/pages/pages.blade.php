<h1 class="text-center">
	Welcome to the ZBW CMS
</h1>
<div class="row">
    <div class="col-md-12">
        @foreach($pages as $page)
            <div class="col-md-6">
                {{ $page->title }} - <a href="/staff/pages/?v=edit&id={{$page->id}}">Edit</a>
            </div>
            <div class="col-md-6">
                {{ $page->content }}
            </div>
        @endforeach
    </div>
</div>
