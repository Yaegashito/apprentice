<?php

require_once('Player.php');
require_once('Card.php');


// 場札を回収できるのは勝った時点だが、手札に加えるのは手札がゼロになってからである。また、その時点でシャッフルする必要がある。
// カード束には①「シャッフル前の山札($cards)」、②「シャッフル後の山札($shuffledCards)」、③「手札($playerCards)」、④「場札($fieldCards)」、⑤「予備の手札($playerSpareCards)」がある。③⑤はPlayerクラスに置くべきかも。

class Game
{
    public function startGame() //引数にプレイヤー数をとるとよい？
    {
        echo '戦争を開始します。' . PHP_EOL;

        $cards = new Card();
        $shuffledCards = $cards->initCards();
        $playerCards = array_chunk($shuffledCards, count($shuffledCards) / 2); //プレイヤー数で割るように修正せよ
        echo 'カードが配られました。' . PHP_EOL;

        $fieldCards = [];
        for ($i = 0; $i < count($shuffledCards) / 2; $i++) { //プレイヤー数に応じて数字が変える
            echo '戦争！' . PHP_EOL;
            echo 'プレイヤー1のカードは' . $playerCards[0][$i]['suit'] . 'の' . $playerCards[0][$i]['numMark'] . 'です。' . PHP_EOL;
            echo 'プレイヤー2のカードは' . $playerCards[1][$i]['suit'] . 'の' . $playerCards[1][$i]['numMark'] . 'です。' . PHP_EOL;
            // 両者の手札を減らす
            if ($playerCards[0][$i]['numMark'] === $playerCards[1][$i]['numMark']) {
                echo '引き分けです。' . PHP_EOL;
                //フィールドに追加
            } else {
                $this->desideWinner($playerCards[0][$i]['rank'], $playerCards[1][$i]['rank']);
                // 場札の回収はここでやるのかも？フィールドをリセットして勝者の配列に追加
                break;
            }
        }

        echo '戦争を終了します。' . PHP_EOL;
    }

    private function desideWinner(int $playerCard1, int $playerCard2)
    {
        if ($playerCard1 > $playerCard2) {
            // プレイヤー1の手札を増やす
            echo 'プレイヤー1が勝ちました。' . PHP_EOL;
        } elseif ($playerCard1 < $playerCard2) {
            // プレイヤー2の手札を増やす
            echo 'プレイヤー2が勝ちました。' . PHP_EOL;
        }
    }
}

$game = new Game();
$game->startGame();

// echo '戦争を開始します。' . PHP_EOL;
// echo 'プレイヤーの人数を入力してください（2人のみ）：';
// $NumberOfPlayer = trim(fgets(STDIN));

// $game = new Game($NumberOfPlayer);
// $game->startGame();
