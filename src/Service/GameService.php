<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Game;

class GameService
{
    public function initialize(Game $game): void
    {
        echo "Initialize Game!\n";
        echo 'Player one is: '.$game->getPlayerA()->getName()."\n";
        echo 'Player two is: '.$game->getPlayerB()->getName()."\n";
    }
}
