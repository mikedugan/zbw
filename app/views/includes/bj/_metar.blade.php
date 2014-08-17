@unless(is_null($metars[0]))
<?php $index = 1; ?>
@foreach($metars as $metar)
@if($index % 2 == 0)
<div class="row">
@endif
    <div class="metar text-left col-md-6">
        @if(\Input::get('raw') == true)
        <p class="raw">{{ $metar->raw }}</p>
        @else
        <h4>{{ $metar->facility }}</h4> at {{ $metar->time}}Z
        <div class="list-group">
            <div class="list-group-item"><b>Altimeter:</b> {{ $metar->altimeter }}</div>
            <div class="list-group-item"><b>Wind: </b>
                    @if(!empty($metar->wind_direction))
                    {{$metar->wind_direction }} at {{$metar->wind_speed or ''}}
                    @else
                    Calm
                    @endif
            </div>
            <div class="list-group-item"><b>Visibility: </b> {{$metar->visibility}}</div>
            <div class="list-group-item"><b>Temp:</b> {{$metar->temp}}, <b>Dewpoint:</b> {{$metar->dewpoint}}</div>
            <div class="list-group-item"><b>Sky: </b>
                @if(count(json_decode($metar->sky)) > 0)
                    @foreach(json_decode($metar->sky) as $sky)
                        {{$sky->type}} at {{$sky->level}} feet,
                    @endforeach
                @else
                    Clear
                @endif
            </div>
        </div>
        @endif
    </div>
    @if($index % 2 == 0)
    </div>
    @endif
<?php $index++; ?>
@endforeach
@endunless
