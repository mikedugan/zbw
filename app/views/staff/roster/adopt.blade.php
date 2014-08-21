<div class="panel-group" id="adoption">
<div class="panel panel-default">
<div class="panel-heading">
  <h4 class="panel-title">
  <a data-toggle="collapse" data-parent="adoption" href="#collapseAvailable">Available for Adoption</a>
  </h4>
</div>
<div id="collapseAvailable" class="panel-collapse collapse">
<div class="panel-body">
  <table class="table table-bordered">
    <thead>
        <tr>
            <td>Name</td>
            <td>CID</td>
            <td>Email</td>
            <td>Join Date</td>
            <td></td>
        </tr>
    </thead>
    @foreach($students as $student)
        <tr>
            <td>{{ "$student->username ($student->initials)" }}</td>
            <td>{{ $student->cid }}</td>
            <td>{{ $student->email }}</td>
            <td>{{ $student->created_at->toDayDateTimeString() }}</td>
            @if(! $student->adopted_by)
              <td><a class="btn btn-success btn-sm" href="/staff/adopt/{{$student->cid}}">Adopt</a></td>
            @elseif($student->adopted_by === $me->cid)
              <td><a class="btn btn-danger btn-sm" href="/staff/adopt/{{$student->cid}}/drop">Drop</a></td>
            @endif
        </tr>
    @endforeach
  </table>
  </div>
  </div>
  </div>
  <div class="panel panel-default">
  <div class="panel-heading">
    <h4 class="panel-title">
    <a data-toggle="collapse" data-parent="adoption" href="#collapseAdopted">Current Adoptions</a>
    </h4>
  </div>
  <div id="collapseAdopted" class="panel-collapse collapse">
  <div class="panel-body">
    <table class="table table-bordered">
      <thead>
          <tr>
              <td>Name</td>
              <td>CID</td>
              <td>Email</td>
              <td>Join Date</td>
              <td>Adopted By</td>
          </tr>
      </thead>
      @foreach($adopted as $student)
          <tr>
              <td>{{ "$student->username ($student->initials)" }}</td>
              <td>{{ $student->cid }}</td>
              <td>{{ $student->email }}</td>
              <td>{{ $student->created_at->toDayDateTimeString() }}</td>
              <td>{{ $student->adopter->initials }}</td>
          </tr>
      @endforeach
    </table>
    </div>
    </div>
    </div>
</div>
