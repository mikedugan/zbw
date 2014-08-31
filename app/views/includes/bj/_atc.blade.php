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
        @foreach($atcs as $atc)
        <tr>
            <td>{{ $atc->user->username or 'CID Not Found' }}</td>
            <td>{{ $atc->position }}</td>
            <td>{{ $atc->frequency }}</td>
            <td>{{ $atc->start->diffForHumans() }}</td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
