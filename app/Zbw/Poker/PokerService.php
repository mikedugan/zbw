<?php  namespace Zbw\Poker; 

use Zbw\Poker\PokerRepository;

class PokerService {

    private $cards;
    private $analyzer;

    public function __construct(PokerRepository $cards, PokerHandAnalyzer $analyzer)
    {
        $this->cards = $cards;
        $this->analyzer = $analyzer;
    }

    public function draw($input)
    {
        $card = $this->cards->create([
              'pid' => $input['pid'],
              'card' => !empty($input['card']) ? $input['card'] : $this->generateCard()
          ]);
        return $card;
    }

    public function discard($cardId)
    {
        return $this->cards->discard($cardId);
    }

    private function generateCard()
    {
        $suite = mt_rand(1,4);
        $val = mt_rand(2,14);
        switch($suite) {
            case '1':
                $suite = 'D';
                break;
            case '2':
                $suite = 'H';
                break;
            case '3':
                $suite = 'S';
                break;
            case '4':
                $suite = 'C';
                break;
        }
        switch($val) {
            case '11':
                $card = 'J';
                break;
            case '12':
                $card = 'Q';
                break;
            case '13':
                $card = 'K';
                break;
            case '14':
                $card = 'A';
                break;
            default:
                $card = $val;
                break;
        }
        return $card.$suite;
    }

    public function getPilotCards($pid)
    {
        return $this->cards->getHandsByPilot($pid);
    }

    public function getPilots()
    {
        return $this->cards->getPilotsList();
    }
}

