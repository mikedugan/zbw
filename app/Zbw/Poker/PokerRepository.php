<?php  namespace Zbw\Poker; 

use Zbw\Poker\Contracts\PokerRepositoryInterface;
use Zbw\Base\EloquentRepository;

class PokerRepository extends EloquentRepository implements PokerRepositoryInterface
{

    public $model = '\PokerCard';

    public function update($input)
    {

    }

    public function create($input)
    {
        $card = \PokerCard::create([
              'card' => $input['card'],
              'pid' => $input['pid'],
              'discarded' => null
          ]);
        return $card;
    }

    public function getValidHands()
    {
        $pilots = $this->getPilotsList();
        $hands = [];
        foreach($pilots as $pilot) {
            $hand = $this->getHandsByPilot($pilot);
            $hand_array = [];
            foreach($hand as $card) {
                $hand_array[] = [$card->card, $card->id];
            }
            if(count($hand) !== 5) continue;
            else {
                $hands[] = [$pilot, $hand_array];
            }
        }
        return $hands;
    }

    public function countCardsInHand($pid)
    {
        return $this->make()->where('pid', $pid)->where('discarded', null)->count();
    }

    public function getDiscarded($pid)
    {
        return $this->make()->where('pid', $pid)->where('discarded', '!=', null)->get();
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
        return $this->make()->where('pid', $pid)->where('discarded', null)->get();
    }
}
