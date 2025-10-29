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
        private int $limit,
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

    public function setBoardGame(BoardGame $boardGame): self
    {
        $this->boardGame = $boardGame;

        if ($boardGame->getGame() !== $this) {
            $boardGame->setGame($this);
        }

        return $this;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function setLimit(int $limit): void
    {
        $this->limit = $limit;
    }
}
