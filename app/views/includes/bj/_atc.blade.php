<div class="row online">
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Controller</th>
            <th>Position</th>
            <th>Frequency</th>
            <th>Sign-On</th>
         </tr>
        </thead>
        <tbody>
        @if($atcs->count() > 0)
          @foreach($atcs as $atc)
          <tr>
              <td>{{ $atc->user->username or 'CID Not Found' }}</td>
              <td>{{ $atc->position }}</td>
              <td>{{ $atc->frequency }}</td>
              <td>{{ $atc->start->toTimeString() }}</td>
          </tr>
          @endforeach
        @else
          <tr>
            <td colspan="4">No controllers currently online.</td>
          </tr>
        @endif
        @if($schedules->count() >0)
        <tr>
          <th colspan="4">Upcoming Scheduled Staffing</th>
        </tr>
        @foreach($schedules as $schedule)
        <tr>
          <td colspan="4">{{ $schedule->controller->initials }} on {{ $schedule->position }} starting {{ $schedule->start->toDayDateTimeString() }}</td>
        </tr>
        @endforeach
        @endif
        </tbody>
    </table>
</div>
