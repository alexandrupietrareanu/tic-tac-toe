<?php

declare(strict_types=1);

namespace App\Controller;

use App\Core\View;
use App\Entity\BoardGame;
use App\Entity\Game;
use App\Service\GameService;

class HomeController implements ControllerInterface
{
    public function __construct(
        private readonly GameService $gameService,
    ) {}

    public function index(): void
    {
        $game = Game::getInstance();
        $this->gameService->startGame($game, 'Player A', 'Player B', $_SESSION['limit']);
        $boardGame = BoardGame::getInstance();
        $boardGame->resetMatrix();

        View::render('home', [
            'game' => $game,
        ]);
    }

    public function move(): void
    {
        $request = json_decode((string) file_get_contents('php://input'), true);

        $row = $request['row'] ?? null;
        $col = $request['col'] ?? null;
        $sign = $request['player'] ?? null;

        if (null === $row || null === $col || !$sign) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid move request']);

            return;
        }

        $game = Game::getInstance();
        $this->gameService->move($row, $col, $sign);

        if (null !== $winner = $this->gameService->getWinner()) {
            $game->setWinner($winner);
            echo 'Winner: '.$winner->getName();

            return;
        }

        $result = [
            'row' => $row,
            'col' => $col,
            'player' => $sign,
            'gameName' => $game->getName(),
        ];

        echo json_encode($result);
    }
}
