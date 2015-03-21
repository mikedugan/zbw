<h1 class="text-center">Edit "{{ $page->title }}"</h1>
<form id="pageEdit"action="/staff/pages/edit" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="row">
            <div class="col-md-12">
                <h3>Page Content</h3>
                <div class="form-group">
                    <label class="control-label" for="title">Title</label>
                    <input class="form-control" name="title" value="{{$page->title}}" id="title">
                </div>
                <input type="hidden" name="author" value="{{$page->author}}">
                <input type="hidden" name="pid" value="{{$page->id}}">
                <textarea class="editor" name="content" id="" cols="30" rows="10">{{$page->content}}</textarea>
                <input type="hidden" id="draft" name="draft">
                <p class="small">To use images: {IMAGE1}, {IMAGE2}, etc</p>
                <p class="small">You can use any valid HTML, scripts will be ignored.</p>
                <p class="small">Existing links will not be changed.</p>
                <div class="form-group">
                    {{ \Form::file('image1', ['class' => 'file-control btn btn-default', 'title' => 'Browse for Image 1']) }}
                    {{ \Form::file('image2', ['class' => 'file-control btn btn-default', 'title' => 'Browse for Image 2']) }}
                    {{ \Form::file('image3', ['class' => 'file-control btn btn-default', 'title' => 'Browse for Image 3']) }}
                    {{ \Form::file('image4', ['class' => 'file-control btn btn-default', 'title' => 'Browse for Image 4']) }}
                </div>
            </div>
            <div class="col-md-5">
                <table class="table">
                    <thead>
                    <tr class="text-center">
                        <td colspan="3">Audience</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="text-center">
                        @foreach(\AudienceType::all() as $type)
                        <td><input type="radio"
                                <?php if($page->audience_type_id === $type->id) echo "checked"; ?>
                                   value="{{$type->id}}" name="audience_type"> {{ucfirst($type->value)}}
                        </td>
                        @endforeach
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-5">
                <table class="table">
                    <thead>
                    <tr class="text-center">
                        <td colspan="3">Menus</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="text-center">
                        <td><input type="radio" name="menu" value="pilots"> Pilots</td>
                        <td><input type="radio" name="menu" value="controllers"> Controllers</td>
                        <td><input type="radio" name="menu" value="staff"> Staff</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <input type="hidden" name="published" id="published" value="1">
            <div class="col-md-6">
            <button type="submit" id="page-create" class="btn btn-success">Publish</button>
            <button type="submit" id="page-draft" onclick="$('#draft').val('true');$('form').submit();" class="btn btn-info">Save Draft</button>
                </div>
        </div>
    </div>
    </div>
</form>
