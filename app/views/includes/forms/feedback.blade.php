<div id="feedbackModal" role="dialog" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Boston ARTCC Feedback</h4>
                </div>
                <div class="modal-body">
                    <form action="/feedback" method="post">
                        <h3 class="text-center">Leave Us Feedback</h3>
                        <div class="form-group">
                            <label class="control-label" for="name">Name</label>
                            <input type="text" class="form-control" name="name" id="name">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="email">Email</label>
                            <input type="email" class="form-control" name="email" id="email">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="subject">Subject</label>
                            <select class="form-control" name="subject" id="subject">
                                <option value="pilot">Pilot Feedback on ATC</option>
                                <option value="web">Website Feedback</option>
                                <option value="feature">Feature Request</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="message">Your Message</label>
                            <textarea class="form-control" name="content" id="content"></textarea>
                        </div>
                        <input type="text" name="poobear" style="display:none">
                        <button type="submit" class="btn btn-primary">Send</button>
                    </form>
                </div>
                <div style="text-align:center" class="modal-footer">
                    Thanks for taking the time to contact us! If your feedback requires a response, the appropriate staff member will be in touch with you as soon as possible
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
