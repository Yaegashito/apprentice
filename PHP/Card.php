<?php

namespace WarGame;

class Card
{
    public function createInitCards()
    {
        $cards = [];
        $suits = ['スペード', 'ハート', 'ダイヤ', 'クラブ'];
        $cardRanks = [
            1 => '2',
            2 => '3',
            3 => '4',
            4 => '5',
            5 => '6',
            6 => '7',
            7 => '8',
            8 => '9',
            9 => '10',
            10 => 'J',
            11 => 'Q',
            12 => 'K',
            13 => 'A',
        ];

        foreach ($suits as $suit) {
            foreach ($cardRanks as $index => $cardRank) {
                $cards[] = [
                    'numMark' => $cardRank,
                    'rank' => $index,
                    'suit' => $suit
                ];
            }
        }
        for ($i = 0; $i < 2; $i++) {
            $cards[] = [
                'numMark' => 'JOKER',
                'rank' => '14',
                'suit' => '最強'
            ];
        }
        shuffle($cards);
        return $cards;
    }
}
