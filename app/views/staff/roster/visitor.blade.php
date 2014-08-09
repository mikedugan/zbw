<h1 class="text-center">Visitor Applications</h1>
<hr/>
<div class="row">
  @foreach($applicants as $applicant)
  <div class="row" style="border-bottom: 3px solid #bbb">
  <div class="col-md-12" style="margin:10px 0;border-bottom: 1px solid #ddd">
      <div class="col-md-4">
        <h3>Applicant Information</h3>
        <p><b>Name:</b> {{ $applicant->first_name . ' ' . $applicant->last_name }}</p>
        <p><b>CID: </b> {{ $applicant->cid }}</p>
        <p><b>Email: </b> <a href="mailto:{{ $applicant->email }}">{{ $applicant->email }}</a></p>
        <p><b>Rating: </b> {{ \Rating::find($applicant->rating)->long }}</p>
        <p><b>Division: </b> {{ $applicant->division }}</p>
        <p><b>ARTCC: </b> {{ $applicant->home }}</p>
      </div>
      <div class="col-md-4" style="border-left: 1px solid #ddd">
          <h3>Application Status</h3>
          <p><b>Submitted: </b> {{ $applicant->created_at->toDayDateTimeString() }}</p>
          <p><b>Accepted: </b> {{ $applicant->accepted ? 'Yes' : 'No' }}</p>
          <p><b>Accepted On: </b> <?php if($applicant->created_at) echo $applicant->created_at->toDayDateTimeString(); else echo "N/A"?></p>
          <p><b>LOR Submitted: </b> {{ $applicant->lor_submitted ? 'Yes' : 'No' }}</p>
          <p><b>LOR Submitted On: </b> <?php if($applicant->lor_submitted_on) echo $applicant->lor_submitted_on->toDayDateTimeString(); else echo "N/A"?></p>
      </div>
      <div class="col-md-4" style="border-left: 1px solid #ddd">
          <h3>Comments and LOR</h3>
          <p><b>Visitor Comments: </b> {{ $applicant->message }}</p>
          <p><b>LOR: </b> {{ $applicant->lor or 'N/A' }}</p>
      </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <h3>ZBW Staff Comments</h3>
      <p>{{ $applicant->comments or 'N/A' }}</p>
    </div>
    <div class="col-md-6">
      <div class="row">
        <form class="axform" style="float:left;margin:0 1%;" action="/visitor/accept" method="post">
          <button type="button" data-warning="The controller will be added to the roster" class="visitor-accept confirm btn btn-success">Accept</button>
        </form>
        <button type="button" data-warning="The controller will receive an email indicating their denial" class="visitor-deny confirm btn btn-danger">Deny</button>
        <button type="button" class="visitor-comment btn btn-primary">Add Comment</button>
        <form class="visitor-comment-form hidden" action="/visitor/comment" method="post">
            <div class="form-group">
                <label class="control-label" for="comment">Your Comment</label>
                <textarea class="form-control" name="comment" id="comment"></textarea>
                <input type="hidden" name="visitor" value="{{ $applicant->id }}">
            </div>
            <button type="submit" class="btn btn-sm">Submit</button>
        </form>
        <form class="visitor-deny-form confirm hidden" data-warning="User will be sent an email with this reason" action="/visitor/deny" method="post">
            <div class="form-group">
                <label class="control-label" for="reason">Reason</label>
                <textarea class="form-control" name="reason" id="reason"></textarea>
                <input type="hidden" name="visitor" value="{{ $applicant->id }}">
            </div>
            <button type="submit" class="btn btn-sm">Submit</button>
        </form>
      </div>
    </div>
  </div>
  </div>
  @endforeach
</div>
