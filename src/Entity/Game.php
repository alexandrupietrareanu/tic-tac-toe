<?php

declare(strict_types=1);

namespace App\Entity;

class Game
{
    private ?Player $winner = null;

    private BoardGame $boardGame;

    public function __construct(
        private readonly Player $playerA,
        private readonly Player $playerB,
    ) {}

    public function getPlayerA(): Player
    {
        return $this->playerA;
    }

    public function getPlayerB(): Player
    {
        return $this->playerB;
    }

    public function getWinner(): ?Player
    {
        return $this->winner;
    }

    public function setWinner(?Player $winner): void
    {
        $this->winner = $winner;
    }

    public function getBoardGame(): BoardGame
    {
        return $this->boardGame;
    }

    public function setBoardGame(BoardGame $boardGame): void
    {
        $this->boardGame = $boardGame;
    }
}
