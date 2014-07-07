<h1 class="text-center">Add CMS Page</h1>
<form action="/staff/pages/create" method="post">
    <div class="row">
        <div class="col-md-6">
            <div class="row">
                <h3>Options</h3>
                <div class="form-group">
                    <label for="starts">Start Date</label>
                    <input type="text" value="{{\Input::old('start') or ''}}" class="form-control" name="start">
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <label for="ends">End Date</label>
                    <input type="text" value="{{\Input::old('end') or ''}}" class="form-control" name="end">
                </div>
            </div>
            <div class="row">
                <table class="table">
                    <thead>
                        <tr class="text-center">
                            <td colspan="3">Audience</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="text-center">
                            <td>
                                <input {{ \Input::old('audience') === 'pilots' ? 'selected' : ''}} type="radio" name="audience" value="pilots">Pilots</td>
                            <td>
                                <input {{ \Input::old('audience') === 'controllers' ? 'selected' : ''}} type="radio" name="audience" value="controllers">Controllers</td>
                            <td>
                                <input {{ \Input::old('audience') === 'staff' ? 'selected' : ''}} type="radio" name="audience" value="staff">Staff</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-6">
                <h3>Page Content</h3>
                <textarea class="editor" name="content" id="" cols="30" rows="10"></textarea>
                <input type="hidden" id="draft" name="draft">
                <p class="small">To use images: {IMAGE1}, {IMAGE2}, etc</p>
                <p class="small">You can use any valid HTML, scripts will be ignored.</p>
                 <div class="form-group">
                    {{ Form::file('image1', ['class' => 'file-control btn btn-default', 'title' => 'Browse for Image 1']) }}
                    {{ Form::file('image2', ['class' => 'file-control btn btn-default', 'title' => 'Browse for Image 2']) }}
                    {{ Form::file('image3', ['class' => 'file-control btn btn-default', 'title' => 'Browse for Image 3']) }}
                    {{ Form::file('image4', ['class' => 'file-control btn btn-default', 'title' => 'Browse for Image 4']) }}
                </div>
                <button type="submit" class="btn btn-success">Publish</button>
                <button type="submit" onclick="$('#draft').val('true');$('form').submit();" class="btn btn-info">Save Draft</button>
        </div>
    </div>
</form>
