<div class="col-md-12 online">
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Controller</th>
				<th>Position</th>
				<th>Frequency</th>
				<th>Sign-On</th>
				<th>Sign-Off</th>
			</tr>
		</thead>
		<tbody>
    @foreach($atcs as $atc)
      <tr>
          <td>{{ $atc->user->username }}</td>
          <td>{{ $atc->position }}</td>
          <td>134.700</td>
          <td>{{ $atc->start }}</td>
      </tr>
    @endforeach
		</tbody>
	</table>
</div>
