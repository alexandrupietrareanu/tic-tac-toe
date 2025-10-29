<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\BoardGame;
use App\Entity\Game;
use App\Entity\Player;
use App\Enum\GameValueEnum;

class GameService
{
    public function play(Player $playerA, Player $playerB): void
    {
        $game = new Game($playerA, $playerB, 3);
        $boardGame = new BoardGame();
        $game->setBoardGame($boardGame);

        $gameLimit = $game->getLimit();

        for ($move = 1; $move <= $gameLimit * $gameLimit; ++$move) {
            $length = rand(1, 4);
            $width = rand(1, 4);

            if (0 === $move % 2) {
                $this->move($boardGame, $length, $width, $playerA);
            } else {
                $this->move($boardGame, $length, $width, $playerB);
            }

            if (null !== $winner = $this->getWinner($boardGame)) {
                $game->setWinner($winner);

                break;
            }
        }

        if (null === $game->getWinner()) {
            echo 'No winner';
        }

        echo \sprintf("The winner is %s\n", $game->getWinner());
    }

    public function move(BoardGame $boardGame, int $length, int $width, Player $player): void
    {
        $boardGame->updateMatrix($length, $width, $player->getType());
    }

    public function getWinner(BoardGame $boardGame): ?Player
    {
        $game = $boardGame->getGame();
        $type = $this->getTypeWinner($boardGame);

        if ($game->getPlayerA()->getType() === $type) {
            return $game->getPlayerA();
        }
        if ($game->getPlayerB()->getType() === $type) {
            return $game->getPlayerB();
        }

        return null;
    }

    private function getTypeWinner(BoardGame $boardGame): ?GameValueEnum
    {
        for ($i = 1; $i <= $boardGame->getGame()->getLimit(); ++$i) {
            if (null !== $typeWinner = $this->getMatrixWinner($boardGame->getGame(), $i)) {
                return $typeWinner;
            }
        }

        return null;
    }

    private function getMatrixWinner(Game $game, int $index): ?GameValueEnum
    {
        $isLineWinner = true;
        $isColumnWinner = true;
        $isDiagonalWinner = true;
        $type = null;
        $matrix = $game->getBoardGame()->getMatrix();

        $valueLine = $matrix[$index][1];
        $valueColumn = $matrix[1][$index];

        for ($i = 1; $i <= $game->getLimit(); ++$i) {
            if ($valueLine !== $matrix[$index][$i]) {
                $isLineWinner = false;
            }

            if ($valueColumn !== $matrix[$i][$index]) {
                $isColumnWinner = false;
            }

            if ($i + 1 <= $game->getLimit() && $matrix[$i][$i] !== $matrix[$i + 1][$i + 1]) {
                $isDiagonalWinner = false;
            }
        }

        if (!$isLineWinner && !$isColumnWinner && !$isDiagonalWinner) {
            return null;
        }

        if ($isLineWinner) {
            $type = $matrix[$index][$i];
        }

        if ($isColumnWinner) {
            $type = $matrix[$i][$index];
        }

        if ($isDiagonalWinner) {
            $type = $matrix[$index][$index];
        }

        if ($type instanceof GameValueEnum) {
            return $type;
        }

        return null;
    }
}
