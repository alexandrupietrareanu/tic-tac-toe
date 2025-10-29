<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Player;
use App\Enum\GameValueEnum;
use App\Service\GameService;

class HomeController implements ControllerInterface
{
    public function __construct(
        private readonly GameService $gameService,
    ) {}

    public function index(): void
    {
        $this->gameService->play(new Player(GameValueEnum::X, 'Player one'), new Player(GameValueEnum::X, 'God mode'));
    }
}
