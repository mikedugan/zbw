<div class="col-md-12">
    <h1 class="text-center">Add ZBW Controller</h1>
    <form id="controllerAdd" action="/staff/roster/add-controller" method="post">
        <div class="form-group">
            <label class="control-label" for="cid">CID</label>
            <input class="form-control" type="number" name="cid" id="cid"/>
        </div>
        <div class="form-group">
            <label class="control-label" for="fname">First Name</label>
            <input class="form-control" name="fname" type="text" id="fname"/>
        </div>
        <div class="form-group">
            <label class="control-label" for="lname">Last Name</label>
            <input class="form-control" name="lname" type="text" id="lname"/>
        </div>
        <div class="form-group">
            <label class="control-label" for="email">Email</label>
            <input class="form-control" type="email" name="email" id="email"/>
        </div>
        <div class="form-group">
            <label class="control-label" for="artcc">ARTCC</label>
            <input class="form-control" type="text" name="artcc" id="artcc" value="ZBW"/>
            <p class="small">Only change if controller is visiting.</p>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        <p>The new controller will be emailed an initial password, as well as
        instructions on accessing the forum, training center, and their operating initials.</p>
        <p>Initial rating will be retrieved from the VATUSA system.</p>
    </form>
</div>
