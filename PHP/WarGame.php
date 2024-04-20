<?php

require_once('Player.php');
require_once('Card.php');

class Game
{
    public function startGame()
    {
        // $this->config();

        // ↓山札作成、カードのランク付け、シャッフル
        $cards = new Card();
        $shuffledCards = $cards->createInitCards();
        // ↓プレイヤーを作成、カードの分配
        $player1 = new Player();
        $player2 = new Player();
        // [修正点(step3)] chunkではなくsliceのほうが人数変更に対応しやすいのでは
        [$player1->playerCards, $player2->playerCards] = array_chunk($shuffledCards, count($shuffledCards) / 2);
        echo 'カードが配られました。' . PHP_EOL;

        $fieldCards = [];
        for ($i = 0;; $i++) { // [修正点(step3)] プレイヤー数に応じて数字を変える
            echo PHP_EOL . $i . '回目の戦争！' . PHP_EOL;
            echo 'プレイヤー1のカードは' . $player1->playerCards[0]['suit'] . 'の' . $player1->playerCards[0]['numMark'] . 'です。' . PHP_EOL;
            echo 'プレイヤー2のカードは' . $player2->playerCards[0]['suit'] . 'の' . $player2->playerCards[0]['numMark'] . 'です。' . PHP_EOL;
            // ↓場札に追加。ここで各プレイヤーの手札は減らさない。ここで手札を減らすと次の条件判定に差し支える。
            $fieldCards[] = $player1->playerCards[0];
            $fieldCards[] = $player2->playerCards[0];

            if ($player1->playerCards[0]['rank'] === $player2->playerCards[0]['rank']) { //条件はもとに戻しておけ
                echo '引き分けです。' . PHP_EOL;
            } else {
                if ($player1->playerCards[0]['rank'] > $player2->playerCards[0]['rank']) {
                    // ↓プレイヤー1の予備手札を増やす
                    $player1->playerSpareCards = array_merge($player1->playerSpareCards, $fieldCards);
                    echo 'プレイヤー1が勝ちました。' . PHP_EOL;
                } elseif ($player1->playerCards[0]['rank'] < $player2->playerCards[0]['rank']) {
                    // ↓プレイヤー2の予備手札を増やす
                    $player2->playerSpareCards = array_merge($player2->playerSpareCards, $fieldCards);
                    echo 'プレイヤー2が勝ちました。' . PHP_EOL;
                }
                $fieldCards = [];
            }
            // ↓ 両者の手札を減らす。
            array_shift($player1->playerCards);
            array_shift($player2->playerCards);

            // ↓テスト用、ちゃんと削除しておけ
            $sum = count($fieldCards) + count($player1->playerSpareCards) + count($player1->playerCards) + count($player2->playerSpareCards) + count($player2->playerCards);
            echo PHP_EOL . '場札→' . count($fieldCards) . '    P1の手札→' . count($player1->playerCards) . '    P1の予備手札→' . count($player1->playerSpareCards) . '    P2の手札→' . count($player2->playerCards) . '    P2の予備手札→' . count($player2->playerSpareCards) . '   合計→' . $sum . PHP_EOL . PHP_EOL;

            // $this->endOrNot($player1, $player2);
            if (count($player1->playerCards) === 0 && count($player2->playerCards) === 0) {
                shuffle($player1->playerSpareCards);
                $player1->playerCards = array_merge($player1->playerCards, $player1->playerSpareCards);
                $player1->playerSpareCards = [];
                shuffle($player2->playerSpareCards);
                $player2->playerCards = array_merge($player2->playerCards, $player2->playerSpareCards);
                $player2->playerSpareCards = [];
                echo '両者のカードを補充しました' . PHP_EOL;
                if (count($player1->playerCards) === 0 && count($player2->playerCards) === 0) {
                    echo 'プレイヤー1とプレイヤー2の手札がなくなりました。' . PHP_EOL;
                    echo '勝敗は決まりませんでした。' . PHP_EOL;
                    break;
                } elseif (count($player1->playerCards) === 0 && count($player2->playerCards) > 0) {
                    echo 'プレイヤー1の手札がなくなりました' . PHP_EOL;
                    echo 'プレイヤー1の手札の枚数は0枚です。プレイヤー2の手札の枚数は' . count($player2->playerCards) . '枚です。' . PHP_EOL;
                    echo 'プレイヤー2が1位、プレイヤー1が2位です。' . PHP_EOL;
                    break;
                } elseif (count($player1->playerCards) > 0 && count($player2->playerCards) === 0) {
                    echo 'プレイヤー2の手札がなくなりました' . PHP_EOL;
                    echo 'プレイヤー1の手札の枚数は' . count($player1->playerCards) . '枚です。プレイヤー2の手札の枚数は0枚です。' . PHP_EOL;
                    echo 'プレイヤー1が1位、プレイヤー2が2位です。' . PHP_EOL;
                    break;
                }
            } elseif (count($player1->playerCards) === 0 && count($player2->playerCards) > 0) {
                shuffle($player1->playerSpareCards);
                $player1->playerCards = array_merge($player1->playerCards, $player1->playerSpareCards);
                $player1->playerSpareCards = [];
                echo 'プレイヤー1の手札を補充します' . PHP_EOL;
                if (count($player1->playerCards) === 0) {
                    echo 'プレイヤー1の手札を補充できませんでした' . PHP_EOL;
                    echo 'プレイヤー1の手札の枚数は0枚です。プレイヤー2の手札の枚数は' . count($player2->playerCards) . '枚です。' . PHP_EOL;
                    echo 'プレイヤー2が1位、プレイヤー1が2位です。' . PHP_EOL;
                    break;
                }
            } elseif (count($player1->playerCards) > 0 && count($player2->playerCards) === 0) {
                shuffle($player2->playerSpareCards);
                $player2->playerCards = array_merge($player2->playerCards, $player2->playerSpareCards);
                $player2->playerSpareCards = [];
                echo 'プレイヤー2の手札を補充します' . PHP_EOL;
                if (count($player2->playerCards) === 0) {
                    echo 'プレイヤー2の手札を補充できませんでした' . PHP_EOL;
                    echo 'プレイヤー1の手札の枚数は' . count($player1->playerCards) . '枚です。プレイヤー2の手札の枚数は0枚です。' . PHP_EOL;
                    echo 'プレイヤー1が1位、プレイヤー2が2位です。' . PHP_EOL;
                    break;
                }
            }
        }

        echo '戦争を終了します。' . PHP_EOL;
    }

    // private function endOrNot(Player $player1, Player $player2)
    // {
    // }

    // private function config()
    // {
    //     echo '戦争を開始します。' . PHP_EOL;
    //     echo 'プレイヤーの人数を入力してください（2人のみ）：';
    //     $NumOfPlayer = trim(fgets(STDIN));

    //     入力した数字を反映させる
    //     $game = new Game($NumberOfPlayer);
    //     $game->startGame();

    // }
}

$game = new Game();
$game->startGame();
