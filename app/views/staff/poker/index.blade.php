@extends('layouts.master')
@section('title')
ZBW Airport Poker
@stop
@section('content')
<h1 class="text-center">ZBW Airport Poker</h1>
<div class="row">
    <div class="col-md-6">
        <h3 class="text-center">Current Standings</h3>
        <div class="col-md-12">
            <ol>
                <?php $names = \Config::get('zbw.poker.card_names'); ?>
            @foreach($standings as $hand)
                <li>
                    <p>Pilot: {{$hand[0]}}</p>
                    <h5 class="text-left">{{ $hand[1][0] }}</h5>
                    <p>
                        <?php $cards = $hand[1][4]; ?>
                    @foreach($cards as $card)
                        <img src="/images/cards/{{$card[0]}}.gif">
                        @endforeach
                    </p>
                </li>
                <hr>
            @endforeach
            </ol>
        </div>
    </div>
    <div class="col-md-6">
        <div class="col-md-12">
        <h3 class="text-center">Deal Card</h3>
        <form action="" method="post">
            <div class="form-group">
                <label class="control-label">Pilot ID</label>
                <input class="form-control"  type="number" name="pid" id="pid">
            </div>
            <div class="form-group">
                <label class="control-label">Override Draw</label>
                <select class="form-control" name="card" id="card">
                    @include('includes.options.poker_cards')
                </select>
            </div>
            <button class="btn btn-submit btn-primary">Deal</button>
        </form>
        </div>
        <div class="col-md-12">
            <h3 class="text-center">Pilots</h3>
            @foreach($pilots as $pilot)
            <p class="col-md-6 text-center"><a href="/staff/poker/{{$pilot}}">{{$pilot}}</a></p>
            @endforeach
        </div>
    </div>
</div>
@stop
