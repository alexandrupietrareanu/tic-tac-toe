<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\BoardGame;
use App\Entity\Game;
use App\Entity\Player;
use App\Enum\GameValueEnum;

class GameService
{
    public function startGame(string $xName, string $oName, int $gameLimit): Game
    {
        $playerX = $this->createPlayer($xName, GameValueEnum::X);
        echo \sprintf('%s is using the %s symbol;  ', $playerX->getName(), GameValueEnum::X->value);

        $playerO = $this->createPlayer($oName, GameValueEnum::O);
        echo \sprintf('%s is using the %s symbol;   ', $playerO->getName(), GameValueEnum::O->value);

        $game = $this->setUpGame($playerX, $playerO, $gameLimit);
        echo \sprintf('The game starts now! The matrix limit is %s;   ', $gameLimit);

        return $game;
    }

    public function move(int $length, int $width, Player $player): void
    {
        $boardGame = BoardGame::getInstance();
        echo \sprintf("Player %s move is %s:%s\n", $player->getType()->value, $length, $width);
        $boardGame->updateMatrix($length, $width, $player->getType());
    }

    public function getWinner(): ?Player
    {
        $game = Game::getInstance();
        $type = $this->getTypeWinner();

        if ($game->getPlayerA()->getType() === $type) {
            return $game->getPlayerA();
        }
        if ($game->getPlayerB()->getType() === $type) {
            return $game->getPlayerB();
        }

        return null;
    }

    protected function playGame(): void
    {
        $move = 0;
        $game = Game::getInstance();
        $gameLimit = $game->getLimit();

        while (null === $game->getWinner()) {
            ++$move;
            $length = rand(1, $gameLimit);
            $width = rand(1, $gameLimit);

            if (0 === $move % 2) {
                $this->move($length, $width, $game->getPlayerA());
            } else {
                $this->move($length, $width, $game->getPlayerB());
            }

            if (null !== $winner = $this->getWinner()) {
                $game->setWinner($winner);

                break;
            }
        }

        if (null === $game->getWinner()) {
            echo 'No winner;';

            return;
        }

        echo \sprintf("The winner is %s\n", $game->getWinner());
    }

    private function createPlayer(string $name, GameValueEnum $type): Player
    {
        $player = new Player();
        $player->setName($name)
            ->setType($type)
        ;

        return $player;
    }

    private function setUpGame(Player $playerX, Player $playerO, int $gameLimit): Game
    {
        $game = Game::getInstance();
        $game->setPlayerA($playerX)
            ->setPlayerB($playerO)
            ->setLimit($gameLimit)
            ->setName('Tic Tac Toe')
        ;

        return $game;
    }

    private function getTypeWinner(): ?GameValueEnum
    {
        $game = Game::getInstance();

        for ($i = 1; $i <= $game->getLimit(); ++$i) {
            if (null !== $typeWinner = $this->getMatrixWinner($game, $i)) {
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

        $boardGame = BoardGame::getInstance();
        $matrix = $boardGame->getMatrix();

        $fvColumn = $matrix[$index][1] ?? '';
        $fvLine = $matrix[1][$index] ?? '';
        $fvDiagonal = $matrix[1][1] ?? '';

        for ($i = 1; $i <= $game->getLimit(); ++$i) {
            $cValue = $matrix[$index][$i] ?? '';
            if (!$cValue || $fvColumn !== $cValue) {
                $isColumnWinner = false;
            }

            $lValue = $matrix[$i][$index] ?? '';
            if (!$lValue || $fvLine !== $lValue) {
                $isLineWinner = false;
            }

            $dValue = $matrix[$i][$i] ?? '';
            $dNextValue = $matrix[$i + 1][$i + 1] ?? '';

            if (!$dValue || ($i + 1 <= $game->getLimit() && $dValue !== $dNextValue)) {
                $isDiagonalWinner = false;
            }
        }

        if (!$isLineWinner && !$isColumnWinner && !$isDiagonalWinner) {
            return null;
        }

        if ($isLineWinner) {
            $type = $fvLine;
        }

        if ($isColumnWinner) {
            $type = $fvColumn;
        }

        if ($isDiagonalWinner) {
            $type = $fvDiagonal;
        }

        if ($type instanceof GameValueEnum) {
            return $type;
        }

        return null;
    }
}
