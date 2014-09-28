<form id="rosterEdit" action="/staff/{{$user->cid}}/edit" method="post">
  <div class="col-md-3">
    <h4>Basic Info</h4>
    <div class="form-group">
        <label for="fname">First Name</label>
        <input class="form-control" type="text" name="fname" readonly id="fname" value="{{$user->first_name}}">
    </div>
    <div class="form-group">
        <label class="control-label" for="lname">Last Name</label>
        <input class="form-control" type="text" name="lname" readonly id="lname" value="{{$user->last_name}}">
    </div>
    <div class="form-group">
        <label class="control-label" for="initials">Initials</label>
        <input class="form-control" type="text" name="initials" readonly id="initials" value="{{$user->initials}}">
    </div>
    <div class="form-group">
        <label class="control-label" for="artcc">ARTCC</label>
        <input class="form-control" type="text" name="artcc" readonly id="artcc" value="{{$user->artcc}}">
    </div>
    <div class="row text-center">
      <button class="btn btn-primary" type="submit">Save</button>
    </div>
  </div>
  <div class="col-md-9">
    <div class="col-md-3">
      <h4>Groups</h4>
      <div class="row">
        <div class="form-group col-md-12">
            <label class="control-label" for="groups">Select Group(s)</label>
            <select readonly style="height:270px" multiple name="groups[]" id="groups" class="form-control">
                @foreach($groups as $group)
                    <option value="{{$group->id}}" <?php if($user->inGroup($group)) echo "selected"; ?>>{{ $group->name }}</option>
                @endforeach
            </select>
        </div>
      </div>
    </div>
    <div class="col-md-5">
      <h4>Actions</h4>
      <form></form>
        @if($user->activated == 1)
          @if($user->cert < 14)
          <form class="axform col-md-12" action="/r/promote/{{$user->cid}}" method="post">
              <button type="submit" class="btn col-md-12 btn-success btn-xs" id="cert-promote">Promote User to {{ $user->nextCert() }}</button>
          </form>
          @endif
          @if($user->cert > 0)
          <form class="axform col-md-12" action="/r/demote/{{$user->cid}}" method="post">
              <button type="submit" class="btn col-md-12 btn-warning btn-xs" id="cert-demote">Demote User to {{ $user->lastCert() }}</button>
          </form>
          @endif
        @endif
    </div>
    <div class="col-md-4">
      <h4>Ratings</h4>
        <div class="row">
            <label for="rating_id">Rating</label>
            <select class="form-control" name="rating_id" id="rating_id">
            @foreach($ratings as $rating)
                <option
                @if($rating->id === $user->rating_id)
                 selected
                @else

                @endif
                value="{{$rating->id}}">{{$rating->short}}</option>
            @endforeach
            </select>
        </div>
        <div class="row">
            <label for="cert">ZBW Cert</label>
            <select class="form-control" name="cert" id="cert">
            @foreach($certs as $cert)
                <option
                @if($cert->id === $user->cert)
                 selected
                @else

                @endif
                value="{{$cert->id}}">{{$cert->readable()}}</option>
            @endforeach
            </select>
        </div>
    </div>
  </div>
</form>
