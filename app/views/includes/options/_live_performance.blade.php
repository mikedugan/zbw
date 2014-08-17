<div class="row form-horizontal">
    <label class="control-label col-md-4">{{$options['label']}}</label>
    <div class="col-md-2 checkbox">
        <label><input type="checkbox" value="true" name="review-{{$options['review_name']}}" class="reviewbox" data-subject="{{$options['subject']}}" id="review-{{$options['review_name']}}"> Reviewed</label>
    </div>
    <div class="form-group col-md-6">
        <select class="form-control performance" name="{{$options['grade_name']}}" id="{{$options['grade_name']}}">
            <option value="reqd">Select One</option>
            <option value="na">NA or Not Observed</option>
            <option value="u">Unsatisfactory</option>
            <option value="n">Needs Improvement</option>
            <option value="s">Satisfactory</option>
        </select>
    </div>
</div>
