<div class="strip col-md-12 text-left">
    <table class="table table-striped">
    <tbody>
    @foreach($flights as $flight)
			<tr style="border-top:2px solid #555;border-left:2px solid #555;border-right:2px solid #555;">
				<td>{{ $flight->callsign }}</td>
				<td>{{ $flight->departure }}</td>
				<td>{{ Zbw\Base\Helpers::shortenRouteString($flight->route) }}</td>
				<td>{{ $flight->name }}</td>
			</tr>
      <tr style="border-bottom:2px solid #555;border-left:2px solid #555;border-right:2px solid #555;">
          <td>{{ $flight->aircraft }}</td>
          <td>{{ $flight->destination }}</td>
          <td>{{ $flight->altitude }}</td>
          <td>{{ $flight->eta }}</td>
      </tr>
    @endforeach
        </tbody>
    </table>
</div>
