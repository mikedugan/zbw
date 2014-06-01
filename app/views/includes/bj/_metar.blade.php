@foreach($metars as $metar)
    <div class="metar text-left col-md-6">
        <h4>{{ $metar->facility }}</h4> at {{ $metar->time}}Z
        <p><b>Altimeter:</b> {{ $metar->altimeter }}</p>
        <p><b>Wind: </b> {{$metar->wind_direction}} at {{$metar->wind_speed}}, <b>Visibility: </b> {{$metar->visibility}}</p>
        <p><b>Sky: </b>
        @if(count(json_decode($metar->sky)) > 0)
            @foreach(json_decode($metar->sky) as $sky)
                {{$sky->type}} at {{$sky->level}} feet,
            @endforeach
        @else
            Clear
        @endif
        </p>
        <p><b>Temp:</b> {{$metar->temp}}, <b>Dewpoint:</b> {{$metar->dewpoint}}</p>
    </div>
@endforeach
