<div class="strip col-md-12 text-left">
    <table class="table">
    <tbody>
    @foreach($flights as $flight)
			<tr style="border-top:2px solid #555;border-left:2px solid #555;border-right:2px solid #555;">
				<td>{{ $flight->callsign }}</td>
				<td>{{ $flight->departure }}</td>
				<td>{{ Zbw\Core\Helpers::shortenRouteString($flight->route) }}</td>
				<td>{{ $flight->name }}</td>
			</tr>
      <tr style="border-bottom:2px solid #555;border-left:2px solid #555;border-right:2px solid #555;">
          <td>{{ $flight->aircraft }}</td>
          <td>{{ $flight->destination }}</td>
          <td>{{ $flight->altitude }}</td>
          <td>
              @if($flight->eta == 0)
              ETE: under 1 hour</td>
              @else
              ETE: {{ $flight->eta }} hours</td>
              @endif
      </tr>
    @endforeach
        </tbody>
    </table>
</div>
