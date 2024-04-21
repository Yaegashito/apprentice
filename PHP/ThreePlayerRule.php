<?php

namespace WarGame;

class ThreePlayerRule
{
    public function applyThreeRule(Player $player1, Player $player2, Player $player3, array $shuffledCards)
    {
        [$player1->playerCards, $player2->playerCards, $player3->playerCards] = array_chunk($shuffledCards, count($shuffledCards) / 3);
        echo 'カードが配られました。' . PHP_EOL;

        $fieldCards = [];
        for ($i = 0;; $i++) {
            echo PHP_EOL . $i + 1 . '回目の戦争！' . PHP_EOL;
            echo $player1->name . 'のカードは' . $player1->playerCards[0]['suit'] . 'の' . $player1->playerCards[0]['numMark'] . 'です。' . PHP_EOL;
            echo $player2->name . 'のカードは' . $player2->playerCards[0]['suit'] . 'の' . $player2->playerCards[0]['numMark'] . 'です。' . PHP_EOL;
            echo $player3->name . 'のカードは' . $player3->playerCards[0]['suit'] . 'の' . $player3->playerCards[0]['numMark'] . 'です。' . PHP_EOL;
            // ↓場札に追加。ここで各プレイヤーの手札は減らさない。ここで手札を減らすと次の条件判定に差し支える。
            $fieldCards[] = $player1->playerCards[0];
            $fieldCards[] = $player2->playerCards[0];
            $fieldCards[] = $player3->playerCards[0];
            // ここまで3人仕様に変更した

            // ↓ 各ターンの勝者を判定、勝者の予備手札を増やす
            [$player1->playerSpareCards, $player2->playerSpareCards, $player3->playerSpareCards, $fieldCards] = $this->decideWinner($player1, $player2, $player3, $fieldCards);

            // ↓ 両者の場に出した手札を減らす
            array_shift($player1->playerCards);
            array_shift($player2->playerCards);
            array_shift($player3->playerCards);

            if ($this->endOrNot($player1, $player2, $player3)) {
                break;
            }
        }
    }

    private function decideWinner(Player $player1, Player $player2, Player $player3, array $fieldCards)
    {
        if (count(array_unique([$player1->playerCards[0]['rank'], $player2->playerCards[0]['rank'], $player3->playerCards[0]['rank']])) === 1) {
            echo '引き分けです。' . PHP_EOL;
        } else {
            // ここからの3人仕様がわからない
            if ($player1->playerCards[0]['rank'] > $player2->playerCards[0]['rank']) {
                // ↓プレイヤー1の予備手札を増やす
                $player1->playerSpareCards = array_merge($player1->playerSpareCards, $fieldCards);
                echo $player1->name . 'が勝ちました。' . PHP_EOL;
            } elseif ($player1->playerCards[0]['rank'] < $player2->playerCards[0]['rank']) {
                // ↓プレイヤー2の予備手札を増やす
                $player2->playerSpareCards = array_merge($player2->playerSpareCards, $fieldCards);
                echo $player2->name . 'が勝ちました。' . PHP_EOL;
            }
            $fieldCards = [];
        }
        return [$player1->playerSpareCards, $player2->playerSpareCards, $player3->playerSpareCards, $fieldCards];
    }

    private function endOrNot(Player $player1, Player $player2, Player $player3)
    {
        if (count($player1->playerCards) === 0 && count($player2->playerCards) === 0) {
            $player1->playerCards = $player1->addSpareToPlayerCards();
            $player1->playerSpareCards = [];
            $player2->playerCards = $player2->addSpareToPlayerCards();
            $player2->playerSpareCards = [];
            echo '両者のカードを補充します。' . PHP_EOL;
            if (count($player1->playerCards) === 0 && count($player2->playerCards) === 0) {
                echo '両者の手札を補充できませんでした。' . PHP_EOL;
                echo 'ゲームを続行できません。引き分けです。' . PHP_EOL;
                return true;
            } elseif (count($player1->playerCards) === 0 && count($player2->playerCards) > 0) {
                $this->echoResultP2Win($player1, $player2);
                return true;
            } elseif (count($player1->playerCards) > 0 && count($player2->playerCards) === 0) {
                $this->echoResultP1Win($player1, $player2);
                return true;
            }
        } elseif (count($player1->playerCards) === 0 && count($player2->playerCards) > 0) {
            $player1->playerCards = $player1->addSpareToPlayerCards();
            $player1->playerSpareCards = [];
            echo $player1->name . 'の手札を補充します。' . PHP_EOL;
            if (count($player1->playerCards) === 0) {
                $this->echoResultP2Win($player1, $player2);
                return true;
            }
        } elseif (count($player1->playerCards) > 0 && count($player2->playerCards) === 0) {
            $player2->playerCards = $player2->addSpareToPlayerCards();
            $player2->playerSpareCards = [];
            echo $player2->name . 'の手札を補充します。' . PHP_EOL;
            if (count($player2->playerCards) === 0) {
                $this->echoResultP1Win($player1, $player2);
                return true;
            }
        }
    }

    private function echoResultP1Win(Player $player1, Player $player2)
    {
        echo $player2->name . 'の手札を補充できませんでした。' . PHP_EOL;
        echo $player1->name . 'の手札の枚数は' . count($player1->playerCards) + count($player1->playerSpareCards) . '枚です。';
        echo $player2->name . 'の手札の枚数は0枚です。' . PHP_EOL;
        echo $player1->name . 'が1位、' . $player2->name . 'が2位です。' . PHP_EOL;
    }

    private function echoResultP2Win(Player $player1, Player $player2)
    {
        echo $player1->name . 'の手札を補充できませんでした。' . PHP_EOL;
        echo $player1->name . 'の手札の枚数は0枚です。';
        echo $player2->name . 'の手札の枚数は' . count($player2->playerCards) + count($player2->playerSpareCards) . '枚です。' . PHP_EOL;
        echo $player2->name . 'が1位、' . $player1->name . 'が2位です。' . PHP_EOL;
    }
}
