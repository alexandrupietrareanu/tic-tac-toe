<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Player;
use App\Service\GameService;

class HomeController implements ControllerInterface
{
    public function __construct(
        private readonly GameService $gameService,
    ) {}

    public function index(): void
    {
        $this->gameService->play(new Player('Player one'), new Player('God mode'));
    }
}
