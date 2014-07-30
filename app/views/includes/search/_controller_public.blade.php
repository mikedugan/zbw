<form id="controllerSearch" action="/roster/results" method="GET">
    @if(\Sentry::check())
    <div class="form-group">
        <label class="control-label" for="text">Email</label>
        <input class="form-control" type="text" name="email" id="email"/>
    </div>
    @endif
    <div class="form-group">
        <label class="control-label" for="rating">Rating (ie I3)</label>
        <select class="form-control" name="rating" id="rating">
            <option value="">Select One (Optional)</option>
            <option value="-1">Inactive (INA)</option>
            <option value="0">Suspended (SUS)</option>
            <option value="1">Pilot/Observer (OBS)</option>
            <option value="2">Student 1 (S1)</option>
            <option value="3">Student 2 (S2)</option>
            <option value="4">Student 3 (S3)</option>
            <option value="5">Controller 1 (C1)</option>
            <option value="6">Controller 2 (C2)</option>
            <option value="7">Senior Controller (C3)</option>
            <option value="8">Instructor (I1)</option>
            <option value="9">Instructor 2 (I2)</option>
            <option value="10">Senior Instructor (I3)</option>
            <option value="11">Superverisor (SUP)</option>
            <option value="12">Administrator (ADM)</option>
        </select>
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
