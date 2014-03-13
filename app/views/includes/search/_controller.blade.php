<form action="/staff/roster/results" method="GET">
    <div class="form-group">
        <label class="control-label" for="text">Email</label>
        <input class="form-control" type="text" name="email" id="email"/>
    </div>
    <div class="form-group">
        <label class="control-label" for="rating">Rating (ie I3)</label>
        <input class="form-control" type="text" name="rating" id="rating"/>
    </div>
    <div class="form-group">
        <label class="control-label" for="cid">CID (exact match)</label>
        <input class="form-control" type="number" name="cid" id="cid" maxlength="2"/>
    </div>
    <div class="form-group">
        <label class="control-label" for="fname">First Name</label>
        <input class="form-control" type="text" name="fname" id="fname"/>
    </div>
    <div class="form-group">
        <label class="control-label" for="lname">Last Name</label>
        <input class="form-control" type="text" name="lname" id="lname"/>
    </div>
    <button class="btn-primary btn-lg" type="submit">Search</button>
</form>
