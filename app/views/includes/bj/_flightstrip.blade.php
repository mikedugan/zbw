<div class="strip col-md-12 text-left">
    <ul>
    <table class="table table-striped">
		<li>
    <tbody>
    @foreach($flights as $flight)
			<tr>
				<td>{{ $flight->callsign }}</td>
				<td>{{ $flight->departure }}</td>
				<td>{{ $flight->route }}</td>
				<td>{{ $flight->name }}</td>
			</tr>
      <tr>
          <td>{{ $flight->aircraft }}</td>
          <td>{{ $flight->destination }}</td>
          <td>{{ $flight->altitude }}</td>
          <td>{{ $flight->eta }}</td>
      </tr>
       <tr><td></td><td></td><td></td><td></td></tr>
    @endforeach
        </tbody>
        </li>
    </table>
    </ul>
</div>
