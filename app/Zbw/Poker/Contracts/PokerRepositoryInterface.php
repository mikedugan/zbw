<?php namespace Zbw\Poker\Contracts;

interface PokerRepositoryInterface
{
    public function all();

    public function get($id, $withTrash = false);

    public function update($input);

    public function create($input);

    public function countCardsInHand($pid);

    public function getDiscarded($pid);

    public function discard($cardId);

    public function getPilotsList();

    public function getHandsByPilot($pid);
}
