<?php

declare(strict_types=1);

namespace App\Controller;

use App\Core\View;
use App\Entity\Game;
use App\Enum\GameValueEnum;
use App\Service\GameService;

class HomeController implements ControllerInterface
{
    public function __construct(
        private readonly GameService $gameService,
    ) {}

    public function index(): void
    {
        $game = $this->gameService->startGame('Player A', 'Player B', 3);

        View::render('home', [
            'game' => $game,
        ]);
    }

    public function move(): void
    {
        $request = json_decode(file_get_contents('php://input'), true);

        $row = $request['row'] + 1 ?? null;
        $col = $request['col'] + 1 ?? null;
        $sign = $request['player'] ?? null;

        if (null === $row || null === $col || !$sign) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid move request']);

            return;
        }

        $game = Game::getInstance();
        $game->setLimit(3);
        $type = GameValueEnum::from($sign);

        if ($game->getPlayerA()->getType() === $type) {
            $player = $game->getPlayerA();
        } else {
            $player = $game->getPlayerB();
        }

        $result = [
            'row' => $row,
            'col' => $col,
            'player' => $sign,
            'gameName' => $game->getName(),
        ];

        $this->gameService->move($row, $col, $player);

        if (null !== $winner = $this->gameService->getWinner()) {
            $game->setWinner($winner);
            echo 'Winner: '.$winner->getName();
        }

        echo json_encode($result);
    }
}
