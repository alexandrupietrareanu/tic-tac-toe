<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Player;
use App\Service\GameService;

class HomeController implements ControllerInterface
{
    public function __construct(
        private readonly GameService $gameService,
    ) {}

    public function index(): void
    {
        $game = new Game(new Player('Player one'), new Player('God mode'));
        $this->gameService->initialize($game);
    }
}
