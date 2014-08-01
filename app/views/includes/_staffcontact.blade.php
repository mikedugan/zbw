<form class="bsv" id="staffContactSubmit" class="col-md-12" action="/contact"
      data-bv-feedbackicons-valid="glyphicons ok_2 green"
      data-bv-feedbackicons-invalid="glyphicon remove_2 red">
        <div class="form-group">
            <label for="to">Staff Member</label>
            <select class="form-control" name="to">
                <option value="atm">Air Traffic Manager</option>
                <option value="datm">Deputy Air Traffic Manager</option>
                <option value="ta">Training Administrator</option>
                <option value="web">Webmaster</option>
                <option value="fe">Facilities Engineer</option>
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
            <textarea required="required" class="editor" name="message" id="message" cols="30" rows="10"
              data-bv-notempty="true"
              data-bv-notempty-message="Please enter a message"></textarea>
        </div>
        <div class="form-group">
            <label for="spam">Human Verification</label>
            <p>What is the 4-digit year plus the two-digit month?</p>
            <p class="small">Hint: July of 2014 would be 2021</p>
            <input required="required" class="form-control" type="text" id="email">
        </div>
        <button type="submit" class="btn btn-success">Send</button>
    </form>
