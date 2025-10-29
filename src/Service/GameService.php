<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\BoardGame;
use App\Entity\BoardGameMove;
use App\Entity\Game;
use App\Entity\Player;

class GameService
{
    public function play(Player $playerA, Player $playerB): void
    {
        $game = new Game(new Player('Player one'), new Player('God mode'));
        $boardGame = $this->initializeBoardGame($game);
        $this->move($boardGame, 1, 1, $playerA);
        // check if is game over;
        // check if all moves are completed
    }

    public function initializeBoardGame(Game $game): BoardGame
    {
        $boardGame = new BoardGame();
        $game->setBoardGame($boardGame);

        return $boardGame;
    }

    public function move(BoardGame $boardGame, int $length, int $width, Player $player): void
    {
        $boardGameMove = new BoardGameMove();
        $boardGameMove->setLength($length)
            ->setWidth($width)
            ->setPlayer($player)
        ;

        $boardGame->addBoardGameMove($boardGameMove);
    }
}
