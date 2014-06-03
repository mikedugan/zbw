<div class="col-md-12 online">
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Controller</th>
            <th>Position</th>
            <th>Frequency</th>
            <th>Sign-On</th>
        <tbody>
        @foreach($atcs as $atc)
        <tr>
            <td>{{ $atc->user->username or 'CID Not Found' }}</td>
            <td>{{ $atc->position }}</td>
            <td>{{ $atc->frequency }}</td>
            <td>{{ $atc->start }}</td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
