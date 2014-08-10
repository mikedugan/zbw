<?php  namespace Zbw\Poker; 

class PokerHandAnalyzer {

    /**
     *  do a little low-level usort magic on the total weight of the hands
     * @param array $hands
     * @return array
     */
    public function sortHands(Array $hands)
    {
        usort($hands, function($a, $b) {
            //wtf is this going to be now?
              return $a[1][3] < $b[1][3];
          });
        return $hands;
    }

    /**
     *  array wrapper for the hand analyzer
     * @param array $hands
     * @return array
     */
    public function analyzeHands(Array $hands)
    {
        $ret = [];
        foreach($hands as $pid => $hand) {
            $ret[] = [$pid, $this->analyzeHand($hand)];
        }
        return $ret;
    }

    /**
     * written by Ross Carlson (vatsim@metacraft.net)
     *  analyzes a poker hand
     * @param array $cards
     * @return indexed_array('name', 'rank', 'total_weight', 'relative_weight', array('cards'))
     */

    private function analyzeHand($cards) {
        $card_weight = \Config::get('zbw.poker.card_weights');
        // Build array representing the relative value of each card.
        $card_weights = [];
        $card_suits = [];
        foreach ($cards as $card) {
            //$card->card
            $c = substr ($card->card, 0, 1);
            $s = substr ($card->card, strlen ($card[0]) - 1, 1);
            array_push ($card_suits, $s);
            array_push ($card_weights, $card_weight[$c]);
        }

        // Sort the card weights for easier detection of straights, pairs, triples, etc.
        sort ($card_weights);

        // Determine the total weight of the hand.
        $total_weight = $card_weights[0] + $card_weights[1] + $card_weights[2] + $card_weights[3] + $card_weights[4];

        $relative_weight = 0;

        // Detect a flush.
        $is_flush = false;
        if (($card_suits[0] == $card_suits[1]) &&
          ($card_suits[0] == $card_suits[2]) &&
          ($card_suits[0] == $card_suits[3]) &&
          ($card_suits[0] == $card_suits[4])) {
            $is_flush = true;
        }

        // Detect a possible straight.
        if (($card_weights[0] == ($card_weights[1] - 1)) &&
          ($card_weights[1] == ($card_weights[2] - 1)) &&
          ($card_weights[2] == ($card_weights[3] - 1))) {

            // Detect an ace-low straight or normal straight.
            if ((($card_weights[4] == 24) && ($card_weights[0] == 12)) || ($card_weights[4] == ($card_weights[3] + 1))) {
                $relative_weight = $card_weights[0] + ($card_weights[1] * 10) + ($card_weights[2] * 100) + ($card_weights[3] * 1000) + ($card_weights[4] * 10000);
                if ($is_flush) {
                    if ($total_weight == 110) {
                        return ['Royal Flush', 10, $total_weight, $relative_weight, $cards];
                    } else {
                        return ['Straight Flush', 9, $total_weight, $relative_weight, $cards];
                    }
                } else {
                    return ['Straight', 5, $total_weight, $relative_weight, $cards];
                }
            }
        }

        // Detect four of a kind.
        if ((($card_weights[0] == $card_weights[1]) &&
            ($card_weights[0] == $card_weights[2]) &&
            ($card_weights[0] == $card_weights[3])) ||
          (($card_weights[1] == $card_weights[2]) &&
            ($card_weights[1] == $card_weights[3]) &&
            ($card_weights[1] == $card_weights[4]))) {
            if ($card_weights[0] == $card_weights[1]) {
                $relative_weight = $card_weights[0] * 40;
                $relative_weight += $card_weights[4];
            } else {
                $relative_weight = $card_weights[1] * 40;
                $relative_weight += $card_weights[0];
            }
            return ['Four of a Kind', 8, $total_weight, $relative_weight, $cards];
        }

        // Detect a full house.
        if ((($card_weights[0] == $card_weights[1]) &&
            ($card_weights[0] == $card_weights[2]) &&
            ($card_weights[3] == $card_weights[4])) ||
          (($card_weights[0] == $card_weights[1]) &&
            ($card_weights[2] == $card_weights[3]) &&
            ($card_weights[2] == $card_weights[4]))) {
            if (($card_weights[0] == $card_weights[1]) && ($card_weights[0] == $card_weights[2])) {
                $relative_weight = (($card_weights[0] * 100) * 3) + ($card_weights[3] * 2);
            } else {
                $relative_weight = (($card_weights[2] * 100) * 3) + ($card_weights[0] * 2);
            }
            return ['Full House', 7, $total_weight, $relative_weight, $cards];
        }

        // At this point, a flush is higher than any as-yet undetected hand.
        if ($is_flush) {
            $relative_weight = $card_weights[0] + ($card_weights[1] * 10) + ($card_weights[2] * 100) + ($card_weights[3] * 1000) + ($card_weights[4] * 10000);
            return ['Flush', 6, $total_weight, $relative_weight, $cards];
        }

        // Detect three of a kind.
        if ((($card_weights[0] == $card_weights[1]) &&
            ($card_weights[0] == $card_weights[2])) ||
          (($card_weights[1] == $card_weights[2]) &&
            ($card_weights[1] == $card_weights[3])) ||
          (($card_weights[2] == $card_weights[3]) &&
            ($card_weights[2] == $card_weights[4]))) {
            if ($card_weights[0] == $card_weights[1]) {
                $relative_weight = $card_weights[0] * 30;
                $relative_weight += $card_weights[3];
                $relative_weight += $card_weights[4];
            } elseif ($card_weights[1] == $card_weights[2]) {
                $relative_weight = $card_weights[1] * 30;
                $relative_weight += $card_weights[0];
                $relative_weight += $card_weights[4];
            } else {
                $relative_weight = $card_weights[2] * 30;
                $relative_weight += $card_weights[0];
                $relative_weight += $card_weights[1];
            }
            return ['Three of a Kind', 4, $total_weight, $relative_weight, $cards];
        }

        // Detect two pair.
        if ((($card_weights[0] == $card_weights[1]) &&
            ($card_weights[2] == $card_weights[3])) ||
          (($card_weights[0] == $card_weights[1]) &&
            ($card_weights[3] == $card_weights[4])) ||
          (($card_weights[1] == $card_weights[2]) &&
            ($card_weights[3] == $card_weights[4]))) {
            $unused = [];
            $unused[0] = true;
            $unused[1] = true;
            $unused[2] = true;
            $unused[3] = true;
            $unused[4] = true;
            if ($card_weights[0] == $card_weights[1]) {
                $relative_weight += ($card_weights[0] * 20);
                $unused[0] = false;
                $unused[1] = false;
            }
            if ($card_weights[1] == $card_weights[2]) {
                $relative_weight += ($card_weights[1] * 20);
                $unused[1] = false;
                $unused[2] = false;
            }
            if ($card_weights[2] == $card_weights[3]) {
                $relative_weight += ($card_weights[2] * 20);
                $unused[2] = false;
                $unused[3] = false;
            }
            if ($card_weights[3] == $card_weights[4]) {
                $relative_weight += ($card_weights[3] * 20);
                $unused[3] = false;
                $unused[4] = false;
            }
            if ($unused[0]) { $relative_weight += $card_weights[0]; }
            if ($unused[1]) { $relative_weight += $card_weights[1]; }
            if ($unused[2]) { $relative_weight += $card_weights[2]; }
            if ($unused[3]) { $relative_weight += $card_weights[3]; }
            if ($unused[4]) { $relative_weight += $card_weights[4]; }
            return ['Two Pair', 3, $total_weight, $relative_weight, $cards];
        }

        // Detect one pair.
        if (($card_weights[0] == $card_weights[1]) ||
          ($card_weights[1] == $card_weights[2]) ||
          ($card_weights[2] == $card_weights[3]) ||
          ($card_weights[3] == $card_weights[4])) {
            if ($card_weights[0] == $card_weights[1]) {
                $relative_weight += ($card_weights[0] * 20);
                $relative_weight += $card_weights[2];
                $relative_weight += $card_weights[3];
                $relative_weight += $card_weights[4];
            }
            if ($card_weights[1] == $card_weights[2]) {
                $relative_weight += ($card_weights[1] * 20);
                $relative_weight += $card_weights[0];
                $relative_weight += $card_weights[3];
                $relative_weight += $card_weights[4];
            }
            if ($card_weights[2] == $card_weights[3]) {
                $relative_weight += ($card_weights[2] * 20);
                $relative_weight += $card_weights[0];
                $relative_weight += $card_weights[1];
                $relative_weight += $card_weights[4];
            }
            if ($card_weights[3] == $card_weights[4]) {
                $relative_weight += ($card_weights[3] * 20);
                $relative_weight += $card_weights[0];
                $relative_weight += $card_weights[1];
                $relative_weight += $card_weights[2];
            }
            return ['One Pair', 2, $total_weight, $relative_weight, $cards];
        }

        // Crappy hand.
        $relative_weight = $card_weights[0] + ($card_weights[1]) + ($card_weights[2]) + ($card_weights[3]) + ($card_weights[4]);
        return ['Nothing', 1, $total_weight, $relative_weight, $cards];
    }
} 
