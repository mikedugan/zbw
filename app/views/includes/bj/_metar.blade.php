@unless(is_null($metars[0]))
@foreach($metars as $metar)
    <div class="metar text-left col-md-6">
        @if(\Input::get('raw') == true)
            <p>{{ $metar->raw }}</p>
        @else
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
        @endif
    </div>
@endforeach
@endunless
