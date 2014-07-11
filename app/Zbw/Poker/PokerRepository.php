<?php  namespace Zbw\Poker; 

use Zbw\Poker\Contracts\PokerRepositoryInterface;
use Zbw\Base\EloquentRepository;

class PokerRepository extends EloquentRepository implements PokerRepositoryInterface
{

    public $model = '\PokerCard';

    /**
     * @name  update
     * @description
     *
     * @param $input
     *
     * @return void
     */
    public function update($input)
    {

    }

    /**
     * @name  create
     * @description
     *
     * @param $input
     *
     * @return \Illuminate\Database\Eloquent\Model|static
     */
    public function create($input)
    {
        $card = \PokerCard::create([
              'card' => $input['card'],
              'pid' => $input['pid'],
              'discarded' => null
          ]);
        return $card;
    }

    /**
     * @name getValidHands
     * @description
     * @return array
     */
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

    /**
     * @name  countCardsInHand
     * @description
     *
     * @param $pid
     *
     * @return mixed
     */
    public function countCardsInHand($pid)
    {
        return $this->make()->where('pid', $pid)->where('discarded', null)->count();
    }

    /**
     * @name  getDiscarded
     * @description
     *
     * @param $pid
     *
     * @return mixed
     */
    public function getDiscarded($pid)
    {
        return $this->make()->where('pid', $pid)->where('discarded', '!=', null)->get();
    }

    /**
     * @name  discard
     * @description
     *
     * @param $cardId
     *
     * @return void
     */
    public function discard($cardId)
    {
        $card = $this->make()->find($cardId);
        $card->discarded = \Carbon::now();
        $card->save();
    }

    /**
     * @name getPilotsList
     * @description
     * @return mixed
     */
    public function getPilotsList()
    {
        return $this->make()->distinct('pid')->lists('pid');
    }

    /**
     * @name  getHandsByPilot
     * @description
     *
     * @param $pid
     *
     * @return mixed
     */
    public function getHandsByPilot($pid)
    {
        return $this->make()->where('pid', $pid)->where('discarded', null)->get();
    }
}
