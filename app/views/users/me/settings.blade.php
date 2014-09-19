<div class="col-md-6">
    <form id='meUpdate'action="/me/profile" method="post" enctype="multipart/form-data">
        {{ Form::hidden('update', 'settings') }}
        <h3 class="text-center">Profile Settings</h3>
        <div class="form-group">
            {{ Form::label('email', 'Email') }}
            <span title="Email is synced with VATSIM, please go to vatsim.net to change it!" class="pointer pull-right blue glyphicons circle_info"></span>
            <input disabled type="text" name="email" id="email" value="{{$me->email}}" class="form-control">
        </div>
        <div class="form-group">
        <p><b>Email Hidden:</b> {{ Form::checkbox('email_hidden', 'true', $me->settings->email_hidden ? 'true': ''); }}</p>
        </div>
        <div class="form-group">
        <p><b>Signature:</b></p>
        <textarea name="signature" id="signature" class="editor form-control" cols="40" rows="5">{{$me->settings->signature}}</textarea>
        </div>
        <div class="form-group">
            <label class="label-control" for="ts_key">Teamspeak Key</label>
            <input class="form-control" name="ts_key" id="ts_key" value="{{ $me->settings->ts_key }}" type="text">
        </div>
        <div class="row">
          <div class="form-group col-md-6">
              {{ Form::label('avatar', 'Avatar') }}
              {{ Form::file('avatar', ['class' => 'file-control btn btn-default', 'title' => 'Browse for Avatar']) }}
              <p class="small">We will use <a href="http://gravatar.com">Gravatar</a> by default</p>
          </div>
          <div class="col-md-6">
              <img src="{{ $me->avatar() }}" class="responsive avatar pull-right">
          </div>
        </div>
        <button type="submit" class="btn btn-block btn-primary">Update</button>
    </form>
    </div>
    <div class="col-md-6">
        <form action="/me/profile" method="post">
            {{ Form::hidden('update', 'notifications') }}
        <h3 class="text-center">Global Notifications</h3>
        <table class="table table-striped">
            <thead>
            <tr>
                <td>Notification</td>
                <td>None</td>
                <td>Message</td>
                <td>Email</td>
                <td>Both</td>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>New Message</td>
                <td><input type="radio" name="n_private_message" {{ $me->settings->n_private_message === "0" ? 'checked' : '' }} value="0"></td>
                <td><input type="radio" name="n_private_message" {{ $me->settings->n_private_message === "1" ? 'checked' : '' }} value="1" disabled></td>
                <td><input type="radio" name="n_private_message" {{ $me->settings->n_private_message === "2" ? 'checked' : '' }} value="2"></td>
                <td><input type="radio" name="n_private_message" {{ $me->settings->n_private_message === "3" ? 'checked' : '' }} value="3" disabled></td>
            </tr>
            <tr style="display:none">
                <td>Exam Assigned</td>
                <td><input type="radio" name="n_exam_assigned" {{ $me->settings->n_exam_assigned === "0" ? 'checked' : '' }} value="0"></td>
                <td><input type="radio" name="n_exam_assigned" {{ $me->settings->n_exam_assigned === "1" ? 'checked' : '' }} value="1"></td>
                <td><input type="radio" name="n_exam_assigned" {{ $me->settings->n_exam_assigned === "2" ? 'checked' : '' }} value="2"></td>
                <td><input type="radio" name="n_exam_assigned" {{ $me->settings->n_exam_assigned === "3" ? 'checked' : '' }} value="3"></td>
            </tr>
            <tr>
                <td>Exam Comment</td>
                <td><input type="radio" name="n_exam_comment" {{ $me->settings->n_exam_comment === "0" ? 'checked' : '' }} value="0"></td>
                <td><input type="radio" name="n_exam_comment" {{ $me->settings->n_exam_comment === "1" ? 'checked' : '' }} value="1"></td>
                <td><input type="radio" name="n_exam_comment" {{ $me->settings->n_exam_comment === "2" ? 'checked' : '' }} value="2"></td>
                <td><input type="radio" name="n_exam_comment" {{ $me->settings->n_exam_comment === "3" ? 'checked' : '' }} value="3"></td>
            </tr>
            <tr>
                <td>Training Request Accepted</td>
                <td><input type="radio" name="n_training_accepted" {{ $me->settings->n_training_accepted === "0" ? 'checked' : '' }} value="0"></td>
                <td><input type="radio" name="n_training_accepted" {{ $me->settings->n_training_accepted === "1" ? 'checked' : '' }} value="1"></td>
                <td><input type="radio" name="n_training_accepted" {{ $me->settings->n_training_accepted === "2" ? 'checked' : '' }} value="2"></td>
                <td><input type="radio" name="n_training_accepted" {{ $me->settings->n_training_accepted === "3" ? 'checked' : '' }} value="3"></td>
            </tr>
            <tr>
                <td>Training Request Cancelled</td>
                <td><input type="radio" name="n_training_cancelled" {{ $me->settings->n_training_cancelled === "0" ? 'checked' : '' }} value="0"></td>
                <td><input type="radio" name="n_training_cancelled" {{ $me->settings->n_training_cancelled === "1" ? 'checked' : '' }} value="1"></td>
                <td><input type="radio" name="n_training_cancelled" {{ $me->settings->n_training_cancelled === "2" ? 'checked' : '' }} value="2"></td>
                <td><input type="radio" name="n_training_cancelled" {{ $me->settings->n_training_cancelled === "3" ? 'checked' : '' }} value="3"></td>
            </tr>
            <tr style="display:none">
                <td style="display:none;">New Events</td>
                <td><input type="radio" name="n_events" {{ $me->settings->n_events === "0" ? 'checked' : '' }} value="0"></td>
                <td><input type="radio" name="n_events" {{ $me->settings->n_events === "1" ? 'checked' : '' }} value="1"></td>
                <td><input type="radio" name="n_events" {{ $me->settings->n_events === "2" ? 'checked' : '' }} value="2"></td>
                <td><input type="radio" name="n_events" {{ $me->settings->n_events === "3" ? 'checked' : '' }} value="3"></td>
            </tr>
            <tr style="display:none">
                <td style="display:none">New News</td>
                <td><input type="radio" name="n_news" {{ $me->settings->n_news === "0" ? 'checked' : '' }} value="0"></td>
                <td><input type="radio" name="n_news" {{ $me->settings->n_news === "1" ? 'checked' : '' }} value="1"></td>
                <td><input type="radio" name="n_news" {{ $me->settings->n_news === "2" ? 'checked' : '' }} value="2"></td>
                <td><input type="radio" name="n_news" {{ $me->settings->n_news === "3" ? 'checked' : '' }} value="3"></td>
            </tr>
            @if($me->is('Staff'))
            <tr style="display:none">
                <td>New Exam Request</td>
                <td><input type="radio" name="n_exam_request" {{ $me->settings->n_exam_request === "0" ? 'checked' : '' }} value="0"></td>
                <td><input type="radio" name="n_exam_request" {{ $me->settings->n_exam_request === "1" ? 'checked' : '' }} value="1"></td>
                <td><input type="radio" name="n_exam_request" {{ $me->settings->n_exam_request === "2" ? 'checked' : '' }} value="2"></td>
                <td><input type="radio" name="n_exam_request" {{ $me->settings->n_exam_request === "3" ? 'checked' : '' }} value="3"></td>
            </tr>
            <tr style="display:none;">
                <td>New Exam Comment (Staff)</td>
                <td><input type="radio" name="n_staff_exam_comment" {{ $me->settings->n_staff_exam_comment === "0" ? 'checked' : '' }} value="0"></td>
                <td><input type="radio" name="n_staff_exam_comment" {{ $me->settings->n_staff_exam_comment === "1" ? 'checked' : '' }} value="1"></td>
                <td><input type="radio" name="n_staff_exam_comment" {{ $me->settings->n_staff_exam_comment === "2" ? 'checked' : '' }} value="2"></td>
                <td><input type="radio" name="n_staff_exam_comment" {{ $me->settings->n_staff_exam_comment === "3" ? 'checked' : '' }} value="3"></td>
            </tr>
            <tr>
                <td>New Training Request</td>
                <td><input type="radio" name="n_training_request" {{ $me->settings->n_training_request === "0" ? 'checked' : '' }} value="0"></td>
                <td><input type="radio" name="n_training_request" {{ $me->settings->n_training_request === "1" ? 'checked' : '' }} value="1"></td>
                <td><input type="radio" name="n_training_request" {{ $me->settings->n_training_request === "2" ? 'checked' : '' }} value="2"></td>
                <td><input type="radio" name="n_training_request" {{ $me->settings->n_training_request === "3" ? 'checked' : '' }} value="3"></td>
            </tr>
            <tr style="display:none">
                <td>New Staff News</td>
                <td><input type="radio" name="n_staff_news" {{ $me->settings->n_staff_news === "0" ? 'checked' : '' }} value="0"></td>
                <td><input type="radio" name="n_staff_news" {{ $me->settings->n_staff_news === "1" ? 'checked' : '' }} value="1"></td>
                <td><input type="radio" name="n_staff_news" {{ $me->settings->n_staff_news === "2" ? 'checked' : '' }} value="2"></td>
                <td><input type="radio" name="n_staff_news" {{ $me->settings->n_staff_news === "3" ? 'checked' : '' }} value="3"></td>
            </tr>
            @endif
            </tbody>
        </table>
            <button class="btn btn-block btn-primary">Update</button>
        </form>
    </div>
