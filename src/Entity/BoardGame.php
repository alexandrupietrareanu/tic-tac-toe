<?php

declare(strict_types=1);

namespace App\Entity;

class BoardGame
{
    /** @var array<BoardGameMove> */
    private array $boardGameMoves;

    /**
     * @return array<BoardGameMove>
     */
    public function getBoardGameMoves(): array
    {
        return $this->boardGameMoves;
    }

    public function addBoardGameMove(BoardGameMove $boardGameMove): self
    {
        if (!\in_array($boardGameMove, $this->boardGameMoves, true)) {
            $this->boardGameMoves[] = $boardGameMove;
        }

        return $this;
    }

    public function removeBookmarkDepartment(BoardGameMove $boardGameMove): self
    {
        unset($this->boardGameMoves[array_search($boardGameMove, $this->boardGameMoves, true)]);

        return $this;
    }

    /**
     * @param array<BoardGameMove> $boardGameMoves
     */
    public function setBoardGameMoves(array $boardGameMoves): void
    {
        $this->boardGameMoves = $boardGameMoves;
    }
}
