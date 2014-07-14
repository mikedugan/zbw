<?php  namespace Zbw\Poker; 

use Zbw\Poker\Contracts\PokerRepositoryInterface;
use Zbw\Base\EloquentRepository;
use Curl\Curl;

class PokerRepository extends EloquentRepository implements PokerRepositoryInterface
{

    public $model = '\PokerCard';
    private $curl;

    public function __construct(Curl $curl)
    {
        $this->curl = $curl;
    }


    //we don't really need these functions, but interface
    public function update($input) {}
    public function create($input) {}

    /**
     * @description creates a poker card, and the associated pilot if necessary
     * @param array $input
     * @return \Illuminate\Database\Eloquent\Model|static
     */
    public function createCard($input)
    {
        $card = \PokerCard::create([
              'card' => $input['card'],
              'pid' => $input['pid'],
              'discarded' => null
          ]);
        if(!\PokerPilot::exists($input['pid'])) {
            $pilot = $this->getVatsimInfo($input['pid']);
            $pilot['user']['pid'] = $input['pid'];
            $this->createPilot($pilot['user']);
        }
        return $card;
    }

    /**
     * @description helper function for creating the pilot above
     * @param $input
     * @return \PokerPilot
     */
    private function createPilot($input)
    {
        $pilot = new \PokerPilot([
            'first_name' => $input['name_first'],
            'last_name' => $input['name_last'],
            'pid' => $input['pid'],
            'country' => $input['country']
        ]);

        return $pilot->save();
    }

    /**
     * @description returns pilots with a valid (5 card) hand
     * @return array
     */
    public function getPilotsWithValidHands()
    {
        $pilots = \PokerPilot::all();
        $ret = [];
        foreach($pilots as $pilot) {
            if(count($pilot->cards) === 5) {
                $ret[] = $pilot;
            }
        }

        return $ret;
    }

    /**
     * @description @deprecated
     * @param $pid
     * @return mixed
     */
    public function countCardsInHand($pid)
    {
        return $this->make()->where('pid', $pid)->where('discarded', null)->count();
    }

    /**
     * @description returns a pilots discarded cards
     * @param $pid
     * @return mixed
     */
    public function getDiscarded($pid)
    {
        return $this->make()->where('pid', $pid)->where('discarded', '!=', null)->get();
    }

    /**
     * @description discard a poker card
     * @param $cardId
     * @return void
     */
    public function discard($cardId)
    {
        return \PokerCard::discard($cardId);
    }

    /**
     * @name getPilotsList
     * @description returns a list of pilots by cid
     * @return mixed
     */
    public function getPilotsList()
    {
        return $this->make()->distinct('pid')->lists('pid');
    }

    /**
     * @param $pid
     * @deprecated use $pilot->cards instead
     * @return mixed
     */
    public function getHandsByPilot($pid)
    {
        return $this->make()->where('pid', $pid)->where('discarded', null)->get();
    }

    /**
     * @description returns array of pilot information from vatsim
     * @param integer $pid
     * @return array
     */
    private function getVatsimInfo($pid)
    {
        $this->curl->get(\Config::get('zbw.controller_status').$pid);
        $pilot = simplexml_load_string($this->curl->response);
        return json_decode(json_encode((array)$pilot), 1);
    }
}
