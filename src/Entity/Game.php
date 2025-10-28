<?php

declare(strict_types=1);

namespace App\Entity;

readonly class Game
{
    public function __construct(
        private Player $playerA,
        private Player $playerB,
    ) {}

    public function getPlayerA(): Player
    {
        return $this->playerA;
    }

    public function getPlayerB(): Player
    {
        return $this->playerB;
    }
}
