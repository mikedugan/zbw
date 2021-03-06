<form class="bsv" id="staffContactSubmit" class="col-md-12" action="/contact" method="post"
      data-bv-feedbackicons-valid="glyphicons ok_2 green"
      data-bv-feedbackicons-invalid="glyphicon remove_2 red">
        <div class="form-group">
            <label for="to">Staff Member</label>
            <select class="form-control" name="to">
                <option value="reqd">Select One</option>
                <option value="ATM">Air Traffic Manager</option>
                <option value="DATM">Deputy Air Traffic Manager</option>
                <option value="TA">Training Administrator</option>
                <option value="Events">Events Coordinator</option>
                <option value="WEB">Webmaster</option>
                <option value="FE">Facilities Engineer</option>
            </select>
        </div>
        <div class="form-group">
            <label for="email">Your Email</label>
            <input required="required" class="form-control" type="text" name="email" id="email"
              data-bv-emailaddress="true"
              data-bv-emailaddress-message="Please enter a valid email address"/>
        </div>
        <div class="form-group">
            <label for="subject">Subject</label>
            <input required="required" class="form-control" id="subject" name="subject" type="text"
              data-bv-notempty="true"
              data-bv-notempty-message="Please enter a subject"/>
        </div>
        <div class="form-group"><label for="message">Message</label>
            <textarea required="required" class="form-control editor" name="message" id="message" cols="30" rows="10"
              data-bv-notempty="true"
              data-bv-notempty-message="Please enter a message"></textarea>
        </div>
        <div class="form-group">
            <label for="spam">Human Verification</label>
            <p>What is sum of the two-digit year (2014 is 14) plus the two-digit month (October is 10)?</p>
            <p class="small">Hint: July of 2014 would be 21</p>
            <input required="required" class="form-control" type="text" id="spam">
        </div>
        <button type="submit" class="btn btn-success">Send</button>
    </form>
@section('scripts')
  <script>
    $('#staffContactSubmit').submit(function(e) {
      var d = new Date;
      m = (d.getMonth() + 1).toString();
      m = ("0" + m).slice(-2);
      d = d.getFullYear().toString();
      d = ("0" + d).slice(-2);
      if($('#spam').val() != (parseInt(d) + parseInt(m))) {
        e.preventDefault();
        alert("We're sorry, you entered the wrong code. Hint: the month is "+m+" and the year is "+d);
      }
    });
  </script>
@stop
