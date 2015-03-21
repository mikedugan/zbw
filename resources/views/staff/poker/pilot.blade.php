@extends('layouts.master')
@section('title')
View Pilot
@stop
@section('content')
<h1 class="text-center">View Pilot</h1>
<div class="row">
    <div class="col-md-6">
        <p><b>Pilot: </b> {{ $pilot->first_name . ' ' . $pilot->last_name }}</p>

        <?php $card_names = \Config::get('zbw.poker.card_names'); ?>
        @foreach($pilot->cards as $card)
            <div style="margin-top:10px" class="row">
                <p style="font-size:18px" class="col-sm-5">{{$card_names[$card->card]}}, dealt at {{$card->created_at->toTimeString()}}</p>
                @unless($card->discarded)
                <form action="" method="post" class="form-inline col-sm-5">
                    <input type="hidden" name="card" value="{{$card->id}}">
                    <button class="btn btn-danger">Discard</button>
                </form>
                @else
                <span class="col-sm-5">Discarded</span>
                @endunless
            </div>
            <hr>
        @endforeach
    </div>
</div>
<h5 class="text-center"><a href="/staff/poker">Back to Poker Cab</a></h5>
@stop
