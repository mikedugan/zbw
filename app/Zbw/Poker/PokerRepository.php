<?php  namespace Zbw\Poker; 

use Zbw\Poker\Contracts\PokerRepositoryInterface;
use Zbw\Base\EloquentRepository;

class PokerRepository extends EloquentRepository implements PokerRepositoryInterface {

    public $model = '\PokerCard';

    public function update($input)
    {

    }

    public function create($input)
    {
        $card = \PokerCard::create([
              'card' => $input['card'],
              'pid' => $input['pid'],
              'discarded' => false
          ]);
        return $card;
    }

    public function discard($cardId)
    {
        $card = $this->make()->find($cardId);
        $card->discarded = \Carbon::now();
        $card->save();
    }

    public function getPilotsList()
    {
        return $this->make()->distinct('pid')->lists('pid');
    }

    public function getHandsByPilot($pid)
    {
        return $this->make()->where('pid', $pid)->get();
    }
}
