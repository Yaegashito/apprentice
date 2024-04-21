<?php

namespace WarGame;

use WarGame\Card;
use WarGame\Player;
use WarGame\TwoPlayerRule;
use WarGame\ThreePlayerRule;

class WarGame
{
    public function startGame()
    {
        echo '戦争を開始します。' . PHP_EOL;

        // ↓ 人数設定
        $numOfPlayer = $this->selectMode();

        // ↓山札作成、カードのランク付け、シャッフル
        $cards = new Card();
        $shuffledCards = $cards->createInitCards();

        // ↓入力した人数に応じてプレイヤーを作成し、名前を設定する
        for ($i = 1; $i <= $numOfPlayer; $i++) {
            ${"player" . $i} = new Player();
            echo 'プレイヤー' . $i . 'の名前を入力してください：';
            ${"player" . $i}->name = trim(fgets(STDIN));
        }

        // ↓ 入力した人数に応じたルールを適用してゲーム開始
        if ($numOfPlayer === 2) {
            $twoPlayerRule = new TwoPlayerRule();
            $twoPlayerRule->applyTwoRule($player1, $player2, $shuffledCards);
        } elseif ($numOfPlayer === 3) {
            echo '実装できませんでした。' . PHP_EOL;
            // $threePlayerRule = new ThreePlayerRule();
            // $threePlayerRule->applyThreeRule($player1, $player2, $player3, $shuffledCards);
        }

        echo '戦争を終了します。' . PHP_EOL;
    }

    private function selectMode()
    {
        while (true) {
            echo 'プレイヤーの人数を入力してください（2~3(今は2人のみ実装)）：';
            $numOfPlayer = (int)trim(fgets(STDIN));
            if ($numOfPlayer >= 2 && $numOfPlayer <= 3) {
                break;
            } else {
                echo '人数は2~3人で入力してください。' . PHP_EOL;
            }
        }
        return $numOfPlayer;
    }
}
