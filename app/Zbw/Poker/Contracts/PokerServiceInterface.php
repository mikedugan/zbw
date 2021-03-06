<?php namespace Zbw\Poker\Contracts;

interface PokerServiceInterface
{
    public function draw($input);

    public function discard($cardId);

    public function getPilots();

    public function getStandings();
}
