<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Game;

class GameService
{
    public function initialize(Game $game): void
    {
        echo 'Initialize Game!';
    }
}
