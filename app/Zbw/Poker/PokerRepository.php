<?php  namespace Zbw\Poker; 

use Zbw\Poker\Contracts\PokerRepositoryInterface;
use Zbw\Base\EloquentRepository;
use Curl\Curl;
use Zbw\Poker\Exceptions\PilotNotFoundException;

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
     *  creates a poker card, and the associated pilot if necessary
     * @param array $input
     * @return \Illuminate\Database\Eloquent\Model|static
     * @throws PilotNotFoundException
     */
    public function createCard($input)
    {
        $card = \PokerCard::create([
              'card' => $input['card'],
              'pid' => $input['pid'],
              'discarded' => null
          ]);
        if(!\PokerPilot::exists($input['pid'])) {
            try {
                $pilot = $this->getVatsimInfo($input['pid']);
            } catch (PilotNotFoundException $e) {
                $card->delete();
                throw new PilotNotFoundException;
            }
            $pilot['user']['pid'] = $input['pid'];
            $this->createPilot($pilot['user']);
        }
        return $card;
    }

    /**
     *  helper function for creating the pilot above
     * @param $input
     * @return \PokerPilot
     */
    private function createPilot($input)
    {
        $pilot = new \PokerPilot;
        $pilot->first_name-> $input['name_first'];
        $pilot->last_name-> $input['name_last'];
        $pilot->pid-> $input['pid'];
        $pilot->country-> $input['country'];
        return $this->checkAndSave($pilot);
    }

    /**
     *  returns pilots with a valid (5 card) hand
     * @return array
     */
    public function getPilotsWithValidHands()
    {
        $pilots = \PokerPilot::all();
        $ret = [];
        foreach($pilots as $pilot) {
            if(count($pilot->cards) >= 5) {
                $ret[] = $pilot;
            }
        }

        return $ret;
    }

    /**
     *  @deprecated
     * @param $pid
     * @return mixed
     */
    public function countCardsInHand($pid)
    {
        return $this->make()->where('pid', $pid)->where('discarded', null)->count();
    }

    /**
     *  returns a pilots discarded cards
     * @param $pid
     * @return mixed
     */
    public function getDiscarded($pid)
    {
        return $this->make()->where('pid', $pid)->where('discarded', '!=', null)->get();
    }

    /**
     *  discard a poker card
     * @param $cardId
     * @return void
     */
    public function discard($cardId)
    {
        return \PokerCard::discard($cardId);
    }

    /**
     * @name getPilotsList
     *  returns a list of pilots by cid
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
     *  returns array of pilot information from vatsim
     * @param integer $pid
     * @return array
     * @throws PilotNotFoundException
     */
    private function getVatsimInfo($pid)
    {
        $this->curl->get(\Config::get('zbw.controller_status').$pid);
        $pilot = simplexml_load_string($this->curl->response);
        $pilot = json_decode(json_encode((array)$pilot), 1);
        if(empty($pilot['user']['name_last'])) { throw new PilotNotFoundException; }
        else return $pilot;
    }
}
