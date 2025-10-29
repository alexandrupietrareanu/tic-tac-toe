<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enum\GameValueEnum;

class BoardGame
{
    private Game $game;

    /**
     * @var array<array<int, null|GameValueEnum|int>>
     */
    private array $matrix;

    public function getGame(): Game
    {
        return $this->game;
    }

    public function setGame(Game $game): self
    {
        $this->game = $game;

        if ($game->getBoardGame() !== $this) {
            $game->setBoardGame($this);
        }

        return $this;
    }

    /**
     * @return array<array<int, null|GameValueEnum|int>>
     */
    public function getMatrix(): array
    {
        return $this->matrix;
    }

    public function updateMatrix(int $i, int $j, GameValueEnum $valueEnum): void
    {
        if (!$this->matrix[$i][$j]) {
            echo \sprintf('Already set matrix on position %s:%s', $i, $j);
        }
        $this->matrix[$i][$j] = $valueEnum;
    }
}
